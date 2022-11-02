<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        //Get - all data from database
        $products = Product::all();
        return response()->json($products);
    }


    public function store(Request $request)
    {
        //post - data to database

        //validation

        $this->validate($request,[
            'title' => 'required',
            'price' => 'required',
            'photo' => 'required',
            'description'=> 'required'
        ]);

        $product = new Product();
        //image upload
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $allowedfileExtention = ['pdf','png','jpg'];
            $extention = $file->getClientOriginalExtension();
            $check = in_array($extention , $allowedfileExtention);

            if($check){
                $name = time(). $file->getClientOriginalName();
                $file->move('images',$name);
                $product->photo = $name;
            }
        }

        //text data
        $product->title = $request->input('title');
        $product->price = $request->input('price');
        $product->description = $request->input('description');

        $product->save();

        return response()->json($product);


    }


    public function show($id)
    {
        // give 1 items from products tables
        $product = Product::find($id);
        return response()->json($product);
    }



    public function update(Request $request, $id)
    {
        //update - id
        $this->validate($request,[
            'title' => 'required',
            'price' => 'required',
            'photo' => 'required',
            'description'=> 'required'
        ]);

        $product = Product::find($id);

        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $allowedfileExtention = ['pdf','png','jpg'];
            $extention = $file->getClientOriginalExtension();
            $check = in_array($extention , $allowedfileExtention);

            if($check){
                $name = time(). $file->getClientOriginalName();
                $file->move('images',$name);
                $product->photo = $name;
            }
        }

        $product->title = $request->input('title');
        $product->price = $request->input('price');
        $product->description = $request->input('description');

        $product->save();

        return response()->json($product);


    }


    public function destroy($id)
    {
        //delete - id
        $product = Product::find($id);
        $product->delete();
        return response()->json('Product deleted Successfully');
    }
}
