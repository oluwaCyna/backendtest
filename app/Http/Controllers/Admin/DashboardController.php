<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;

class DashboardController extends Controller
{
    public function index()
    {
        $total_users = User::maker()->get()->count();
        // $total_balance = Wallet::find(1)->formatted_balance;
        $total_transactions = Transaction::all()->count();

        return view('admin-dashboard', compact('total_users', 'total_transactions'));
    }
}
