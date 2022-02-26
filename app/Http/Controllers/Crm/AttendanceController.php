<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;
use App\Http\Controllers\Laralum\Laralum;
use Illuminate\Support\Facades\DB;
use App\Services\AttendanceService;
use App\User;
use App\Lead;
use App\Donation;
use App\Permission;
use Maatwebsite\Excel\Facades\Excel;
use Validator, File;
use Illuminate\Support\Str;
use Response;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
//use Datatables;
use App\Attendance;
use App\AttendanceSetting;
use Carbon\Carbon;
use App\Holiday;
use App\Leave;
use Yajra\DataTables\DataTables;
use App\Http\Requests\Attendance\StoreAttendance;
use App\Helper\Reply;
//use App\Imports\CampaignImport;
class AttendanceController extends Controller
{
    private $attendance;

	public function __construct(AttendanceService $attendance)
    {
        $this->attendance = $attendance;
        // Getting Attendance setting data
        $this->attendanceSettings = cache()->remember(
            'attendance-setting', 60*60*24, function () {
                return AttendanceSetting::first();;
            }
        );

        $this->maxAttendanceInDay = $this->attendanceSettings->clockin_in_day;
    }

	public function index(Request $request)
	{
		Laralum::permissionToAccess('laralum.attendance.list');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$openDays = json_decode($this->attendanceSettings->office_open_days);

        $startDate = Carbon::now()->timezone('Asia/Kolkata')->startOfMonth();
        $endDate = Carbon::now()->timezone('Asia/Kolkata');
        
        $employees = User::allEmployees(1);

        //$userId = User::first()->id;
        $userId = $employees[0]->id;

        $totalWorkingDays = $startDate->diffInDaysFiltered(function (Carbon $date) use ($openDays) {
            foreach ($openDays as $day) {
                if ($date->dayOfWeek == $day) {
                    return $date;
                }
            }
        }, $endDate);

        $daysPresent = Attendance::countDaysPresentByUser($startDate, $endDate, $userId);

        $daysLate = Attendance::countDaysLateByUser($startDate, $endDate, $userId);

        $halfDays = Attendance::countHalfDaysByUser($startDate, $endDate, $userId);

        $holidays = Count(Holiday::getHolidayByDates($startDate->format("Y-m-d"), $endDate->format("Y-m-d")));
		
		return view('hyper/attendance/index', compact('openDays','startDate','endDate','employees','userId','totalWorkingDays','daysPresent','daysLate','halfDays','holidays'));
	}


	public function summaryData(Request $request)
    {
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $employees = User::with(
            ['attendance' => function ($query) use ($request,$client_id) {
                $query->where('attendances.client_id', $client_id)->whereRaw('MONTH(attendances.clock_in_time) = ?', [$request->month])
                    ->whereRaw('YEAR(attendances.clock_in_time) = ?', [$request->year]);
            }]
        )
        ->where('users.reseller_id', $client_id)
        ->where('users.id', '<>', 1)
        ->where('users.isReseller', '!=', 1)
        //->join('role_user', 'role_user.user_id', '=', 'users.id')
            //->join('roles', 'roles.id', '=', 'role_user.role_id')
            //->leftJoin('employee_details', 'employee_details.user_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.email', 'users.created_at', 'users.department')
            //->where('roles.name', '<>', 'client')

                    
            ->groupBy('users.id');
          
        if ($request->department != 'all') {
            $employees = $employees->where('users.department', $request->department);
        }

        if ($request->userId != '0' && $request->userId != '1') {
            $employees = $employees->where('users.id', $request->userId);
        }

        $employees = $employees->get();

        $holidays = Holiday::whereRaw('MONTH(holidays.date) = ?', [$request->month])->whereRaw('YEAR(holidays.date) = ?', [$request->year])->get();


        $final = [];

        $daysInMonth = Carbon::parse('01-' . $request->month . '-' . $request->year)->daysInMonth;
        $month = Carbon::parse('01-' . $request->month . '-' . $request->year)->lastOfMonth();

        $now = Carbon::now()->timezone('Asia/Kolkata');
        $requestedDate = Carbon::parse(Carbon::parse('01-' . $request->month . '-' . $request->year))->endOfMonth();

        foreach ($employees as $employee) {


            if($requestedDate->isPast()){
                $dataTillToday = array_fill(1, $daysInMonth, 'Absent');
            }
            else{
                $dataTillToday = array_fill(1, $now->copy()->format('d'), 'Absent');
            }

            $dataFromTomorrow = [];
            if (($now->copy()->addDay()->format('d') != $daysInMonth) && !$requestedDate->isPast()) {
                $dataFromTomorrow = array_fill($now->copy()->addDay()->format('d'), ($daysInMonth - $now->copy()->format('d')), '-');
            } else {
                if($daysInMonth < $now->copy()->format('d')){
                    $dataFromTomorrow = array_fill($month->copy()->addDay()->format('d'), (0), 'Absent');
                }
                else{
                    $dataFromTomorrow = array_fill($month->copy()->addDay()->format('d'), ($daysInMonth - $now->copy()->format('d')), 'Absent');
                }            }
            $final[$employee->id . '#' . $employee->name] = array_replace($dataTillToday, $dataFromTomorrow);

            foreach ($employee->attendance as $attendance) {
                $final[$employee->id . '#' . $employee->name][Carbon::parse($attendance->clock_in_time)->timezone('Asia/Kolkata')->day] = '<a href="javascript:;" class="view-attendance" data-attendance-id="' . $attendance->id . '"><i class="fa fa-check text-success"></i></a>';
            }

            $image = '';

            $emplolyeeName = '<div class="row"><div class="col-xs-4"></div><div class="col-xs-8"><a href="' . route('Crm::staff_details', $employee->id) . '">' . ucwords($employee->name) . '</a></div></div>';
            
            $final[$employee->id . '#' . $employee->name][] = $emplolyeeName;

            foreach ($holidays as $holiday) {
                if ($final[$employee->id . '#' . $employee->name][$holiday->date->day] == 'Absent') {
                    $final[$employee->id . '#' . $employee->name][$holiday->date->day] = 'Holiday';
                }
            }
        }
        //
        $employeeAttendence = $final;

        //$view = view('admin.attendance.summary_data', $this->data)->render();
        $view = view('hyper/attendance/summary_data', ['employeeAttendence' => $employeeAttendence,'holidays' => $holidays,'daysInMonth' => $daysInMonth])->render();
       // view('hyper.attendance.user_attendance', ['employeeAttendence' => $employeeAttendence,'holidays' => $holidays,'daysInMonth' => $daysInMonth])->render()
        return response()->json(['status' => true , 'data' => $view]);
        //return Reply::dataOnly(['status' => 'success', 'data' => $view]);
    }
	public function summary()
    {
    	Laralum::permissionToAccess('laralum.attendance.list');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $employees = User::allEmployees(1);
        $now = Carbon::now();
        $year = $now->format('Y');
        $month = $now->format('m');
        $departments = DB::table('departments')
							->where('client_id', $client_id)
							->get();


        return view('hyper.attendance.summary', compact('employees','year','month','departments'));
    }



	public function refreshCount(Request $request, $startDate = null, $endDate = null, $userId = null)
    {

        $openDays = json_decode($this->attendanceSettings->office_open_days);
        $startDate = Carbon::createFromFormat("d-m-Y", $request->startDate);
        $endDate = Carbon::createFromFormat("d-m-Y", $request->endDate)->addDay(1); //addDay(1) is hack to include end date
        $userId = $request->userId;

        $totalWorkingDays = $startDate->diffInDaysFiltered(function (Carbon $date) use ($openDays) {
            foreach ($openDays as $day) {
                if ($date->dayOfWeek == $day) {
                    return $date;
                }
            }
        }, $endDate);
        $daysPresent = Attendance::countDaysPresentByUser($startDate, $endDate, $userId);
        $daysLate = Attendance::countDaysLateByUser($startDate, $endDate, $userId);
        $halfDays = Attendance::countHalfDaysByUser($startDate, $endDate, $userId);
        $daysAbsent = (($totalWorkingDays - $daysPresent) < 0) ? '0' : ($totalWorkingDays - $daysPresent);
        $holidays = Count(Holiday::getHolidayByDates($startDate->format('Y-m-d'), $endDate->format('Y-m-d')));

        return response()->json(['status' => true ,'daysPresent' => $daysPresent, 'daysLate' => $daysLate, 'halfDays' => $halfDays, 'totalWorkingDays' => $totalWorkingDays, 'absentDays' => $daysAbsent, 'holidays' => $holidays]);
        //return Reply::dataOnly(['daysPresent' => $daysPresent, 'daysLate' => $daysLate, 'halfDays' => $halfDays, 'totalWorkingDays' => $totalWorkingDays, 'absentDays' => $daysAbsent, 'holidays' => $holidays]);
    }

    public function employeeData(Request $request, $startDate = null, $endDate = null, $userId = null)
    {
    	Laralum::permissionToAccess('laralum.attendance.list');
        if (Laralum::loggedInUser()->reseller_id == 0) {
            $client_id = Laralum::loggedInUser()->id;
        } else {
            $client_id = Laralum::loggedInUser()->reseller_id;
        }
        $ant = []; // Array For attendance Data indexed by similar date
        $dateWiseData = []; // Array For Combine Data

        $startDate = Carbon::createFromFormat("d-m-Y", $request->startDate)->startOfDay();
        $endDate = Carbon::createFromFormat("d-m-Y", $request->endDate)->endOfDay()->addDay(1);
        $userId = $request->userId;

        $attendances = Attendance::userAttendanceByDate($startDate, $endDate, $userId); // Getting Attendance Data
        $holidays = Holiday::getHolidayByDates($startDate, $endDate); // Getting Holiday Data

        // Getting Leaves Data
        $leavesDates = Leave::where('user_id', $userId)
            ->where('leave_date', '>=', $startDate)
            ->where('leave_date', '<=', $endDate)
            ->where('client_id', '=', $client_id)
            ->where('status', 'approved')
            ->select('leave_date', 'reason', 'duration')
            ->get()->keyBy('date')->toArray();

        $holidayData = $holidays->keyBy('holiday_date');
        $holidayArray = $holidayData->toArray();

        // Set Date as index for same date clock-ins
        foreach ($attendances as $attand) {
            $ant[$attand->clock_in_date][] = $attand; // Set attendance Data indexed by similar date
        }

        $endDate = Carbon::createFromFormat("d-m-Y", $request->endDate)->timezone('Asia/Kolkata');
        $startDate = Carbon::createFromFormat("d-m-Y", $request->startDate)->timezone('Asia/Kolkata')->subDay();

        // Set All Data in a single Array
        for ($date = $endDate; $date->diffInDays($startDate) > 0; $date->subDay()) {

            // Set default array for record
            $dateWiseData[$date->toDateString()] = [
                'holiday' => false,
                'attendance' => false,
                'leave' => false
            ];

            // Set Holiday Data
            if (array_key_exists($date->toDateString(), $holidayArray)) {
                $dateWiseData[$date->toDateString()]['holiday'] = $holidayData[$date->toDateString()];
            }

            // Set Attendance Data
            if (array_key_exists($date->toDateString(), $ant)) {
                $dateWiseData[$date->toDateString()]['attendance'] = $ant[$date->toDateString()];
            }

            // Set Leave Data
            if (array_key_exists($date->toDateString(), $leavesDates)) {
                $dateWiseData[$date->toDateString()]['leave'] = $leavesDates[$date->toDateString()];
            }
        }

        // Getting View data
        $view = view('hyper.attendance.user_attendance', ['dateWiseData' => $dateWiseData])->render();
        return response()->json(['status' => true , 'data' => $view]);
        //return Reply::dataOnly(['status' => 'success', 'data' => $view]);
    }

    public function destroy($id)
    {
    	Laralum::permissionToAccess('laralum.attendance.delete');
        Attendance::destroy($id);
        //return Reply::success(__('messages.attendanceDelete'));
        return response()->json(array(
			'status' => 'success',
		));
    }

    public function create()
    {
    	Laralum::permissionToAccess('laralum.attendance.create');
        return view('hyper.attendance.create');
    }

    public function checkHoliday(Request $request)
    {
        $date = Carbon::createFromFormat("d-m-Y", $request->date)->format('Y-m-d');
        $checkHoliday = Holiday::checkHolidayByDate($date);
        //return Reply::dataOnly(['status' => 'success', 'holiday' => $checkHoliday]);
        return response()->json(['status' => true , 'holiday' => $checkHoliday]);
    }

    public function data(Request $request)
    {
        $date = Carbon::createFromFormat("d-m-Y", $request->date)->format('Y-m-d');
        $attendances = Attendance::attendanceByDate($date);

        return DataTables::of($attendances)
            ->editColumn('id', function ($row) {
                return view('hyper.attendance.attendance_list', ['row' => $row, 'maxAttendanceInDay' => $this->maxAttendanceInDay])->render();
            })
            ->rawColumns(['id'])
            ->removeColumn('name')
            ->removeColumn('clock_in_time')
            ->removeColumn('clock_out_time')
            //->removeColumn('image')
            ->removeColumn('attendance_id')
            ->removeColumn('working_from')
            ->removeColumn('late')
            ->removeColumn('half_day')
            ->removeColumn('clock_in_ip')
            ->removeColumn('total_clock_in')
            ->removeColumn('clock_in')
            //->removeColumn('designation_name')
            ->make();
    }




    public function store(StoreAttendance $request)
    {
    	Laralum::permissionToAccess('laralum.attendance.create');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $date = Carbon::createFromFormat("d-m-Y", $request->date)->format('Y-m-d');
        $clockIn = Carbon::createFromFormat("Y-m-d"." "."h:i a", $date.' '.$request->clock_in_time, "Asia/Kolkata");
        //$clockIn->setTimezone('UTC');
        //dd($clockIn);
        if ($request->clock_out_time != '') {
            $clockOut = Carbon::createFromFormat("Y-m-d"." "."h:i a", $date.' '.$request->clock_out_time, "Asia/Kolkata");
            //$clockOut->setTimezone('UTC');

            if ($clockIn->gt($clockOut) && !is_null($clockOut)) {
                return Reply::error('Clock-out time cannot be less than clock in time');
            }

            $clockIn = $clockIn->toDateTimeString();
            $clockOut = $clockOut->toDateTimeString();

        } else {
            $clockOut = null;
        }


        $attendance = Attendance::where('user_id', $request->user_id)
        	->where('client_id', $client_id)
            ->where(DB::raw('DATE(`clock_in_time`)'), $date)
            ->whereNull('clock_out_time')
            ->first();

        $clockInCount = Attendance::getTotalUserClockIn($date, $request->user_id);

        $data = [
        	'client_id' => $client_id,
            'user_id' => $request->user_id,
            'clock_in_time' => $clockIn,
            'clock_in_ip' => $request->clock_in_ip,
            'clock_out_time' => $clockOut,
            'clock_out_ip' => $request->clock_out_ip,
            'working_from' => $request->working_from,
            'late' => $request->late,
            'half_day' => $request->half_day
        ];

        if (is_null($attendance)) {
            // Check maximum attendance in a day
            if ($clockInCount < $this->attendanceSettings->clockin_in_day) {
                Attendance::create($data);
            } else {
                return Reply::error('Maximum check-ins reached.');
            }
        } else {
            $attendance->update($data);
        }

        return response()->json(['status' => true , 'message' => 'Attendance Saved Successfully.']);
        //return Reply::success('Attendance Saved Successfully.');
    }

    // Attendance Detail Show
    public function attendanceDetail(Request $request)
    {
    	Laralum::permissionToAccess('laralum.attendance.view');
        // Getting Attendance Data By User And Date
        $attendances =  Attendance::attendanceByUserAndDate($request->date, $request->userID);
        //return view('hyper.attendance.attendance-detail',compact('attendances'))->render();

        return $view = view('hyper.attendance.attendance-detail', ['attendances' => $attendances])->render();
        //return response()->json(['status' => true , 'data' => $view]);
    }

    

    public function mark(Request $request, $userid, $day, $month, $year)
    {
    	Laralum::permissionToAccess('laralum.attendance.create');
        $userDetail = User::find($userid);

        $date = Carbon::createFromFormat('d-m-Y', $day . '-' . $month . '-' . $year)->format('Y-m-d');
        $row = Attendance::attendanceByUserDate($userid, $date);
        $clock_in = 0;
        $total_clock_in = Attendance::where('user_id', $userid)
            ->where(DB::raw('DATE(attendances.clock_in_time)'), '=', $date)
            ->whereNull('attendances.clock_out_time')->count();

        $userid = $userid;
        $type = 'add';
        $maxAttendanceInDay = $this->maxAttendanceInDay;
        return view('hyper.attendance.attendance_mark', compact('userDetail','row','clock_in','total_clock_in','userid','type','maxAttendanceInDay','date'));
    }

    public function update(Request $request, $id)
    {
    	Laralum::permissionToAccess('laralum.attendance.create');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $attendance = Attendance::findOrFail($id);
        $date = Carbon::parse($request->attendance_date)->format('Y-m-d');
        $clockIn = Carbon::createFromFormat("Y-m-d"." "."h:i a", $date.' '.$request->clock_in_time, "Asia/Kolkata");
        //$clockIn->setTimezone('UTC');
        if ($request->clock_out_time != '') {
            $clockOut = Carbon::createFromFormat("Y-m-d"." "."h:i a", $date.' '.$request->clock_out_time, "Asia/Kolkata");
            //$clockOut->setTimezone('UTC');

            if ($clockIn->gt($clockOut) && !is_null($clockOut)) {
                return Reply::error('Clock-out time cannot be less than clock in time');
            }

            $clockIn = $clockIn->toDateTimeString();
            $clockOut = $clockOut->toDateTimeString();

        } else {
            $clockOut = null;
        }
        $attendance->client_id = $client_id;
        $attendance->user_id = $request->user_id;
        $attendance->clock_in_time = $clockIn;
        $attendance->clock_in_ip = $request->clock_in_ip;
        $attendance->clock_out_time = $clockOut;
        $attendance->clock_out_ip = $request->clock_out_ip;
        $attendance->working_from = $request->working_from;
        $attendance->late = ($request->has('late')) ? 'yes' : 'no';
        $attendance->half_day = ($request->has('half_day')) ? 'yes' : 'no';
        $attendance->save();

        return Reply::success('Attendance Saved Successfully.');
    }


    public function storeMark(StoreAttendance $request)
    {
    	Laralum::permissionToAccess('laralum.attendance.create');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $date = Carbon::parse($request->attendance_date)->format('Y-m-d');
        $clockIn = Carbon::createFromFormat("Y-m-d"." "."h:i a", $date.' '.$request->clock_in_time, "Asia/Kolkata");
        //$clockIn->setTimezone('UTC');
        if ($request->clock_out_time != '') {
            $clockOut = Carbon::createFromFormat("Y-m-d"." "."h:i a", $date.' '.$request->clock_out_time, "Asia/Kolkata");
            //$clockOut->setTimezone('UTC');

            if ($clockIn->gt($clockOut) && !is_null($clockOut)) {
                return Reply::error('Maximum check-ins reached.');
            }

            $clockIn = $clockIn->toDateTimeString();
            $clockOut = $clockOut->toDateTimeString();
    
        } else {
            $clockOut = null;
        }
        
        $attendance = Attendance::where('user_id', $request->user_id)
            ->where(DB::raw('DATE(`clock_in_time`)'), "$date")
            ->whereNull('clock_out_time')
            ->first();

        $clockInCount = Attendance::getTotalUserClockIn($date, $request->user_id);

        if (!is_null($attendance)) {
            $attendance->update([
            	'client_id' => $client_id,
                'user_id' => $request->user_id,
                'clock_in_time' => $clockIn,
                'clock_in_ip' => $request->clock_in_ip,
                'clock_out_time' => $clockOut,
                'clock_out_ip' => $request->clock_out_ip,
                'working_from' => $request->working_from,
                'late' => ($request->has('late')) ? 'yes' : 'no',
                'half_day' => ($request->has('half_day')) ? 'yes' : 'no'
            ]);
        } else {

            // Check maximum attendance in a day
            if ($clockInCount < $this->attendanceSettings->clockin_in_day) {
                Attendance::create([
                	'client_id' => $client_id,
                    'user_id' => $request->user_id,
                    'clock_in_time' => $clockIn,
                    'clock_in_ip' => $request->clock_in_ip,
                    'clock_out_time' => $clockOut,
                    'clock_out_ip' => $request->clock_out_ip,
                    'working_from' => $request->working_from,
                    'late' => ($request->has('late')) ? 'yes' : 'no',
                    'half_day' => ($request->has('half_day')) ? 'yes' : 'no'
                ]);
            } else {
                return Reply::error('Maximum check-ins reached.');
            }
        }

        return Reply::success('Attendance Saved Successfully.');
    }


    public function detail($id)
    {
    	Laralum::permissionToAccess('laralum.attendance.view');
        // $attendanceSetting = AttendanceSetting::first();
        $attendance = Attendance::findOrFail($id);
        $this->attendanceActivity = Attendance::userAttendanceByDate($attendance->clock_in_time->format('Y-m-d'), $attendance->clock_in_time->format('Y-m-d'), $attendance->user_id);
        $this->firstClockIn = Attendance::where(DB::raw('DATE(attendances.clock_in_time)'), $attendance->clock_in_time->format('Y-m-d'))
            ->where('user_id', $attendance->user_id)->orderBy('id', 'asc')->first();
        $this->lastClockOut = Attendance::where(DB::raw('DATE(attendances.clock_in_time)'), $attendance->clock_in_time->format('Y-m-d'))
            ->where('user_id', $attendance->user_id)->orderBy('id', 'desc')->first();

        $this->startTime = Carbon::parse($this->firstClockIn->clock_in_time)->timezone("Asia/Kolkata");
        $this->notClockedOut = "";
        if (!is_null($this->lastClockOut->clock_out_time)) {
            $this->endTime = Carbon::parse($this->lastClockOut->clock_out_time)->timezone("Asia/Kolkata");
        } elseif (($this->lastClockOut->clock_in_time->timezone("Asia/Kolkata")->format('Y-m-d') != Carbon::now()->timezone("Asia/Kolkata")->format('Y-m-d')) && is_null($this->lastClockOut->clock_out_time)) {
            $this->endTime = Carbon::parse($this->startTime->format('Y-m-d') . ' ' . $this->attendanceSettings->office_end_time, "Asia/Kolkata");
            $this->notClockedOut = true;
        } else {
            $settingEndTime = Carbon::createFromFormat('H:i:s', $this->attendanceSettings->office_end_time, "Asia/Kolkata");
            if ($settingEndTime->greaterThan(Carbon::now()->timezone("Asia/Kolkata"))) {
                $this->endTime = Carbon::now()->timezone("Asia/Kolkata");
            } else {
                $this->endTime = $settingEndTime;
            }
            $this->notClockedOut = true;
        }

        $this->totalTime = $this->endTime->timezone("Asia/Kolkata")->diff($this->startTime, true)->format('%h.%i');

        $this->attendance = $attendance;


        return view('hyper.attendance.attendance_info', ['attendance'=>$this->attendance,'totalTime'=>$this->totalTime,'notClockedOut'=>$this->notClockedOut,'endTime'=>$this->endTime,'startTime'=>$this->startTime,'lastClockOut'=>$this->lastClockOut,'firstClockIn'=>$this->firstClockIn,'attendanceActivity'=>$this->attendanceActivity]);
    }

    public function edit($id)
    {
    	Laralum::permissionToAccess('laralum.attendance.edit');
        $attendance = Attendance::find($id);
        $this->date = $attendance->clock_in_time->format('Y-m-d');
        $this->row =  $attendance;
        $this->clock_in = 1;
        $this->userid = $attendance->user_id;
        $this->total_clock_in  = Attendance::where('user_id', $attendance->user_id)
            ->where(DB::raw('DATE(attendances.clock_in_time)'), '=', $this->date)
            ->whereNull('attendances.clock_out_time')->count();
        $this->type = 'edit';
        //$maxAttendanceInDay = $this->maxAttendanceInDay;
        return view('hyper.attendance.attendance_mark', ['date'=>$this->date,'row'=>$this->row,'clock_in'=>$this->clock_in,'userid'=>$this->userid,'total_clock_in'=>$this->total_clock_in,'type'=>$this->type,'maxAttendanceInDay'=>$this->maxAttendanceInDay]);
    }
///===========================employee=================================////
    public function staff_attendace()
    {
    	Laralum::permissionToAccess('laralum.attendance.list');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}

        $openDays = json_decode($this->attendanceSettings->office_open_days);
        $this->startDate = Carbon::now()->timezone('Asia/Kolkata')->startOfMonth();
        $this->endDate = Carbon::now()->timezone('Asia/Kolkata');
        $this->employees = User::allEmployees();

        //$this->userId = $this->user->id;


        //dd($client_id);
        $this->totalWorkingDays = $this->startDate->diffInDaysFiltered(function (Carbon $date) use ($openDays) {
            foreach ($openDays as $day) {
                if ($date->dayOfWeek == $day) {
                    return $date;
                }
            }
        }, $this->endDate);
        $this->daysPresent = Attendance::countDaysPresentByUser($this->startDate, $this->endDate, $client_id);
        $this->daysLate = Attendance::countDaysLateByUser($this->startDate, $this->endDate, $client_id);
        $this->halfDays = Attendance::countHalfDaysByUser($this->startDate, $this->endDate, $client_id);
        $this->holidays = Count(Holiday::getHolidayByDates($this->startDate->format('Y-m-d'), $this->endDate->format('Y-m-d')));
        $this->checkHoliday = Holiday::checkHolidayByDate(Carbon::now()->format('Y-m-d'));

        // Getting Current Clock-in if exist
        $this->currenntClockIn = Attendance::where(DB::raw('DATE(clock_in_time)'), Carbon::today()->format('Y-m-d'))
            ->where('user_id', $client_id)->whereNull('clock_out_time')->first();

        // Getting Today's Total Check-ins
        $this->todayTotalClockin = Attendance::where(DB::raw('DATE(clock_in_time)'), Carbon::today()->format('Y-m-d'))
            ->where('user_id', $client_id)->where(DB::raw('DATE(clock_out_time)'), Carbon::today()->format('Y-m-d'))->count();

        return view('hyper.attendance.employee.index', ['startDate'=>$this->startDate,'endDate'=>$this->endDate,'employees'=>$this->employees,'totalWorkingDays'=>$this->totalWorkingDays,'daysPresent'=>$this->daysPresent,'daysLate'=>$this->daysLate,'halfDays'=>$this->halfDays,'holidays'=>$this->holidays,'checkHoliday'=>$this->checkHoliday,'currenntClockIn'=>$this->currenntClockIn,'todayTotalClockin'=>$this->todayTotalClockin,'maxAttendanceInDay'=>$this->maxAttendanceInDay,'userId'=>$client_id]);
    }

    public function staff_attendance_create()
    {
    	Laralum::permissionToAccess('laralum.attendance.create');
        // if (!$this->user->can('add_attendance')) {
        //     abort(403);
        // }
        
        //return view('member.attendance.create', $this->data);
        return view('hyper.attendance.employee.create');
    }

    public function staff_store(Request $request)
    {
    	Laralum::permissionToAccess('laralum.attendance.create');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $now = Carbon::now();
        $clockInCount = Attendance::getTotalUserClockIn($now->format('Y-m-d'), $client_id);

        // Check user by ip
        if ($this->attendanceSettings->ip_check == 'yes') {
            $ips = (array) json_decode($this->attendanceSettings->ip_address);
            if (!in_array($request->ip(), $ips)) {
                return Reply::error('This is not an authorised device for clock-in or clock-out');
            }
        }

        // Check user by location
        if ($this->attendanceSettings->radius_check == 'yes') {
            $checkRadius  = $this->isWithinRadius($request);
            if (!$checkRadius) {
                return Reply::error('Your current location is not with in the clock-in range');
            }
        }

        // Check maximum attendance in a day
        if ($clockInCount < $this->attendanceSettings->clockin_in_day) {

            // Set TimeZone And Convert into timestamp
            //$currentTimestamp = $now->setTimezone('UTC');
            //$currentTimestamp = $currentTimestamp->timestamp;;

            // Set TimeZone And Convert into timestamp in halfday time
            if ($this->attendanceSettings->halfday_mark_time) {
                $halfDayTimestamp = $now->format('Y-m-d') . ' ' . $this->attendanceSettings->halfday_mark_time;
                $halfDayTimestamp = Carbon::createFromFormat('Y-m-d H:i:s', $halfDayTimestamp, 'Asia/Kolkata');
                //$halfDayTimestamp = $halfDayTimestamp->setTimezone('UTC');
                //$halfDayTimestamp = $halfDayTimestamp->timestamp;
            }


            $timestamp = $now->format('Y-m-d') . ' ' . $this->attendanceSettings->office_start_time;
            $officeStartTime = Carbon::createFromFormat('Y-m-d H:i:s', $timestamp, 'Asia/Kolkata');
            //$officeStartTime = $officeStartTime->setTimezone('UTC');


            $lateTime = $officeStartTime->addMinutes($this->attendanceSettings->late_mark_duration);

            $checkTodayAttendance = Attendance::where('user_id', $client_id)
                ->where(DB::raw('DATE(attendances.clock_in_time)'), '=', $now->format('Y-m-d'))->first();

            $attendance = new Attendance();
            $attendance->client_id = $client_id;
            $attendance->user_id = Laralum::loggedInUser()->id;
            $attendance->clock_in_time = $now;
            $attendance->clock_in_ip = request()->ip();

            if (is_null($request->working_from)) {
                $attendance->working_from = 'office';
            } else {
                $attendance->working_from = $request->working_from;
            }

            if ($now->gt($lateTime) && is_null($checkTodayAttendance)) {
                $attendance->late = 'yes';
            }

            $attendance->half_day = 'no'; // default halfday

            // Check day's first record and half day time
            if (!is_null($this->attendanceSettings->halfday_mark_time) && is_null($checkTodayAttendance) && $currentTimestamp > $halfDayTimestamp) {
                $attendance->half_day = 'yes';
            }

            $attendance->save();

            return Reply::successWithData('Attendance Saved Successfully.', ['time' => $now->format('h:i A'), 'ip' => $attendance->clock_in_ip, 'working_from' => $attendance->working_from]);
        }

        return Reply::error('Maximum check-ins reached.');
    }


    public function staff_edit($id)
    {
    	Laralum::permissionToAccess('laralum.attendance.create');
        // if (!$this->user->can('add_attendance')) {
        //     abort(403);
        // }
        $attendance = Attendance::find($id);

        $this->date = $attendance->clock_in_time->format('Y-m-d');
        $this->row =  $attendance;
        $this->clock_in = 1;
        $this->userid = $attendance->user_id;
        $this->total_clock_in  = Attendance::where('user_id', $attendance->user_id)
            ->where(DB::raw('DATE(attendances.clock_in_time)'), '=', $this->date)
            ->whereNull('attendances.clock_out_time')->count();
        $this->type = 'edit';
        return view('hyper.attendance.employee.attendance_mark', ['date'=>$this->date,'row'=>$this->row,'clock_in'=>$this->clock_in,'userid'=>$this->userid,'total_clock_in'=>$this->total_clock_in,'type'=>$this->type,'maxAttendanceInDay'=>$this->maxAttendanceInDay]);
    }

    public function staff_update(Request $request, $id)
    {
    	Laralum::permissionToAccess('laralum.attendance.create');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $now = Carbon::now();
        $attendance = Attendance::findOrFail($id);

        if ($this->attendanceSettings->ip_check == 'yes') {
            $ips = (array) json_decode($this->attendanceSettings->ip_address);
            if (!in_array($request->ip(), $ips)) {
                return Reply::error('This is not an authorised device for clock-in or clock-out');
            }
        }

        if ($this->attendanceSettings->radius_check == 'yes') {
            $checkRadius  = $this->isWithinRadius($request);
            if (!$checkRadius) {
                return Reply::error('Your current location is not with in the clock-in range');
            }
        }

        $attendance->client_id = $client_id;
        $attendance->clock_out_time = $now;
        $attendance->clock_out_ip = request()->ip();
        $attendance->save();

        return Reply::success('Attendance Saved Successfully.');
    }

    public function staff_destroy($id)
    {
    	Laralum::permissionToAccess('laralum.attendance.delete');
        Attendance::destroy($id);
        //return Reply::success(__('messages.attendanceDelete'));
        return response()->json(array(
			'status' => 'success',
		));
    }



    public function staff_refreshCount(Request $request, $startDate = null, $endDate = null, $userId = null)
    {
        $openDays = json_decode($this->attendanceSettings->office_open_days);
            $startDate = $request->startDate == null? $request->startDate : Carbon::createFromFormat("d-m-Y", $request->startDate);
            $endDate = $request->endDate == null? $request->endDate : Carbon::createFromFormat("d-m-Y", $request->endDate)->addDay(1);
            $userId = $request->userId;
            if(!is_null($startDate) || !is_null($endDate) ){
                $totalWorkingDays = $startDate->diffInDaysFiltered(function (Carbon $date) use ($openDays) {
                    foreach ($openDays as $day) {
                        if ($date->dayOfWeek == $day) {
                            return $date;
                        }
                    }
                }, $endDate);
            }else{
                $totalWorkingDays = 0;
            }
    
        $daysPresent = Attendance::countDaysPresentByUser($startDate, $endDate, $userId);
        $daysLate = Attendance::countDaysLateByUser($startDate, $endDate, $userId);
        $halfDays = Attendance::countHalfDaysByUser($startDate, $endDate, $userId);
        $daysAbsent = (($totalWorkingDays - $daysPresent) < 0) ? '0' : ($totalWorkingDays - $daysPresent);        
        $holidays = $startDate == null ? '0' : Count(Holiday::getHolidayByDates($startDate->format('Y-m-d'), $endDate->format('Y-m-d')));
        return Reply::dataOnly(['daysPresent' => $daysPresent, 'daysLate' => $daysLate, 'halfDays' => $halfDays, 'totalWorkingDays' => $totalWorkingDays , 'absentDays' => $daysAbsent, 'holidays' => $holidays]);
    }

    public function staff_employeeData(Request $request, $startDate = null, $endDate = null, $userId = null)
    {
        $startDate = $request->startDate == null? $request->startDate : Carbon::createFromFormat("d-m-Y", $request->startDate)->startOfDay();
        $endDate = $request->endDate == null? $request->endDate : Carbon::createFromFormat("d-m-Y", $request->endDate)->endOfDay()->addDay(1);
        $userId = $request->userId;

        $ant = [];
        $dateWiseData = [];

        $attendances = Attendance::userAttendanceByDate($startDate, $endDate, $userId); // Getting Attendance Data
        $holidays = Holiday::getHolidayByDates($startDate, $endDate); // Getting Holiday Data

        // Getting Leaves Data
        if(!is_null($startDate) || !is_null($endDate) ){
            $leavesDates = Leave::where('user_id', $userId)
                ->where('leave_date', '>=', $startDate)
                ->where('leave_date', '<=', $endDate)
                ->where('status', 'approved')
                ->select('leave_date', 'reason', 'duration')
                ->get()->keyBy('date')->toArray();
        }
        $holidayData = $holidays==null? $holidays:$holidays->keyBy('holiday_date');
        $holidayArray = $holidayData == null ? $holidayData : $holidayData->toArray();

        // Set Date as index for same date clock-ins

        if(!is_null($attendances)){
            foreach ($attendances as $attand) {
                $ant[$attand->clock_in_date][] = $attand;
            }
        }

        $endDate = $request->endDate == null? $request->endDate :Carbon::createFromFormat("d-m-Y", $request->endDate)->timezone('Asia/Kolkata');
        $startDate =$request->startDate == null? $request->startDate :  Carbon::createFromFormat("d-m-Y", $request->startDate)->timezone('Asia/Kolkata')->subDay();
       
        if($request->endDate || $request->startDate){
        // Set All Data in a single Array
        for ($date = $endDate; $date->diffInDays($startDate) > 0; $date->subDay()) {

            // Set default array for record
            $dateWiseData[$date->toDateString()] = [    
                'holiday' => false,
                'attendance' => false,
                'leave' => false
            ];

            // Set Holiday Data
            if (array_key_exists($date->toDateString(), $holidayArray)) {
                $dateWiseData[$date->toDateString()]['holiday'] = $holidayData[$date->toDateString()];
            }

            // Set Attendance Data
            if (array_key_exists($date->toDateString(), $ant)) {
                $dateWiseData[$date->toDateString()]['attendance'] = $ant[$date->toDateString()];
            }

            // Set Leave Data
            if (array_key_exists($date->toDateString(), $leavesDates)) {
                $dateWiseData[$date->toDateString()]['leave'] = $leavesDates[$date->toDateString()];
            }
        }
    }
        // Getting View data
        $view = view('hyper.attendance.employee.user_attendance', ['dateWiseData' => $dateWiseData])->render();

        return Reply::dataOnly(['status' => 'success', 'data' => $view]);
    }

    public function staff_data(Request $request)
    {

        $date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
        $attendances = Attendance::attendanceByDate($date);

        return DataTables::of($attendances)
            ->editColumn('id', function ($row) {
                return view('hyper.attendance.employee.attendance_list', ['row' => $row, 'maxAttendanceInDay' => $this->maxAttendanceInDay])->render();
            })
            ->rawColumns(['id'])
            ->removeColumn('name')
            ->removeColumn('clock_in_time')
            ->removeColumn('clock_out_time')
            //->removeColumn('image')
            ->removeColumn('attendance_id')
            ->removeColumn('working_from')
            ->removeColumn('late')
            ->removeColumn('half_day')
            ->removeColumn('clock_in_ip')
            //->removeColumn('designation_name')
            ->removeColumn('clock_in')
            ->removeColumn('total_clock_in')

            ->make(true);
    }


    public function staff_summary()
    {
    	Laralum::permissionToAccess('laralum.attendance.staffattendance');
        // if (!$this->user->can('view_attendance')) {
        //     abort(403);
        // }
        if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $this->employees = User::allEmployees(1);
        $now = Carbon::now();
        $this->year = $now->format('Y');
        $this->month = $now->format('m');
        $this->departments = DB::table('departments')
							->where('client_id', $client_id)
							->get();

        return view('hyper.attendance.employee.summary', ['employees'=>$this->employees,'year'=>$this->year,'month'=>$this->month,'departments'=>$this->departments]);
    }

    public function staff_summaryData(Request $request)
    {
    	Laralum::permissionToAccess('laralum.attendance.staffattendance');
        // if (!$this->user->can('view_attendance')) {
        //     abort(403);
        // }
        if (Laralum::loggedInUser()->reseller_id == 0) {
            $client_id = Laralum::loggedInUser()->id;
        } else {
            $client_id = Laralum::loggedInUser()->reseller_id;
        }
        $employees = User::with(
            ['attendance' => function ($query) use ($request,$client_id) {
                $query->where('attendances.client_id', $client_id)->whereRaw('MONTH(attendances.clock_in_time) = ?', [$request->month])
                    ->whereRaw('YEAR(attendances.clock_in_time) = ?', [$request->year]);
            }]
        )
        ->where('users.reseller_id', $client_id)
        ->where('users.id', '<>', 1)
        ->where('users.isReseller', '!=', 1)
        //->join('role_user', 'role_user.user_id', '=', 'users.id')
            //->join('roles', 'roles.id', '=', 'role_user.role_id')
            //->leftJoin('employee_details', 'employee_details.user_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.email', 'users.created_at')
            //->where('roles.name', '<>', 'client')
            ->groupBy('users.id');

        if ($request->department != 'all') {
            $employees = $employees->where('users.department', $request->department);
        }

        if ($request->userId != '0') {
            $employees = $employees->where('users.id', $request->userId);
        }

        $employees = $employees->get();

        $this->holidays = Holiday::whereRaw('MONTH(holidays.date) = ?', [$request->month])->whereRaw('YEAR(holidays.date) = ?', [$request->year])->get();

        $final = [];

        $this->daysInMonth = Carbon::parse('01-' . $request->month . '-' . $request->year)->daysInMonth;
        $now = Carbon::now()->timezone('Asia/Kolkata');
        $requestedDate = Carbon::parse(Carbon::parse('01-' . $request->month . '-' . $request->year))->endOfMonth();

        foreach ($employees as $employee) {


            $dataTillToday = array_fill(1, $now->copy()->format('d'), 'Absent');

            $dataFromTomorrow = [];
            if (($now->copy()->addDay()->format('d') != $this->daysInMonth) && !$requestedDate->isPast()) {
                $dataFromTomorrow = array_fill($now->copy()->addDay()->format('d'), ($this->daysInMonth - $now->copy()->format('d')), '-');
            } else {
                $dataFromTomorrow = array_fill($now->copy()->addDay()->format('d'), ($this->daysInMonth - $now->copy()->format('d')), 'Absent');
            }
            $final[$employee->id . '#' . $employee->name] = array_replace($dataTillToday, $dataFromTomorrow);

            foreach ($employee->attendance as $attendance) {
                $final[$employee->id . '#' . $employee->name][Carbon::parse($attendance->clock_in_time)->timezone('Asia/Kolkata')->day] = '<a href="javascript:;" class="view-attendance" data-attendance-id="' . $attendance->id . '"><i class="fa fa-check text-success"></i></a>';
            }
            $image = '';
            //$image = '<img src="' . $employee->image_url . '"alt="user" class="img-circle" width="30" height="30"> ';

            $emplolyeeName = '<div class="row"><div class="col-xs-4"></div><div class="col-xs-8"><a href="' . route('Crm::staff_details', $employee->id) . '">' . ucwords($employee->name) . '</a></div></div>';
            
            $final[$employee->id . '#' . $employee->name][] = $emplolyeeName;

            foreach ($this->holidays as $holiday) {
                if ($final[$employee->id . '#' . $employee->name][$holiday->date->day] == 'Absent') {
                    $final[$employee->id . '#' . $employee->name][$holiday->date->day] = 'Holiday';
                }
            }
        }
        //
        $this->employeeAttendence = $final;

        $view = view('hyper.attendance.employee.summary_data', ['employeeAttendence' => $this->employeeAttendence,'holidays' => $this->holidays,'daysInMonth' => $this->daysInMonth])->render();
        return Reply::dataOnly(['status' => 'success', 'data' => $view]);
    }

    public function staff_detail($id)
    {
    	Laralum::permissionToAccess('laralum.attendance.view');
        $attendance = Attendance::find($id);
        $this->attendanceActivity = Attendance::userAttendanceByDate($attendance->clock_in_time->format('Y-m-d'), $attendance->clock_in_time->format('Y-m-d'), $attendance->user_id);
        $this->firstClockIn = Attendance::where(DB::raw('DATE(attendances.clock_in_time)'), $attendance->clock_in_time->format('Y-m-d'))
            ->where('user_id', $attendance->user_id)->orderBy('id', 'asc')->first();
        $this->lastClockOut = Attendance::where(DB::raw('DATE(attendances.clock_in_time)'), $attendance->clock_in_time->format('Y-m-d'))
            ->where('user_id', $attendance->user_id)->orderBy('id', 'desc')->first();

        $this->startTime = Carbon::parse($this->firstClockIn->clock_in_time)->timezone("Asia/Kolkata");
        $this->notClockedOut = "";
        if (!is_null($this->lastClockOut->clock_out_time)) {
            $this->endTime = Carbon::parse($this->lastClockOut->clock_out_time)->timezone("Asia/Kolkata");
        } elseif (($this->lastClockOut->clock_in_time->timezone("Asia/Kolkata")->format('Y-m-d') != Carbon::now()->timezone("Asia/Kolkata")->format('Y-m-d')) && is_null($this->lastClockOut->clock_out_time)) {
            $this->endTime = Carbon::parse($this->startTime->format('Y-m-d') . ' ' . $this->attendanceSettings->office_end_time, "Asia/Kolkata");
            $this->notClockedOut = true;
        } else {
            $this->notClockedOut = true;
            $this->endTime = Carbon::now()->timezone("Asia/Kolkata");
        }

        $this->totalTime = $this->endTime->diff($this->startTime, true)->format('%h.%i');

        $this->attendance = $attendance;


        return view('hyper.attendance.employee.attendance_info', ['attendance'=>$this->attendance,'totalTime'=>$this->totalTime,'endTime'=>$this->endTime,'notClockedOut'=>$this->notClockedOut,'startTime'=>$this->startTime,'lastClockOut'=>$this->lastClockOut,'firstClockIn'=>$this->firstClockIn,'attendanceActivity'=>$this->attendanceActivity]);
    }


    public function staff_updateDetails(Request $request, $id)
    {
    	Laralum::permissionToAccess('laralum.attendance.create');
        // if (!$this->user->can('add_attendance')) {
        //     abort(403);
        // }
        if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $attendance = Attendance::findOrFail($id);
        $date = Carbon::parse($request->attendance_date)->format('Y-m-d');
        $clockIn = Carbon::createFromFormat('Y-m-d '.' '.'h:i a', $date.' '.$request->clock_in_time, "Asia/Kolkata");
        //$clockIn->setTimezone('UTC');
        if ($request->clock_out_time != '') {
            $clockOut = Carbon::createFromFormat('Y-m-d '.' '.'h:i a', $date.' '.$request->clock_out_time, "Asia/Kolkata");
            //$clockOut->setTimezone('UTC');

            if ($clockIn->gt($clockOut) && !is_null($clockOut)) {
                return Reply::error('Clock-out time cannot be less than clock in time');
            }

            $clockIn = $clockIn->toDateTimeString();
            $clockOut = $clockOut->toDateTimeString();
    
        } else {
            $clockOut = null;
        }
        $attendance->client_id = $client_id;
        $attendance->user_id = $request->user_id;
        $attendance->clock_in_time = $clockIn;
        $attendance->clock_in_ip = $request->clock_in_ip;
        $attendance->clock_out_time = $clockOut;
        $attendance->clock_out_ip = $request->clock_out_ip;
        $attendance->working_from = $request->working_from;
        $attendance->late = ($request->has('late')) ? 'yes' : 'no';
        $attendance->half_day = ($request->has('half_day')) ? 'yes' : 'no';
        $attendance->save();

        return Reply::success('Attendance Saved Successfully.');
    }

    public function staff_mark(Request $request, $userid, $day, $month, $year)
    {
    	Laralum::permissionToAccess('laralum.attendance.create');
        // if (!$this->user->can('add_attendance')) {
        //     abort(403);
        // }

        $this->date = Carbon::createFromFormat('d-m-Y', $day . '-' . $month . '-' . $year)->format('Y-m-d');
        $this->row = Attendance::attendanceByUserDate($userid, $this->date);
        $this->clock_in = 0;
        $this->total_clock_in = Attendance::where('user_id', $userid)
            ->where(DB::raw('DATE(attendances.clock_in_time)'), '=', $this->date)
            ->whereNull('attendances.clock_out_time')->count();

        $this->userid = $userid;
        $this->type = 'add';
        return view('hyper.attendance.employee.attendance_mark', ['date'=>$this->date,'row'=>$this->row,'clock_in'=>$this->clock_in,'total_clock_in'=>$this->total_clock_in,'userid'=>$this->userid,'type'=>$this->type,'maxAttendanceInDay'=>$this->maxAttendanceInDay]);
    }

    public function staff_storeMark(StoreAttendance $request)
    {
    	Laralum::permissionToAccess('laralum.attendance.create');
        // if (!$this->user->can('add_attendance')) {
        //     abort(403);
        // }
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $date = Carbon::parse($request->attendance_date)->format('Y-m-d');
        $clockIn = Carbon::createFromFormat('Y-m-d '.' '.'h:i a', $date.' '.$request->clock_in_time, "Asia/Kolkata");
        //$clockIn->setTimezone('UTC');
        if ($request->clock_out_time != '') {
            $clockOut = Carbon::createFromFormat('Y-m-d '.' '.'h:i a', $date.' '.$request->clock_out_time, "Asia/Kolkata");
            //$clockOut->setTimezone('UTC');

            if ($clockIn->gt($clockOut) && !is_null($clockOut)) {
                return Reply::error('Clock-out time cannot be less than clock in time');
            }

            $clockIn = $clockIn->toDateTimeString();
            $clockOut = $clockOut->toDateTimeString();    
    
        } else {
            $clockOut = null;
        }

        $attendance = Attendance::where('user_id', $request->user_id)
            ->where(DB::raw('DATE(`clock_in_time`)'), "$date")
            ->whereNull('clock_out_time')
            ->first();

        $clockInCount = Attendance::getTotalUserClockIn($date, $request->user_id);

        if (!is_null($attendance)) {
            $attendance->update([
            	'client_id' => $client_id,
                'user_id' => $request->user_id,
                'clock_in_time' => $clockIn,
                'clock_in_ip' => $request->clock_in_ip,
                'clock_out_time' => $clockOut,
                'clock_out_ip' => $request->clock_out_ip,
                'working_from' => $request->working_from,
                'late' => ($request->has('late')) ? 'yes' : 'no',
                'half_day' => ($request->has('half_day')) ? 'yes' : 'no'
            ]);
        } else {

            // Check maximum attendance in a day
            if ($clockInCount < $this->attendanceSettings->clockin_in_day) {
                Attendance::create([
                	'client_id' => $client_id,
                    'user_id' => $request->user_id,
                    'clock_in_time' => $clockIn,
                    'clock_in_ip' => $request->clock_in_ip,
                    'clock_out_time' => $clockOut,
                    'clock_out_ip' => $request->clock_out_ip,
                    'working_from' => $request->working_from,
                    'late' => ($request->has('late')) ? 'yes' : 'no',
                    'half_day' => ($request->has('half_day')) ? 'yes' : 'no'
                ]);
            } else {
                return Reply::error('Maximum check-ins reached.');
            }
        }

        return Reply::success('Attendance Saved Successfully.');
    }



    public function staff_checkHoliday(Request $request)
    {
        $date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
        $checkHoliday = Holiday::checkHolidayByDate($date);
        return Reply::dataOnly(['status' => 'success', 'holiday' => $checkHoliday]);
    }

    // Attendance Detail Show
    public function staff_attendanceDetail(Request $request)
    {
    	Laralum::permissionToAccess('laralum.attendance.view');
        // Getting Attendance Data By User And Date
        $this->attendances =  Attendance::attendanceByUserAndDate($request->date, $request->userID);
        return view('hyper.attendance.employee.attendance-detail', ['attendances'=>$this->attendances])->render();
    }

    public function staff_storeAttendance(StoreAttendance $request)
    {
    	Laralum::permissionToAccess('laralum.attendance.create');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
        $clockIn = Carbon::createFromFormat('Y-m-d '.' '.'h:i a', $date.' '.$request->clock_in_time, 'Asia/Kolkata');
        //$clockIn->setTimezone('UTC');
        if ($request->clock_out_time != '') {
            $clockOut = Carbon::createFromFormat('Y-m-d '.' '.'h:i a', $date.' '.$request->clock_out_time, 'Asia/Kolkata');
            //$clockOut->setTimezone('UTC');

            if ($clockIn->gt($clockOut) && !is_null($clockOut)) {
                return Reply::error('Clock-out time cannot be less than clock in time');
            }

            $clockIn = $clockIn->toDateTimeString();
            $clockOut = $clockOut->toDateTimeString();    

        } else {
            $clockOut = null;
        }

        $clockInCount = Attendance::getTotalUserClockIn($date, $request->user_id);

        $attendance = Attendance::where('user_id', $request->user_id)
            ->where(DB::raw('DATE(`clock_in_time`)'), $date)
            ->whereNull('clock_out_time')
            ->first();

        if (!is_null($attendance)) {
            $attendance->update([
            	'client_id' => $client_id,
                'user_id' => $request->user_id,
                'clock_in_time' => $clockIn,
                'clock_in_ip' => $request->clock_in_ip,
                'clock_out_time' => $clockOut,
                'clock_out_ip' => $request->clock_out_ip,
                'working_from' => $request->working_from,
                'late' => $request->late,
                'half_day' => $request->half_day
            ]);
        } else {

            // Check maximum attendance in a day
            if ($clockInCount < $this->attendanceSettings->clockin_in_day) {
                Attendance::create([
                	'client_id' => $client_id,
                    'user_id' => $request->user_id,
                    'clock_in_time' => $clockIn,
                    'clock_in_ip' => $request->clock_in_ip,
                    'clock_out_time' => $clockOut,
                    'clock_out_ip' => $request->clock_out_ip,
                    'working_from' => $request->working_from,
                    'late' => $request->late,
                    'half_day' => $request->half_day
                ]);
            } else {
                return Reply::error('Maximum check-ins reached.');
            }
        }

        return Reply::success('Attendance Saved Successfully.');
    }








    
}
