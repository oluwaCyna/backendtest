<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function create(Request $request)
    {
        User::find($request->id)->createWallet();

        return redirect()->back()->with('success', 'Wallet created successfully');
    }
}
