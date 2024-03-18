<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HtmlContent;

class FormController extends Controller
{

    public function index(){

        $list = HtmlContent::all();

        return view('front.index', compact('list'));
    }

    public function showForm()
    {
        return view('front.form');
    }

    // public function login_page(){
    //     return view('login_page');
    // }

    public function processForm(Request $request)
    {
        // return $request;

        // Validate the form data
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'sku' => 'required|string|max:50',
            'price' => 'required|numeric',
        ]);

       

        // Generate HTML
        $html = view('front.product_layout', $validatedData)->render();

        // Save HTML to the database
        $htmlContent = new HtmlContent();
        $htmlContent->product_name = $validatedData['product_name'];
        $htmlContent->sku = $validatedData['sku'];
        $htmlContent->price = $validatedData['price'];
        $htmlContent->html = $html;
        $htmlContent->save();

        return redirect()->route('show.form')->with('success', 'HTML generated and saved successfully!');
    }

    public function viewHtml($id)
    {
        $htmlContent = HtmlContent::findOrFail($id);

        echo $htmlContent->html;
        // return view('front.view_html', compact('htmlContent'));
    }

}
