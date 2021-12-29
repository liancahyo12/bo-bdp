<?php

namespace App\Http\Controllers;

use App\Models\approvepengajuan;
use App\Http\Requests\StoreapprovepengajuanRequest;
use App\Http\Requests\UpdateapprovepengajuanRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ApprovepengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('boilerplate::pengajuan.approve');
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
     * @param  \App\Http\Requests\StoreapprovepengajuanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreapprovepengajuanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\approvepengajuan  $approvepengajuan
     * @return \Illuminate\Http\Response
     */
    public function show(approvepengajuan $approvepengajuan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\approvepengajuan  $approvepengajuan
     * @return \Illuminate\Http\Response
     */
    public function edit(approvepengajuan $approvepengajuan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateapprovepengajuanRequest  $request
     * @param  \App\Models\approvepengajuan  $approvepengajuan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateapprovepengajuanRequest $request, approvepengajuan $approvepengajuan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\approvepengajuan  $approvepengajuan
     * @return \Illuminate\Http\Response
     */
    public function destroy(approvepengajuan $approvepengajuan)
    {
        //
    }
}
