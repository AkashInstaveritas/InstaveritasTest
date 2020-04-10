<?php 

namespace App\Repositories\Eloquent;

use App\User;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Model;  
use Auth;
use App\Jobs\OrderPlacedJob;


class OrderRepository 
{
	/**      
     * @var Model      
     */     
     protected $order; 
     protected $user;       

    /**      
     * ProductRepository constructor.      
     *      
     * @param Product $model      
     */     
    public function __construct(Order $order, User $user)     
    {         
        $this->order = $order;
        $this->user = $user;
    }

	public function currentUser()
    {
        $user = auth('api')->user();

        return $user;
    }

    public function find($id)
    {
        return $this->order::findorFail($id);
    }

    public function userOrders()
    {
        $order = $this->user->find($this->currentUser()->id)->orders()->orderBy('created_at', 'desc')->get();

        return $order;
    }

    public function cartContents()
    {
        $contents = $this->user->find($this->currentUser()->id)->cart()->get();

        return $contents;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Array $data
     * @return \Addition of new address
     */
    public function create(array $data)
    {
        $order  =   Order::create([
                        'user_id'       => $this->currentUser()->id,
                        'email'         => $this->currentUser()->email,
                        'phone'         => $this->currentUser()->phone,
                        'address_id'    => $data['address_id'],
                        'type'          => 'cod',
                        'discount'      => isset($data['discount']) ? $data['discount'] : null,
                        'discount_code' => isset($data['discount_code']) ? $data['discount_code'] : null,
                        'tax'           => $this->getNumbers()->get('tax'),
                        'subtotal'      => $this->getNumbers()->get('subTotal'),
                        'total'         => $this->getNumbers()->get('total'),
                        'status'        => 0,
                    ]);

        //Insert into order_product table
        foreach ($this->cartContents() as $content) 
        {
            OrderProduct::create([ 
                'order_id' => $order->id, 
                'product_id' => $content->pivot->product_id,
                'quantity' => $content->pivot->quantity,
            ]);
        }

        $this->decreaseQuantities();
        $this->emptyCart();

        //OrderPlaced::dispatch($podcast);

        return $order;

    }

    /**
     * Decrease of the quantity of the products that are placed in the order.
     *
     * @param  \Authenticated user's cart products
     * @return \Update products quantities.
     */
    public function decreaseQuantities()
    {
        foreach ($this->cartContents() as $content) 
        {
            $product = Product::findorFail($content->pivot->product_id);
        
            return $product->update(['quantity' => $product->quantity - $content->pivot->quantity]);
        }
    }

    /**
     * Check whether products in the cart are in stock or not
     *
     * @param  \Authenticated user's cart products
     * @return \True or false
     */
    public function emptyCart()
    {
        return Cart::where('user_id', $this->currentUser()->id)->delete();
    }

    /**
     * Check whether products in the cart are in stock or not
     *
     * @param  \Authenticated user's cart products
     * @return \True or false
     */
    public function productsNoLongerAvailable()
    {
        foreach($this->cartContents() as $content)
        {
            $product = Product::findorFail($content->pivot->product_id);

            if($product->quantity < $content->pivot->quantity)
            {
                return true;
            }
        }

        return false;
    }

    /**
     * Check whether products in the cart are in stock or not
     *
     * @param  \Authenticated user's cart products
     * @return \True or false
     */
    public function getNumbers()
    {
        $cartSubTotal = array();

        foreach($this->cartContents() as $content)
        {
            $product = Product::findorFail($content->pivot->product_id);

            $cartSubTotal[] = $product->price * $content->pivot->quantity;

        }

        $cartTotal = array_sum($cartSubTotal);
        $tax = 1;

        $subTotal = $cartTotal;
        $total = $cartTotal * $tax/100 + $cartTotal;

        return collect([
            'tax' => $tax,
            'subTotal' => $subTotal,
            'total' => $total,
        ]);
    }

    public function cancel($id)
    {
        $order = Order::where([
                                ['user_id', $this->currentUser()->id],
                                ['id', $id]
                        ])->firstOrFail();

        $order->update(['status' => 1]);

        $orderProducts = OrderProduct::where('order_id', $order->id)->get();

        foreach($orderProducts as $orderProduct)
        {
            $product = Product::find($orderProduct->product_id);

            $product->update(['quantity' => $product->quantity + $orderProduct->quantity]);
        }

        return $order;

    }



}