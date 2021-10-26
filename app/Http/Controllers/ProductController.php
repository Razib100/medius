<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Illuminate\Http\Request;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $products = Product::all();
        $product_variants = ProductVariant::all();
        return view('products.index',compact('products','product_variants'));
    }

    public function filter(Request $request)
    {
        $query = DB::table('products')
            ->select('products.id')
            ->join('product_variants', 'product_variants.product_id', '=', 'products.id')
            ->join('product_variant_prices', 'product_variant_prices.product_id', '=', 'products.id');
        if ($request->title) {
            $query->where('products.title','like',$request->title);
        }
        if ($request->date) {
            $query->where('products.created_at','like','%'.$request->date.'%');
        }
        if ($request->variant) {
            $query->where('product_variants.variant','like',$request->variant);
        }
        if ($request->price_from) {
            $query->where('product_variant_prices.price','>=',$request->price_from);
        }
        if ($request->price_to) {
            $query->where('product_variant_prices.price','<=',$request->price_to);
        }
        $result= $query->pluck('id');    

        $products = Product::whereIn('id', $result)->get();
        $product_variants = ProductVariant::all();

        return view('products.index',compact('products','product_variants'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $variants = Variant::all();
        return view('products.edit', compact('variants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
