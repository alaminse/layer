<?php

namespace Modules\Leave\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\AdvSaas\Events\OrganizationCreated;
use Modules\Leave\Entities\LeaveType;

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

        LeaveType::insert([

            [
                'name' => 'Sick Leave',
                'created_by' => $organization->user->id,
                'updated_by' => $organization->user->id,
                'organization_id' => $organization->id,
            ],
            [
                'name' => 'Annual Leave',
                'created_by' => $organization->user->id,
                'updated_by' => $organization->user->id,
                'organization_id' => $organization->id,
            ],



        ]);

    }
}
