<?php

namespace Modules\ModuleManager\Http\Controllers;

use App\Traits\UploadTheme;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Modules\ModuleManager\Entities\InfixModuleManager;

use Nwidart\Modules\Facades\Module;
use ZipArchive;

class ModuleManagerController extends Controller
{
    use UploadTheme;

    public function __construct()
    {
        $this->middleware(['prohibited.demo.mode'])->only(['uploadModule', 'moduleAddOnsEnable']);
    }

    public function ModuleRefresh()
    {
        try {
//            exec('php composer.phar dump-autoload');
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            Artisan::call('config:clear');
            Toastr::success('Refresh successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Your server doesn\'t allow this refresh.' . $e->getMessage(), 'Failed');
            return redirect('');
        }
    }

    public function ManageAddOns()
    {
        try {
            $module_list = [];
            $is_module_available = app('ModuleList');
            return view('modulemanager::manage_module', compact('is_module_available', 'module_list'));
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), trans('common.Failed'));
            return redirect('');
        }
    }

    public function uploadModule(Request $request)
    {

        try {
            $validatedData = $request->validate([
                'module' => ['mimes:zip'],
            ], [
                'module.mimes' => 'The module must be a file of type: zip.',
            ]);


            $path = $request->module->store('updateFile');
            $request->module->getClientOriginalName();
            $zip = new ZipArchive;
            $res = $zip->open(storage_path('app/' . $path));
            if ($res === true) {
                $zip->extractTo(storage_path('app/tempUpdate'));
                $zip->close();
            } else {
                abort(500, 'Error! Could not open File');
            }


            $src = storage_path('app/tempUpdate');

            $dir = opendir($src);

            $module = '';
            while ($file = readdir($dir)) {
                if ($file != "." && $file != "..") {
                    $module = $file;
                }
            }

            $dst = base_path('/Modules/');
            $this->recurse_copy($src, $dst);

            if (moduleStatusCheck($module)) {
                $this->moduleMigration($module);
            }


            if (storage_path('app/updateFile')) {
                $this->delete_directory(storage_path('app/updateFile'));
            }
            if (storage_path('app/tempUpdate')) {
                $this->delete_directory(storage_path('app/tempUpdate'));
            }

            Cache::forget('ModuleList');
            Cache::forget('ModuleManagerList');
            Toastr::success("Your module successfully uploaded", 'Success');
            return redirect()->back();


        } catch (\Exception $e) {

            Toastr::error($e->getMessage(), trans('common.Failed'));
            return redirect()->back();
        }
    }


    public function moduleAddOnsEnable($name)
    {
        $module_tables = [];
        $module_tables_names = [];
        $dataPath = 'Modules/' . $name . '/' . $name . '.json';        // // Get the contents of the JSON file
        $strJsonFileContents = file_get_contents($dataPath);
        $array = json_decode($strJsonFileContents, true);
        $migrations = $array[$name]['migration'];
        $names = $array[$name]['names'];
        $version = $array[$name]['versions'][0];
        $url = $array[$name]['url'][0];
        $notes = $array[$name]['notes'][0];

        $s = InfixModuleManager::where('name', $name)->first();
        if (empty($s)) {
            return response()->json(['error' => __('common.Please verify module first')]);
        }

        $is_module_available = 'Modules/' . $name . '/Providers/' . $name . 'ServiceProvider.php';

        if (!empty($migrations) && count($migrations) != 0)
            foreach ($migrations as $value) {
                $module_tables[] = 'Modules/' . $name . '/Database/Migrations/' . $value;
            }

        foreach ($names as $value) {
            $module_tables_names[] = $value;
        }

        if (file_exists($is_module_available)) {
            try {

                if (!empty($module_tables)) {
                    foreach ($module_tables as $table) {
                        $path = $table;
                        if (file_exists($path)) {
                            try {
                                Artisan::call('migrate',
                                    array(
                                        '--path' => $path,
                                        '--force' => true));


                            } catch (\Exception $e) {
                                Log::info($e->getMessage());

                            }
                        }
                    }
                }

            } catch (\Exception $e) {
                Log::info($e->getMessage());

            }
        } else {
            Log::info('module not found');
            DB::rollback();
        }

        if (file_exists($is_module_available)) {
            $moduleStatus = Module::find($name)->isDisabled();
            if ($moduleStatus && $s->purchase_code) {
                $ModuleManage = Module::find($name)->enable();
                $data['data'] = 'enable';
            } else {
                $ModuleManage = Module::find($name)->disable();
                $data['data'] = 'disable';
            }

            $data['Module'] = $ModuleManage;
            $data['success'] = 'Operation success! Thanks you.';

            Cache::forget('ModuleList');
            Cache::forget('ModuleManagerList');

            return response()->json($data, 200);
        }

        return response()->json(['error' => __('common.Module file not found')]);

    }


    public function FreemoduleAddOnsEnable($name)
    {
        try {

            $module_tables = [];
            $module_tables_names = [];
            $dataPath = 'Modules/' . $name . '/' . $name . '.json';        // // Get the contents of the JSON file
            $strJsonFileContents = file_get_contents($dataPath);
            $array = json_decode($strJsonFileContents, true);
            $migrations = $array[$name]['migration'] ?? '';
            $names = $array[$name]['names'];


            $version = $array[$name]['versions'][0] ?? '';
            $url = $array[$name]['url'][0] ?? '';
            $notes = $array[$name]['notes'][0] ?? '';


            DB::beginTransaction();
            $s = InfixModuleManager::where('name', $name)->first();
            if (empty($s)) {
                $s = new InfixModuleManager();
            }
            $s->name = $name;
            $s->notes = $notes;
            $s->version = $version;
            $s->update_url = $url;
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();
            DB::commit();


            if (!empty($migrations) && count($migrations) != 0)
                foreach ($migrations as $value) {
                    $module_tables[] = 'Modules/' . $name . '/Database/Migrations/' . $value;
                }

            foreach ($names as $value) {
                $module_tables_names[] = $value;
            }

            $is_module_available = 'Modules/' . $name . '/Providers/' . $name . 'ServiceProvider.php';

            if (file_exists($is_module_available)) {
                try {

                    if (!empty($module_tables)) {
                        foreach ($module_tables as $table) {
                            $path = $table;
                            if (file_exists($path)) {
                                try {
                                    Artisan::call('migrate',
                                        array(
                                            '--path' => $path,
                                            '--force' => true));


                                } catch (\Exception $e) {
                                    Log::info($e->getMessage());

                                }
                            }
                        }
                    }


                    $moduleCheck = \Nwidart\Modules\Facades\Module::find($name);
                    $moduleCheck->enable();

                } catch (\Exception $e) {
                    Log::info($e->getMessage());

                }
            } else {
                Log::info('module not found');
                DB::rollback();
            }


        } catch (\Exception $e) {
            Log::info($e->getMessage());
            DB::rollback();
        }
        Cache::forget('ModuleList');
        Cache::forget('ModuleManagerList');
    }

    public function moduleMigration($module)
    {

        try {
            Artisan::call('module:migrate', [
                'module' => $module,
                '--force' => true
            ]);

            return true;
        } catch (\Exception $e) {
            Log::info($e);
            return false;
        }

    }

}
