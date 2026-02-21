<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use function Pest\Laravel\session;

class SessionController extends Controller
{
    public function sessionRemoved(Request $request)
    {
        \session()->forget('forms');
        \session()->forget('home');
        \session()->forget('workgroup');
        \session()->forget('user_form_access');
        \session()->forget('form_workgroup');
    
        return response()->json([
            'status' => 'success',
            'message' => 'Session removed successfully.'
        ]);
    }
}
