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
        if (!\session()->has('home')) {
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


        // Get record if available
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
        }

        // dd($current_form_status, $status_nextes);
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
        $fields = FormFieldsModel::with(['refField', 'tab'])
            ->where('form_id', $formId)
            ->get();
        if($fields->isEmpty()){
            return '<center><h3>No fields defined for this form.</h3></center>';
        }

        $tabIds = $fields->pluck('tab_id')->unique()->toArray();
        $uniqueTabs = $fields->pluck('tab')->filter()->unique('id')->sortBy('id')->values();
        $tabsFields = $fields->groupBy('tab_id')->transform(fn($f) => $f->sortBy('sequence')->values());

        $html = '<form action="#" id="form_submit" method="POST">';
        $html .= csrf_field();

        if (!$isView) {
            $html .= '<button type="submit" class="btn btn-success float-end mb-3">Save</button>';
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
            if (isset($tabsFields[$tab->id])) {
                foreach ($tabsFields[$tab->id] as $field) {

                    $field_data = $field->refField;
                    if (!$field_data) continue;
                    $field_unique_id = $formId . '_' . $field->sequence . '_' . $field_data->id;
                    $viewName = 'form.' . $field_data->field_type;

                    if (View::exists($viewName)) {

                        $value = $record ? ($record->{$field['input_name']} ?? '') : '';

                        $html .= view($viewName, compact('field', 'field_data', 'field_unique_id', 'isView', 'value'))->render();
                    } else {
                        $html .= "<!-- View {$viewName} does not exist -->";
                    }
                }
            }
            $html .= '</div></div>';
            $first = false;
        }
        $html .= '</div></form>';

        return $html;
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

        $modelName = $forms[$formId]['model_name'];

        if (!class_exists($modelName)) {
            return response()->json([
                'success' => false,
                'message' => "<center>Model {$modelName} does not exist.</center>"
            ]);
        }

        // Return JSON for DataTable
        $records = $modelName::with('created_user', 'category')->orderBy('id', 'desc')->get(); 
        
        return response()->json([
            'success' => true,
            'records' => $records
        ]);
    }

    private function getAccessValidate($formId, $accessType)
    {
        $access_list = \session()->get('user_form_access', []);
        $specific_form_access = $access_list[$formId] ?? [];
        $has_access = $specific_form_access ? $specific_form_access['access'][$accessType] ?? false : false;
        return $has_access;
    }
}
