<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    
public function createForm(Request $request){
    
    #validate here if admin
     \session()->put('home', []);
    return view('admin.create_form');
}

}
