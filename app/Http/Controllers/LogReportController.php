<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cekdeppengajuan;
use App\Models\cekpengajuan;
use App\Models\approvepengajuan;
use App\Http\Requests\StorepengajuanRequest;
use App\Http\Requests\UpdatepengajuanRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Auth;

class LogReportController extends Controller
{
    public function lr_pengajuan_saya()
    {
        return view('boilerplate::log-report.pengajuan-saya');
    }

    public function lr_pengajuan()
    {
        return view('boilerplate::log-report.pengajuan');
    }
    public function lr_closing_saya()
    {
        return view('boilerplate::log-report.closing-saya');
    }

    public function lr_closing()
    {
        return view('boilerplate::log-report.closing');
    }
    public function lr_suratkeluar_saya()
    {
        return view('boilerplate::log-report.suratkeluar-saya');
    }

    public function lr_suratkeluar()
    {
        return view('boilerplate::log-report.suratkeluar');
    }
}
