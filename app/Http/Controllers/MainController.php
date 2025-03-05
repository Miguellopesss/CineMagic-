<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Genre;
use App\Models\Screening;
use Illuminate\Contracts\View\View;
use Carbon\Carbon;

class MainController extends Controller
{
    public function index() : View
    {
        $today = Carbon::today();
        $twoWeeksLater = Carbon::today()->addWeeks(2);

        $idMovies = Screening::whereBetween('date', [$today, $twoWeeksLater])->pluck('movie_id')->toArray();
        $moviesCartaz = Movie::whereIn('id', $idMovies)->distinct()->get();

        // Obtendo os códigos dos gêneros dos filmes em cartaz
        $genreCodes = $moviesCartaz->pluck('genre_code')->unique();

        // Obtendo os gêneros relacionados a esses códigos
        $genres = Genre::whereIn('code', $genreCodes)->get();

        return view('home', compact('genres', 'moviesCartaz'));
    }
}

