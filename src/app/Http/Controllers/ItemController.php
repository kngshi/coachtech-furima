<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Item;

class ItemController extends Controller
{

    public function index(Request $request)
    {
        return view('index');
    }

    public function create()
    {
        return view('sell');
    }

}
