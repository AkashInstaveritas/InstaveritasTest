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
        $cart = $this->user->find($this->currentUser()->id)->cart()->get();

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
        if(!empty($this->checkProduct($data['product_id'])))
        {
           return $this->incrementProductQuantity($data['product_id']);
        }
        else
        {
            Cart::create([
            'user_id'    => $this->currentUser()->id,
            'product_id' => $data['product_id'],
            'quantity'   => $data['quantity'],
            ]);

            $message = "Product added to cart!";

            return $message;
        }

         
        
    }

    /**
     * Update the specified resource from storage.
     *
     * @param Request $request, int  $id
     * @return Perform delete operation on cart product
     */
    public function update(array $data, $id)
    {
        $cart = $this->checkProduct($id);
        
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

    public function checkProduct($id)
    {
        $cart = Cart::where([
                    ['user_id', $this->currentUser()->id],
                    ['product_id', $id],
                ])->first();

        return $cart;
    }

    public function incrementProductQuantity($id)
    {
        $cart = $this->checkProduct($id);

        if($cart->quantity <= 2)
        {
            $qty = $cart->quantity + 1;
        
            $cart->update(['quantity' => $qty]);

            $message = "Product already added, Cart Updated!";

            return $message;
        }

        $message = "Product already added, Reached maximum quantity!";

        return $message;
        
    }
    

}