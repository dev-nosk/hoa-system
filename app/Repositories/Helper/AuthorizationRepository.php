<?php

namespace App\Repositories\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkgroupModel;
use App\Models\FormWorkgroupModel;
use App\Models\FormsModel;
use App\Models\HomeModel;

class AuthorizationRepository

{
    public function canAccess(string $permission): bool
    {
        // example logic    
        return auth()->check() &&
               in_array($permission, auth()->user()->permissions ?? []);
    }

    public static function getWorkgroup(){
         $user = Auth::user();
         if (! $user) {
            return null;
        }
        $workgroups = WorkgroupModel::all();
        return $workgroups; 

    }

      public static function getFormWorkgroup(){
         $user = Auth::user();
         if (! $user) {
            return null;
        }
        $form_workgroups = FormWorkgroupModel::all();
        return $form_workgroups; 

    }

     public static function getForms(){
         $user = Auth::user();
         if (! $user) {
            return null;
        }
        $forms = FormsModel::where('deleted_tag', 0)->get();
        return $forms; 

    }

      public static function getHome(){
         $user = Auth::user();
         if (! $user) {
            return null;
        }
        $home = HomeModel::all();
        return $home; 

    }
}
