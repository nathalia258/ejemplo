<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    
    public function index(){
        try{
             $productos = Product::all();
             return response()->json([
                 'productos' => $productos,
             ]);
         }
         catch(\Exception $e){
            return response()->json([
                 'error' => $e-> getMessage()
        ]);
    }
    }
    
    public function show($id){
        $product=Product::find($id);
        return response()->json([
            'producto' => $product       
        ]);
    }

    public function create(Request $request){
        try{
            $request->validate([
                'name'=> 'required|string',
                'price' => 'required|numeric',
                'description'=> 'string',
                'quantity'=> 'required|integer',
                'serial'=> 'required|string|unique:products',
                'featured' => 'nullable|boolean'
            ]);

        $product=Product::create([
        'name'=> $request->name,
        'price' => $request->price,
        'description'=> $request->description,
        'quantity'=> $request->quantity,
        'serial'=> $request->serial,
        'featured' => $request->featured,
        ]);
        return response()->json([
            'product'=>$product,
            'Mensaje'=>'Producto creado correctamente'
        ]);
        }catch(\Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
            
        }
    }
    public function  destroy($id){
        try{
            
            $product = Product::find($id);
            if(!$product){
                return response()->json([
                    'error' => 'Product not found',
                ], 404);
            }
            Product:: destroy($id);
            return response()->json([
                'message' => 'product deleted seccessfully',
            ], 200);
        }catch (\Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
    public function findbyserial($serial){
        try{
            $product=Product::where('serial', $serial)->first();
            return $product;
        }catch(\Exception $e){
            return response()->json([
                'error' => 'product not created'
            ],404);
        }
    }
    public function update($id, Request $request){
        try{
            $request->validate([
                'name'=> 'string',
                'price' => 'numeric',
                'description'=> 'string',
                'quantity'=> 'integer',
                'serial'=> 'string|unique:products',
                'featured' => 'boolean'
            ]);
            $product = Product::find($id);
            if(!$product){
                return response()->json([
                    'Mensaje'=> 'Producto no encontrado' 
                ]);
            }
            $product = Product::find($id)->update($request->all());
            $product = Product::find($id);
            return response()->json([
                "Respuesta"=>$product
            ]);
            
        }catch(\Exception $e){
            return response()->json([
                'error' => ''
            ]);
        }
    }
    
}