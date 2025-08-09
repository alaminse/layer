<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Models\Cases;
use App\Traits\Dashboard;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Modules\Appointment\Entities\Booking;
use Modules\Appointment\Entities\Schedule;
use Modules\Appointment\Repositories\Interfaces\BookingRepositoryInterface;
use Modules\Todo\Entities\ToDo;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Modules\Attendance\Repositories\EventRepositoryInterface;
use Modules\Attendance\Repositories\HolidayRepositoryInterface;
use Modules\RolePermission\Entities\Permission;

class HomeController extends Controller
{
    protected $eventRepository,
        $holidayRepository;

    public function __construct(
        EventRepositoryInterface $eventRepository,
        HolidayRepositoryInterface $holidayRepository
    )
    {
        $this->eventRepository = $eventRepository;
        $this->holidayRepository = $holidayRepository;
    }

    use Dashboard;


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        if (auth()->user()->role_id == 0){
            return redirect()->route('client.my_dashboard');
        }
        $data = [
            'toDos' => ToDo::where('created_by', Auth::id())->get(),
            'appointments' => Appointment::orderBy('id', 'desc')->take(10)->get(),
            'upcommingdate' => Cases::where(['status' => 'Open'])->where('hearing_date','>=', date('Y-m-d'))->orderBy('hearing_date', 'asc')->take(10)->get()
        ];

        if(moduleStatusCheck('Appointment')){
            $booking_repo = App::make(BookingRepositoryInterface::class);
            $payload['lawyer'] = '';
            $payload['time_slot'] = '';
            $payload['start_date'] = '';
            $payload['end_date'] = '';
            $payload['status'] = 'active';
            $data['appointments'] = $booking_repo->filterBookedUser($payload);


        }
        return view('home')->with($data);

    }

    public function calendar(Request $request)
    {
        $calendar_events = $this->calendarEvents();
        if(moduleStatusCheck('Appointment')){
           
            // $schedules = Schedule::where('user_id', auth()->user()->id)
            //     ->whereBetween('schedule_date', [$request->start, $request->end])
            //     ->where('status', 1)
            //     ->get();

                $schedules = Booking::when(auth()->user()->role_id == 0, function($q){
                    $q->where('client_id', auth()->id());
                }, function($q){
                    $q->where('user_id', auth()->id());
                })->with(['schedule' => function($q) use($request){
                    $q->whereBetween('schedule_date', [$request->start, $request->end]);
                }, 'meeting'])->whereHas('schedule', function($q) use($request){
                    $q->whereBetween('schedule_date', [$request->start, $request->end]);
                });

            $count_event = count($calendar_events);
            foreach ($schedules as $k => $event) {
                $start_time = Carbon::parse($event->schedule->schedule_date)->format('Y-m-d').' '.$event->schedule->slotInfo->start_time;
                $end_time = Carbon::parse($event->schedule->schedule_date)->format('Y-m-d').' '.$event->schedule->slotInfo->end_time;
                $calendar_events[$count_event]['title'] = 'Appointment';

                $calendar_events[$count_event]['start'] = $start_time;

                $calendar_events[$count_event]['end'] = $end_time;
                $calendar_events[$count_event]['description'] = view('appointment::calender_modal', compact('event'))->render();
                $calendar_events[$count_event]['url'] = null;

                $count_event++;
            }
        }

        return response()->json($calendar_events);
    }

    public function change_password()
    {
        return view('backEnd.profiles.password');
    }

    public function post_change_password (Request $request)
    {
        if($this->demoCheck() == true){
            Toastr::warning('This Features is disabled for demo.');
            return back();
        }
        $validation_rules = [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ];

        $validator = Validator::make($request->all(), $validation_rules, validationMessage($validation_rules));
        $user = User::where(['email' => auth()->user()->email])->first();

        $validator->after(function ($validator) use ($user, $request) {
            if ($user and Hash::check($request->current_password, $user->password)) {
                return true;
            }
            $validator->errors()->add(
                'current_password', __('auth.failed')
            );
        });

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user->password = bcrypt($request->password);
        $user->save();
        Toastr::success(__('common.Password change successful'), __('common.success'));
        return redirect()->route('home');

    }
}
