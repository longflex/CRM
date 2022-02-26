<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\AttendanceSetting;
use App\Helper\Reply;
use App\Http\Requests\CommonRequest;
use App\Http\Requests\Holiday\CreateRequest;
use App\Http\Requests\Holiday\DeleteRequest;
use App\Http\Requests\Holiday\IndexRequest;
use App\Http\Requests\Holiday\UpdateRequest;
use App\Holiday;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

use App\Role;
use App\Http\Controllers\Laralum\Laralum;
use App\User;
use App\Permission;
use Validator, File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule; 






class HolidaysController extends Controller
{
    public function __construct()
    {
        for ($m = 1; $m <= 12; $m++) {
            $month[] = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
        }

        $this->months = $month;
        $this->currentMonth = date('F');
    }

    public function index(IndexRequest $request)
    {
        Laralum::permissionToAccess('laralum.holiday.list');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $this->holidayActive = 'active';
        $hol = [];
        $this->year = Carbon::now()->format('Y');

        $years = [];
        $lastFiveYear = (int) Carbon::now()->subYears(5)->format('Y');
        $nextYear = (int) Carbon::now()->addYear()->format('Y');

        for ($i = $lastFiveYear; $i <= $nextYear; $i++) {
            $years[] = $i;
        }
        $this->years = $years;

        $this->holidays = Holiday::orderBy('date', 'ASC')
            ->where(DB::raw('Year(holidays.date)'), '=', $this->year)
            ->where('client_id', $client_id)
            ->get();

        $dateArr = $this->getDateForSpecificDayBetweenDates($this->year . '-01-01', $this->year . '-12-31', 0);
        $this->number_of_sundays = count($dateArr);

        $this->holidays_in_db = count($this->holidays);

        foreach ($this->holidays as $holiday) {
            $hol[date('F', strtotime($holiday->date))]['id'][] = $holiday->id;
            $hol[date('F', strtotime($holiday->date))]['date'][] = $holiday->date->format("d-m-Y");
            $hol[date('F', strtotime($holiday->date))]['ocassion'][] = ($holiday->occassion) ? $holiday->occassion : 'Not Define';
            $hol[date('F', strtotime($holiday->date))]['day'][] = $holiday->date->format('D');
        }
        $this->holidaysArray = $hol;

        return View::make('hyper.holidays.index', ['months'=>$this->months,'currentMonth'=>$this->currentMonth,'holidayActive'=>$this->holidayActive,'year'=>$this->year,'years'=>$this->years,'holidays'=>$this->holidays,'number_of_sundays'=>$this->number_of_sundays,'holidays_in_db'=>$this->holidays_in_db,'holidaysArray'=>$this->holidaysArray]);
    }

    public function viewHoliday($year)
    {
        Laralum::permissionToAccess('laralum.holiday.view');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $this->holidayActive = 'active';
        $hol = [];

        $this->holidays = Holiday::orderBy('date', 'ASC')
            ->where(DB::raw('Year(holidays.date)'), '=', $year)
            ->where('client_id', $client_id)
            ->get();

        $dateArr = $this->getDateForSpecificDayBetweenDates($year . '-01-01', $year . '-12-31', 0);
        $this->number_of_sundays = count($dateArr);

        $this->holidays_in_db = count($this->holidays);

        foreach ($this->holidays as $holiday) {
            $hol[date('F', strtotime($holiday->date))]['id'][] = $holiday->id;
            $hol[date('F', strtotime($holiday->date))]['date'][] = $holiday->date->format("d-m-Y");
            $hol[date('F', strtotime($holiday->date))]['ocassion'][] = ($holiday->occassion) ? $holiday->occassion : 'Not Define';
            $hol[date('F', strtotime($holiday->date))]['day'][] = __('app.'.strtolower($holiday->date->format('l')));
        }
        $this->holidaysArray = $hol;

        $view = View::make('hyper.holidays.holiday-view', ['months'=>$this->months,'currentMonth'=>$this->currentMonth,'holidayActive' => $this->holidayActive,'holidays' => $this->holidays,'number_of_sundays' => $this->number_of_sundays,'holidays_in_db' => $this->holidays_in_db,'holidaysArray' => $this->holidaysArray])->render();
        return Reply::dataOnly(['view' => $view, 'number_of_sundays' => $this->number_of_sundays, 'holidays_in_db' => $this->holidays_in_db]);
    }


    /**
     * Show the form for creating a new holiday
     *
     * @return Response
     */
    public function create()
    {
        Laralum::permissionToAccess('laralum.holiday.create');
        return View::make('hyper.holidays.create');
    }

    /**
     * Store a newly created holiday in storage.
     *
     * @return Response
     */
    public function store(CreateRequest $request)
    {	
        Laralum::permissionToAccess('laralum.holiday.create');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $holiday = array_combine($request->date, $request->occasion);
        foreach ($holiday as $index => $value) {
            if ($index && $value != '') {
                $add = Holiday::firstOrCreate([
                    'date' => Carbon::createFromFormat("m/d/Y", $index)->format("Y-m-d"),
                    'occassion' => $value,
                    'client_id' => $client_id,
                ]);
            }
        }

        if (request()->has('type')) {
           return redirect(route('Crm::holidays'));
        }

        return Reply::redirect(route('Crm::holidays'), '<strong>New Holidays</strong> successfully added to the Database.');
    }

    /**
     * Display the specified holiday.
     */
    public function show($id)
    {
        Laralum::permissionToAccess('laralum.holiday.view');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $this->holiday = Holiday::findOrFail($id);

        return view('hyper.holidays.show', ['holiday'=>$this->holiday,'months'=>$this->months,'currentMonth'=>$this->currentMonth]);
    }

    /**
     * Show the form for editing the specified holiday.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        Laralum::permissionToAccess('laralum.holiday.edit');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $holiday = Holiday::find($id);

        return View::make('hyper.holidays.edit', compact('holiday'));
    }

    /**
     * Update the specified holiday in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(UpdateRequest $request, $id)
    {
        Laralum::permissionToAccess('laralum.holiday.edit');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $holiday = Holiday::findOrFail($id);
        $data = $request->all();
        $holiday->update($data);

        return Redirect::route('Crm::holidays');
    }

    /**
     * Remove the specified holiday from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(DeleteRequest $request, $id)
    {
        Laralum::permissionToAccess('laralum.holiday.delete');
        Holiday::destroy($id);
        return Reply::redirect(route('Crm::holidays'), 'Holidays successfully deleted.');
    }

    /**
     * @return array
     */

    public function Sunday()
    {
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $year = Carbon::now()->format('Y');

        $dateArr = $this->getDateForSpecificDayBetweenDates($year . '-01-01', $year . '-12-31', 0);

        foreach ($dateArr as $date) {
            Holiday::firstOrCreate([
                'date' => $date,
                'client_id' => $client_id,
                'occassion' => 'Sunday'
            ]);
        }
        return Reply::redirect(route('Crm::holidays'), '<strong>New Holidays</strong> successfully added to the Database.');
    }

    /**
     * @param $startDate
     * @param $endDate
     * @param $weekdayNumber
     * @return array
     */
    public function getDateForSpecificDayBetweenDates($startDate, $endDate, $weekdayNumber)
    {
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);

        $dateArr = [];

        do {
            if (date('w', $startDate) != $weekdayNumber) {
                $startDate += (24 * 3600); // add 1 day
            }
        } while (date('w', $startDate) != $weekdayNumber);


        while ($startDate <= $endDate) {
            $dateArr[] = date('Y-m-d', $startDate);
            $startDate += (7 * 24 * 3600); // add 7 days
        }

        return ($dateArr);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function holidayCalendar($year = null)
    {
        Laralum::permissionToAccess('laralum.holiday.view');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $this->pageTitle = 'Holiday Calendar';
        $this->year = Carbon::now()->format('Y');
        if ($year) {
            $this->year = $year;
        }

        $years = [];
        $lastFiveYear = (int) Carbon::now()->subYears(5)->format('Y');
        $nextYear = (int) Carbon::now()->addYear()->format('Y');

        for ($i = $lastFiveYear; $i <= $nextYear; $i++) {
            $years[] = $i;
        }
        $this->years = $years;

        $this->holidays = Holiday::where(DB::raw('Year(holidays.date)'), '=', $this->year)->where('client_id', $client_id)->get();
        return view('hyper.holidays.holiday-calendar', ['pageTitle'=>$this->pageTitle,'year'=>$this->year,'years'=>$this->years,'holidays'=>$this->holidays]);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Throwable
     */
    public function getCalendarMonth(Request $request)
    {
        Laralum::permissionToAccess('laralum.holiday.list');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $month = Carbon::createFromFormat('Y-m-d', $request->startDate)->format('m');
        $year = Carbon::createFromFormat('Y-m-d', $request->startDate)->format('Y');
        $this->holidays = Holiday::whereMonth('date', '=', $month)
            ->whereYear('date', '=', $year)
            ->where('client_id', $client_id)
            ->get();

        $view = view('hyper.holidays.month-wise-holiday', ['holidays'=>$this->holidays])->render();
        return Reply::dataOnly(['data' => $view]);
    }

    public function markHoliday()
    {
        Laralum::permissionToAccess('laralum.holiday.create');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $this->days = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday'
        ];

        //$attandanceSetting = AttendanceSetting::first()->where('client_id', $client_id);
        //$attandanceSetting->office_open_days
        $this->holidays = $this->missing_number(json_decode('[1,2,3,4,5]'));
        $holidaysArray = [];
        foreach ($this->holidays as $index => $holiday) {
            $holidaysArray[$holiday] = $this->days[$holiday - 1];
        }
        $this->holidaysArray = $holidaysArray;

        return View::make('hyper.holidays.mark-holiday', ['days'=>$this->days,'holidaysArray'=>$this->holidaysArray]);
    }

    public function missing_number($num_list)
    {
        // construct a new array
        $new_arr = range(1,7);
        if(is_null($num_list))
        {
            return $new_arr;
        }

        return array_diff($new_arr, $num_list);
    }

    public function markDayHoliday(CommonRequest $request)
    {
        Laralum::permissionToAccess('laralum.holiday.create');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}

        if (!$request->has('office_holiday_days')) {
            return Reply::error('Choose at-least 1.');
        }
        $year = Carbon::now()->format('Y');
        if ($request->has('year')) {
            $year = $request->has('year');
        }

        $daysss = [];
        $this->days = [
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday'
        ];

        if ($request->office_holiday_days != null && count($request->office_holiday_days) > 0) {
            foreach ($request->office_holiday_days as $holiday) {
                $daysss[] = $this->days[($holiday - 1)];
                $day = $holiday;
                if ($holiday == 7) {
                    $day = 0;
                }
                $dateArr = $this->getDateForSpecificDayBetweenDates($year . '-01-01', $year . '-12-31', ($day));

                foreach ($dateArr as $date) {
                    Holiday::firstOrCreate([
                        'date' => $date,
                        'client_id' => $client_id,
                        'occassion' => $this->days[$day]
                    ]);
                }
            }
        }
        return Reply::redirect(route('Crm::holidays'), '<strong>New Holidays</strong> successfully added to the Database.');
    }
    /// ======================staff holiday=====================================


    public function staff_holiday(IndexRequest $request)
    {
        Laralum::permissionToAccess('laralum.holiday.list');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $this->holidays = Holiday::orderBy('date', 'ASC')->where('client_id', $client_id)->get();
        $this->holidayActive = 'active';
        $hol = [];

        $years = [];
        $lastFiveYear = (int)Carbon::now()->subYears(5)->format('Y');
        $nextYear = (int)Carbon::now()->addYear()->format('Y');

        for($i=$lastFiveYear;$i <= $nextYear;$i++ ){
            $years [] =$i;
        }
        $this->years = $years;
        $this->year = Carbon::now()->format('Y');
        $dateArr = $this->getDateForSpecificDayBetweenDates($this->year . '-01-01', $this->year . '-12-31', 0);
        $this->number_of_sundays = count($dateArr);

        $this->holidays_in_db = count($this->holidays);

        foreach ($this->holidays as $holiday) {
            $hol[date('F', strtotime($holiday->date))]['id'][] = $holiday->id;
            $hol[date('F', strtotime($holiday->date))]['date'][] = $holiday->date->format('d-m-Y');
            $hol[date('F', strtotime($holiday->date))]['ocassion'][] = ($holiday->occassion)? $holiday->occassion : 'Not Define'; ;
            $hol[date('F', strtotime($holiday->date))]['day'][] = $holiday->date->format('D');
        }
        $this->holidaysArray = $hol;
        return View::make('hyper.holidays.employee.index', ['months'=>$this->months,'currentMonth'=>$this->currentMonth,'holidayActive'=>$this->holidayActive,'year'=>$this->year,'years'=>$this->years,'holidays'=>$this->holidays,'number_of_sundays'=>$this->number_of_sundays,'holidays_in_db'=>$this->holidays_in_db,'holidaysArray'=>$this->holidaysArray]);
    }

    public function staff_viewHoliday($year)
    {
        Laralum::permissionToAccess('laralum.holiday.view');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}

        $this->holidayActive = 'active';
        $hol = [];

        $this->holidays = Holiday::orderBy('date', 'ASC')
            ->where(DB::raw('Year(holidays.date)'), '=', $year)
            ->where('client_id', $client_id)
            ->get();

        $dateArr = $this->getDateForSpecificDayBetweenDates($year . '-01-01', $year . '-12-31', 0);
        $this->number_of_sundays = count($dateArr);

        $this->holidays_in_db = count($this->holidays);

        foreach ($this->holidays as $holiday) {
            $hol[date('F', strtotime($holiday->date))]['id'][] = $holiday->id;
            $hol[date('F', strtotime($holiday->date))]['date'][] = $holiday->date->format('d-m-Y');
            $hol[date('F', strtotime($holiday->date))]['ocassion'][] = ($holiday->occassion)? $holiday->occassion : 'Not Define';
            $hol[date('F', strtotime($holiday->date))]['day'][] = $holiday->date->format('D');
        }
        $this->holidaysArray = $hol;

        $view = View::make('hyper.holidays.employee.holiday-view', ['months'=>$this->months,'currentMonth'=>$this->currentMonth,'holidayActive' => $this->holidayActive,'holidays' => $this->holidays,'number_of_sundays' => $this->number_of_sundays,'holidays_in_db' => $this->holidays_in_db,'holidaysArray' => $this->holidaysArray])->render();
        return Reply::dataOnly(['view' =>$view, 'number_of_sundays' => $this->number_of_sundays, 'holidays_in_db' => $this->holidays_in_db]);

    }

    /**
     * Show the form for creating a new holiday
     *
     * @return Response
     */
    public function staff_create()
    {
        // if (!$this->user->can('add_holiday')) {
        //     abort(403);
        // }
        Laralum::permissionToAccess('laralum.holiday.create');
        return View::make('hyper.holidays.employee.create');
    }

    /**
     * Store a newly created holiday in storage.
     *
     * @return Response
     */
    public function staff_store(CreateRequest $request)
    {
        // if (!$this->user->can('add_holiday')) {
        //     abort(403);
        // }
        Laralum::permissionToAccess('laralum.holiday.create');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $holiday = array_combine($request->date, $request->occasion);
        foreach ($holiday as $index => $value) {
            if ($index) {
                $add = Holiday::firstOrCreate([
                    'date' => Carbon::createFromFormat('m/d/Y', $index)->format('Y-m-d'),
                    'occassion' => $value,
                    'client_id' => $client_id,
                ]);
            }
        }
        return Reply::redirect(route('Crm::staff.holidays'), '<strong>New Holidays</strong> successfully added to the Database.');
    }

    /**
     * Display the specified holiday.
     */
    public function staff_show($id)
    {
        Laralum::permissionToAccess('laralum.holiday.view');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $this->holiday = Holiday::findOrFail($id);

        return view('hyper.holidays.employee.show', ['holiday'=>$this->holiday]);
    }

    /**
     * Show the form for editing the specified holiday.
     *
     * @param  int $id
     * @return Response
     */
    public function staff_edit($id)
    {
        // if(!$this->user->can('edit_holiday')){
        //     abort(403);
        // }
        Laralum::permissionToAccess('laralum.holiday.edit');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $this->holiday = Holiday::find($id);

        return view('hyper.holidays.employee.edit', ['holiday'=>$this->holiday]);
    }

    /**
     * Update the specified holiday in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function staff_update(UpdateRequest $request, $id)
    {
        // if(!$this->user->can('edit_holiday')){
        //     abort(403);
        // }
        Laralum::permissionToAccess('laralum.holiday.edit');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $holiday = Holiday::findOrFail($id);
        $data = $request->all();
        $holiday->update($data);

        return Redirect::route('Crm::staff.holidays');
    }

    /**
     * Remove the specified holiday from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function staff_destroy(DeleteRequest $request, $id)
    {
        // if(!$this->user->can('delete_holiday')){
        //     abort(403);
        // }
        Laralum::permissionToAccess('laralum.holiday.delete');
        Holiday::destroy($id);
        return Reply::redirect(route('Crm::staff.holidays'), 'Holidays successfully deleted.');
    }

    /**
     * @return array
     */

    public function staff_Sunday()
    {
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $year = Carbon::now()->format('Y');

        $dateArr = $this->getDateForSpecificDayBetweenDates($year . '-01-01', $year . '-12-31', 0);

        foreach ($dateArr as $date) {
            Holiday::firstOrCreate([
                'date' => $date,
                'occassion' => 'Sunday',
                'client_id' => $client_id,
            ]);
        }
        return Reply::redirect(route('Crm::staff.holidays'), '<strong>New Holidays</strong> successfully added to the Database.');
    }

    /**
     * @param $startDate
     * @param $endDate
     * @param $weekdayNumber
     * @return array
     */
    public function staff_getDateForSpecificDayBetweenDates($startDate, $endDate, $weekdayNumber)
    {
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);

        $dateArr = [];

        do {
            if (date('w', $startDate) != $weekdayNumber) {
                $startDate += (24 * 3600); // add 1 day
            }
        } while (date('w', $startDate) != $weekdayNumber);


        while ($startDate <= $endDate) {
            $dateArr[] = date('Y-m-d', $startDate);
            $startDate += (7 * 24 * 3600); // add 7 days
        }

        return ($dateArr);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function staff_holidayCalendar(Request $request, $year = null)
    {
        Laralum::permissionToAccess('laralum.holiday.view');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $this->pageTitle = 'Holiday Calendar';
        $this->year = Carbon::now()->format('Y');

        if($year){
            $this->year = $year;
        }

        $years = [];
        $lastFiveYear = (int)Carbon::now()->subYears(5)->format('Y');
        $nextYear = (int)Carbon::now()->addYear()->format('Y');

        for($i=$lastFiveYear;$i <= $nextYear;$i++ ){
            $years [] =$i;
        }
        $this->years = $years;

        $this->holidays = Holiday::where(DB::raw('Year(holidays.date)'), '=', $this->year)->where('client_id', $client_id)->get();

        if($request->ajax()){
            return Reply::dataOnly(['eventData' => $this->holidays, 'year' => $this->year]);
        }

        return view('hyper.holidays.employee.holiday-calendar', ['pageTitle'=>$this->pageTitle,'year'=>$this->year,'years'=>$this->years,'holidays'=>$this->holidays]);
    }

    public function staff_markHoliday()
    {
        Laralum::permissionToAccess('laralum.holiday.create');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $this->days = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday'
        ];

        $attandanceSetting = AttendanceSetting::first();

        $this->holidays = $this->missing_number(json_decode($attandanceSetting->office_open_days));
        $holidaysArray = [];
        foreach($this->holidays as $index => $holiday){
            $holidaysArray[$holiday] = $this->days[$holiday-1];
        }
        $this->holidaysArray = $holidaysArray;

        return View::make('hyper.holidays.employee.mark-holiday', ['days'=>$this->days,'holidaysArray'=>$this->holidaysArray]);
    }

    public function staff_missing_number($num_list)
    {
        // construct a new array
        $new_arr = range(1,7);
        return array_diff($new_arr, $num_list);
    }

    public function staff_markDayHoliday(CommonRequest $request){
        Laralum::permissionToAccess('laralum.holiday.create');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        if (!$request->has('office_holiday_days')) {
            return Reply::error('Choose at-least 1.');
        }
        $year = Carbon::now()->format('Y');
        if($request->has('year')){
            $year = $request->has('year');
        }


        $daysss = [];
        $this->days = [
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday'
        ];

        if($request->office_holiday_days != null && count($request->office_holiday_days) > 0){
            foreach($request->office_holiday_days as $holiday){
                $daysss[] = $this->days[($holiday-1)];
                $day = $holiday;
                if($holiday == 7){
                    $day = 0;
                }
                $dateArr = $this->getDateForSpecificDayBetweenDates($year . '-01-01', $year . '-12-31', ($day));

                foreach ($dateArr as $date) {
                    Holiday::firstOrCreate([
                        'date' => $date,
                        'client_id' => $client_id,
                        'occassion' => $this->days[$day]
                    ]);
                }
            }

        }
        return Reply::redirect(route('Crm::staff.holidays'), '<strong>New Holidays</strong> successfully added to the Database.');
    }
    /**
     * @param Request $request
     * @return mixed
     * @throws \Throwable
     */
    public function staff_getCalendarMonth(Request $request){
        Laralum::permissionToAccess('laralum.holiday.view');
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $month = Carbon::createFromFormat('Y-m-d', $request->startDate)->format('m');
        $year = Carbon::createFromFormat('Y-m-d', $request->startDate)->format('Y');
        $this->holidays = Holiday::whereMonth('date', '=', $month)
            ->whereYear('date', '=', $year)
            ->where('client_id', $client_id)
            ->get();

        $view = view('hyper.holidays.employee.month-wise-holiday', ['holidays'=>$this->holidays])->render();
        return Reply::dataOnly(['data'=> $view]);
    }





































}
