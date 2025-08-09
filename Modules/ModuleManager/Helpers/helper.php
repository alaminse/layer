<?php

if (!function_exists('moduleStatusCheck')) {
    function moduleStatusCheck($module)
    {
        try {
           

            $haveModule = app('ModuleList')->where('name', $module)->first();

            if (empty($haveModule)) {
                return false;
            }
            $moduleStatus = $haveModule->status;

            $is_module_available = 'Modules/' . $module . '/Providers/' . $module . 'ServiceProvider.php';

            if (file_exists($is_module_available)) {

                $moduleCheck = \Nwidart\Modules\Facades\Module::find($module)->isEnabled();

                if (!$moduleCheck) {
                    return false;
                }

                if ($moduleStatus == 1) {
                    $is_verify = app('ModuleManagerList')->where('name', $module)->first();

                    if (!empty($is_verify->purchase_code)) {
                        if(saasDomain() != 'main' && $module != 'AdvSaas'){
                            $plan = activePlan();
                            $modules = $plan ? $plan->modules : [];
                            return in_array($module, $modules);
                        }
                        return true;
                    }
                }
            }

            return false;
        } catch (\Throwable $th) {

//            dd($th);
            return false;
        }
    }
}
