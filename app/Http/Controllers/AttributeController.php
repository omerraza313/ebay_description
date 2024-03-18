<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attribute;
use Illuminate\Support\Facades\DB;

class AttributeController extends Controller
{
    public function attributes()
    {
        $attributes = Attribute::paginate(25);
        
        return view('admin.attribute.index', compact('attributes'));
    }

    public function addAttribute(){

        return view('admin.attribute.add_attribute');
    }

    public function createAttribute(Request $request)
    {
        //return $request;

        $validatedData = $request->validate([
            'name' => 'required|unique:attributes'
        ]);

        // print_r($validatedData);
        // echo $validatedData['name'];
        // die();
        $attribute = new Attribute;
        $attribute->name = $validatedData['name'];
        $attribute->save();
        DB::table('attributes')->where('id', $attribute->id)->update(['sort_order' => $attribute->id]);

        return redirect()->route('admin.attribute.add')->with('success', 'New attribute added!');

    }

    public function editAttribute(Attribute $attribute)
    {
        return view('admin.attribute.edit_attribute', compact('attribute'));
    }

    public function updateAttribute(Request $request, Attribute $attribute)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // Add any other validation rules as needed
        ]);

        $attribute->update([
            'name' => $request->input('name'),
            // Add other attributes as needed
        ]);

        return redirect()->route('admin.attributes')->with('success', 'Attribute updated successfully.');
    }

    public function destroy(Attribute $attribute)
    {
        // echo $attribute->id;
        //  return $attribute;
        DB::table('attribute_product')->where('attribute_id', $attribute->id)->delete();
         $attribute->delete();
        
         return redirect()->route('admin.attributes')->with('delete', 'Attribute deleted');
    }

}
