<?php

namespace App\Http\Controllers;

use App\Duel;
use Illuminate\Http\Request;

class DuelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $duel = new Duel;
        $duel->code = $request->multiplayer;
        $duel->number_target = $request->random;
        $duel->number_0 = $request->smallNumbers[0][1];
        $duel->number_1 = $request->smallNumbers[1][1];
        $duel->number_2 = $request->smallNumbers[2][1];
        $duel->number_3 = $request->smallNumbers[3][1];
        $duel->number_4 = $request->bigNumbers[0][1];
        $duel->number_5 = $request->bigNumbers[1][1];

        $duel->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Duel  $duel
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $duel = Duel::where('code', $request->code)->first();
        return $duel;       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Duel  $duel
     * @return \Illuminate\Http\Response
     */
    public function edit(Duel $duel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Duel  $duel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Duel $duel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Duel  $duel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Duel $duel)
    {
        //
    }
}
