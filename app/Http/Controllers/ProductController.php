<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;

class ProductController extends Controller
{
    /**
     * CREATE NEW PRODUCTS
     */
    function CreateProduct(Request $request){
        $request->validate([
            'name'=> 'required',
            'description'=> 'required',
            'skuNumber'=> 'required',
            'category'=> 'required',
            'supplier'=> 'required',
            'numberAvailable'=> 'required',
            'price'=> 'required'
        ]);
        $product = ProductModel::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'skuNumber'=>$request->skuNumber,
            'category'=>$request->category,
            'supplier'=>$request->supplier,
            'numberAvailable'=>$request->numberAvailable,
            'price'=>$request->price,
        ]);
        $product= ProductModel::find($product->id);
        if($product){
            return response(
                [
                    'message'=>'Product added successfully!',
                    'product'=>$product,
                    'status'=>200
                ]
                );
        }
        else{
            return response([
                'message'=>'error',
                'product'=>'product does not exist!',
                'status'=>404
            ]);
        }
    }
/**
 * GET ALL PRODUCTS
 */
    function getAllProducts(){
        $products = ProductModel::all();
        if($products){
            return response([
                'message'=>'success',
                'products'=>$products,
                'status'=>200

            ]);
        }
        else{
            return response([
                'message'=>'error',
                'products'=>'No products found in database',
                'status'=>404
            ]);
        }
    }
    /**
     * GET ONE PRODUCT
     */
    function getProduct(Request $request, $id){
       
        $product = ProductModel::find($id);
        if($product){
            return response([
                'message'=>'success',
                'products'=>$product,
                'status'=>200
            ]);
        }
        else{
            return response([
                'message'=>'Product ID does not exist!',
                'products'=>'Product does not exist!',
                'status'=>404
            ], 404);
        }
    }

    /**
     * UPDATING A PRODUCT
     */
    function updateProduct(Request $request, $id){
        $request -> validate([
            'id'=>'required',
            'name'=> 'required',
            'description'=> 'required',
            'skuNumber'=> 'required',
            'category'=> 'required',
            'supplier'=> 'required',
            'numberAvailable'=> 'required',
            'price'=> 'required'
        ]);
        $product = ProductModel::find($id);
        if($product){
            $product->name=$request->name;
            $product->description=$request->description;
            $product->skuNumber=$request->skuNumber;
            $product->category=$request->category;
            $product->supplier=$request->supplier;
            $product->numberAvailable=$request->numberAvailable;
            $product->price=$request->price;

            $product->save();

            return response([
                'message'=>'Product updated successfully!',
                'products'=>$product,
                'status'=>200
            ]);
        }
        else{
            return response([
                'message'=>'Product does not exist!',
                'products'=>'Product doesn\'t exist!',
                'status'=>404
            ]);

        }
    }
    /**
     * DELETING A PRODUCT
     */
    function deleteProduct(Request $request, $id){
       
        $product=ProductModel::find($id);

        if($product){
            $product->delete();
            return response([
                'message'=>'Product has been deleted successfully!',
                'products'=>'Product has been deleted successfully!',
                'status'=>200
            ]);
        }
        else{
            return response([
                'message'=>'Product does not exist!',
                'products'=>'Product does not exist!',
                'status'=>404
            ]);
        }
    }
    
}
