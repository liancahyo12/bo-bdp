<?php

namespace App\Http\Controllers;

use App\Models\Boilerplate\User;
use App\Models\departemen;
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
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Collection;
use DB;

class DepartemenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('boilerplate::settings.departemen');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $reviewerdep = User::leftJoin('role_user', 'role_user.user_id', 'users.id')->leftJoin('permission_role', 'permission_role.role_id', 'role_user.role_id')->where('permission_id', 12)->select('users.id as idr', DB::raw('concat(first_name, " ", last_name) as nama'))->get();
        return view('boilerplate::settings.buat-departemen', [
            'reviewerdep' => $reviewerdep,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
                'kode'  => 'required',
                'departemen' => 'required',
                'reviewerdep' => 'required',
        ]);
        $input['kode'] = $request->kode;
        $input['departemen'] = $request->departemen;
        $input['reviewerdep_id'] = $request->reviewerdep;
        $depart = departemen::create($input);
        return redirect()->route('boilerplate.departemen')
            ->with('growl', [__('Departemen berhasil ditambah'), 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $depart = departemen::where([['status', '=',1], ['id', '=', $id]])->first();
        $reviewerdep = User::leftJoin('role_user', 'role_user.user_id', 'users.id')->leftJoin('permission_role', 'permission_role.role_id', 'role_user.role_id')->where('permission_id', 12)->select('users.id as idr', DB::raw('concat(first_name, " ", last_name) as nama'))->get();
        return view('boilerplate::settings.edit-departemen', [
            'reviewerdep' => $reviewerdep,
            'depart' => $depart,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = departemen::where([['id', '=', $id], ['status', '=', 1]])->first();
        $this->validate($request, [
                'kode'  => 'required',
                'departemen' => 'required',
                'reviewerdep' => 'required',
        ]);
        $input['kode'] = $request->kode;
        $input['departemen'] = $request->departemen;
        $input['reviewerdep_id'] = $request->reviewerdep;
        $depart = $input->save();
        return redirect()->route('boilerplate.departemen')
            ->with('growl', [__('Departemen berhasil diubah'), 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $input = departemen::where('id', $id)->first();
        $input['status'] = 0;
        $depart = $input->save();
    }
}
