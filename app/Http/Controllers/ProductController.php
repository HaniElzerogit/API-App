<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Validator; //للتأكد من صحة معلومات المستخدم المرسلة

class ProductController extends Controller
{
    public function index() {
        $product = Product::all();
        return response()->json( [
            'success' => true ,
            'message' => 'All products' ,
            'data' => $product
        ]
        );
    }
    public function store(Request $request) {
        $input = $request->all();
        $validator = Validator::make($input , [
            'name' => 'required' ,
            'detail' => 'required' ,
        ]);
        if ($validator->fails()) {
            return response()->json( [
                'fails' => false ,
                'message' => 'product not stored' ,
                'error' => $validator->errors()
            ]
            );
        }
        $product = Product::create($input) ;
        return response()->json( [
            'success' => true ,
            'message' => 'product stored successfully' ,
            'data' => $product
        ]
        );

    }
    public function show($id) {
        $product = Product::find($id) ; 
        if (is_null($product)) {
            return response()->json( [
                'fails' => false ,
                'message' => 'product not found' ,
            ]
            );
        }
        return response()->json( [
            'success' => true ,
            'message' => 'product fetched successfully' ,
            'data' => $product
        ]
        );

    }
    public function update(Request $request , Product $product) {
        $input = $request->all();
        $validator = Validator::make($input , [
            'name' => 'required' ,
            'detail' => 'required' ,
        ]);
        if ($validator->fails()) {
            return response()->json( [
                'fails' => false ,
                'message' => 'product not stored' ,
                'error' => $validator->errors()
            ]
            );
        }
        $product->name = $input ['name'] ;
        $product->detail = $input['detail'] ;
        $product->save();
        return response()->json( [
            'success' => true ,
            'message' => 'product has been updated successfully' ,
            'data' => $product
        ]
        );

    }
    public function destroy(Product $product) {
        $product->delete();
        return response()->json( [
            'success' => true ,
            'message' => 'product has been deleted successfully' ,
            'data' => $product
        ]
        );

    }
}
