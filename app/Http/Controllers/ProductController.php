<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index()
    {
        //$products = Product::paginate(25);
        $products = Product::orderBy('id', 'desc')->paginate(25);
        return view('admin.product.index', compact('products'));

    }

    public function addProduct()
    {
        $attributes = Attribute::orderByRaw('sort_order IS NULL ASC, sort_order ASC')->get();
        $categories = Category::all();

        $categoryData = [];

        foreach ($categories as $category) {
            $path = $this->getCategoryPath($category);
            $categoryData[] = (object)[
                'id' => $category->id,
                'name' => $category->name,
                'path' => $path,
            ];
        }
        
        $categoryCollection = (object)$categoryData;

        return view('admin.product.add_product', compact('attributes', 'categoryCollection'));
    }

    public function createProduct(Request $request)
    {
        $attributes = $request->input('attributes');
        $attributeValues = $request->input('attribute_values', []);
       


        $request->validate([
            'product_name' => 'required',
            'main_image' => 'required|mimes:jpeg,jpg,png,webp|max:102400',
            'gallery_images.*' => 'mimes:jpg,jpeg,png,webp|max:102400',
            'attributes.*' => 'exists:attributes,id',
            'categories.*' => 'exists:categories,id',
        ]);

//         try {
//     $validatedData = $request->validate([
//         'product_name' => 'required',
//         'main_image' => 'required|mimes:jpeg,jpg,png',
//         'gallery_images.*' => 'mimes:jpg,jpeg,png',
//         'attributes.*' => 'exists:attributes,id',
//         'categories.*' => 'exists:categories,id',
//     ]);
// } catch (ValidationException $e) {
//     dd($e->errors());
// }

        $content = $request->description;
        
        $content = preg_replace('/<p>\s*<\/p>$/', '', $content);
        if(!empty($content)){
            $dom = new \DomDocument();
            @$dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $content = $dom->saveHTML();
        } else{
            $content = '';
        }
        

        
        // Begin a database transaction
        DB::beginTransaction();

        try {
            
           $product = Product::create([
                'product_name' => $request->input('product_name'),
                'sku' => !empty($request->input('sku')) ? $request->input('sku') : null,
                'price' => !empty($request->input('price')) ? $request->input('price') : null,
                'description' => $content,
                'html' => '<p>Added</p>', // Add the HTML content here
                // Add other product fields as needed
            ]);

           
            // Attach attributes to the product
            $attributes = $request->input('attributes');
            $attributeValues = $request->input('attribute_values');

            //$product->attributes()->attach($request->input('attributes'));
            if (count($attributes) == count($attributeValues)) {
                
                foreach ($attributes as $index => $attributeId) {
                    if(!empty($attributeValues[$index])){
                        $att_val_array['product_id'] = $product->id;
                        $att_val_array['attribute_id'] = $attributes[$index];
                        $att_val_array['value'] = $attributeValues[$index];

                        DB::table('attribute_product')->insert($att_val_array);
                    }
                    
                }
            }

            // Attach categories to the product
            $categories = $request->input('categories');
            foreach($categories as $key => $cat){
                $cat_pro['category_id'] = $categories[$key];
                $cat_pro['product_id'] = $product->id;

                DB::table('category_product')->insert($cat_pro);
            }
            //$product->categories()->attach($request->input('categories'));

            // Save the main image
            $mainImage = $request->file('main_image');
            $mainImagePath = $this->storeUniqueImage($mainImage, 'main_images');
            // $product->update(['image' => $mainImagePath]);
            DB::table('products')->where('id', $product->id)->update(['image' => $mainImagePath]);

            // Save gallery images

            $gallery_data = [];

            $galleryImages = $request->file('gallery_images');
                foreach ($galleryImages as $galleryImage) {
                    $galleryImagePath = $this->storeUniqueImage($galleryImage, 'gallery_images');
                    
                    $gallery_data[] = array(
                        'product_id' => $product->id,
                        'image_path' => $galleryImagePath
                    );
                }

            foreach ($gallery_data as $data) {
                // Assuming $data['product->id'] is the product_id and $data['image_path'] is the image_path
                $gallery_image_array['product_id'] = $data['product_id'];
                $gallery_image_array['image_path'] = $data['image_path'];

                DB::table('product_galleries')->insert($gallery_image_array);
               
            }

            $html = view('admin.product_layout.layout', compact('product'))->render();

            DB::table('products')->where('id', $product->id)->update(['html' => $html]);
            
            DB::commit();
            //return redirect()->route('admin.product')->with('success', 'Product updated successfully.');
            return redirect()->route('admin.product')->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            // Rollback the database transaction in case of any error
            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to create the product. Please try again.');
        }
    }

    public function editProduct($id)
    {
        //echo "id is = ".$id;
        $allAttributes =Attribute::orderByRaw('sort_order IS NULL ASC, sort_order ASC')->get();
        $allCategories = Category::all();

        $categoryData = [];

        foreach ($allCategories as $category) {
            $path = $this->getCategoryPath($category);
            $categoryData[] = (object)[
                'id' => $category->id,
                'name' => $category->name,
                'path' => $path,
            ];
        }
        
        $categoryCollection = (object)$categoryData;

        $product = Product::findOrFail($id);
        $categories = $product->categories;
        $gallery = $product->gallery;
        $attributes = $product->attributesWithValue;

        //return $categoryCollection;
        //return $categories;
        $productAttributes = [];
        foreach($attributes as $key => $attribute){
            $productAttributes[] = array(
                'id' => $attribute->pivot->id,
                'attribute_id' => $attribute->id,
                'name' => $attribute->name,
                'value' => $attribute->pivot->value,
            );
        }

         // return $productAttributes;

        return view('admin.product.edit_product', compact('allAttributes', 'allCategories', 'product', 'categories', 'gallery', 'productAttributes','attributes', 'categoryCollection'));
    }

    public function updateProduct(Request $request, Product $product){

        $attributes = $request->input('attributes');
        $attributeValues = $request->input('attribute_values');

       
        $mainImage = $request->file('main_image');
       
        $request->validate([
            'product_name' => 'required',
            'main_image' => 'mimes:jpeg,jpg,png,webp|max:102400',
            'gallery_images.*' => 'mimes:jpg,jpeg,png,webp|max:102400',
            'attributes.*' => 'exists:attributes,id',
            'categories.*' => 'exists:categories,id',
        ]);

       
        $content = $request->description;

        // Remove empty paragraphs at the end of the content
        $content = preg_replace('/<p>\s*<\/p>$/', '', $content);
         if(!empty($content)){
            $dom = new \DomDocument();
            @$dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $content = $dom->saveHTML();
        } else{
            $content = '';
        }

      // return $request;

        DB::beginTransaction();
        // DB::table('products')->where('id', $product->id)->update(['image' => $mainImagePath]);
        try {


            DB::table('products')->where('id', $product->id)->update([
                'product_name' => $request->input('product_name'),
                'sku' => !empty($request->input('sku')) ? $request->input('sku') : null,
                'price' => !empty($request->input('price')) ? $request->input('price') : null,
                'description' => $content,
                'html' => '<p>updated</p>'
            ]);


            //return $request;

            $attributes = $request->input('attributes');
            $attributeValues = $request->input('attribute_values');

            if (count($attributes) == count($attributeValues)) {
                DB::table('attribute_product')->where('product_id', $product->id)->delete();
                foreach ($attributes as $index => $attributeId) {
                    if(!empty($attributeValues[$index])){
                        $att_val_array['product_id'] = $product->id;
                        $att_val_array['attribute_id'] = $attributes[$index];
                        $att_val_array['value'] = $attributeValues[$index];

                        DB::table('attribute_product')->insert($att_val_array);
                    }
                    
                }
            }

           

            // Attach categories to the product
            $categories = $request->input('categories');
            if($categories){
                DB::table('category_product')->where('product_id', $product->id)->delete();
                foreach($categories as $key => $cat){
                    $cat_pro['category_id'] = $categories[$key];
                    $cat_pro['product_id'] = $product->id;

                    DB::table('category_product')->insert($cat_pro);
                }
            }
            

            if($request->hasfile('main_image')){
                $mainImage = $request->file('main_image');
                $mainImagePath = $this->storeUniqueImage($mainImage, 'main_images');
                // $product->update(['image' => $mainImagePath]);
                DB::table('products')->where('id', $product->id)->update(['image' => $mainImagePath]);
            }

            if ($request->hasFile('gallery_images')) {
                $gallery_data = [];

                $galleryImages = $request->file('gallery_images');
                    foreach ($galleryImages as $galleryImage) {
                        $galleryImagePath = $this->storeUniqueImage($galleryImage, 'gallery_images');
                        
                        $gallery_data[] = array(
                            'product_id' => $product->id,
                            'image_path' => $galleryImagePath
                        );
                    }

                foreach ($gallery_data as $data) {
                    // Assuming $data['product->id'] is the product_id and $data['image_path'] is the image_path
                    $gallery_image_array['product_id'] = $data['product_id'];
                    $gallery_image_array['image_path'] = $data['image_path'];

                    DB::table('product_galleries')->insert($gallery_image_array);
                   
                }
            }
           // return $product;
            //dd($product);

            $html = view('admin.product_layout.layout', compact('product'))->render();
            
            DB::table('products')->where('id', $product->id)->update(['html' => $html]);

            DB::commit();

            return redirect()->route('admin.product')->with('success', 'Product updated successfully.');


        } catch (\Exception $e) {
            // Rollback the database transaction in case of any error
            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to update the product. Please try again.');
        }

    }

    public function deleteAttribute($attributeId){
        try {
            // Use the query builder to delete the record
            DB::table('attribute_product')->where('id', $attributeId)->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id){
        $product = Product::findOrFail($id);

        DB::table('attribute_product')->where('product_id', $id)->delete();
        DB::table('category_product')->where('product_id', $id)->delete();
        DB::table('product_galleries')->where('product_id', $id)->delete();

        $product->delete();
        
        return redirect()->route('admin.product')->with('delete', 'Product deleted');
    }

    public function productPreview($id){
        $product = Product::findOrFail($id);
        $allAttributes = Attribute::all();
        $allCategories = Category::all();

        $categoryData = [];

        foreach ($allCategories as $category) {
            $path = $this->getCategoryPath($category);
            $categoryData[] = (object)[
                'id' => $category->id,
                'name' => $category->name,
                'path' => $path,
            ];
        }
        
        $categoryCollection = (object)$categoryData;

        $product = Product::findOrFail($id);
        $categories = $product->categories;
        $gallery = $product->gallery;
        $attributes = $product->attributesWithValue;

        //return $categoryCollection;
        //return $categories;
        $productAttributes = [];
        foreach($attributes as $key => $attribute){
            $productAttributes[] = array(
                'id' => $attribute->pivot->id,
                'attribute_id' => $attribute->id,
                'name' => $attribute->name,
                'value' => $attribute->pivot->value,
            );
        }
        // echo $product->html;
        // die();
        
        //return $product;
        return view('admin.product_layout.layout', compact('product'));
    }

    private function storeUniqueImage($image, $path)
    {
        $ext = $image->extension();
        $image_name = time() . '_' . uniqid() . '.' . $ext;
        $image->storeAs("/public/{$path}", $image_name);

        return $image_name;
    }

    private function getCategoryPath($category)
    {
        $pathArray = [$category->name];

        while ($category->parent) {
            $category = $category->parent;
            array_unshift($pathArray, $category->name);
        }

        return implode(' > ', $pathArray);
    }

    public function deleteGalleryImage(ProductGallery $image){
        return $image->delete();
    }
}
