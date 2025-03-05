<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Theater;
use App\Models\Screening;
use App\Models\Seat;
use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ScreeningFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ScreeningController extends Controller
{
    public function filme($id): View
    {
        $movie = Movie::findOrFail($id); // Encontrar o filme pelo id ou lançar uma exceção se não encontrado

        $today = Carbon::today();
        $twoWeeksLater = Carbon::today()->addWeeks(2);

        // Obter filmes que estão em cartaz nas próximas duas semanas
        $idMovies = Screening::whereBetween('date', [$today, $twoWeeksLater])->pluck('movie_id')->toArray();
        $moviesCartaz = Movie::whereIn('id', $idMovies)->distinct()->get();

        // Verificar se o filme atual está na lista de filmes em cartaz
        $isInCartaz = $moviesCartaz->contains('id', $movie->id);

        $screeningsByDate = collect();
        if ($isInCartaz) {
            // Obter as sessões disponíveis para o filme e agrupar por data e teatro
            $screenings = Screening::where('movie_id', $movie->id)
                                   ->whereBetween('date', [$today, $twoWeeksLater])
                                   ->orderBy('date')
                                   ->orderBy('start_time')
                                   ->get();

            // Agrupar sessões por data e por teatro
            $screeningsByDate = $screenings->groupBy(function($screening) {
                return Carbon::parse($screening->date)->format('Y-m-d');
            })->map(function($dateGroup) {
                return $dateGroup->groupBy('theater_id')->map(function($theaterScreenings, $theaterId) {
                    $theater = Theater::findOrFail($theaterId);
                    return [
                        'theater_name' => $theater->name,
                        'screenings' => $theaterScreenings
                    ];
                });
            });
        }

        return view('movies.show', compact('movie', 'isInCartaz', 'screeningsByDate'));
    }

    public function index(Request $request) : View
    {
        $query = Screening::query()
            ->join('movies', 'screenings.movie_id', '=', 'movies.id')
            ->join('theaters', 'screenings.theater_id', '=', 'theaters.id')
            ->select('screenings.*', 'movies.title as movie_name', 'theaters.name as theater_name');

        if ($request->has('movie') && !empty($request->get('movie'))) {
            $query->where('movies.title', 'like', '%' . $request->get('movie') . '%');
        }

        if ($request->has('theater') && !empty($request->get('theater'))) {
            $query->where('theaters.name', 'like', '%' . $request->get('theater') . '%');
        }

        if ($request->has('date') && !empty($request->get('date'))) {
            $query->where('screenings.date', 'like', '%' . $request->get('date') . '%');
        }

        if ($request->has('start_time') && !empty($request->get('start_time'))) {
            $query->where('screenings.start_time', 'like', '%' . $request->get('start_time') . '%');
        }

        $allScreenings = $query->paginate(10)->appends($request->query());

        return view('screenings.index', compact('allScreenings'));
    }

    public function show(Screening $screening): View
    {
        $movie = Movie::findOrFail($screening->movie_id);

        $seats = Seat::where('theater_id', $screening->theater_id)->get();

        $theater = Theater::findOrFail($screening->theater_id);

        $theater_name = $theater->name;

        $tickets = Ticket::where('screening_id', $screening->id)->get();

        if (Auth::check() && Auth::user()->type === 'A' ) {
            return $this->showScreening($screening);
        } else {
            return $this->showScreeningCartaz($screening);
        }

        return view('screenings.show', compact('movie', 'screening', 'seats', 'theater_name', 'tickets'));
    }

    public function showScreening(Screening $screening): View
    {
        $movie = Movie::findOrFail($screening->movie_id);
        $seats = Seat::where('theater_id', $screening->theater_id)->get();
        $theater = Theater::findOrFail($screening->theater_id);
        $theater_name = $theater->name;
        $tickets = Ticket::where('screening_id', $screening->id)->get();

        return view('screenings.show', compact('movie', 'screening', 'seats', 'theater_name', 'tickets'));
    }

    public function showScreeningCartaz(Screening $screening): View
    {
        $today = Carbon::today();
        $twoWeeksLater = Carbon::today()->addWeeks(2);

        // Verificar se o screening está em cartaz
        $isInCartaz = Screening::where('id', $screening->id)
                              ->whereBetween('date', [$today, $twoWeeksLater])
                              ->exists();

        if ($isInCartaz) {
            $movie = Movie::findOrFail($screening->movie_id);
            $seats = Seat::where('theater_id', $screening->theater_id)->get();
            $theater = Theater::findOrFail($screening->theater_id);
            $theater_name = $theater->name;
            $tickets = Ticket::where('screening_id', $screening->id)->get();

            return view('screenings.show', compact('movie', 'screening', 'seats', 'theater_name', 'tickets'));
        }

        abort(403, 'Unauthorized action.');
    }


    public function create(): View
    {
        $screening = new Screening();
        $theaters = Theater::pluck('name', 'id')->toArray();
        return view('screenings.create', compact('screening', 'theaters'));
    }


    public function store(ScreeningFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $newScreening = DB::transaction(function () use ($validatedData) {
            $newScreening = new Screening();
            $newScreening->movie_id = $validatedData['movie_id'];
            $newScreening->theater_id = $validatedData['theater_id'];
            $newScreening->date = $validatedData['date'];
            $newScreening->start_time = $validatedData['start_time'];
            $newScreening->save();

            return $newScreening;
        });

        $url = route('screenings.show', ['screening' => $newScreening]);
        $htmlMessage = "Sessão <a href='$url'><u>{$newScreening->id}</u></a> foi criada com sucesso!";
        return redirect()->route('screenings.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function edit(Screening $screening): View
    {
        $theaters = Theater::pluck('name', 'id')->toArray();

        $seats = Seat::where('theater_id', $screening->theater_id)->get();

        $tickets = Ticket::where('screening_id', $screening->id)->get();

        return view('screenings.edit', compact('screening', 'theaters', 'seats', 'tickets'));
    }

    public function update(ScreeningFormRequest $request, Screening $screening): RedirectResponse
    {
        $url = route('screenings.show', ['screening' => $screening]);
        if ($screening->tickets()->exists()) {
            $htmlMessage = "Sessão <a href='$url'><u>{$screening->id}</u></a> não pode ser alterada porque já tem bilhetes vendidos!";
            return redirect()->route('screenings.index')
                ->with('alert-type', 'danger')
                ->with('alert-msg', $htmlMessage);
        }

        // Atualizar a sessão com os dados validados
        $screening->update($request->validated());

        $htmlMessage = "Sessão <a href='$url'><u>{$screening->id}</u></a> foi atualizada com sucesso!";
        return redirect()->route('screenings.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(Screening $screening): RedirectResponse
    {
        $url = route('screenings.show', ['screening' => $screening]);

        if ($screening->tickets()->exists()) {
            $htmlMessage = "Sessão <a href='$url'><u>{$screening->id}</u></a> não pode ser apagada porque já tem bilhetes vendidos!";
            return redirect()->route('screenings.index')
                ->with('alert-type', 'danger')
                ->with('alert-msg', $htmlMessage);
        }

        $screening->delete();
        $htmlMessage = "Sessão ({$screening->id}) foi apagada com sucesso!";
        return redirect()->route('screenings.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

}
