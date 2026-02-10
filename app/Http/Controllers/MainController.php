<?php

namespace App\Http\Controllers;
use App\Repositories\Helper\AuthorizationRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkgroupModel;

class MainController extends Controller
{
    protected AuthorizationRepository $authorizationRepository;

    public function __construct(AuthorizationRepository $authorizationRepository)
    {
      
        $this->authorizationRepository = $authorizationRepository;
    }

    public function mainView(){
         $user = Auth::user();
         if (! $user) {
            return null;
        }
        $user_data = $user->toArray();
     
        if(!session()->has('workgroup')){
            $get_workgroup = $this->authorizationRepository->getWorkgroup()->toArray();
            session()->put('workgroup', $get_workgroup);

        }
         if(!session()->has('form_workgroup')){
            $get_form_workgroup = $this->authorizationRepository->getFormWorkgroup()->toArray();
            session()->put('form_workgroup', $get_form_workgroup);

        }
         if(!session()->has('forms')){
            $get_forms = $this->authorizationRepository->getForms()->toArray();
            session()->put('forms', $get_forms);

        }
         if(!session()->has('home')){
            $get_home = $this->authorizationRepository->getHome()->toArray();
            session()->put('home', $get_home);

        }
        
        return view('mainview');
    }

    public function workgroupView(){
            $user = Auth::user();
            if (! $user) {
                return null;
            }
            $user_data = $user->toArray();
            $workgoups = WorkgroupModel::all()->toArray();
            
            return view('admin.WorkgroupView', compact('user_data', 'workgoups'));
    }
}
