<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use mysql_xdevapi\Table;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return Inertia::render('Products', [
            'products' => $products,
        ]);
    }

    public function exportToXml(Request $request)
    {
        $request->validate([
            'items' => 'required'
        ]);

        return json_encode($request->items);
    }

    public function exportToJson(Request $request)
    {
        $request->validate([
            'items' => 'required'
        ]);

        return json_encode($request->items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return Inertia::render('Product/Show', [
            'product' => $product->only('id', 'name', 'price', 'description', 'is_active'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
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
        $quantity = '';
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
