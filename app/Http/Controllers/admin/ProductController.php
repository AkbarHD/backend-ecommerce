<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        // with('category', 'brand')->
        if (!$products) {
            return response()->json([
                'status' => 404,
                'message' => 'No products found'
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'data' => $products
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id|integer',
            'is_featured' => 'required',
            'sku' => 'required|unique:products,sku',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ], 400);
        }

        $product = new Product();
        $product->title = $request->title;
        $product->price = $request->price;
        $product->compare_price = $request->compare_price;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->sku = $request->sku;
        $product->qty = $request->qty;
        $product->description = $request->description;
        $product->short_description = $request->short_description;
        $product->status = $request->status;
        $product->is_featured = $request->is_featured;
        $product->barcode = $request->barcode;
        $product->save();

        return response()->json([
            'status' => 200,
            'message' => 'Product created successfully',
            'data' => $product
        ], 200);

    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        if (!$product) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found'
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'data' => $product
        ]);
    }

    public function update(Request $request, $id)
    {
        // $product = new Product();
        $product = Product::findOrFail($id);
        if (!$product) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id|integer',
            'is_featured' => 'required',
            'sku' => 'required|unique:products,sku,' . $id . ',id',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ], 400);
        }

        $product->title = $request->title;
        $product->price = $request->price;
        $product->compare_price = $request->compare_price;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->sku = $request->sku;
        $product->qty = $request->qty;
        $product->description = $request->description;
        $product->short_description = $request->short_description;
        $product->status = $request->status;
        $product->is_featured = $request->is_featured;
        $product->barcode = $request->barcode;
        $product->save();

        return response()->json([
            'status' => 200,
            'message' => 'Product updated successfully',
            'data' => $product
        ], 200);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if (!$product) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found'
            ], 404);
        }
        $product->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Product deleted successfully'
        ], 200);
    }
}
