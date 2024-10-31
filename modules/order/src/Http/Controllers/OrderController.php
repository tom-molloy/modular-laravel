<?php

namespace Modules\Order\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Modules\Order\Models\Order;

class OrderController
{
    public function index(): View
    {
        $orders = Order::all();

        return view('order::index', ['orders' => $orders]);
    }

    public function create(): View
    {
        $products = [
            (object) [
                "name" =>  "Umbrella",
                "price" => 12
            ],
            (object) [
                "name" =>  "Raincoat",
                "price" => 80
            ],
            (object) [
                "name" =>  "Gumboots",
                "price" => 45
            ],
        ];

        return view('order::create', ['products' => $products]);
    }

    public function store(): View
    {
        
        
        return $this->index();
    }
}
