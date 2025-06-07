<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class BulkPrintController extends Controller
{
    public function printCard()
    {
        $users = User::all();
        return view('prints.card-id', compact('users'));
    }
}
