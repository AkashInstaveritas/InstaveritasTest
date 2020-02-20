<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth; 

class WishListController extends Controller
{
    public $successStatus = 200;

    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array (            
                        'product_id' => 'required',      
        );

        $validator = Validator::make($request->all(), $rules);        
        
        if ($validator-> fails())
        {               
            return response()->json(['success' => true, 'data' => $validator->errors()], $this->successStatus);     
        }

        $user = Auth::guard('api')->user();

        $wishlist = Wishlist::create([
                        'user_id' => $user->id,
                        'product_id' => $request->product_id,
        ]);

        $data = 'Product added to wishlist.';

        return response()->json(['success' => true, 'data' => $data], $this->successStatus);  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
