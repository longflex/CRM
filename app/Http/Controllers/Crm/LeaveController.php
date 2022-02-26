<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\Reply;
use App\Http\Requests\Leaves\StoreLeave;
use App\Http\Requests\Leaves\UpdateLeave;
use App\Leave;
use App\LeaveType;
//use App\Notifications\LeaveStatusApprove;
//use App\Notifications\LeaveStatusReject;
//use App\Notifications\LeaveStatusUpdate;
use App\User;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

use App\Role;
use App\Http\Controllers\Laralum\Laralum;

use App\Permission;
use Validator, File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\EmployeeLeaveQuota;

class LeaveController extends Controller
{
    public function __construct()
    {
        // parent::__construct();
        // $this->pageTitle = 'app.menu.leaves';
        // $this->pageIcon = 'icon-logout';
        // $this->middleware(function ($request, $next) {
        //     if (!in_array('leaves', $this->user->modules)) {
        //         abort(403);
        //     }
        //     return $next($request);
        // });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	Laralum::permissionToAccess('laralum.leave.list');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
    	$this->leaves = [];
        // Data return for calendar direct with this route
        if (request('start') && request('end')) {
            $startDate = Carbon::parse(request('start'))->format('Y-m-d');
            $endDate = Carbon::parse(request('end'))->format('Y-m-d');
            $this->leaves = Leave::where('status', '<>', 'rejected')
                ->whereDate('leave_date', '>=', $startDate)
                ->whereDate('leave_date', '<=', $endDate)
                ->where('client_id', $client_id)
                ->get();
//echo 1;die;
            $calendarData = array();

            foreach ($this->leaves as $key => $value) {
                $calendarData[] = [
                    'id' => $value->id,
                    'title' => ucfirst($value->user->name),
                    'start' => $value->leave_date->format("Y-m-d"),
                    'end' => $value->leave_date->format("Y-m-d"),
                    'className' => 'bg-'.$value->type->color,
                ];
            }
            return $calendarData;
        }

        $this->pendingLeaves = Leave::where('status', 'pending')->where('client_id', $client_id)->count();

        return view('hyper.leaves.index', ['pendingLeaves'=>$this->pendingLeaves,'leaves'=>$this->leaves]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	Laralum::permissionToAccess('laralum.leave.create');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        
        $this->employees = User::allEmployees();
        $this->leaveTypes = LeaveType::where('client_id', $client_id)->get();
        return view('hyper.leaves.create', ['employees'=>$this->employees,'leaveTypes'=>$this->leaveTypes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	Laralum::permissionToAccess('laralum.leave.create');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        if ($request->duration == 'multiple') {
            session(['leaves_duration' => 'multiple']);
            $dates = explode(',', $request->multi_date);
            foreach ($dates as $date) {
                $leave = new Leave();
               
                $leave->user_id = $request->user_id;
                $leave->leave_type_id = $request->leave_type_id;
                $leave->duration = $request->duration;
                $leave->leave_date = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
                $leave->reason = $request->reason;
                $leave->status = $request->status;
                $leave->client_id = $client_id;
                $leave->save();
                session()->forget('leaves_duration');
            }
            $msg="The Leave has been created.";
			return response()->json(['status' => true ,'message' => $msg]);
            //return Reply::redirect(route('Crm::leaves'), 'Leave assigned successfully.');
        } else {
            $leave = new Leave();
            $leave->user_id = $request->user_id;
            $leave->leave_type_id = $request->leave_type_id;
            $leave->duration = $request->duration;
            $leave->leave_date = Carbon::createFromFormat('d-m-Y', $request->leave_date)->format('Y-m-d');
            $leave->reason = $request->reason;
            $leave->status = $request->status;
           	$leave->client_id = $client_id;
            $leave->save();
            $msg="The Leave has been created.";
			return response()->json(['status' => true ,'message' => $msg]);
            //return Reply::redirect(route('Crm::leaves'), 'Leave assigned successfully.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	Laralum::permissionToAccess('laralum.leave.view');
        $this->leave = Leave::findOrFail($id);
        return view('hyper.leaves.show', ['leave'=>$this->leave]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	Laralum::permissionToAccess('laralum.leave.edit');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $this->employees = User::allEmployees();
        $this->leaveTypes = LeaveType::where('client_id', $client_id)->get();
        $this->leave = Leave::findOrFail($id);
        $view = view('hyper.leaves.edit', ['employees'=>$this->employees,'leaveTypes'=>$this->leaveTypes,'leave'=>$this->leave])->render();
        return Reply::dataOnly(['status' => 'success', 'view' => $view]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLeave $request, $id)
    {
    	Laralum::permissionToAccess('laralum.leave.edit');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $leave = Leave::findOrFail($id);
        $oldStatus = $leave->status;
        $leave->user_id = $request->user_id;
        $leave->leave_type_id = $request->leave_type_id;
        $leave->leave_date = Carbon::createFromFormat('d-m-Y', $request->leave_date)->format('Y-m-d');
        $leave->reason = $request->reason;
        $leave->status = $request->status;
        $leave->client_id = $client_id;
        $leave->save();

        return Reply::redirect(route('Crm::leaves'), 'Leave assigned successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	Laralum::permissionToAccess('laralum.leave.delete');
        Leave::destroy($id);
        return Reply::success('Leave deleted successfully.');
    }

    public function leaveAction(Request $request)
    {
    	Laralum::permissionToAccess('laralum.leave.edit');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $leave = Leave::findOrFail($request->leaveId);
        $leave->status = $request->action;
        if (!empty($request->reason)) {
            $leave->reject_reason = $request->reason;
        }
        $leave->save();

        return Reply::success('Leave status updated successfully.');
    }

    public function rejectModal(Request $request)
    {
    	Laralum::permissionToAccess('laralum.leave.edit');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $this->leaveAction = $request->leave_action;
        $this->leaveID = $request->leave_id;
        return view('hyper.leaves.reject-reason-modal', ['leaveAction'=>$this->leaveAction,'leaveID'=>$this->leaveID]);
    }

    public function allLeaves()
    {
    	//Laralum::permissionToAdminAccess('laralum.leave.list');
    	Laralum::permissionToAccess('laralum.leave.list');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $this->employees = User::allEmployees();
        $this->fromDate = Carbon::today()->subDays(7);
        $this->toDate = Carbon::today()->addDays(30);
        $this->pendingLeaves = Leave::where('status', 'pending')->where('client_id', $client_id)->count();

        return view('hyper.leaves.all-leaves', ['employees'=>$this->employees,'fromDate'=>$this->fromDate,'toDate'=>$this->toDate,'pendingLeaves'=>$this->pendingLeaves]);
    }

    /**
     * @param null $startDate
     * @param null $endDate
     * @param null $employeeId
     * @return mixed
     */
    public function data($startDate = null, $endDate = null, $employeeId = null)
    {
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $employeeId = request('employeeId');
        $startDate = request('startDate');
        $endDate = request('endDate');
        
        $startDt = '';
        $endDt = '';

        if (!is_null($startDate) && !is_null($endDate)) {
            $startDate = Carbon::createFromFormat('d-m-Y', $startDate)->toDateString();
            $endDate = Carbon::createFromFormat('d-m-Y', $endDate)->toDateString();

            $startDt = $startDate;
            $endDt = $endDate;
        }

        $leavesList = Leave::join('users', 'users.id', 'leaves.user_id')
            ->join('leave_types', 'leave_types.id', 'leaves.leave_type_id')
            //->where('users.status', 'active')
            ->where('leaves.client_id', $client_id)
            ->whereRaw('Date(leaves.leave_date) >= ?', [$startDt])
            ->whereRaw('Date(leaves.leave_date) <= ?', [$endDt])
            ->select('leaves.id', 'users.name', 'leaves.leave_date', 'leaves.status', 'leave_types.type_name', 'leave_types.color', 'leaves.leave_date', 'leaves.duration');

        if ($employeeId != 0) {
            $leavesList->where('users.id', $employeeId);
        }

        $leaves = $leavesList->get();

        return DataTables::of($leaves)
            ->addColumn('employee', function ($row) {
                return ucwords($row->name);
            })
            ->addColumn('leave_date', function ($row) {
                return $row->leave_date->format('d-m-Y');
            })
            ->addColumn('status', function ($row) {
                if ($row->status == 'approved') {
                    $statusColor = 'success';
                    $status = 'Approved';
                } else if ($row->status == 'pending') {
                    $statusColor = 'warning';
                    $status = 'Pending';
                } else {
                    $statusColor = 'danger';
                    $status = 'Rejected';
                }
                return '<div class="label-' . $statusColor . ' label">' . $status . '</div>';
            })
            ->addColumn('leave_type', function ($row) {
                $type = '<div class="label-' . $row->color . ' label">' . $row->type_name . '</div>';

                if ($row->duration == 'half day') {
                    $type .= ' <div class="label-inverse label">' . 'Half Day' . '</div>';
                }

                return $type;
            })
            ->addColumn('action', function ($row) {
                if ($row->status == 'pending') {
                    return '<a href="javascript:;"
                            data-leave-id=' . $row->id . ' 
                            data-leave-action="approved" 
                            class="btn btn-success btn-circle leave-action"
                            data-toggle="tooltip"
                            data-original-title="Approve">
                                <i class="fa fa-check"></i>
                            </a>
                            <a href="javascript:;" 
                            data-leave-id=' . $row->id . '
                            data-leave-action="rejected"
                            class="btn btn-danger btn-circle leave-action-reject"
                            data-toggle="tooltip"
                            data-original-title="Reject">
                                <i class="fa fa-times"></i>
                            </a>
                            
                            <a href="javascript:;"
                            data-leave-id=' . $row->id . '
                            class="btn btn-info btn-circle show-leave"
                            data-toggle="tooltip"
                            data-original-title="Details">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </a>';
                }

                return '<a href="javascript:;"
                        data-leave-id=' . $row->id . '
                        class="btn btn-info btn-circle show-leave"
                        data-toggle="tooltip"
                        data-original-title="Details">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </a>';
            })
            ->addIndexColumn()
            ->rawColumns(['status', 'leave_type', 'action'])
            ->make(true);
    }

    public function pendingLeaves()
    {
    	Laralum::permissionToAccess('laralum.leave.list');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $pendingLeaves = Leave::with('type', 'user', 'user.leaveTypes')
        	->where('status', 'pending')
        	->where('client_id', $client_id)
            ->orderBy('leave_date', 'asc')
            ->get();
        $this->pendingLeaves = $pendingLeaves->each->append('leaves_taken_count');
        $this->allowedLeaves = EmployeeLeaveQuota::where('client_id', $client_id)->sum('no_of_leaves');
        //dd($this->allowedLeaves);
        return view('hyper.leaves.pending', ['pendingLeaves'=>$this->pendingLeaves, 'allowedLeaves'=>$this->allowedLeaves]);
    }
    //=================================staff module=====================================

    public function staff_leave()
    {
    	Laralum::permissionToAccess('laralum.leave.list');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}

        $this->leaves = Leave::byUser(Laralum::loggedInUser()->id);
        $this->leavesCount = Leave::byUserCount(Laralum::loggedInUser()->id);
        $this->leaveTypes = LeaveType::byUser(Laralum::loggedInUser()->id);
        $this->allowedLeaves = EmployeeLeaveQuota::where('user_id', Laralum::loggedInUser()->id)->where('client_id', $client_id)->sum('no_of_leaves');
        $this->pendingLeaves = Leave::where('status', 'pending')
            ->where('user_id', Laralum::loggedInUser()->id)
            ->orderBy('leave_date', 'asc')
            ->where('client_id', $client_id)
            ->get();//echo 1;die;
        //$this->user = User::find(Laralum::loggedInUser()->id);    
        $this->employeeLeavesQuota = EmployeeLeaveQuota::where('user_id', Laralum::loggedInUser()->id)->get();
        //$this->user->leaveTypes;

        return view('hyper.leaves.employee.index', ['leaves'=>$this->leaves,'leavesCount'=>$this->leavesCount,'leaveTypes'=>$this->leaveTypes,'allowedLeaves'=>$this->allowedLeaves,'pendingLeaves'=>$this->pendingLeaves,'employeeLeavesQuota'=>$this->employeeLeavesQuota]);
    }

    public function staff_create()
    {
    	//Laralum::permissionToAccess('laralum.leave.create');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $this->leaveTypes = EmployeeLeaveQuota::with('leaveType')
            ->where('no_of_leaves', '>', 0)
            ->where('client_id', $client_id)
            ->get();
        $this->leaves = Leave::where('user_id', Laralum::loggedInUser()->id)
            ->select('leave_date')
            ->where('status', '<>', 'rejected')
            ->where('duration', '<>', 'half day')
            ->where('client_id', $client_id)
            ->groupBy('leave_date')
            ->get();
        return view('hyper.leaves.employee.create', ['leaveTypes'=>$this->leaveTypes,'leaves'=>$this->leaves,'user_id'=>Laralum::loggedInUser()->id]);
    }

    public function staff_store(Request $request)
    {
    	//Laralum::permissionToAccess('laralum.leave.create');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        if ($request->duration == 'multiple') {
            session(['leaves_duration' => 'multiple']);

            $dates = explode(',', $request->multi_date);
            foreach ($dates as $date) {
                $leave = new Leave();
                $leave->user_id = $request->user_id;
                $leave->leave_type_id = $request->leave_type_id;
                $leave->duration = $request->duration;
                $leave->leave_date = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
                $leave->reason = $request->reason;
                $leave->status = $request->status;
                $leave->client_id = $client_id;
                $leave->save();
                session()->forget('leaves_duration');
            }
        } else {
            $leave = new Leave();
            $leave->user_id = $request->user_id;
            $leave->leave_type_id = $request->leave_type_id;
            $leave->duration = $request->duration;
            $leave->leave_date = Carbon::createFromFormat('d-m-Y', $request->leave_date)->format('Y-m-d');
            $leave->reason = $request->reason;
            $leave->status = $request->status;
            $leave->client_id = $client_id;
            $leave->save();
        }
        $msg="The Leave has been created.";
		return response()->json(['status' => true ,'message' => $msg]);
        //return Reply::redirect(route('Crm::staffleaves'), 'Leave applied successfully.');
    }

    public function staff_show($id)
    {
    	Laralum::permissionToAccess('laralum.leave.view');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $this->leave = Leave::findOrFail($id);
        return view('hyper.leaves.employee.show', ['leave'=>$this->leave]);
    }

    public function staff_edit($id)
    {
    	Laralum::permissionToAccess('laralum.leave.edit');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $this->leaveTypes = EmployeeLeaveQuota::with('leaveType')
            ->where('no_of_leaves', '>', 0)
            ->where('user_id', Laralum::loggedInUser()->id)
            ->get();
        $this->leave = Leave::findOrFail($id);
        $view = view('hyper.leaves.employee.edit', ['leaveTypes'=>$this->leaveTypes,'leave'=>$this->leave,'user_id'=>Laralum::loggedInUser()->id])->render();
        return Reply::dataOnly(['status' => 'success', 'view' => $view]);
    }

    public function staff_update(UpdateLeave $request, $id)
    {
    	Laralum::permissionToAccess('laralum.leave.edit');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $leave = Leave::findOrFail($id);
        $leave->user_id = $request->user_id;
        $leave->leave_type_id = $request->leave_type_id;
        $leave->leave_date = Carbon::createFromFormat('d-m-Y', $request->leave_date)->format('Y-m-d');
        $leave->reason = $request->reason;
        $leave->status = $request->status;
        $leave->client_id = $client_id;
        $leave->save();

        return Reply::redirect(route('Crm::staff.leaves'), 'Leave assigned successfully.');
    }

    public function staff_destroy($id)
    {
    	Laralum::permissionToAccess('laralum.leave.delete');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        Leave::destroy($id);
        return Reply::success('Leave deleted successfully.');
    }

    public function staff_leaveAction(Request $request)
    {
    	Laralum::permissionToAccess('laralum.leave.edit');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        Leave::destroy($request->leaveId);

        return Reply::success('Leave status updated successfully.');
    }

    public function staff_data()
    {
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $leaves = Leave::with('user', 'type')
            ->where('user_id', Laralum::loggedInUser()->id)
            ->orderBy('id', 'desc')
            ->where('client_id', $client_id)
            ->get();
        return DataTables::of($leaves)
            ->addColumn('action', function ($row) {
                $action = '';

                $action .= '<a href="javascript:;" onclick="getEventDetail(' . $row->id . ')" class="btn btn-info btn-circle"
                      data-toggle="tooltip" data-original-title="View"><i class="fa fa-search" aria-hidden="true"></i></a>';

                if ($row->status == 'pending') {
                    $action .= '  <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                      data-toggle="tooltip" data-user-id="' . $row->id . '" data-original-title="Delete"><i class="fa fa-times" aria-hidden="true"></i></a>';
                }

                return $action;
            })
            ->addColumn('type', function ($row) {
                return ucfirst($row->type->type_name);
            })
            ->editColumn('leave_date', function ($row) {
                return Carbon::parse($row->leave_date)->format('d-m-Y');
            })
            ->editColumn('status', function ($row) {
                if ($row->status == 'approved') {
                    return '<label class="label label-success">' . ucfirst($row->status) . '</label>';
                } elseif ($row->status == 'pending') {
                    return '<label class="label label-warning">' . ucfirst($row->status) . '</label>';
                } else {
                    return '<label class="label label-danger">' . ucfirst($row->status) . '</label>';
                }
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'status'])
            ->make(true);
    }


































}
