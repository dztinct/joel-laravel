<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function create(Request $request){
        try {
            $validated = $request->validate([
                'price' => 'required|numeric',
                'name' => 'required|string',
                'description' => 'required|string',
                'size' => 'required|string',
            ]);
    
            $formFields = [
                'price' => $validated['price'],
                'name' => $validated['name'],
                'description' => $validated['description'],
                'size' => $validated['size'],
                'user_id' => auth()->id()
            ];
    
            $product = Product::create($formFields);
            return response()->json(['message' => $product], 201);
        } catch (Exception $e) {
            Log::error(['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    
    public function all(){
        try {

            // $products = Product::get();
            $products = Product::orderBy('created_at', 'desc')->get();
            // $products = Product::orderBy('created_at', 'desc')->limit(2)->get();
            // $products = Product::orderBy('created_at', 'desc')->paginate(2);
            return response()->json(['message' => $products], 200);
        } catch (Exception $e) {
            Log::error(['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function single($id){
        try{
            $product = Product::where('id', $id)->first();
            if(!$product){
                return response()->json(['message' => "Product does not exists"], 404);
            }
            return response()->json(['message' => $product], 200);
        }catch (Exception $e) {
            Log::error(['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function delete($id){
        try{
            $product = Product::where('id', $id)->first();
            if(!$product){
                return response()->json(['message' => "Product does not exists"], 404);
            }
            $product->delete();
            return response()->json(['message' => "delete successful"], 200);
        }catch (Exception $e) {
            Log::error(['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function singleProductData($product_id){
        try{
            $product_data = Product::where('id', $product_id)->with(['user'])->get();
            return response()->json(['message' => $product_data], 200);
        } catch (Exception $e) {
            Log::error(['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    
    public function allProductData(){
        try{
            $product_data = Product::with(['user'])->get();
            return response()->json(['message' => $product_data], 200);
        } catch (Exception $e) {
            Log::error(['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}