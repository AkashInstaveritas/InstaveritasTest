<?php

namespace App\Repositories\Eloquent;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Wishlist;
use Auth;


class WishlistRepository
{
	/**
     * @var Model
     */
     protected $user;

    /**
     * ProductRepository constructor.
     *
     * @param Product $model
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

	public function currentUser()
    {
        $user = auth('api')->user();

        return $user;
    }

	/**
    * @param collection BelongsToMany
    *
    * @return Model
    */

    public function userWishlist()
    {
        $wishlist = $this->user->find(auth('api')->user()->id)->wishlist()->get();

        return $wishlist;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Array $data
     * @return \Illuminate\Http\Response
     */
    public function create(array $data)
    {

        return  Wishlist::create([
                    'user_id' => $this->currentUser()->id,
                    'product_id' => $data['product_id'],
                ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        return  Wishlist::where([
                    ['user_id', $this->currentUser()->id],
                    ['product_id', $id],
                ])->firstorFail()->delete();

    }


}
