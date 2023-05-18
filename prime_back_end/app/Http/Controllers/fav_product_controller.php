<?php

namespace App\Http\Controllers;

use App\Models\fav_product_model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class fav_product_controller extends Controller
{
    public function index(){
        $fav_product = fav_product_model::all();
        
     if($fav_product ->count() > 0){
         $data =[ 
             'status' => 200,
             'products' => $fav_product
     
             ];
 
         return response()->json($data, 200);
         
     }else{
         return response()->json([
             'status' => 404,
             'message' => 'No product registerd'
         ], 404);
     }
   
     }




     public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'fav_product_name' => 'required|string|max:191',
        'fav_product_image' => ['required', 'string', 'regex:/^(http)?s?:?(\/\/[^\']*\.(?:png|jpg|jpeg))$/'],
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 422,
            'error' => $validator->messages()
        ], 422);
    } else {
        // Since the input is an image URL, you don't need to handle file uploads
        $imageUrl = $request->input('fav_product_image');

        $productData = [
            'fav_product_name' => $request->input('fav_product_name'),
            'fav_product_image' => $imageUrl,
        ];

        $product = fav_product_model::create($productData);

        if ($product) {
            return response()->json([
                'status' => 200,
                'message' => 'Product added successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong!'
            ], 500);
        }
    }
}

public function update(Request $request, int $id)
{
    $validator = Validator::make($request->all(), [
        'fav_product_name' => 'required|string|max:191',
        // 'fav_product_image' => ['required', 'string', 'regex:/^(http)?s?:?(\/\/[^\']*\.(?:png|jpg|jpeg))$/'],
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 422,
            'error' => $validator->messages()
        ], 422);
    }

    $product = fav_product_model::find($id);

    if (!$product) {
        return response()->json([
            'status' => 404,
            'message' => 'Product Not Found! :(',
        ], 404);
    }

    $product->update($request->only([
        'fav_product_name',
    ]));

  
    return response()->json([
        'status' => 200,
        'message' => 'Product Updated Successfully',
    ], 200);
}





public function edit($id){
    $fav_product = fav_product_model::find($id);

    if($products){
        return response()->json([
            'status' => 200,
            'product' => $products
        ], 200);
        
    }else{
        return response()->json([
            'status' => 404,
            'message' => 'Product Not Found :('
        ], 404);
        

    }

}



public function destroy($id){
    $fav_product = fav_product_model::find($id);
    if($fav_product){
        $fav_product->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Product deleted successfully'
        ]);
    } else {
        return response()->json([
            'status' => 404,
            'message' => 'Product not found'
        ], 404);
    }
}






}
