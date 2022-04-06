<?php

namespace App\Http\Controllers;



use App\Http\Requests\albumRequest;
use App\Http\Requests\dierRequest;
use App\Models\Album;
use App\Models\DierModel;

use App\Models\Song;
use Illuminate\Http\Request;

class albumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('albums.index', ['albums'=> album::all('id', 'name', 'year', 'times_sold')]);

//return view('/albums/index');
    }//,'name' ,'year','times_sold'

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

        public function create()
    {
        return view('albums.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(albumRequest $request)
    {
        Album::create($request -> except('_token'));

        //   return redirect()->route('dieren');
        return view('albums.index', ['albums'=> Album::all( 'name', 'year', 'times_sold')]);
        $validated = $request->validate();


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('albums.show', ['albums' => Album::find($id)]);
        //return view('show', ['dieren' => dierModel::find($id)]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $songs = Song::all();
        $albums = Album::find($id);
        return view('albums.edit', ['albums' => $albums, 'songs' => $songs]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(albumRequest $request, $id)
    {
        $albums = Album::find($id);
        Album::find($id)->songs()->attach($request->input('song_id'));
        $albums->update($request->only(['name', 'year', 'times_sold']));
        return redirect()->route('albums.index', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Album::destroy($id);
        return redirect()->route('albums.index');
    }
}
