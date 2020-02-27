<?php

namespace App\Mail;

use App\Models\Order;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlaced extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('akashsingh@instaveritas.com', 'DummyEcommerce')
                    ->to($this->order->email, $this->order->user->name)
                    ->bcc('someother@gmail.com')
                    ->subject('Order Placed through DummyEcommerce')
                    ->view('view.name');
    }

}
