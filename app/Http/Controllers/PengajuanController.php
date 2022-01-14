<?php

namespace App\Http\Controllers;

use App\Models\pengajuan;
use App\Models\departemen;
use App\Models\jenis_pengajuan;
use App\Http\Requests\StorepengajuanRequest;
use App\Http\Requests\UpdatepengajuanRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('boilerplate::pengajuan.pengajuan');
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('boilerplate::pengajuan.buat', [
            'jenis_pengajuan' => jenis_pengajuan::all(),
            'departemens' => departemen::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorepengajuanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorepengajuanRequest $request)
    {
        $this->validate($request, [
                'jenis_pengajuan' => 'required',
                'departemen'  => 'required',
                'tgl_pengajuan'  => 'required',
                'perihal' => 'required',
                'file_lampiran' => 'mimes:pdf|max:20480',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pengajuan  $pengajuan
     * @return \Illuminate\Http\Response
     */
    public function show(pengajuan $pengajuan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pengajuan  $pengajuan
     * @return \Illuminate\Http\Response
     */
    public function edit(pengajuan $pengajuan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepengajuanRequest  $request
     * @param  \App\Models\pengajuan  $pengajuan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatepengajuanRequest $request, pengajuan $pengajuan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pengajuan  $pengajuan
     * @return \Illuminate\Http\Response
     */
    public function destroy(pengajuan $pengajuan)
    {
        //
    }
}
