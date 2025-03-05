<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function salesStatistics()
    {
        // Média de vendas por filme
        $averageSalesPerMovie = Purchase::select('movies.title', DB::raw('AVG(purchases.total_price) as avg_sold'))
            ->join('tickets', 'purchases.id', '=', 'tickets.purchase_id')
            ->join('screenings', 'tickets.screening_id', '=', 'screenings.id')
            ->join('movies', 'screenings.movie_id', '=', 'movies.id')
            ->groupBy('movies.title')
            ->get();

        // Total de vendas por dia
        $totalSalesPerDay = Purchase::select(DB::raw('DATE(purchases.date) as purchase_date'), DB::raw('SUM(purchases.total_price) as total_sales'))
            ->groupBy('purchase_date')
            ->get();

        return view('statistics.sales_statistics', [
            'averageSalesPerMovie' => $averageSalesPerMovie,
            'totalSalesPerDay' => $totalSalesPerDay,
        ]);
    }
}
