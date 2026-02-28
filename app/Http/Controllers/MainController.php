<?php

namespace App\Http\Controllers;

use App\Repositories\Helper\AuthorizationRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkgroupModel;
use App\Models\FormFieldsModel;
use App\Models\CategoryModel;
use App\Models\FormStatusModel;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

use function Pest\Laravel\session;

class MainController extends Controller
{
    protected AuthorizationRepository $authorizationRepository;

    public function __construct(AuthorizationRepository $authorizationRepository)
    {

        $this->authorizationRepository = $authorizationRepository;
    }

    public function mainView()
    {
        $user = Auth::user();
        if (! $user) {
            return null;
        }
        $user_data = $user->toArray();
        // return response()->json($this->authorizationRepository->getWorkgroup()->toArray());
        // if (!\session()->has('workgroup')) {
            $get_workgroup = $this->authorizationRepository->getWorkgroup()->toArray();
            $user_form_access = [];
            $forms_access = [];

            foreach ($get_workgroup as $workgroup) {
                $formId = $workgroup['form_id'];

                // Add form_id to forms_access if not already there
                if (!in_array($formId, $forms_access)) {
                    $forms_access[] = $formId;
                }

                // Initialize if not exists
                if (!isset($user_form_access[$formId])) {
                    $user_form_access[$formId] = [
                        'form_id' => $formId,
                        'workgroup_id' => $workgroup['workgroup_id'],
                        'access' => [
                            'create' => 0,
                            'listview' => 0,
                            'upload' => 0,
                            'attachement_create' => 0,
                        ]
                    ];
                }

                // Aggregate access (logical OR)
                $user_form_access[$formId]['access']['create'] = $user_form_access[$formId]['access']['create']
                    || ($workgroup['workgroup']['create'] == 1 ? 1 : 0);
                $user_form_access[$formId]['access']['listview'] = $user_form_access[$formId]['access']['listview']
                    || ($workgroup['workgroup']['list_view'] == 1 ? 1 : 0);
                $user_form_access[$formId]['access']['upload'] = $user_form_access[$formId]['access']['upload']
                    || ($workgroup['workgroup']['upload'] == 1 ? 1 : 0);
                $user_form_access[$formId]['access']['attachement_create'] = $user_form_access[$formId]['access']['attachement_create']
                    || ($workgroup['workgroup']['attachement_create'] == 1 ? 1 : 0);
            }

            // Convert boolean to int
            foreach ($user_form_access as &$form) {
                foreach ($form['access'] as $key => $value) {
                    $form['access'][$key] = $value ? 1 : 0;
                }
            }

            // Make form IDs unique
            $forms_access = array_unique($forms_access);

            // Save in session
            \session()->put('forms_access', $forms_access);
            \session()->put('user_form_access', $user_form_access);
            \session()->put('workgroup', $get_workgroup);
        // }

        // dd(\session()->get('user_form_access'));
        if (!\session()->has('form_workgroup')) {
            $get_form_workgroup = $this->authorizationRepository->getFormWorkgroup()->toArray();
            \session()->put('form_workgroup', $get_form_workgroup);
        }
        if (!\session()->has('forms')) {
            $get_forms = $this->authorizationRepository->getForms()->toArray();

            // Make the array key the form id
            $get_forms_by_id = array_column($get_forms, null, 'id');

            \session()->put('forms', $get_forms_by_id);
        }
        if (!\session()->has('home') || empty(\session('home'))) {
            $get_home = $this->authorizationRepository->getHome()->toArray();
            \session()->put('home', $get_home);
        }


        return view('mainview');
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

    // public function formBuilder(Request $request)
    // {

    //     $formId = $request->form_id;

    //     session()->put('form_id', $formId);
    //     $fields = FormFieldsModel::with(['refField', 'tab'])
    //         ->where('form_id', $formId)
    //         ->get();

    //     $fields = FormFieldsModel::with(['refField', 'tab'])
    //         ->where('form_id', $formId)
    //         ->get();

    //     # collect all valid tabs
    //     $tabIds = $fields->pluck('tab_id')->toArray();
    //     $tabIds = array_unique($tabIds);
    //     #end collect valid tabs

    //     #getting all tabs unique
    //     $uniqueTabs = $fields->pluck('tab')->filter()->unique('id')->sortBy('id')->values();
    //     $tabsFields = $fields->groupBy('tab_id');
    //     $tabsFields->transform(function ($fieldsInTab) {
    //         return $fieldsInTab->sortBy('sequence')->values();
    //     });

    //     # Generate HTML
    //     $html = '';

    //     $html .= '<form action="#" id="form_submit" method="POS"T>';
    //     $html .= csrf_field();
    //     $html .= '<button type="submit" class="btn btn-success" style="float:right;"> save </button>';
    //     $html .= '<ul class="nav nav-tabs" id="formTab" role="tablist">';
    //     $first = true;
    //     foreach ($uniqueTabs as $tab) {
    //         if (!in_array($tab->id, $tabIds)) continue;
    //         $tabId = $tab->id;
    //         $tabName = $tab->tab_name ?? 'Tab ' . $tabId;
    //         $activeClass = $first ? 'active' : '';
    //         $ariaSelected = $first ? 'true' : 'false';
    //         $html .= '<li class="nav-item" role="presentation">
    //         <button class="nav-link ' . $activeClass . '" 
    //                 id="tab' . $tabId . '-tab" 
    //                 data-bs-toggle="tab" 
    //                 data-bs-target="#tab' . $tabId . '" 
    //                 type="button" 
    //                 role="tab" 
    //                 aria-controls="tab' . $tabId . '" 
    //                 aria-selected="' . $ariaSelected . '">
    //             ' . $tabName . '
    //         </button>
    //     </li>';

    //         $first = false;
    //     }
    //     $html .= '</ul>';

    //     # Tabs content
    //     $html .= '<div class="tab-content mt-3" id="formTabContent">';
    //     $first = true;

    //     foreach ($uniqueTabs as $tab) {
    //         if (!in_array($tab->id, $tabIds)) continue;
    //         $tabId = $tab->id;
    //         $activeClass = $first ? 'show active' : '';
    //         $html .= '<div class="tab-pane fade ' . $activeClass . '" 
    //                   id="tab' . $tabId . '" 
    //                   role="tabpanel" 
    //                   aria-labelledby="tab' . $tabId . '-tab">
    //                   <div class="row">';

    //         // Render fields for this tab
    //         if (isset($tabsFields[$tabId])) {
    //             foreach ($tabsFields[$tabId] as $field) {
    //                 $field_data = $field->refField; // use object, not array
    //                 if (!$field_data) continue;

    //                 $field_unique_id = $formId . '_' . $field->sequence . '_' . $field_data->id;
    //                 $viewName = 'form.' . $field_data->field_type;
    //                 $is_view = 0;
    //                 if (View::exists($viewName)) {
    //                     $html .= view($viewName, compact('field', 'field_data', 'field_unique_id'))->render();
    //                 } else {
    //                     $html .= "<!-- View {$viewName} does not exist -->";
    //                 }
    //             }
    //         }

    //         $html .= '</div></div>';
    //         $first = false;
    //     }

    //     $html .= '</div></form>';

    //     return response()->json(['html' => $html]);
    // }


    public function getUser(Request $request)
    {
        $query = \App\Models\User::query();

        // Optional search filter
        if ($search = $request->input('search.value')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }

        $total = $query->count();

        // Pagination
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $users = $query->offset($start)->limit($length)->get();

        // Format response for DataTables server-side
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $users
        ]);
    }

    public function getCategory()
    {
        $data = CategoryModel::all();

        return  response()->json($data);
    }

    public function saveRecord(Request $request)
    {

        $form_id = \session()->get('form_id', 0);
        $form_access = \session()->get('forms_access', []);
        if (!in_array($form_id, $form_access)) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have access to this form.'
            ]);
        }
        $forms = \session()->get('forms'); // get the array, not boolean
        $valid_inputs = FormFieldsModel::where('form_id', $form_id)
            ->pluck('input_name')  // get only this column
            ->toArray();


        if ($form_id && $forms) {

            $modelName = $forms[$form_id]['model_name']; // e.g., App\Models\Form

            if (!class_exists($modelName)) {
                return response()->json([
                    'success' => false,
                    'message' => "Model {$modelName} does not exist."
                ]);
            }

            // Create new record
            $record = new $modelName();

            foreach ($request->except('_token') as $key => $value) {
                if (!in_array($key, $valid_inputs)) continue;
                $record->$key = $value;
            }
            $record->current_status_id = $forms[$form_id]['initial_status'];
            $record->save();
            // $this->addStatusHistory($forms[$form_id]['initial_status'],Auth::user()->id,date('Y-m-d H:s:i'));
            return response()->json([
                'success' => true,
                'message' => 'Record saved successfully!',
                'record' => $record
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Form ID or model_name not found in session.',

        ]);
    }


    //    public function viewRecord(Request $request)
    // {
    //     $form_id = session('form_id', 0);
    //     $forms = session('forms'); 

    //     if (!$form_id || !$forms || !isset($forms[$form_id]['model_name'])) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Form ID or model_name not found in session.'
    //         ]);
    //     }

    //     $modelName = $forms[$form_id]['model_name'];

    //     if (!class_exists($modelName)) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => "Model {$modelName} does not exist."
    //         ]);
    //     }

    //     // Get the record ID from request
    //     $record_id = $request->input('record_id');

    //     if (!$record_id) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'No record ID provided.'
    //         ]);
    //     }

    //     // Fetch the record
    //     $record = $modelName::find($record_id);

    //     if (!$record) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Record not found.'
    //         ]);
    //     }

    //     // Return as JSON (or you can render a view)
    //     return response()->json([
    //         'success' => true,
    //         'record' => $record
    //     ]);
    // }


    public function formBuilder(Request $request)
    {
        $formId = $request->form_id;
        \session()->put('form_id', $formId);
        $has_access =  $this->getAccessValidate($formId, 'create');
   
        if (!$has_access) {
            return response()->json([
                'html' => '<center><h3>You do not have access to create records for this form.</h3></center>',
                'success' => false,
                'message' => 'You do not have access to create records for this form.'
            ]);
        }
    // dd($this->generateFormHtml($formId, false));
        return response()->json([
            'html' => $this->generateFormHtml($formId, false), // false = create/edit,
            'isView' => false,
            'form_status' => null
        ]);
    }

    public function viewRecord(Request $request)
    {
        $formId = \session()->get('form_id');
        $recordId = $request->record_id;


       
        $record = null;
        $forms = \session()->get('forms');
        if ($recordId && isset($forms[$formId]['model_name'])) {
          
            $modelName = $forms[$formId]['model_name'];
            if (class_exists($modelName)) {

                $record = $modelName::find($recordId);
            }

        }

        $current_status_id = $record ? $record->current_status_id : null;
      
        $current_form_status = null;
        $status_next = collect();

        if ($formId && $current_status_id) {
            
            $current_form_status = FormStatusModel::with('repStatus')->where('form_id', $formId)
                ->where('status_id', $current_status_id)
                ->first();
            

            if ($current_form_status && $current_form_status->status_next) {
                $nextStatusIds = explode(',', $current_form_status->status_next);

                $nextStatusIds = array_map('trim', $nextStatusIds);

                $status_next = FormStatusModel::with('repStatus')->where('form_id', $formId)
                    ->whereIn('status_id', $nextStatusIds)
                    ->get();
            }
            else{
                $current_form_status = "no current status";
            }
        }

        // dd($current_form_status, $status_next);
        return response()->json([
            'html' => $this->generateFormHtml($formId, true, $record),
            'isView' => true,
            'status' => [
               
                'current' => $current_form_status,
                'next' => $status_next
            ]
        ]);
    }
    private function generateFormHtml($formId, $isView = false, $record = null)
    {
        $role = Auth::user()->toArray()['role'];
        $fields = FormFieldsModel::with(['refField', 'tab'])
            ->where('form_id', $formId)
            ->get();
        $create_field = '';
     
        // $record = $record;

        if ($role == 0) {
            $create_field = "<a href='#' id='create-field-link' data-form-id='{$formId}'  >Create Field</a>";
        }
        if ($fields->isEmpty()) {
            return '<center><h3>No fields defined for this form.</h3> ' . $create_field . '</center>';
        }

        $tabIds = $fields->pluck('tab_id')->unique()->toArray();
        $uniqueTabs = $fields->pluck('tab')->filter()->unique('id')->sortBy('id')->values();
        $tabsFields = $fields->groupBy('tab_id')->transform(fn($f) => $f->sortBy('sequence')->values());
        $html = '';
        if ($isView) {

            $html .= '
                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <!-- Left Side -->
                        <div>
                            <button type="button" class="btn btn-secondary me-2 list-view "data-formid="'.$formId.'" id="back-to-list">
                                <i class="bi bi-arrow-left"></i> Back to List
                            </button>
                        </div>

                        <!-- Right Side -->
                        <div class="d-flex align-items-center gap-2">

                            <button type="button" class="btn btn-primary" id="edit-btn">
                                <i class="bi bi-pencil"></i> Edit
                            </button>

                            <button type="submit" class="btn btn-success d-none" id="save-btn">
                                <i class="bi bi-save"></i> Save
                            </button>

                            <button type="button" class="btn btn-danger d-none" id="cancel-btn">
                                <i class="bi bi-x"></i> Cancel
                            </button>

                           <div class="dropdown" id="change-status-div" >
                    <button class="btn btn-success dropdown-toggle"style="float:right" type="button" data-bs-toggle="dropdown">
                       Change Status
                    </button>
                    <ul class="dropdown-menu" id="status-change-list">
                        
                    </ul>
                </div>
                        </div>
                    </div>';
                        }
        $html .= '<form action="#" id="form_submit" method="POST">';
        $html .= csrf_field();
         if (!$isView) {

            $html .= '
                    <div class="d-flex justify-content-end mb-3">
                        <button type="submit" id="save_btn" class="btn btn-success">
                            <i class="bi bi-save"></i> Save
                        </button>
                    </div>';
                } 
            

        // Tabs header
        $first = true;
        $html .= '<ul class="nav nav-tabs" id="formTab" role="tablist">';
        foreach ($uniqueTabs as $tab) {
            if (!in_array($tab->id, $tabIds)) continue;
            $activeClass = $first ? 'active' : '';
            $ariaSelected = $first ? 'true' : 'false';
            $html .= '<li class="nav-item" role="presentation">
            <button class="nav-link ' . $activeClass . '" 
                    id="tab' . $tab->id . '-tab" 
                    data-bs-toggle="tab" 
                    data-bs-target="#tab' . $tab->id . '" 
                    type="button" 
                    role="tab" 
                    aria-controls="tab' . $tab->id . '" 
                    aria-selected="' . $ariaSelected . '">
                ' . ($tab->tab_name ?? 'Tab ' . $tab->id) . '
            </button>
        </li>';
            $first = false;
        }
        $html .= '</ul>';

        // Tabs content
        $first = true;
        $html .= '<div class="tab-content mt-3" id="formTabContent">';
        foreach ($uniqueTabs as $tab) {
            if (!in_array($tab->id, $tabIds)) continue;
            $activeClass = $first ? 'show active' : '';
            $html .= '<div class="tab-pane fade ' . $activeClass . '" 
                      id="tab' . $tab->id . '" 
                      role="tabpanel" 
                      aria-labelledby="tab' . $tab->id . '-tab">
                      <div class="row">';
                    // return$tabsFields->toArray();
            if (isset($tabsFields[$tab->id])) {
                foreach ($tabsFields[$tab->id] as $field) {

                    $field_data = $field->refField;
                    if ($field_data) {
                         $field_unique_id = $formId . '_' . $field->sequence . '_' . $field_data->id;
                        $viewName = 'form.' . $field_data->field_type;

                        if (View::exists($viewName)) {

                            $value = $record ? ($record->{$field['input_name']} ?? '') : '';
                            $label = view('form.layout_label', compact('field', 'field_unique_id'))->render();

                            $html .= view($viewName, compact('field', 'field_data', 'field_unique_id', 'isView', 'value', 'record', 'label'))->render();
                        } else {
                             $field_unique_id = $formId . '_' . $field->sequence . '_' . $field_data->id;
                            $label = view('form.layout_label', compact('field', 'field_unique_id'))->render();
                            $html .= view('form.default_fields', compact('field', 'viewName', 'field_unique_id', 'label'));
                        }
                    } else {
                        $html .= view('form.default_fields', compact('field', 'viewName', 'field_unique_id','isView','record', 'label'));
                    }
                   
                }
            }
            $html .= '</div></div>';
            $first = false;
        }
        $html .= '</div></form>';

        return $html;
    }

    public function changeStatus(Request $request)
    {
        dd('change status', $request->all());
        $recordId = $request->input('record_id');
        $newStatusId = $request->input('new_status_id');

        $formId = \session()->get('form_id');
        $forms = \session()->get('forms');

        if (!$formId || !$forms || !isset($forms[$formId]['model_name'])) {
            return response()->json([
                'success' => false,
                'message' => 'Form ID or model_name not found in session.'
            ]);
        }

        $modelName = $forms[$formId]['model_name'];

        if (!class_exists($modelName)) {
            return response()->json([
                'success' => false,
                'message' => "Model {$modelName} does not exist."
            ]);
        }

        $record = $modelName::find($recordId);

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'Record not found.'
            ]);
        }

        $record->current_status_id = $newStatusId;
        $record->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!',
            'record' => $record
        ]);
    }

    public function getList(Request $request)
    {


        $formId = $request->form_id;
        \session()->put('form_id', $formId);
        $has_access =  $this->getAccessValidate($formId, 'listview');

        if (!$has_access) {
            return response()->json([
                'success' => false,
                'records' => [],
                'message' => '<center>You do not have access to view records for this form.</center>'
            ]);
        }
        $forms = \session()->get('forms', []);

        if (!$formId || !isset($forms[$formId]['model_name'])) {
            return response()->json([
                'success' => false,
                'message' => '<center>Form not found.</center>'
            ]);
        }

        $role = Auth::user()->toArray()['role'];

        $modelName = $forms[$formId]['model_name'];
      
        # for super admin show create model and create table link if model or table not exists
        $create_model = '<center> This feature not available right now. Please contact developer </center>';
        $create_table = '<center> This feature not available right now. Please contact developer </center>';
        if ($role == 0) {
            $create_model = "<center>Model {$modelName} does not exist.<a href='#' id='create-model-link' data-form-id='{$formId}' data-model-name='{$modelName}' >Create Model</a></center>";
        }

        if (!class_exists($modelName)) {
            return response()->json([
                'success' => false,
                'message' => $create_model
            ]);
        }
        $table = (new $modelName)->getTable();
        $create_table = '<center> This feature not available right now. Please contact developer </center>';
        if ($role == 0) {
            $create_table = "<center>Table '{$table}' for model {$modelName} does not exist. <a href='#' id='create-table-link' data-form-id='{$formId}' data-model-name='{$modelName}' >Create Table</a></center>";
        }
        if (!Schema::hasTable($table)) {
            return response()->json([
                'success' => false,
                'message' => $create_table
            ]);
        }

        $relations = [];
        if (method_exists($modelName, 'created_user')) {
            $relations[] = 'created_user';
        }
        if (method_exists($modelName, 'category')) {
            $relations[] = 'category';
        }

        $records = $modelName::with($relations)->orderBy('id', 'desc')->get();
        $formFolder = 'form_listview';
        $formViewFile = 'list_view_form_' . $formId;

        $viewName = $formFolder . '.' . $formViewFile;

        $viewPath = resource_path("views/{$formFolder}/{$formViewFile}.blade.php");

        File::ensureDirectoryExists(resource_path("views/{$formFolder}"));

        if (!View::exists($viewName)) {
            File::put($viewPath, '
        <div class="text-center p-4">
            <h5>No content for form</h5>
        </div>
    ');
        }

        // Render the view
        $html = view($viewName, compact('records'))->render();
        return response()->json([
            'success' => true,
            'records' => $records,
            'html' => $html
        ]);
    }

    private function getAccessValidate($formId, $accessType)
    {
        $access_list = \session()->get('user_form_access', []);
       
        $specific_form_access = $access_list[$formId] ?? [];
        $has_access = $specific_form_access ? $specific_form_access['access'][$accessType] ?? false : false;
        return $has_access;
    }

    private function addStatusHistory($status_id,$create_by,$date_created){


    }
}
