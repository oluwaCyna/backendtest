<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $auth_user = Auth::user();

        $total_transactions = $auth_user->totalTransactions();
        if ($auth_user->hasWallet()) {
            $total_balance = $auth_user->wallet->formatted_balance;
        } else {
            $total_balance = null;
        }

        return view('user-dashboard', compact('auth_user', 'total_transactions', 'total_balance'));
    }
}
