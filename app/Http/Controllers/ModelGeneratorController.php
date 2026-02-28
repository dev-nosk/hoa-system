<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use App\Models\FormsModel;

class ModelGeneratorController extends Controller
{
    /**
     * Show the form to enter model name
     */
    public function index()
    {
        return view('model-generator.index'); // simple form with input for model name
    }

    /**
     * Handle model creation request
     */
    public function create(Request $request)
    {
        $modelInput = $request->input('model_name'); // e.g., "App\Models\PaymentModel"
        $id = $request->input('form_id');        // Get form ID from request

        // Get table name dynamically from FormsModel
        $form = FormsModel::where('id', $id)->first()->toArray();

       $table = $form['table']; // Assuming 'table_name' is the column in your forms table
    
        // Extrac   t just the class basename
        $modelName = class_basename($modelInput); // e.g., "PaymentModel"

        // Model file path
        $modelPath = app_path("Models/{$modelName}.php");

        // Check if model already exists
        if (File::exists($modelPath)) {
            return back()->with('error', "Model {$modelName} already exists!");
        }

        // Create model using Artisan
        Artisan::call('make:model', [
            'name' => "Models\\{$modelName}",
            '-m' => true,
            '-c' => true,
            '-f' => true,
            '--no-interaction' => true, // <-- add this
        ]);

        // Overwrite the generated model file to include dynamic table name
        $modelContent = <<<EOD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class {$modelName} extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected \$table = '{$table}';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected \$fillable = [
        // Add your fillable fields here
    ];
}
EOD;

        File::put($modelPath, $modelContent);

        $output = Artisan::output();

        return response()->json([
            'success' => true,
            'message' => "Model {$modelName} created successfully! Output: {$output}"
        ]);
    }
}