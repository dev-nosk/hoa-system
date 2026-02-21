<?php

namespace App\Repositories\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkgroupModel;
use App\Models\FormWorkgroupModel;
use App\Models\FormsModel;
use App\Models\HomeModel;
use App\Models\UserWorkgroupModel;

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
        # get all user workgroup with user_id and grant 1 and form workgroup with form_id and workgroup_id then get workgroup with id in form workgroup
        
        $userWorkgroups = UserWorkgroupModel::where('user_id', $user->id)->where('grant', 1)->get();
        $workgroupIds = $userWorkgroups->pluck('workgroup_id');
        $workgroups = FormWorkgroupModel::with('workgroup')->whereIn('workgroup_id', $workgroupIds)->get();

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
