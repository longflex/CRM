<?php

namespace App\Http\Controllers\Crm;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Lead;
use App\User;
use App\Appointment;
use App\Donation;
use App\Exports\AppointmentExport;
use Maatwebsite\Excel\Facades\Excel;
use Laralum;
use Validator, DB, File;
use Response;

class AppointmentController extends Controller
{

	public function index(Request $request)
	{
		Laralum::permissionToAccess('laralum.appointments.view');

		# Get all appointments for admin
		$status = $request->status;
		$from_date = $request->from_date;
		$to_date = $request->to_date;
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}

		if (Laralum::loggedInUser()->reseller_id == 0) {
			$appointment = DB::table('appointments')
				->when($status, function ($query, $status) {
					return $query->where('appointments.status', $status);
				})
				->when($from_date, function ($query, $from_date) {
					return $query->whereDate('appointments.apt_date', '>=', $from_date);
				})
				->when($to_date, function ($query, $to_date) {
					return $query->whereDate('appointments.apt_date', '<=', $to_date);
				})
				->where('appointments.client_id', Laralum::loggedInUser()->id)
				->join('leads', 'appointments.lead_id', '=', 'leads.id')
				->join('users', 'appointments.whom_to_meet', '=', 'users.id')
				->select('appointments.*', 'leads.name', 'leads.email', 'leads.mobile', 'leads.address', 'users.name as empName')
				->orderBy('appointments.id', 'desc')
				->get();
		} else {
			$appointment = DB::table('appointments')
				->when($status, function ($query, $status) {
					return $query->where('appointments.status', $status);
				})
				->when($from_date, function ($query, $from_date) {
					return $query->whereDate('appointments.apt_date', '>=', $from_date);
				})
				->when($to_date, function ($query, $to_date) {
					return $query->whereDate('appointments.apt_date', '<=', $to_date);
				})
				->where('appointments.created_by', Laralum::loggedInUser()->id)
				->join('leads', 'appointments.lead_id', '=', 'leads.id')
				->join('users', 'appointments.whom_to_meet', '=', 'users.id')
				->select('appointments.*', 'leads.name', 'leads.email', 'leads.mobile', 'leads.address', 'users.name as empName')
				->orderBy('appointments.id', 'desc')
				->get();
		}
		$apt_staff = DB::table('users')->where('reseller_id', $client_id)->where('isAptMeet', 1)->get();
		# Return the view
		return view('crm/appointments/index', ['appointments' => $appointment, 'client_id' => $client_id, 'apt_staff' => $apt_staff]);
	}

	public function dashboard(Request $request)
	{
		Laralum::permissionToAccess('laralum.appointments.dashboard');
		# Get all leads for admin
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$total_appointment = DB::table('appointments')->where('client_id', Laralum::loggedInUser()->id)->count();
			$pending_appointment = DB::table('appointments')->where('status', 'Pending')->where('client_id', Laralum::loggedInUser()->id)->count();
			$completed_appointment = DB::table('appointments')->where('status', 'Completed')->where('client_id', Laralum::loggedInUser()->id)->count();
			$average_booking = DB::table('appointments')->where('client_id', Laralum::loggedInUser()->id)->count();
			$returncustomer = DB::table('appointments')->where('client_id', Laralum::loggedInUser()->id)->groupBy('lead_id')->count();
			$newcustomer = DB::table('appointments')->where('client_id', Laralum::loggedInUser()->id)->groupBy('lead_id')->count();
			$today_appointment = DB::table('appointments')->where('client_id', Laralum::loggedInUser()->id)->whereDate('apt_date', '=', date("Y-m-d"))->count();
		} else {
			$total_appointment = DB::table('appointments')->where('created_by', Laralum::loggedInUser()->id)->count();
			$pending_appointment = DB::table('appointments')->where('status', 'Pending')->where('created_by', Laralum::loggedInUser()->id)->count();
			$completed_appointment = DB::table('appointments')->where('status', 'Completed')->where('created_by', Laralum::loggedInUser()->id)->count();
			$average_booking = DB::table('appointments')->where('created_by', Laralum::loggedInUser()->id)->count();
			$returncustomer = DB::table('appointments')->where('created_by', Laralum::loggedInUser()->id)->groupBy('lead_id')->count();
			$newcustomer = DB::table('appointments')->where('created_by', Laralum::loggedInUser()->id)->groupBy('lead_id')->count();
			$today_appointment = DB::table('appointments')->where('created_by', Laralum::loggedInUser()->id)->whereDate('apt_date', '=', date("Y-m-d"))->count();
		}
		$account_types = DB::table('account_types')->get();
		# Return the view
		return view('crm/appointments/dashboard', [
			'total_appointment' => $total_appointment,
			'pending_appointment' => $pending_appointment,
			'completed_appointment' => $completed_appointment,
			'average_booking' => round($average_booking / 30, 2),
			'today_appointment' => $today_appointment,
			'account_types' => $account_types,
			'returncustomer' => $returncustomer,
			'newcustomer' => $newcustomer,
		]);
	}

	public function aptDashboardFilter(Request $request)
	{
		$exp_requested_date = explode("-", $request->data);
		$from = $exp_requested_date[0];
		$to = $exp_requested_date[1];

		$from_date = date('Y-m-d H:i:s', strtotime($from));
		$to_date = date('Y-m-d H:i:s', strtotime($to));

		# Get all leads for admin
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$total_appointment = DB::table('appointments')->where('client_id', Laralum::loggedInUser()->id)->whereBetween('created_at', [$from_date, $to_date])->count();
			$pending_appointment = DB::table('appointments')->where('status', 'Pending')->where('client_id', Laralum::loggedInUser()->id)->whereBetween('created_at', [$from_date, $to_date])->count();
			$completed_appointment = DB::table('appointments')->where('status', 'Completed')->where('client_id', Laralum::loggedInUser()->id)->whereBetween('created_at', [$from_date, $to_date])->count();
			$average_booking = DB::table('appointments')->where('client_id', Laralum::loggedInUser()->id)->whereBetween('created_at', [$from_date, $to_date])->count();
			$returncustomer = DB::table('appointments')->where('client_id', Laralum::loggedInUser()->id)->whereBetween('created_at', [$from_date, $to_date])->groupBy('lead_id')->count();
			$newcustomer = DB::table('appointments')->where('client_id', Laralum::loggedInUser()->id)->whereBetween('created_at', [$from_date, $to_date])->groupBy('lead_id')->count();
			$today_appointment = DB::table('appointments')->where('client_id', Laralum::loggedInUser()->id)->whereBetween('apt_date', [$from_date, $to_date])->count();
		} else {
			$total_appointment = DB::table('appointments')->where('created_by', Laralum::loggedInUser()->id)->whereBetween('created_at', [$from_date, $to_date])->count();
			$pending_appointment = DB::table('appointments')->where('status', 'Pending')->where('created_by', Laralum::loggedInUser()->id)->whereBetween('created_at', [$from_date, $to_date])->count();
			$completed_appointment = DB::table('appointments')->where('status', 'Completed')->where('created_by', Laralum::loggedInUser()->id)->whereBetween('created_at', [$from_date, $to_date])->count();
			$average_booking = DB::table('appointments')->where('created_by', Laralum::loggedInUser()->id)->whereBetween('created_at', [$from_date, $to_date])->count();
			$returncustomer = DB::table('appointments')->where('created_by', Laralum::loggedInUser()->id)->groupBy('lead_id')->whereBetween('created_at', [$from_date, $to_date])->count();
			$newcustomer = DB::table('appointments')->where('created_by', Laralum::loggedInUser()->id)->groupBy('lead_id')->whereBetween('created_at', [$from_date, $to_date])->count();
			$today_appointment = DB::table('appointments')->where('created_by', Laralum::loggedInUser()->id)->whereBetween('apt_date', [$from_date, $to_date])->count();
		}

		return response()->json(array(
			'success' => true,
			'status' => 'success',
			'total_appointment' => $total_appointment,
			'pending_appointment' => $pending_appointment,
			'completed_appointment' => $completed_appointment,
			'average_booking' => round($average_booking / 30, 2),
			'today_appointment' => $today_appointment,
			'returncustomer' => $returncustomer,
			'newcustomer' => $newcustomer,
		), 200);
	}

	public function create()
	{
		Laralum::permissionToAccess('laralum.appointments.create');
		if (Laralum::loggedInUser()->isReseller == 1 && Laralum::loggedInUser()->reseller_id == 0) {
			$reseller_id = Laralum::loggedInUser()->id;
		} else {
			$reseller_id = Laralum::loggedInUser()->reseller_id;
		}
		$apt_staff = DB::table('users')->where('reseller_id', $reseller_id)->where('isAptMeet', 1)->get();
		# Return the view
		return view('crm/appointments/create', ['apt_staffs' => $apt_staff]);
	}

	public function store(Request $request)
	{
		Laralum::permissionToAccess('laralum.appointments.create');
		# Check permissions
		//Laralum::permissionToAccess('laralum.senderid.access');

		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}

		if (isset($request->searched_member_id) && !empty($request->searched_member_id)) {
			$lead_id = $request->searched_member_id;
		} else {
			$lead = new Lead;
			$lead->client_id = $client_id;
			$lead->user_id = Laralum::loggedInUser()->id;
			$lead->account_type = 'Permanent';
			$lead->department = 'Appointment';
			$lead->name = $request->name;
			$lead->email = $request->email;
			$lead->mobile = $request->phone;
			$lead->address = $request->address;
			$lead->save();

			$lead_id = $lead->id;
		}

		$appointment = new Appointment;
		$appointment->client_id = $client_id;
		$appointment->lead_id = $lead_id;
		$appointment->created_by = Laralum::loggedInUser()->id;
		$appointment->whom_to_meet = $request->whom_to_meet;
		$appointment->apt_date = $request->apt_date;
		$appointment->time_slot = $request->time_slot;
		$appointment->service_request = $request->service_request;
		$appointment->branch = Laralum::loggedInUser()->branch;
		$appointment->status = "Pending";
		$appointment->save();

		DB::table('time_slots')
			->where('staff_id', $request->whom_to_meet)
			->where('slot_date', $request->apt_date)
			->where('slot_time', $request->time_slot)
			->update([
				'status' => 'Booked',
			]);

		# Return the admin to the blogs page with a success message
		return response()->json(array('success' => true, 'status' => 'success'), 200);
	}


	public function update(Request $request)
	{
		Laralum::permissionToAccess('laralum.appointments.edit');
		# Check permissions
		//Laralum::permissionToAccess('laralum.senderid.access');

		DB::table('appointments')->where('id', $request->apt_id)->update([
			'apt_date' => $request->apt_date,
			'time_slot' => $request->time_slot,
			'whom_to_meet' => $request->whom_to_meet,
			'service_request' => $request->service_request
		]);

		DB::table('time_slots')
			->where('staff_id', $request->whom_to_meet)
			->where('slot_date', $request->apt_date)
			->where('slot_time', $request->time_slot)
			->update([
				'status' => 'Booked',
			]);

		# Return the admin to the blogs page with a success message
		return response()->json(array('success' => true, 'status' => 'success'), 200);
	}

	public function changeStatus(Request $request)
	{
		Laralum::permissionToAccess('laralum.appointments.edit');

		DB::table('appointments')->where('id', $request->appointment_id)->update([
			'status' => $request->status,
		]);

		# Return the admin to the blogs page with a success message
		return response()->json(array('success' => true, 'status' => 'success'), 200);
	}

	public function show($id)
	{
		Laralum::permissionToAccess('laralum.appointments.view');
		if (Laralum::loggedInUser()->isReseller == 1 && Laralum::loggedInUser()->reseller_id == 0) {
			$reseller_id = Laralum::loggedInUser()->id;
		} else {
			$reseller_id = Laralum::loggedInUser()->reseller_id;
		}
		$apt_staff = DB::table('users')->where('reseller_id', $reseller_id)->where('isAptMeet', 1)->get();

		# Find the appointment    	
		$appointment = DB::table('appointments')
			->where('appointments.id', $id)
			->join('leads', 'appointments.lead_id', '=', 'leads.id')
			->select('appointments.*', 'leads.name', 'leads.email', 'leads.mobile', 'leads.address')
			->first();

		$time_slots = DB::table('time_slots')
			->where('staff_id', $appointment->whom_to_meet)
			->where('slot_date', $appointment->apt_date)->get();


		# Return the view
		return view('crm/appointments/show', [
			'appointment' => $appointment,
			'apt_staffs' => $apt_staff,
			'time_slots' => $time_slots,
		]);
	}

	public function destroy(Request $request, $id)
	{
		Laralum::permissionToAccess('laralum.appointments.delete');
		# Find The Appointment
		$appointment = Laralum::appointment('id', $id);

		# Delete Appointment 
		$appointment->delete();

		# Return a redirect
		return redirect()->route('Crm::appointments')->with('success', "The appointment has been deleted");
	}

	/**
	 *@author {Previous devloper}
	 *@updatedBy {Paras}
	 *@description {Function to search member while creating donation}
	 *@return {member detail if present else member add form}
	 */
	public function searchMember(Request $request)
	{//dd($request->all());
		$data = '';
		$history_data = '';
		$member_data = null;
		if (Laralum::loggedInUser()->isReseller == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		//echo $client_id;die;
		$member_datas = DB::table('leads')->orWhere('email', $request->key)->orWhere('mobile', $request->key)->orWhere('member_id', $request->key)->first();
		if ($member_datas && $member_datas->user_id = $client_id) {
			$member_data = $member_datas;
		}

		//echo "<pre>";print_r($member_data);die;
		$address_html = '';
		if ($member_data) {
			$searched_member_id = $member_data->id;
			// if ($member_data->address != null && $member_data->address != '' && unserialize($member_data->address) != null && unserialize($member_data->address)[0] != '') {
			// 	foreach (unserialize($member_data->address) as $key => $address) {
			// 		//echo $address;
			// 		// $states = [];
			// 		// $districts = [];
			// 		// $countries = [];
			// 		// array_push($states, DB::table('state')->where('StCode', $member_data->state)->first());
			// 		// array_push($districts, DB::table('district')->where('DistCode', $$member_data->district)->first());
			// 		// array_push($countries, DB::table('countries')->where('country_code', $$member_data->country)->first());
			// 		$address_html .= '<span class="div-' . $key . '">';
			// 		$address_html .=  unserialize($member_data->address_type)[$key] == "permanent" ? "Permanent : " : "Temporary : ";
			// 		$address_html .=  $address ? ucfirst($address) : "";
			// 		$address_html .= '</span><br/>';
			// 		//$address_html = '<span>'.unserialize($member_data->address_type)[$key]=="permanent"?"Permanent :":"Temporary : ".'</span>'. ucfirst($address) ?? "";
			// 	}
			// }





			//echo "<pre>";print_r(unserialize($member_data->address));die;
			$data = '
				<div class="row">
					<input type="hidden" value="' . $member_data->id . '" id="searched_member_id" name="lead_id" />
					<div class="col-md-4">
	                    <div class="form-group">
	                        <label>Name</label><br>
	                        <span>' . $member_data->name . '</span>	
	                    </div>
	                </div>
	                <div class="col-md-4">
	                    <div class="form-group">
	                        <label>Email</label><br>
	                        <span>' . $member_data->email . '</span>
	                    </div>
	                </div>
	                <div class="col-md-4">
	                    <div class="form-group">
	                        <label>Phone No.</label><br>
	                        <span>' . $member_data->mobile . '</span>
	                    </div>
	                </div>
	            </div>
					';
				// <div class="col-md-3">
				// 	<div class="form-group">
				// 		<label><span style="color:#f9ba48;"><i class="fa fa-map-marker" aria-hidden="true"></i></span>&nbsp;Address</label></br>
				// 		<span>' . $address_html . '</span>
				// 	</div>
				// </div>
			# Donation History
			//$donations_history = DB::table('donations')->where('donations.donated_by', $searched_member_id)->get();
			$donations_history = DB::table('donations')
				->where('donations.donated_by', $searched_member_id)
				->join('leads', 'donations.donated_by', '=', 'leads.id')
				->select('donations.*', 'leads.name', 'leads.email', 'leads.mobile', 'leads.address')
				->orderBy('donations.id', 'desc')->paginate(10);

			if ($donations_history->count() > 0) {
				$history_data .= '<div class="col-md-12">';
				$history_data .= '<div class="col-md-12"><h3 class="form-heading">Donation History</h3></div>';
				$history_data .= '<table class="ui five column table">
							<thead>
							<tr>           
							<th>Receipt No</th>
							<th>Donation Type</th>
							<th>Amount</th>
							<th>Mode</th>
							<th>Status</th>
							<th>Date</th>                                       
							</tr>
							</thead>
							<tbody>';
				foreach ($donations_history as $donation) {
					$history_data .= '<tr>
								<td>
									<div class="text">' . $donation->receipt_number . '</div>
								</td>
								<td>
									<div class="text">' . $donation->payment_type . '</div>
								</td>
								<td>
									<div class="text">' . $donation->amount . '</div>
								</td>
								<td>
									<div class="text">' . ($donation->payment_mode == 'OTHER' ? $donation->payment_method : $donation->payment_mode) . '</div>
								</td>
								<td>
									<div class="text">' . ($donation->payment_status ? 'Paid' : 'Pending') . '</div>
								</td>
								<td>
									<div class="text">' . date("d/m/Y", strtotime($donation->created_at)) . '</div>
								</td>                       
							</tr>';
				}

				$history_data .= '</tbody>
				</table>';
				$history_data .= $donations_history->links() . '</div>';
			}
		} else {
			$membertypes = DB::table('member_types')->where('user_id', Laralum::loggedInUser()->id)->get();
			$data .= '
			     <div class="col-md-12"><span style="color:red;">Member not found, please add new.</span></div>
				 <div class="col-md-4">
					<div class="form-group ">
						<label>Name<span style="color:red;">*</span></label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Enter fullname" />
						<input type="hidden" value="" id="searched_member_id" name="searched_member_id" />				
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group ">
						<label>Phone No.<span style="color:red;">*</span></label>
						<input type="text" class="form-control" placeholder="Enter phone number" id="phone" name="phone" />
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group ">
						<label>Member Type</label>
						
						<select class="form-control custom-select" name="member_type" id="member_type_id">';
			foreach ($membertypes as $type) {
				$data .=	'<option value="' . $type->type . '">' . $type->type . '</option>';
			}
			$data .=		'<option value="add">Add Value</option>
						</select>
					</div>
				</div>';
		}

		return response()->json(array('data' => $data, 'history' => $history_data), 200);
	}


	public function getTimeSlots(Request $request)
	{

		$time_slots = DB::table('time_slots')
			->where('staff_id', $request->whom_to_meet)
			->where('slot_date', $request->apt_date)->get();

		if (count($time_slots) > 0) {
			$data = "";
			foreach ($time_slots as $slots) {
				if ($slots->status == 'Booked') {
					$disabled = 'disabled';
				} else {
					$disabled = '';
				}
				$data .= '
					 <div class="time-slot-col plr-5" data-toggle="tooltip" title="' . $slots->status . '">
						<div class="custom-radio-time">
							<input type="radio" name="time_slot" value="' . $slots->slot_time . '" id="r' . $slots->id . '" ' . $disabled . '>
							<label for="r' . $slots->id . '">' . date("g:i", strtotime($slots->slot_time)) . '<span>' . date("A", strtotime($slots->slot_time)) . '</span></label>
						</div>
					</div>';
			}
		} else {
			$data = '<p class="time-no-avi"><i class="frown icon"></i>Time slot is not available for <strong>' . date('d/m/Y', strtotime($request->apt_date)) . '</strong></p>';
		}



		return response()->json($data);
	}



	public function export(Request $request)
	{
		return Excel::download(new AppointmentExport($request->client_id), 'appointment.xlsx');
	}
	public function import(Request $request)
	{

		if (isset($_POST['importSubmit'])) {
			// Allowed mime types
			$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

			// Validate whether selected file is a CSV file
			if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {

				// If the file is uploaded
				if (is_uploaded_file($_FILES['file']['tmp_name'])) {

					// Open uploaded CSV file with read-only mode
					$csvFile = fopen($_FILES['file']['tmp_name'], 'r');

					// Skip the first line
					fgetcsv($csvFile);

					// Parse data from CSV file line by line
					while (($line = fgetcsv($csvFile)) !== FALSE) {
						// Get row data
						//echo '<pre>';print_r($line);die;																		
						$lead = new Lead;
						$lead->client_id = $request->import_apt_client_id;
						$lead->user_id = Laralum::loggedInUser()->id;
						$lead->account_type = 'Permanent';
						$lead->department = 'Appointment';
						$lead->name = $line[0];
						$lead->email = $line[1];
						$lead->mobile = $line[2];
						$lead->save();

						$appointment = new Appointment;
						$appointment->client_id = $request->import_apt_client_id;
						$appointment->lead_id = $lead->id;
						$appointment->created_by = Laralum::loggedInUser()->id;
						$appointment->whom_to_meet = $line[3];
						$appointment->apt_date = ($line[4] != '') ? date('Y-m-d', strtotime($line[4])) : '';
						$appointment->time_slot = $line[5];
						$appointment->service_request = $line[6];
						$appointment->branch = Laralum::loggedInUser()->branch;
						$appointment->status = "Pending";
						$appointment->save();
					}
					// Close opened CSV file
					fclose($csvFile);

					return redirect()->route('Crm::appointments')->with('success', 'Appointments data has been imported successfully.');
				} else {

					return redirect()->route('Crm::appointments')->with('error', 'Some problem occurred, please try again.');
				}
			} else {

				return redirect()->route('Crm::appointments')->with('error', 'Please upload a valid CSV file.');
			}
		}
	}
}
