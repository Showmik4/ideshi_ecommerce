<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function view_cart()
    {
        return view('frontend.cart');
    }

    public function checkout()
    {
        return view('checkout');
    }
}
