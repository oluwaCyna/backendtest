<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * Create a new wallet for the user based on the provided request.
     *
     * @param  Request  $request  The request containing the user ID.
     * @return RedirectResponse A redirect response indicating the result of the wallet creation.
     */
    public function create(Request $request): RedirectResponse
    {
        User::find($request->id)->createWallet();

        return redirect()->back()->with('success', 'Wallet created successfully');
    }
}
