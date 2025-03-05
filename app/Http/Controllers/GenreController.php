<?php
namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Requests\GenreFormRequest;
use Illuminate\Http\RedirectResponse;


class GenreController extends Controller
{
    public function index(Request $request) : View
    {
        $query = Genre::query();

        if ($request->has('nome') && !empty($request->get('nome'))) {
            $query->where('name', 'like', '%' . $request->get('nome') . '%');
        }

        $allGenres = $query->paginate(10)->appends($request->query());

        return view('genres.index', compact('allGenres'));
    }

    public function show(Genre $genre): View
    {
        return view('genres.show')->with('genre', $genre);
    }

    public function create(): View
    {
        $newGenre = new Genre();
        return view('genres.create')->with('genre', $newGenre);
    }

    public function store(GenreFormRequest $request): RedirectResponse
    {
        $newGenre = Genre::create($request->validated());
        $url = route('genres.show', ['genre' => $newGenre]);
        $htmlMessage = "Género <a href='$url'><u>{$newGenre->name}</u></a> foi criado com sucesso!";
        return redirect()->route('genres.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function edit($code): View
    {
        $genre = Genre::findOrFail($code);
        return view('genres.edit', compact('genre'));
    }

    public function update(GenreFormRequest $request, Genre $genre): RedirectResponse
    {
        $genre->update($request->validated());
        $url = route('genres.show', ['genre' => $genre]);
        $htmlMessage = "Género <a href='$url'><u>{$genre->name}</u></a> foi atualizado com sucesso!";
        return redirect()->route('genres.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(Genre $genre): RedirectResponse
    {
        try {
            $url = route('genres.show', ['genre' => $genre]);

            $movies = Movie::all();
            $totalMovies = $movies->where('genre_code', $genre->code)->count();

            if ($totalMovies == 0) {
                $genre->delete();
                $alertType = 'success';
                $alertMsg = "Género {$genre->name} foi apagado com sucesso!";
            } else {
                $alertType = 'danger';
                $alertMsg = "Género <a href='$url'><u>{$genre->name}</u></a> não pode ser apagado porque tem filmes com sessões ativas!";
            }
        } catch (\Exception $error) {
            $alertType = 'warning';
            $alertMsg = "Não foi possível apagar o género <a href='$url'><u>{$genre->name}</u></a> devido a um erro na operação!";
        }

        return redirect()->route('genres.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }

}
