<?php

namespace Modules\Setting\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Modules\AdvSaas\Events\OrganizationCreated;
use Modules\Setting\Entities\Config;
use Modules\Setting\Model\EmailTemplate;

class OrganizationCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrganizationCreated $event)
    {
        $organization = $event->organization;

        $configs = getModuleVar('Setting', 'config');
        $configs['site_title'] = $organization->name;
        $configs['company_name'] = $organization->name;
        $configs = collect($configs)->map(function($value, $key) use($organization) {
            return [
                'key' => $key,
                'value' => $value,
                'organization_id' => $organization->id
            ];
        })->values()->toArray();

        Config::insert($configs);

       $email_templates = EmailTemplate::where('is_default', 1)->where('module', '!=', 'AdvSaas')->orWhereNull('module')->get();
       foreach($email_templates as $template){
           $template = $template->replicate();
           $template->organization_id = $organization->id;
           $template->save();
       }

       

        
        $sql [] = ['title'  => "Default Theme", 'color_mode' => "gradient", 'background_type'  => "image", 'background_image' => asset('/public/backEnd/img/body-bg.jpg'),
                'is_default'  => 1, 'created_by' => 1, 'organization_id' => $organization->id];
        

        DB::table('themes')->insert($sql);

        $theme = \Modules\Setting\Entities\Theme::withOutGlobalScope(\App\Scopes\OrganizationScope::class)->where('organization_id', $organization->id)->first();
        $sql = [];

        $sql[] = ['theme_id'  => $theme->id, 'color_id' => 1, 'value'  => "#415094"];
        $sql[] = ['theme_id'  => $theme->id, 'color_id' => 2, 'value'  => "#7c32ff"];
        $sql[] = ['theme_id'  => $theme->id, 'color_id' => 3, 'value'  => "#A235EC"];
        $sql[] = ['theme_id'  => $theme->id, 'color_id' => 4, 'value'  => "#c738d8"];
        $sql[] = ['theme_id'  => $theme->id, 'color_id' => 5, 'value'  => "#7e7172"];
        $sql[] = ['theme_id'  => $theme->id, 'color_id' => 6, 'value'  => "#828bb2"];
        $sql[] = ['theme_id'  => $theme->id, 'color_id' => 7, 'value'  => "#ffffff"];
        $sql[] = ['theme_id'  => $theme->id, 'color_id' => 8, 'value'  => "#ffffff"];
        $sql[] = ['theme_id'  => $theme->id, 'color_id' => 9, 'value'  => "#000000"];
        $sql[] = ['theme_id'  => $theme->id, 'color_id' => 10, 'value'  => "#000000"];
        $sql[] = ['theme_id'  => $theme->id, 'color_id' => 11, 'value'  => "#ECEEF4"];
        $sql[] = ['theme_id'  => $theme->id, 'color_id' => 12, 'value'  => "#ffffff"];
        $sql[] = ['theme_id'  => $theme->id, 'color_id' => 13, 'value'  => "#51A351"];
        $sql[] = ['theme_id'  => $theme->id, 'color_id' => 14, 'value'  => "#E09079"];
        $sql[] = ['theme_id'  => $theme->id, 'color_id' => 15, 'value'  => "#FF6D68"];
        

        DB::table('color_theme')->insert($sql);

    }
}
