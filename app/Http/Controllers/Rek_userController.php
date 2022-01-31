<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorepengajuanRequest;
use App\Http\Requests\UpdatepengajuanRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Collection;
use App\Models\rek_user;
use Auth;

class Rek_userController extends Controller
{
    public function index()
    {
        return view('boilerplate::pengajuan.reviewdep');
        //
    }
    public function store(Request $request)
    {
        return view('boilerplate::pengajuan.reviewdep');
        //
    }
    public function edit($id)
    {
        return view('boilerplate::pengajuan.reviewdep');
        //
    }
    public function update(Request $request, $id)
    {
        return view('boilerplate::pengajuan.reviewdep');
        //
    }
    public function destroy($id)
    {
        return view('boilerplate::pengajuan.reviewdep');
        //
    }
}
