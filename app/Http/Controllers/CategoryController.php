<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(25);

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
        // var_dump($categoryCollection);
        // die();
        return view('admin.category.index', compact('categoryCollection', 'categories'));
    }

    public function addCategory()
    {
        return view('admin.category.add_category');
    }

    public function createCategory(Request $request)
    {
        // return $request;
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $parent_id = $request->input('parent_id', 0);

        if($parent_id){
            $parent_id = $parent_id;
        } else{
            $parent_id = 0;
        }

        // Create a new category
        $category = Category::create([
            'name' => $request->input('name'),
            'parent_id' => $parent_id,
        ]);

        return redirect()->back()->with('success', 'Category created successfully!');
    }

    public function editCategory($id)
    {
        $category1 = Category::findOrFail($id);
        $category = $category1;
        $path = $this->getCategoryPath($category1);
        
        return view('admin.category.edit_category', compact('category', 'path'));
    }

    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category->update([
            'name' => $request->input('name'),
            'parent_id' => $request->input('parent_id', 0),
        ]);

        return redirect()->route('admin.category')->with('success', 'Category updated successfully.');
    }


    public function destroy($id)
    {
         //return $task;
        $category = Category::findOrFail($id);
        DB::table('category_product')->where('category_id', $category->id)->delete();
        $category->delete();
        
         return redirect()->route('admin.category')->with('delete', 'Category deleted');
    }

    public function autocomplete(Request $request)
    {
        $term = $request->input('term');

        $categories = Category::where('name', 'like', '%'.$term.'%')->get();

        $formattedCategories = [];

        foreach ($categories as $category) {
            $path = $this->getCategoryPath($category);
            $formattedCategories[] = [
                'label' => $path,
                'value' => $category->id,
            ];
        }

        return response()->json($formattedCategories);
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
}
