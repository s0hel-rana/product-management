<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;

class ProductController extends Controller
{
    
    public function index()
    {
        $perPage = 10;
        $total = count(Product::all());

        if(request()->keyword){
            // paginating products
            $products = Product::latest()->where('title','like', '%'.request()->keyword. '%')->get();
            $searching = true;
            return view('products.index',compact('products', 'perPage', 'total', 'searching'));
        }
        else{
            $products = Product::latest()->paginate($perPage);
            $searching = false;
            return view('products.index',compact('products', 'total', 'perPage', 'searching'));
        }
        
    }

    public function create()
    {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }

   
    public function store(Request $request)
    {
        try{
            Product::create([
                'title'=> $request->title ?? null,
                'sku'=> $request->sku ?? null,
                'description'=> $request->description ?? null
            ]);
            return response()->json([
                'success' => true
            ]);

        }catch(Exception $e){
            dd($e->getMessage());
        }
    }


    public function show($product)
    {
    //
    }

    public function edit(Product $product)
    {  
        $variants = Variant::all();
        return view('products.edit', compact('product','variants'));
    }

    public function update(Request $request, Product $product)
    {
        $product->update([
            'title'=> $request->title ,
            'sku'=> $request->sku,
            'description'=> $request->description
            ]);
            return response()->json([
                'success' => true
            ]);
    }

    public function destroy(Product $product)
    {
        //
    }
}
