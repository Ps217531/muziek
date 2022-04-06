<?php

namespace App\Http\Controllers;

use App\Http\Requests\albumRequest;
use App\Http\Requests\songRequest;
use App\Models\Album;
use Illuminate\Http\Request;
use  App\Models\Song;

class NummerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        {

            return view('songs.index', ['songs'=> Song::all('title', 'id', 'singer')]);

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('songs.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(songRequest $request)
    {
    Song::create($request -> except('_token'));

    return view('songs.index', ['songs'=> Song::all('title', 'id')]);
        $validated = $request->validate();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {  // $songs = ['Living on a prayer', 'Nothing else matters', 'Thunderstruck', 'Back in black', 'Ace of spades'];
       //$song = $songs[$id];
        return view('songs.show', ['songs' => song::find($id)]);



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     //   $songs = ['Living on a prayer', 'Nothing else matters', 'Thunderstruck', 'Back in black', 'Ace of spades'];
     //   $song = $songs[$id];
     //   return view('songs.edit', ['songs' =>  $songs[$id]]);

        $albums = Album::all();
        $song = Song::find($id);
        return view('songs.edit', ['song' => $song, 'albums' => $albums]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(songRequest $request, $id)
    {
        $albums = Album::find($id);
        Album::find($id)->albums()->attach($request->input('album_id'));
        $song = Song::find($id);
        $song->update($request->only(['title', 'singer']));
        return redirect()->route('songs.edit', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Song::destroy($id);
        return redirect('songs');
//        DB::delete('delete from songs where id = ?',[$id]);


    }
}
