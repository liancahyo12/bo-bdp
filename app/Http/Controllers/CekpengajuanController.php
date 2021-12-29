<?php

namespace App\Http\Controllers;

use App\Models\cekpengajuan;
use App\Http\Requests\StorecekpengajuanRequest;
use App\Http\Requests\UpdatecekpengajuanRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CekpengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('boilerplate::pengajuan.review');
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
     * @param  \App\Http\Requests\StorecekpengajuanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorecekpengajuanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cekpengajuan  $cekpengajuan
     * @return \Illuminate\Http\Response
     */
    public function show(cekpengajuan $cekpengajuan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\cekpengajuan  $cekpengajuan
     * @return \Illuminate\Http\Response
     */
    public function edit(cekpengajuan $cekpengajuan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatecekpengajuanRequest  $request
     * @param  \App\Models\cekpengajuan  $cekpengajuan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatecekpengajuanRequest $request, cekpengajuan $cekpengajuan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\cekpengajuan  $cekpengajuan
     * @return \Illuminate\Http\Response
     */
    public function destroy(cekpengajuan $cekpengajuan)
    {
        //
    }
}
