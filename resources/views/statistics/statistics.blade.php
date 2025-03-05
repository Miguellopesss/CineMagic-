<!-- resources/views/statistics/statistics.blade.php -->
@extends('layouts.main')

@section('main')

    <h1>Média de Vendas por Filme</h1>

    <table>
        <thead>
            <tr>
                <th>Filme</th>
                <th>Média de Preco Bilhete</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($averageSalesPerMovie as $average)
                <tr>
                    <td>{{ $average->title }}</td>
                    <td>{{ $average->avg_sold }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
