<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Products;
use App\Models\Sections;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Products::with('sections')->get();
        $sections = Sections::all();
        // return $sections;
        // return $product->id;
        // $products = Products::all();
        // $section = $products->section->name;
        // return $section;
        return view('products.products', compact('products','sections'));
    }


    public function store(ProductRequest $request)
    {
        $section_id =Sections::where('section_name',$request->section_name)->first();
        
// return $request;
        Products::create([
            'product_name'=>$request->product_name,
            'description'=>$request->description,
            'section_id'=>$section_id->id
        ]);
        
        session()->flash('add','تم اضافة المنتج بنجاح');
                return redirect('products');

    }

    public function update(ProductRequest $request){
        $product = Products::find($request->id);
        $section_id =Sections::where('section_name',$request->section_name)->first();
        $product->update([
            'product_name'=>$request->product_name,
            'description'=>$request->description,
            'section_id'=>$section_id->id
        ]);
        session()->flash('update','تم تعديل المنتج بنجاح');
        return redirect('products');

    }

    public function delete($id){
        $product = Products::find($id);
        $product->delete();
        session()->flash('delete','تم حذف المنتج بنجاح');
        return redirect('products');

    }
}
