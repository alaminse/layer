<?php

namespace Modules\Setting\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\AdvSaas\Events\OrganizationCreated;
use Modules\Setting\Listeners\OrganizationCreatedListener;
use Modules\Setting\Repositories\GeneralSettingRepository;
use Modules\Setting\Repositories\GeneralSettingRepositoryInterface;
use Modules\Setting\Repositories\CurrencyRepository;
use Modules\Setting\Repositories\CurrencyRepositoryInterface;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Modules\Setting\Model\GeneralSetting;
use Modules\Setting\Model\DateFormat;
use Modules\Setting\Entities\Config;
use Modules\Setting\Entities\Theme;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Setting';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'setting';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        if(moduleStatusCheck('AdvSaas')){
            Event::listen(
                OrganizationCreated::class,
                [OrganizationCreatedListener::class, 'handle']
            );
        }
        View::composer(['partials.header', 'layouts.guest'], function ($view){
            if (session()->has('color_theme')) {
                $theme =  session('color_theme');
            } else {
                $theme = Theme::with('colors')->where('is_default', 1)->first();
                session()->put('color_theme', $theme);
            }

            $view->with('color_theme', $theme);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->bind(GeneralSettingRepositoryInterface::class,GeneralSettingRepository::class);
        $this->app->bind(CurrencyRepositoryInterface::class,CurrencyRepository::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production') && $this->app->runningInConsole()) {

            $this->loadFactoriesFrom(module_path($this->moduleName, '$FACTORIES_PATH$'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
