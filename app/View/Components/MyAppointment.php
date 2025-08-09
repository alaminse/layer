<?php

namespace App\View\Components;

use Carbon\Carbon;
use Illuminate\View\Component;
use Modules\Appointment\Entities\Booking;
use Modules\Appointment\Repositories\Interfaces\ScheduleRepositoryInterface;

class MyAppointment extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    protected $scheduleRepository;
    public function __construct(
        ScheduleRepositoryInterface $scheduleRepository
    )
    {
        $this->scheduleRepository = $scheduleRepository;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        $user_id = auth()->user()->client->id;
        $booking_list = Booking::with('schedule', 'meeting')->where('status', 'active')->where('client_id', $user_id)->groupBy('schedule_id');
       
        $data['booking_list'] = $booking_list->get();
        
        $data += $this->scheduleRepository->datePeriods();
        $schedules = $data['booking_list'];
        $calendar_events = [];
        $count_event = 0;
        foreach ($schedules as $k => $event) {
            $start_time = Carbon::parse($event->schedule->schedule_date)
            ->format('Y-m-d').' '.$event->schedule->slotInfo->start_time;

            $end_time = Carbon::parse($event->schedule->schedule_date)
            ->format('Y-m-d').' '.$event->schedule->slotInfo->end_time;
            
            $calendar_events[$count_event]['title'] = 'Appointment';

            $calendar_events[$count_event]['start'] = $start_time;

            $calendar_events[$count_event]['end'] = $end_time;
            $calendar_events[$count_event]['description'] = view('appointment::calender_modal', compact('event'))->render();
            $calendar_events[$count_event]['url'] = $event->share_link;

            $count_event++;
        }
        
        return view('components.my-appointment', compact('calendar_events'));
    }
}
