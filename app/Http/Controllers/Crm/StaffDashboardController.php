<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;
use App\Http\Controllers\Laralum\Laralum;
use Illuminate\Support\Facades\DB;
use App\User;
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
//use App\Http\Requests\Attendance\StoreAttendance;
use App\Helper\Reply;

use App\Http\Requests\Leaves\StoreLeave;
use App\Http\Requests\Leaves\UpdateLeave;
use App\LeaveType;


use App\DashboardWidget;
//use App\Notifications\LeaveStatusApprove;
//use App\Notifications\LeaveStatusReject;
//use App\Notifications\LeaveStatusUpdate;

/*use App\Attendance;
use App\ClientDetails;
use App\Contract;
use App\ContractSign;
use App\DashboardWidget;
use App\DataTables\Admin\EstimatesDataTable;
use App\DataTables\Admin\ExpensesDataTable;
use App\DataTables\Admin\InvoicesDataTable;
use App\DataTables\Admin\PaymentsDataTable;
use App\DataTables\Admin\ProposalDataTable;
use App\Designation;
use App\EmployeeDetails;
use App\Estimate;
use App\Expense;
use App\Helper\Reply;
use App\Invoice;
use App\InvoiceItems;
use App\Lead;
use App\LeadFollowUp;
use App\LeadSource;
use App\LeadStatus;
use App\Leave;
use App\Payment;
use App\Project;
use App\ProjectActivity;
use App\ProjectMilestone;
use App\ProjectTimeLog;
use App\Proposal;
use App\Setting;
use App\Task;
use App\TaskboardColumn;
use App\Team;
use App\Ticket;
use App\Traits\CurrencyExchange;
use App\User;
use App\UserActivity;
use Carbon\Carbon;
use Exception;
use Froiden\Envato\Traits\AppBoot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;*/

class StaffDashboardController extends Controller
{
	public function __construct()
    {      
        //parent::__construct();

        // Getting Attendance setting data
        $this->attendanceSettings = AttendanceSetting::first();

        //Getting Maximum Check-ins in a day
        $this->maxAttendanceInDay = $this->attendanceSettings->clockin_in_day;
    }   

    public function index(Request $request)
    {
        if (Laralum::loggedInUser()->reseller_id == 0) {
         $client_id = Laralum::loggedInUser()->id;
        } else {
         $client_id = Laralum::loggedInUser()->reseller_id;
        }
        $this->pageTitle = 'app.hrDashboard';
        $this->fromDate = Carbon::now()->timezone('Asia/Kolkata')->subDays(30)->toDateString();
        $this->toDate = Carbon::now()->timezone('Asia/Kolkata')->toDateString();

        $this->widgets = DashboardWidget::where('dashboard_type', 'admin-hr-dashboard')->where('client_id', $client_id)->get();
        $this->activeWidgets = DashboardWidget::where('dashboard_type', 'admin-hr-dashboard')->where('status', 1)->where('client_id', $client_id)->get()->pluck('widget_name')->toArray();

        if (request()->ajax()) {
            if (!is_null($request->startDate) && $request->startDate != "null" && !is_null($request->endDate) && $request->endDate != "null") {
                $this->fromDate = Carbon::createFromFormat('d-m-Y', $request->startDate)->toDateString();
                $this->toDate = Carbon::createFromFormat('d-m-Y', $request->endDate)->toDateString();
            }

            $this->totalLeavesApproved = Leave::whereBetween(DB::raw('DATE(`updated_at`)'), [$this->fromDate, $this->toDate])->where('status', 'approved')->where('client_id', $client_id)->get()->count();
            //$this->totalNewEmployee = EmployeeDetails::whereBetween(DB::raw('DATE(`joining_date`)'), [$this->fromDate, $this->toDate])->get()->count();
            $this->totalNewEmployee = DB::table('users')
                                      ->leftJoin('user_details', 'users.id', '=', 'user_details.user_id') 
                                      ->whereBetween('user_details.created_at', [$this->fromDate, $this->toDate])
                                      ->where('users.reseller_id', $client_id)
                                      ->get()->count();

            //$this->totalEmployeeExits = EmployeeDetails::whereBetween(DB::raw('DATE(`last_date`)'), [$this->fromDate, $this->toDate])->get()->count();
            $this->totalEmployeeExits = DB::table('users')
                                      ->leftJoin('user_details', 'users.id', '=', 'user_details.user_id') 
                                      ->whereBetween('user_details.created_at', [$this->fromDate, $this->toDate])
                                      ->where('users.reseller_id', $client_id)
                                      ->get()->count();
            


            //$this->departmentWiseEmployee = Team::join('employee_details', 'employee_details.department_id', 'teams.id')
               // ->whereBetween(DB::raw('DATE(employee_details.`created_at`)'), [$this->fromDate, $this->toDate])
               // ->select(DB::raw('count(employee_details.id) as totalEmployee'), 'teams.team_name')
                //->groupBy('teams.team_name')
               // ->get()->toJson();
            $this->departmentWiseEmployee = DB::table('departments')
                                            ->leftJoin('users', 'users.department', '=', 'departments.id')
                                            ->whereBetween(DB::raw('DATE(users.`created_at`)'), [$this->fromDate, $this->toDate])
                                            ->where('departments.client_id', $client_id)
                                            ->where('users.reseller_id', $client_id)
                                           ->select(DB::raw('count(users.id) as totalEmployee'), 'departments.department')
                                            ->groupBy('departments.department')
                                           ->get()->toJson();

            // $this->designationWiseEmployee = Designation::join('employee_details', 'employee_details.designation_id', 'designations.id')
            //     ->whereBetween(DB::raw('DATE(employee_details.`created_at`)'), [$this->fromDate, $this->toDate])
            //     ->select(DB::raw('count(employee_details.id) as totalEmployee'), 'designations.name')
            //     ->groupBy('designations.name')
            //     ->get()->toJson();
            $this->designationWiseEmployee = DB::table('designation')
                                            ->leftJoin('user_details', 'designation.designation', '=', 'user_details.work_title')
                                            ->whereBetween(DB::raw('DATE(user_details.`created_at`)'), [$this->fromDate, $this->toDate])
                                            ->where('designation.client_id', $client_id)
                                           ->select(DB::raw('count(user_details.user_id) as totalEmployee'), 'designation.designation')
                                            ->groupBy('designation.designation')
                                           ->get()->toJson();
            

            // $this->genderWiseEmployee = EmployeeDetails::whereBetween(DB::raw('DATE(employee_details.`created_at`)'), [$this->fromDate, $this->toDate])
            //     ->join('users', 'users.id', 'employee_details.user_id')
            //     ->select(DB::raw('count(employee_details.id) as totalEmployee'), 'users.gender')
            //     ->groupBy('users.gender')
            //     ->orderBy('users.gender', 'ASC')
            //     ->get()->toJson();

            $this->genderWiseEmployee = DB::table('users')
                                      ->join('user_details', 'users.id', '=', 'user_details.user_id') 
                                      ->whereBetween(DB::raw('DATE(user_details.`created_at`)'), [$this->fromDate, $this->toDate])
                                      ->where('users.reseller_id', $client_id)
                                      ->select(DB::raw('count(users.id) as totalEmployee'), 'user_details.gender')
                                      ->groupBy('user_details.gender')
                                      ->orderBy('user_details.gender', 'ASC')
                                      ->get()->toJson();   

            // $this->roleWiseEmployee = EmployeeDetails::whereBetween(DB::raw('DATE(employee_details.`created_at`)'), [$this->fromDate, $this->toDate])
            //     ->Join('users', 'users.id', 'employee_details.user_id')
            //     ->join('role_user', 'role_user.user_id', '=', 'users.id')
            //     ->join('roles', 'roles.id', '=', 'role_user.role_id')
            //     ->where('roles.name', '<>', 'client')
            //     ->select(DB::raw('count(employee_details.id) as totalEmployee'), 'roles.name')
            //     ->groupBy('roles.name')
            //     ->orderBy('roles.name', 'ASC')
            //     ->get()->toJson();

            // $attandance = EmployeeDetails::join('users', 'users.id', 'employee_details.user_id')
            //     ->join('attendances', 'attendances.user_id', 'users.id')
            //     ->whereBetween(DB::raw('DATE(attendances.`clock_in_time`)'), [$this->fromDate, $this->toDate])
            //     ->select(DB::raw('count(users.id) as employeeCount'), DB::raw('DATE(attendances.clock_in_time) as date'))
            //     ->groupBy('date')
            //     ->get();
            $attandance = User::join('user_details', 'users.id', '=', 'user_details.user_id') 
                ->join('attendances', 'attendances.user_id', 'users.id')
                ->whereBetween(DB::raw('DATE(attendances.`clock_in_time`)'), [$this->fromDate, $this->toDate])
                ->where('users.reseller_id', $client_id)
                ->select(DB::raw('count(users.id) as employeeCount'), DB::raw('DATE(attendances.clock_in_time) as date'))
                ->groupBy('date')
                ->get();                          

            try {
                $this->averageAttendance = number_format(((array_sum(array_column($attandance->toArray(), 'employeeCount')) / $attandance->count()) * 100) / User::allEmployees()->count(), 2) . '%';
            } catch (Exception $e) {
                $this->averageAttendance = '0%';
            }

            $this->leavesTakens = User::join('user_details', 'users.id', '=', 'user_details.user_id') 
                ->join('leaves', 'leaves.user_id', 'users.id')
                ->whereBetween(DB::raw('DATE(leaves.`leave_date`)'), [$this->fromDate, $this->toDate])
                ->where('leaves.status', 'approved')
                ->where('users.reseller_id', $client_id)
                ->where('leaves.client_id', $client_id)
                ->select(DB::raw('count(leaves.id) as employeeLeaveCount'), 'users.name', 'users.id')
                ->groupBy('users.id')
                ->orderBy('employeeLeaveCount', 'DESC')
                ->get();

            $this->lateAttendanceMarks = User::join('user_details', 'users.id', '=', 'user_details.user_id') 
                ->join('attendances', 'attendances.user_id', 'users.id')
                ->whereBetween(DB::raw('DATE(attendances.`clock_in_time`)'), [$this->fromDate, $this->toDate])
                ->where('late', 'yes')
                ->where('users.reseller_id', $client_id)
                ->where('attendances.client_id', $client_id)
                ->select(DB::raw('count(attendances.id) as employeeLateCount'), 'users.id', 'users.name')
                ->groupBy('users.id')
                ->orderBy('employeeLateCount', 'DESC')
                ->get();

             //dd($this->genderWiseEmployee);

            $view = view('hyper.staff.hr-dashboard', ['fromDate'=>$this->fromDate,'toDate'=>$this->toDate,'widgets'=>$this->widgets,'activeWidgets'=>$this->activeWidgets,'totalLeavesApproved'=>$this->totalLeavesApproved,'totalNewEmployee'=> $this->totalNewEmployee,'totalEmployeeExits'=>$this->totalEmployeeExits,'departmentWiseEmployee'=>$this->departmentWiseEmployee,'designationWiseEmployee'=>$this->designationWiseEmployee,'genderWiseEmployee'=>$this->genderWiseEmployee,'averageAttendance'=>$this->averageAttendance,'leavesTakens'=>$this->leavesTakens,'lateAttendanceMarks'=>$this->lateAttendanceMarks])->render();
            return Reply::dataOnly(['view' => $view]);
        }

        return view('hyper.staff.dashboard', ['fromDate'=>$this->fromDate,'toDate'=>$this->toDate,'widgets'=>$this->widgets,'activeWidgets'=>$this->activeWidgets]);
    }

    public function widget(Request $request, $dashboardType)
    {
        $data = $request->all();
        unset($data['_token']);
        DashboardWidget::where('status', 1)->where('dashboard_type', $dashboardType)->update(['status' => 0]);

        foreach ($data as $key => $widget) {
            DashboardWidget::where('widget_name', $key)->where('dashboard_type', $dashboardType)->update(['status' => 1]);
        }

        return Reply::success(__('messages.updatedSuccessfully'));
    }

  //   public function index()
  //   {
  //   	Laralum::permissionToAccess('laralum.leave.list');
  //   	//Laralum::permissionToAccess('laralum.leave.list');
  //   	if (Laralum::loggedInUser()->reseller_id == 0) {
		// 	$client_id = Laralum::loggedInUser()->id;
		// } else {
		// 	$client_id = Laralum::loggedInUser()->reseller_id;
		// }
  //       //$this->languageSettings = language_setting();
  //       //$this->timer = ProjectTimeLog::memberActiveTimer($this->user->id);
  //       //$completedTaskColumn = TaskboardColumn::completeColumn();

  //       //$this->totalProjects = Project::select('projects.id')
  //           //->join('project_members', 'project_members.project_id', '=', 'projects.id');

  //       // if (!$this->user->can('view_projects')) {
  //       //     $this->totalProjects = $this->totalProjects->where('project_members.user_id', '=', $this->user->id);
  //       // }

  //       //$this->totalProjects =  $this->totalProjects->groupBy('projects.id');
  //       //$this->totalProjects = count($this->totalProjects->get());
  //       // $this->counts = DB::table('users')
  //       //     ->select(
  //       //         DB::raw('(select IFNULL(sum(project_time_logs.total_minutes),0) from `project_time_logs` where user_id = ' . $this->user->id . ') as totalHoursLogged '),
  //       //         DB::raw('(select count(tasks.id) from `tasks` inner join task_users on task_users.task_id=tasks.id where tasks.board_column_id=' . $completedTaskColumn->id . ' and task_users.user_id = ' . $this->user->id . ') as totalCompletedTasks'),
  //       //         DB::raw('(select count(tasks.id) from `tasks` inner join task_users on task_users.task_id=tasks.id where tasks.board_column_id!=' . $completedTaskColumn->id . ' and task_users.user_id = ' . $this->user->id . ') as totalPendingTasks')
  //       //     )
  //       //     ->first();

  //       // $timeLog = intdiv($this->counts->totalHoursLogged, 60) . ' hrs ';

  //       // if (($this->counts->totalHoursLogged % 60) > 0) {
  //       //     $timeLog .= ($this->counts->totalHoursLogged % 60) . ' mins';
  //       // }

  //       // $this->counts->totalHoursLogged = $timeLog;

  //       // $this->projectActivities = ProjectActivity::join('projects', 'projects.id', '=', 'project_activity.project_id')
  //       //     ->join('project_members', 'project_members.project_id', '=', 'projects.id');

  //       // if (!$this->user->can('view_projects')) {
  //       //     $this->projectActivities = $this->projectActivities->where('project_members.user_id', '=', $this->user->id);
  //       // }

  //       // $this->projectActivities = $this->projectActivities->whereNull('projects.deleted_at')
  //       //     ->select('projects.project_name', 'project_activity.created_at', 'project_activity.activity', 'project_activity.project_id')
  //       //     ->limit(15)->orderBy('project_activity.id', 'desc')->groupBy('project_activity.id')->get();

  //       // if ($this->user->can('view_notice')) {
  //       //     $this->notices = Notice::latest()->get();
  //       // }

  //       // $this->userActivities = UserActivity::with('user')->limit(15)->orderBy('id', 'desc');

  //       // if (!$this->user->can('view_employees')) {
  //       //     $this->userActivities = $this->userActivities->where('user_id', $this->user->id);
  //       // }

  //       // $this->userActivities = $this->userActivities->get();

  //       // $this->pendingTasks = Task::with('project')
  //       //     ->join('task_users', 'task_users.task_id', '=', 'tasks.id')
  //       //     ->where('tasks.board_column_id', '<>', $completedTaskColumn->id)
  //       //     ->where(DB::raw('DATE(due_date)'), '<=', Carbon::today()->format('Y-m-d'))
  //       //     ->where('task_users.user_id', $this->user->id)
  //       //     ->select('tasks.*')
  //       //     ->groupBy('tasks.id')
  //       //     ->limit(15)
  //       //     ->get();


  //       // Getting Current Clock-in if exist
  //       $this->currenntClockIn = Attendance::where(DB::raw('DATE(clock_in_time)'), Carbon::today()->format('Y-m-d'))
  //           ->where('user_id', Laralum::loggedInUser()->id)->whereNull('clock_out_time')->where('client_id', $client_id)->first();

  //       // Getting Today's Total Check-ins
  //       $this->todayTotalClockin = Attendance::where(DB::raw('DATE(clock_in_time)'), Carbon::today()->format('Y-m-d'))
  //       	->where('client_id', $client_id)
  //           ->where('user_id', Laralum::loggedInUser()->id)->where(DB::raw('DATE(clock_out_time)'), Carbon::today()->format('Y-m-d'))->count();

  //       $currentDate = Carbon::now()->format('Y-m-d');

  //       // Check Holiday by date
  //       $this->checkTodayHoliday = Holiday::where('date', $currentDate)->where('client_id', $client_id)->first();

  //       //check office time passed
  //       $officeEndTime = Carbon::createFromFormat('H:i:s', $this->attendanceSettings->office_end_time, 'Asia/Kolkata')->timestamp;
  //       $currentTime = Carbon::now()->timezone('Asia/Kolkata')->timestamp;
  //       if ($officeEndTime < $currentTime) {
  //           // $this->noClockIn = true;
  //       }

  //       // if ($this->user->can('view_timelogs') && in_array('timelogs', $this->user->modules)) {

  //       //     $this->activeTimerCount = ProjectTimeLog::with('user', 'project', 'task')
  //       //         ->whereNull('end_time')
  //       //         ->join('users', 'users.id', '=', 'project_time_logs.user_id');

  //       //     $this->activeTimerCount = $this->activeTimerCount
  //       //         ->select('project_time_logs.*', 'users.name')
  //       //         ->count();
  //       // } 

  //       //$this->languageSettings = language_setting(); 

  //       $this->leaves = Leave::where('status', '<>', 'rejected')->where('client_id', $client_id)->get();
  //       $this->pendingLeaves = Leave::where('status', 'pending')->where('client_id', $client_id)->orderBy('leave_date', 'asc')->get();

  //       return view('hyper.staff.dashboard', ['maxAttendanceInDay'=>$this->maxAttendanceInDay,'currenntClockIn'=>$this->currenntClockIn,'todayTotalClockin'=>$this->todayTotalClockin,'checkTodayHoliday'=>$this->checkTodayHoliday,'attendanceSettings'=>$this->attendanceSettings,'leaves'=>$this->leaves,'pendingLeaves'=>$this->pendingLeaves]);
  //   }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //public function staff_leaveCreate()
  //   {
  //   	Laralum::permissionToAccess('laralum.leave.create');
  //   	if (Laralum::loggedInUser()->reseller_id == 0) {
		// 	$client_id = Laralum::loggedInUser()->id;
		// } else {
		// 	$client_id = Laralum::loggedInUser()->reseller_id;
		// }
  //       // if (!$this->user->can('add_leave')) {
  //       //     abort(403);
  //       // }

  //       $this->employees = User::allEmployees();
  //       $this->leaveTypes = LeaveType::where('client_id', $client_id)->get();
  //       return view('hyper.leave-dashboard.create', ['employees'=>$this->employees,'leaveTypes'=>$this->leaveTypes]);
  //   }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  //   public function staff_leaveStore(StoreLeave $request)
  //   {
  //   	Laralum::permissionToAccess('laralum.leave.create');
  //       // if (!$this->user->can('add_leave')) {
  //       //     abort(403);
  //       // }
  //   	if (Laralum::loggedInUser()->reseller_id == 0) {
		// 	$client_id = Laralum::loggedInUser()->id;
		// } else {
		// 	$client_id = Laralum::loggedInUser()->reseller_id;
		// }
  //       if ($request->duration == 'multiple') {
  //           session(['leaves_duration' => 'multiple']);
  //           $dates = explode(',', $request->multi_date);
  //           foreach ($dates as $date) {
  //               $leave = new Leave();
  //               $leave->user_id = $request->user_id;
  //               $leave->leave_type_id = $request->leave_type_id;
  //               $leave->duration = $request->duration;
  //               $leave->leave_date = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
  //               $leave->reason = $request->reason;
  //               $leave->status = $request->status;
  //               $leave->client_id = $client_id;
  //               $leave->save();
  //               session()->forget('leaves_duration');
  //           }

  //           return Reply::redirect(route('Crm::staff.dashboard'), 'Leave assigned successfully.');
  //       } else {
  //           $leave = new Leave();
  //           $leave->user_id = $request->user_id;
  //           $leave->leave_type_id = $request->leave_type_id;
  //           $leave->duration = $request->duration;
  //           $leave->leave_date = Carbon::createFromFormat('d-m-Y', $request->leave_date)->format('Y-m-d');
  //           $leave->reason = $request->reason;
  //           $leave->status = $request->status;
  //           $leave->client_id = $client_id;
  //           $leave->save();
  //           return Reply::redirect(route('Crm::staff.dashboard'), 'Leave assigned successfully.');
  //       }
  //   }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  //   public function staff_leaveShow($id)
  //   {
  //   	Laralum::permissionToAccess('laralum.leave.view');
  //       // if (!$this->user->can('view_leave')) {
  //       //     abort(403);
  //       // }
  //   	if (Laralum::loggedInUser()->reseller_id == 0) {
		// 	$client_id = Laralum::loggedInUser()->id;
		// } else {
		// 	$client_id = Laralum::loggedInUser()->reseller_id;
		// }
  //       $this->leave = Leave::findOrFail($id);
  //       return view('hyper.leave-dashboard.show', ['leave'=>$this->leave]);
  //   }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  //   public function staff_leaveEdit($id)
  //   {
  //   	Laralum::permissionToAccess('laralum.leave.edit');
  //       // if (!$this->user->can('edit_leave')) {
  //       //     abort(403);
  //       // }
  //   	if (Laralum::loggedInUser()->reseller_id == 0) {
		// 	$client_id = Laralum::loggedInUser()->id;
		// } else {
		// 	$client_id = Laralum::loggedInUser()->reseller_id;
		// }
  //       $this->employees = User::allEmployees();
  //       $this->leaveTypes = LeaveType::where('client_id', $client_id)->get();
  //       $this->leave = Leave::findOrFail($id);
  //       $view = view('hyper.leave-dashboard.edit', ['employees'=>$this->employees,'leaveTypes'=>$this->leaveTypes,'leave'=>$this->leave])->render();
  //       return Reply::dataOnly(['status' => 'success', 'view' => $view]);
  //   }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  //   public function staff_leaveUpdate(UpdateLeave $request, $id)
  //   {
  //   	Laralum::permissionToAccess('laralum.leave.edit');
  //       // if (!$this->user->can('edit_leave')) {
  //       //     abort(403);
  //       // }
  //   	if (Laralum::loggedInUser()->reseller_id == 0) {
		// 	$client_id = Laralum::loggedInUser()->id;
		// } else {
		// 	$client_id = Laralum::loggedInUser()->reseller_id;
		// }
  //       $leave = Leave::findOrFail($id);
  //       $oldStatus = $leave->status;

  //       $leave->user_id = $request->user_id;
  //       $leave->leave_type_id = $request->leave_type_id;
  //       $leave->leave_date = Carbon::createFromFormat('d-m-Y', $request->leave_date)->format('Y-m-d');
  //       $leave->reason = $request->reason;
  //       $leave->status = $request->status;
  //       $leave->client_id = $client_id;
  //       $leave->save();

  //       return Reply::redirect(route('Crm::staff.dashboard'), 'Leave assigned successfully.');
  //   }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  //   public function staff_leaveDestroy($id)
  //   {
  //   	Laralum::permissionToAccess('laralum.leave.delete');
  //       // if (!$this->user->can('delete_leave')) {
  //       //     abort(403);
  //       // }

  //       Leave::destroy($id);
  //       return Reply::success('Leave deleted successfully.');
  //   }

  //   public function staff_leaveAction(Request $request)
  //   {
  //   	Laralum::permissionToAccess('laralum.leave.edit');
  //       // if (!$this->user->can('edit_leave')) {
  //       //     abort(403);
  //       // }
  //   	if (Laralum::loggedInUser()->reseller_id == 0) {
		// 	$client_id = Laralum::loggedInUser()->id;
		// } else {
		// 	$client_id = Laralum::loggedInUser()->reseller_id;
		// }
  //       $leave = Leave::findOrFail($request->leaveId);
  //       $leave->status = $request->action;
  //       $leave->save();

  //       return Reply::success('Leave status updated successfully.');
  //   }





























}
