<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        return Product::with('category')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'image'       => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'expired_at'  => 'nullable|date'
        ]);

        $product = Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'image'       => $request->image,
            'category_id' => $request->category_id,
            'expired_at'  => $request->expired_at,
            'modified_by' => Auth::user()->email
        ]);

        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        return $product->load('category');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'image'       => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'expired_at'  => 'nullable|date',
        ]);

        $product->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'image'       => $request->image,
            'category_id' => $request->category_id,
            'expired_at'  => $request->expired_at,
            'modified_by' => Auth::user()->email, // update modified_by dengan email user sekarang
        ]);

        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }
}
