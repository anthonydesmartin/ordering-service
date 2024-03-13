<?php

namespace App\Http\Controllers;

use App\Models\History;

class HistoryController extends Controller
{
    public function index()
    {
        return History::all();
    }

    public function show($id)
    {
        return History::find($id);
    }
}
