<?php

namespace App\Http\Controllers;

use App\Models\Theater;
use App\Models\Seat;
use App\Models\Movie;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Requests\TheaterFormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;


class TheaterController extends Controller
{
    public function index(Request $request) : View
    {
        $query = Theater::query()
            ->leftJoin('seats', function ($join) {
                $join->on('theaters.id', '=', 'seats.theater_id')
                     ->whereNull('seats.deleted_at');
            })
            ->select('theaters.*', DB::raw('COUNT(seats.id) as total_seats'))
            ->groupBy('theaters.id');

        if ($request->has('nome') && !empty($request->get('nome'))) {
            $query->where('theaters.name', 'like', '%' . $request->get('nome') . '%');
        }

        $allTheaters = $query->paginate(10);

        return view('theaters.index', compact('allTheaters'));
    }



    public function show(Theater $theater): View
    {
        $seats = Seat::where('theater_id', $theater->id)->get();

        return view('theaters.show', compact('theater', 'seats'));
    }

    public function create(): View
    {
        $newTheater = new Theater();
        return view('theaters.create')->with('theater', $newTheater);
    }

    public function store(TheaterFormRequest $request): RedirectResponse
    {
        // Valida os dados do formulário usando TheaterFormRequest
        $validatedData = $request->validated();

        // Inicia uma transação para garantir consistência
        return DB::transaction(function () use ($validatedData) {
            // Cria o teatro com os dados básicos
            $newTheater = Theater::create([
                'name' => $validatedData['nome'],
            ]);

            // Verifica se o teatro foi criado com sucesso
            if (!$newTheater) {
                throw new \Exception('Erro ao criar o teatro.');
            }

            // Gera os assentos com base no número de filas e lugares por fila informados no formulário
            $numRows = (int) $validatedData['num_rows'];
            $numSeatsPerRow = (int) $validatedData['num_seats_per_row'];

            // Array de letras para as filas (rows)
            $rows = range('A', 'Z'); // Você pode ajustar conforme necessário

            // Loop para criar os assentos
            for ($i = 0; $i < $numRows; $i++) {
                $rowLetter = $rows[$i]; // Obtém a letra da fila

                for ($seatNumber = 1; $seatNumber <= $numSeatsPerRow; $seatNumber++) {
                    // Cria o assento associado ao teatro
                    Seat::create([
                        'theater_id' => $newTheater->id,
                        'row' => $rowLetter,
                        'seat_number' => $seatNumber,
                    ]);
                }
            }

            // URL para redirecionar após a criação
            $url = route('theaters.show', ['theater' => $newTheater]);
            $htmlMessage = "Teatro <a href='$url'><u>{$newTheater->name}</u></a> foi criado com sucesso!";

            return redirect()->route('theaters.index')
                ->with('alert-type', 'success')
                ->with('alert-msg', $htmlMessage);
        });
    }


    public function edit(Theater $theater): View
    {
        $seats = Seat::where('theater_id', $theater->id)->get();

        return view('theaters.edit', compact('theater', 'seats'));
    }


    public function update(TheaterFormRequest $request, Theater $theater): RedirectResponse
    {
        $validatedData = $request->validated();

        // Inicia uma transação para garantir consistência
        return DB::transaction(function () use ($theater, $validatedData) {
            // Atualiza o teatro com os dados básicos
            $theater->update([
                'name' => $validatedData['nome'],
            ]);

            // Verifica se o teatro foi atualizado com sucesso
            if (!$theater) {
                throw new \Exception('Erro ao atualizar o teatro.');
            }

            // Remove todos os assentos existentes associados a este teatro
            $deletedSeatsCount = Seat::where('theater_id', $theater->id)->delete();

            // Verifica a contagem de assentos excluídos (opcional)
            // echo "Assentos antigos excluídos: " . $deletedSeatsCount . "<br>";

            // Gera os assentos com base no número de filas e lugares por fila informados no formulário
            $numRows = (int) $validatedData['num_rows'];
            $numSeatsPerRow = (int) $validatedData['num_seats_per_row'];

            // Array de letras para as filas (rows)
            $rows = range('A', 'Z'); // Você pode ajustar conforme necessário

            // Loop para criar os assentos
            for ($i = 0; $i < $numRows; $i++) {
                $rowLetter = $rows[$i]; // Obtém a letra da fila

                for ($seatNumber = 1; $seatNumber <= $numSeatsPerRow; $seatNumber++) {
                    // Cria o assento associado ao teatro
                    Seat::create([
                        'theater_id' => $theater->id,
                        'row' => $rowLetter,
                        'seat_number' => $seatNumber,
                    ]);
                }
            }

            // URL para redirecionar após a atualização
            $url = route('theaters.show', ['theater' => $theater]);
            $htmlMessage = "Teatro <a href='$url'><u>{$theater->name}</u></a> foi atualizado com sucesso!";

            return redirect()->route('theaters.index')
                ->with('alert-type', 'success')
                ->with('alert-msg', $htmlMessage);
        });
    }

    public function destroy(Theater $theater): RedirectResponse
    {
        try {
            $url = route('theaters.show', ['theater' => $theater]);

            $movies = Movie::all();
            $totalMovies = $movies->where('theater_id', $theater->id)->count();

            if ($totalMovies == 0) {
                $theater->delete();
                $alertType = 'success';
                $alertMsg = "Teatro {$theater->name} foi apagado com sucesso!";
            } else {
                $alertType = 'danger';
                $alertMsg = "Género <a href='$url'><u>{$theater->name}</u></a> ({$theater->id}) não pode ser excluído porque tem filmes associados";
            }
        } catch (\Exception $error) {
            $alertType = 'warning';
            $alertMsg = "Não foi possível eliminar o teatro <a href='$url'><u>{$theater->name}</u></a> ({$theater->id}) devido a um erro na operação!";
        }

        return redirect()->route('theaters.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
}
