<?php 

namespace App\Repositories\Eloquent;

use Auth;
use App\User;
use App\Models\Cart;
use Illuminate\Database\Eloquent\Model;  


class CartRepository 
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
    
    public function userCart()
    {
        $cart = $this->user->find(auth('api')->user()->id)->cart()->get();

        return $cart;
    }

    /**
     * Create new entry in the cart for the authenticated user 
     *
     * @param Request $data
     * @return Perform Created data
     */
    public function create(array $data)
    {
        return  Cart::create([
                    'user_id'    => $this->currentUser()->id,
                    'product_id' => $request->product_id,
                    'quantity'   => $request->quantity,
                ]);
        
    }

    /**
     * Update the specified resource from storage.
     *
     * @param Request $request, int  $id
     * @return Perform delete operation on cart product
     */
    public function update(array $data, $id)
    {
        $cart =Cart::where([
                    ['user_id', $this->currentUser()->id],
                    ['product_id', $id],
                ])->firstorFail();
        
        return $cart->update(['quantity' => $data['quantity']]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Perform delete operation on cart product
     */
    public function delete($id)
    {
        return  Cart::where([
                    ['user_id', $this->currentUser()->id],
                    ['product_id', $id],
                ])->firstorFail()->delete();
    }
    

}