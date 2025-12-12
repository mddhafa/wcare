<?php

namespace App\Http\Controllers;

use App\Models\User;

class HomeChatController extends Controller
{
    public function index()
    {
        $psikolog = User::where('role_id', 2)->get();

        return view('korban.homechat', compact('psikolog'));
    }
}