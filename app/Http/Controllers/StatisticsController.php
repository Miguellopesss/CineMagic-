<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function averageSalesPerMovie()
    {
        $averageSalesPerMovie = Ticket::select('movies.title', DB::raw('AVG(tickets.price) as avg_sold'))
            ->join('screenings', 'tickets.screening_id', '=', 'screenings.id')
            ->join('movies', 'screenings.movie_id', '=', 'movies.id')
            ->groupBy('movies.title')
            ->get();

        return view('statistics.statistics', [
            'averageSalesPerMovie' => $averageSalesPerMovie,
        ]);
    }
}
