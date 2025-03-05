<?php

namespace App\View\Components\Tickets;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component
{
    public $tickets;
    public $showView;
    public $showDelete;
    public $showRemoveFromCart;

    /**
     * Create a new component instance.
     */
    public function __construct($tickets, $showView = false, $showDelete = true, $showRemoveFromCart = false)
    {
        $this->tickets = $tickets;
        $this->showView = $showView;
        $this->showDelete = $showDelete;
        $this->showRemoveFromCart = $showRemoveFromCart;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tickets.table');
    }
}
