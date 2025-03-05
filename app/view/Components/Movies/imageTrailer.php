<?php

namespace App\View\Components\movies;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class imageTrailer extends Component
{
    public $movie;
    public $overview;
    public $button;

    public function __construct($movie, $overview = false, $sessions = false, $button = false)
    {
        $this->movie = $movie;
        $this->overview = $overview;
        $this->button = $button;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.movies.image-trailer');
    }
}
