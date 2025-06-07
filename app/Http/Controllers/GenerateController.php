<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Milon\Barcode\Facades\DNS2DFacade as DNS2D;

class GenerateController extends Controller
{
    public function show()
    {
        $users = User::all();
        return view('generate.index', compact('users'));
    }

    public function process()
    {
        // Generate user_id untuk user yang belum punya user_id
        $users = User::whereNull('user_id')->get();

        foreach ($users as $user) {
            $user->user_id = 'MID' . str_pad($user->id, 5, '0', STR_PAD_LEFT);
            $user->save();
        }

        return redirect()->route('generate.id.show')->with('success', 'user ID berhasil digenerate.');
    }
}
