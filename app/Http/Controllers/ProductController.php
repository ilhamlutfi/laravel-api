<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductSingleResource;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function __construct()
    {
        // deklarasi middleware, selain function index dan show, required auth
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // tampil seluruh data dengan resource
        return ProductResource::collection(Product::latest()->paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        // set otorisasi harus admin
        $this->authorize('if_admin');

        // simpan request di $product dan create ke database
        $product = Product::create($request->toArray());

        // kembalikan response 
        return response()->json([
            'message' => 'Product was created',
            'data' => new ProductSingleResource($product)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // tampil data tertentu berdasarkan resource
        return new ProductSingleResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        // simpan request di $product dan update ke database
        $attributes = $request->toArray();
        $attributes['slug'] = Str::slug($request->name); // update slug

        $product->update($attributes);

        // kembalikan response 
        return response()->json([
            'message' => 'Product was updated',
            'data' => new ProductSingleResource($product)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        // kembalikan response 
        return response()->json([
            'message' => 'Product was deleted',
        ]);
    }
}
