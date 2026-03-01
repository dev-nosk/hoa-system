<?php

namespace App\Http\Controllers;
use App\Models\WorkgroupModel;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
{
    
    function __construct()
    {
       
         \session()->put('home', []);
    }
public function createForm(Request $request){
    
    #validate here if admin
    return view('admin.create_form');
}
 public function workgroupView()
    {
        
        $user = Auth::user();
        if (! $user) {
            return null;
        }
        $user_data = $user->toArray();
        $workgoups = WorkgroupModel::all()->toArray();
    
        return view('admin.WorkgroupView', compact('user_data', 'workgoups'));
    }
}
