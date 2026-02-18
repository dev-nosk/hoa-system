<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function sessionRemoved(Request $request)
    {
        session()->forget('forms');
        session()->forget('home');

        return response()->json([
            'status' => 'success',
            'message' => 'Session removed successfully.'
        ]);
    }
}
