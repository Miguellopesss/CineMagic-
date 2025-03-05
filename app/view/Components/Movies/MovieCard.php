<?php

namespace App\View\Components\Movies;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MovieCard extends Component
{
    public $movie;
    public $ano;

    /**
     * Create a new component instance.
     */
    public function __construct($movie, $ano = false)
    {
        $this->movie = $movie;
        $this->ano = $ano;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.movies.movie-card');
    }
}
