<?php

namespace App\Http\Controllers;


use App\Http\Requests\bandRequest;

use App\Models\Band;
use App\Models\Album;


class bandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('bands.index', ['bands'=> band::all('id', 'name', 'genre', 'founded', 'active_til')]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(bandRequest $request)
    {
        Band::create($request -> except('_token'));

        //   return redirect()->route('dieren');
        return view('bands.index', ['bands'=> Band::all( 'name', 'genre', 'founded', 'active_til')]);
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
        return view('bands.show', ['bands' => Band::find($id)]);
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
        $bands = Band::find($id);
        return view('bands.edit', ['bands' => $bands,'albums'=>Album::all()]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(bandRequest $request, $id)
    {
        // Band update
        if($request->input('album') == null) {
            $bands = Band::find($id);
            $bands->update($request->only(['name', 'genre', 'founded', 'active_til']));
            return redirect()->route('bands.index', ['id' => $id]);
        }
        // Album koppelen
        else {
            Album::find($request->input('album'))->update(['band_id' => $id]);
            return redirect()->route('albums.show', ['id' => $request->input('album')]);
        }




//        $bands = Band::find($id);
//        $bands->update($request->only(['name', 'genre', 'founded', 'active_til']));
//        return redirect()->route('bands.index', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Band::destroy($id);
        return redirect()->route('bands.index');
    }
}
