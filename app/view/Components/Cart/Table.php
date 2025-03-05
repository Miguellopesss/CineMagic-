<?php

namespace App\View\Components\Cart;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;


class Table extends Component
{
    public $cart;
    public $showView;
    public $showDelete;

    /**
     * Create a new component instance.
     *
     * @param  array  $cart
     * @param  bool  $showView
     * @param  bool  $showDelete
     * @return void
     */
    public function __construct($cart, $showView = false, $showDelete = true)
    {
        $this->cart = $cart;
        $this->showView = $showView;
        $this->showDelete = $showDelete;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('components.cart.table');
    }
}

