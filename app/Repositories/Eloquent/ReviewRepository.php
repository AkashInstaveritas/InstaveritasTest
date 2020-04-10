<?php

namespace App\Repositories\Eloquent;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review;
use App\Models\Product;
use Auth;


class ReviewRepository
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
     * Store a newly created resource in storage.
     *
     * @param  Array $data
     * @return \Illuminate\Http\Response
     */
    public function create(array $data)
    {
        return  Review::create([
                    'user_id'     => $this->currentUser()->id,
                    'product_id'  => $data['product'],
                    'rating'      => $data['rating'],
                    'description' => isset($data['description']) ? $data['description'] : null,
                ]);
    }


}
