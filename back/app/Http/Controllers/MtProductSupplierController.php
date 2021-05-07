<?php

namespace App\Http\Controllers;

use App\Models\MtProductSupplier;
use Illuminate\Http\Request;

class MtProductSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MtProductSupplier::all();
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MtProductSupplier  $mtProductSupplier
     * @return \Illuminate\Http\Response
     */
    public function show(MtProductSupplier $mtProductSupplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MtProductSupplier  $mtProductSupplier
     * @return \Illuminate\Http\Response
     */
    public function edit(MtProductSupplier $mtProductSupplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MtProductSupplier  $mtProductSupplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MtProductSupplier $mtProductSupplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MtProductSupplier  $mtProductSupplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(MtProductSupplier $mtProductSupplier)
    {
        //
    }
}
