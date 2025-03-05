<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Genre;
use App\Models\Screening;
use App\Models\Theater;
use Illuminate\Contracts\View\View;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\MovieFormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{

    public function index(Request $request) : View
    {
        $query = Movie::query();

        if ($request->has('title') && !empty($request->get('title'))) {
            $query->where('title', 'like', '%' . $request->get('title') . '%');
        }

        if ($request->has('genre_code') && !empty($request->get('genre_code'))) {
            $query->where('genre_code', $request->get('genre_code'));
        }

        if ($request->has('year') && !empty($request->get('year'))) {
            $query->where('year', $request->get('year'));
        }

        $allMovies = $query->paginate(10)->appends($request->query());
        $moviesCount = $query->count();

        $today = Carbon::today();
        $twoWeeksLater = Carbon::today()->addWeeks(2);
        $idMovies = Screening::whereBetween('date', [$today, $twoWeeksLater])->pluck('movie_id')->toArray();
        $moviesCartaz = Movie::whereIn('id', $idMovies)->distinct()->get();
        $moviesCartazCount = $moviesCartaz->count();

        $genres = Genre::pluck('name', 'code')->toArray();
        $genres = ['' => 'Todos os Géneros'] + $genres;

        return view('movies.index', compact('allMovies', 'genres', 'moviesCartazCount', 'moviesCount'));
    }


    public function cartaz(Request $request) : View
    {
        $genres = Genre::pluck('name', 'code')->toArray();
        $genres = ['' => 'Todos os Géneros'] + $genres;

        $today = Carbon::today();
        $twoWeeksLater = Carbon::today()->addWeeks(2);

        $moviesQuery = Movie::whereIn('id', function($query) use ($today, $twoWeeksLater) {
            $query->select('movie_id')
                ->from('screenings')
                ->whereBetween('date', [$today, $twoWeeksLater]);
        });

        if ($request->has('genero') && !empty($request->get('genero'))) {
            $moviesQuery->where('genre_code', $request->get('genero'));
        }

        $moviesCartaz = $moviesQuery->distinct()->get();

        $moviesCount = Movie::count();
        $moviesCartazCount = $moviesCartaz->count();

        return view('movies.cartaz', compact('genres', 'moviesCartaz', 'moviesCartazCount', 'moviesCount'));
    }

    public function all(Request $request) : View
    {
        $query = Movie::query();

        if ($request->has('title') && !empty($request->get('title'))) {
            $query->where('title', 'like', '%' . $request->get('title') . '%');
        }

        if ($request->has('genre_code') && !empty($request->get('genre_code'))) {
            $query->where('genre_code', $request->get('genre_code'));
        }

        if ($request->has('year') && !empty($request->get('year'))) {
            $query->where('year', $request->get('year'));
        }

        $movies = $query->get()->groupBy('genre_code');
        $moviesCount = $query->count();

        $genres = Genre::pluck('name', 'code')->toArray();
        $genres = ['' => 'Todos os Géneros'] + $genres;

        $today = Carbon::today();
        $twoWeeksLater = Carbon::today()->addWeeks(2);
        $idMovies = Screening::whereBetween('date', [$today, $twoWeeksLater])->pluck('movie_id')->toArray();
        $moviesCartaz = Movie::whereIn('id', $idMovies)->distinct()->get();
        $moviesCartazCount = $moviesCartaz->count();

        return view('movies.todos', compact('genres', 'movies', 'moviesCartazCount', 'moviesCount'));
    }


    public function edit($id): View
    {
        $movie = Movie::findOrFail($id);
        $genres = Genre::pluck('name', 'code')->toArray();
        return view('movies.edit', compact('movie', 'genres'));
    }

    public function create(): View
    {
        $movie = new Movie();
        $genres = Genre::pluck('name', 'code')->toArray();
        return view('movies.create', compact('movie', 'genres'));
    }

    public function store(MovieFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $newMovie = DB::transaction(function () use ($validatedData, $request) {
            $newMovie = new Movie();
            $newMovie->title = $validatedData['title'];
            $newMovie->genre_code = $validatedData['genre_code'];
            $newMovie->year = $validatedData['year'];

            if ($request->hasFile('poster_filename')) {
                $path = $request->poster_filename->store('public/posters');
                $newMovie->poster_filename = basename($path);
            }

            $newMovie->synopsis = $validatedData['synopsis'];

            if (isset($validatedData['trailer_url'])) {
                $newMovie->trailer_url = $validatedData['trailer_url'];
            }

            $newMovie->save();

            return $newMovie;
        });

        $url = route('movies.show', ['movie' => $newMovie]);
        $htmlMessage = "Filme <a href='$url'><u>{$newMovie->title}</u></a> foi criado com sucesso!";

        return redirect()->route('movies.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }


    public function update(MovieFormRequest $request, Movie $movie): RedirectResponse
    {
        $validatedData = $request->validated();

        $movie = DB::transaction(function () use ($validatedData, $request, $movie) {
            $movie->title = $validatedData['title'];
            $movie->genre_code = $validatedData['genre_code'];
            $movie->year = $validatedData['year'];
            $movie->synopsis = $validatedData['synopsis'];
            $movie->trailer_url = $validatedData['trailer_url'];

            if ($request->hasFile('poster_filename')) {
                if ($movie->poster_filename && Storage::exists('public/posters/' . $movie->poster_filename)) {
                    Storage::delete('public/posters/' . $movie->poster_filename);
                }
                $path = $request->file('poster_filename')->store('public/posters');
                if (!$path) {
                    throw new \Exception("Failed to update poster");
                }
                $movie->poster_filename = basename($path);
            }

            $movie->save();
            return $movie;
        });

        $url = route('movies.show', ['movie' => $movie]);
        $htmlMessage = "Filme <a href='$url'><u>{$movie->name}</u></a> foi atualizado com sucesso!";

        return redirect()->route('movies.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function search(Request $request): View
    {
        $query = $request->input('q');

            $today = Carbon::today();
            $twoWeeksLater = Carbon::today()->addWeeks(2);
            $idMovies = Screening::whereBetween('date', [$today, $twoWeeksLater])->pluck('movie_id')->toArray();
            $moviesCartaz = Movie::whereIn('id', $idMovies)->distinct()->get();

            $movies = $moviesCartaz->filter(function ($movie) use ($query) {
                return stripos($movie->title, $query) !== false || stripos($movie->synopsis, $query) !== false;
            });

        return view('movies.search', ['movies' => $movies]);
    }

    public function ano(Request $request): View
    {
        $query = $request->input('query');

        $movies = Movie::where('year', 'like', "$query")->get();

        return view('movies.ano', compact('movies'));
    }

    public function show(Movie $movie): View
    {
        if (Auth::check() && Auth::user()->type === 'A' ) {
            return $this->showMovie($movie);
        } else {
            return $this->showCartaz($movie);
        }
    }

    public function showMovie(Movie $movie): View
    {
        // Lógica para mostrar o filme (admins)
        // Esta é a lógica atual do método `show`
        $today = Carbon::today();
        $twoWeeksLater = Carbon::today()->addWeeks(2);

        $idMovies = Screening::whereBetween('date', [$today, $twoWeeksLater])->pluck('movie_id')->toArray();
        $moviesCartaz = Movie::whereIn('id', $idMovies)->distinct()->get();

        $isInCartaz = $moviesCartaz->contains('id', $movie->id);

        $screeningsByDate = collect();
        if ($isInCartaz) {
            $screenings = Screening::where('movie_id', $movie->id)
                                ->whereBetween('date', [$today, $twoWeeksLater])
                                ->orderBy('date')
                                ->orderBy('start_time')
                                ->get();

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

    public function showCartaz(Movie $movie): View
    {
        // Lógica para mostrar apenas os filmes em cartaz (clientes)
        $today = Carbon::today();
        $twoWeeksLater = Carbon::today()->addWeeks(2);

        $idMovies = Screening::whereBetween('date', [$today, $twoWeeksLater])->pluck('movie_id')->toArray();
        $moviesCartaz = Movie::whereIn('id', $idMovies)->distinct()->get();

        $isInCartaz = $moviesCartaz->contains('id', $movie->id);

        if (!$isInCartaz) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        $screenings = Screening::where('movie_id', $movie->id)
                            ->whereBetween('date', [$today, $twoWeeksLater])
                            ->orderBy('date')
                            ->orderBy('start_time')
                            ->get();

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

        return view('movies.show', compact('movie', 'isInCartaz', 'screeningsByDate'));
    }


    public function destroy(Movie $movie): RedirectResponse
    {
        try {
            $movie->delete();

            $url = route('movies.show', ['movie' => $movie]);
            $alertType = 'success';
            $alertMsg = "Filme <a href='$url'><u>{$movie->name}</u></a> ({$movie->email}) foi apagado com sucesso!";
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "Não foi possível apagar o filme <a href='$url'><u>{$movie->title}</u></a> ({$movie->genre}) devido a um erro na operação!";
        }

        return redirect()->route('movies.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }

    public function destroyPoster(Movie $movie): RedirectResponse
    {
        if ($movie->poster_filename) {
            if (Storage::fileExists('public/posters/' . $movie->poster_filename)) {
                Storage::delete('public/posters/' . $movie->poster_filename);
            }
            $movie->poster_filename = null;
            $movie->save();
            return redirect()->back()
                ->with('alert-type', 'success')
                ->with('alert-msg', "O poster do filme {$movie->title} foi eliminado!");
        }
        return redirect()->back();
    }
}
