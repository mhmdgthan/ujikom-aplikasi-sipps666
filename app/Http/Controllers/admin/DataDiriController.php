<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DataDiriController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        return view('admin.data-diri.index', compact('user'));
    }
}