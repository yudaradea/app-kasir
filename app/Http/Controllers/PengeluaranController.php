<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengeluaran;

class PengeluaranController extends Controller
{
    public function index()
    {
        $data = Pengeluaran::all();

        return view('pages.index', compact('data'));
    }
}
