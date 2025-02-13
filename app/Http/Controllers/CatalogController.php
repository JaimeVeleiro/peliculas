<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class CatalogController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies = Movie::all();
        return View('catalog.index', ["films" => $movies]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return View('catalog.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $filmToShow = collect($this->films)->firstWhere('id', $id);
        $filmToShow = Movie::find($id);
        return View('catalog.show', ['film' => $filmToShow]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // $filmToEdit = collect($this->films)->firstWhere('id', $id);
        $filmToEdit = Movie::find($id);
        return View('catalog.edit', ['film' => $filmToEdit]);
    }

    public function store(Request $request){

        $request->validate([
            'title' => 'required|unique:movies|max:255',
            'year' => 'required|integer|min:1895|max:'.date('Y'),
            'director' => 'required|string',
            'synopsis' => 'required|string|min:10'
        ]);
        
        $movie = new Movie;

        $movie->title = $request['title'];
        $movie->year = $request['year'];
        $movie->director = $request['director'];
        $movie->poster = $request['poster'];
        $movie->rented = false;
        $movie->synopsis = $request['synopsis'];

        $movie->save();
        $idSavedMovie = $movie->id;
        return redirect()->route('catalog.show', $idSavedMovie)->with('mensaje', 'Película Guardada!');
    }

    public function update(Request $request) {
        $request->validate([
            'title' => 'required|max:255',
            'year' => 'required|integer|min:1895|max:'.date('Y'),
            'director' => 'required|string',
            'synopsis' => 'required|string|min:10'
        ]);

        $movie = Movie::find($request['id']);
        $movie->title = $request['title'];
        $movie->year = $request['year'];
        $movie->director = $request['director'];
        $movie->poster = $request['poster'];
        $movie->rented = false;
        $movie->synopsis = $request['synopsis'];

        $movie->save();
        $idSavedMovie = $movie->id;
        return redirect()->route('catalog.show', $idSavedMovie)->with('mensaje', "Película Actualizada!");
    }

    public function rent(Request $request) {
        $movie = Movie::find($request['id']);

        $movie->rented = true;
        $movie->save();

        $idSavedMovie = $movie->id;
        return redirect()->route('catalog.show', $idSavedMovie)->with('mensaje', "Película Alquilada!");
    }

    public function return(Request $request) {
        $movie = Movie::find($request['id']);

        $movie->rented = false;
        $movie->save();

        $idSavedMovie = $movie->id;
        return redirect()->route('catalog.show', $idSavedMovie)->with('mensaje', "Película Devuelta!");
    }

    public function delete(Request $request) {
        $movie = Movie::find($request['id']);

        $movie->delete();

        return redirect()->route('catalog.index')->with('mensaje', 'Película Eliminada!');
    }

}
