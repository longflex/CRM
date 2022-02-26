<?php
$countries = Laralum::countries();
if(Laralum::loggedInUser()->reseller_id==0){
	$type = 'client_id';
	$data = Laralum::loggedInUser()->id;
}else{
	$type = 'created_by';
	$data = Laralum::loggedInUser()->id;
}
/*
|--------------------------------------------------------------------------
| latest_appointment_graph
|--------------------------------------------------------------------------
*/

$latest_appointment_graph['labels'] = array_reverse([
    date("F j, Y"),
    date("F j, Y", strtotime("-1 Day")),
    date("F j, Y", strtotime("-2 Day")),
    date("F j, Y", strtotime("-3 Day")),
    date("F j, Y", strtotime("-4 Day")),
]);

    if(Laralum::loggedInUser()->reseller_id==0){
	  $latest_appointment_graph['data'] = array_reverse([
		count(App\Appointment::where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d"))->get()),
		count(App\Appointment::where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-1 Day")))->get()),
		count(App\Appointment::where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-2 Day")))->get()),
		count(App\Appointment::where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-3 Day")))->get()),
		count(App\Appointment::where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-4 Day")))->get()),
		]);
	}else{
	  $latest_appointment_graph['data'] = array_reverse([	
		count(App\Appointment::where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d"))->get()),
		count(App\Appointment::where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-1 Day")))->get()),
		count(App\Appointment::where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-2 Day")))->get()),
		count(App\Appointment::where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-3 Day")))->get()),
		count(App\Appointment::where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-4 Day")))->get()),
	  ]);
	}

$latest_appointment_graph['element_label'] = trans('laralum.users_total_appointments');
$latest_appointment_graph['title'] = trans('laralum.appointments_graph1');

/*
|--------------------------------------------------------------------------
| latest_donation_graph
|--------------------------------------------------------------------------
*/

$latest_donation_graph['labels'] = array_reverse([
    date("F j, Y"),
    date("F j, Y", strtotime("-1 Day")),
    date("F j, Y", strtotime("-2 Day")),
    date("F j, Y", strtotime("-3 Day")),
    date("F j, Y", strtotime("-4 Day")),
    date("F j, Y", strtotime("-5 Day")),
    date("F j, Y", strtotime("-6 Day")),
]);

    if(Laralum::loggedInUser()->reseller_id==0){
	  $latest_donation_graph['data'] = array_reverse([
			App\Donation::where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d"))->sum('amount'),
			App\Donation::where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-1 Day")))->sum('amount'),
			App\Donation::where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-2 Day")))->sum('amount'),
			App\Donation::where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-3 Day")))->sum('amount'),
			App\Donation::where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-4 Day")))->sum('amount'),
			App\Donation::where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-5 Day")))->sum('amount'),
			App\Donation::where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-6 Day")))->sum('amount'),
		]);
	}else{
	  $latest_donation_graph['data'] = array_reverse([	
			App\Donation::where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d"))->sum('amount'),
			App\Donation::where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-1 Day")))->sum('amount'),
			App\Donation::where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-2 Day")))->sum('amount'),
			App\Donation::where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-3 Day")))->sum('amount'),
			App\Donation::where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-4 Day")))->sum('amount'),
			App\Donation::where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-5 Day")))->sum('amount'),
			App\Donation::where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-6 Day")))->sum('amount'),
	  ]);
	}

$latest_donation_graph['element_label'] = trans('laralum.users_total_donations');
$latest_donation_graph['title'] = trans('laralum.donations_graph1');


/*
|--------------------------------------------------------------------------
| latest_vehicles_graph
|--------------------------------------------------------------------------
*/

$latest_vehicles_graph['labels'] = array_reverse([
    date("F j, Y"),
    date("F j, Y", strtotime("-1 Day")),
    date("F j, Y", strtotime("-2 Day")),
    date("F j, Y", strtotime("-3 Day")),
    date("F j, Y", strtotime("-4 Day")),
    date("F j, Y", strtotime("-5 Day")),
    date("F j, Y", strtotime("-6 Day")),
]);

    if(Laralum::loggedInUser()->reseller_id==0){
	  $latest_vehicles_graph['data'] = array_reverse([
		count(App\Vehicle::where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d"))->get()),
		count(App\Vehicle::where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-1 Day")))->get()),
		count(App\Vehicle::where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-2 Day")))->get()),
		count(App\Vehicle::where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-3 Day")))->get()),
		count(App\Vehicle::where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-4 Day")))->get()),
		count(App\Vehicle::where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-5 Day")))->get()),
		count(App\Vehicle::where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-6 Day")))->get()),
		]);
	}else{
	  $latest_vehicles_graph['data'] = array_reverse([	
		count(App\Vehicle::where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d"))->get()),
		count(App\Vehicle::where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-1 Day")))->get()),
		count(App\Vehicle::where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-2 Day")))->get()),
		count(App\Vehicle::where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-3 Day")))->get()),
		count(App\Vehicle::where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-4 Day")))->get()),
		count(App\Vehicle::where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-5 Day")))->get()),
		count(App\Vehicle::where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-6 Day")))->get()),
	  ]);
	}

$latest_vehicles_graph['element_label'] = trans('laralum.vehicle_total');
$latest_vehicles_graph['title'] = trans('laralum.vehicle_graph_last_7day');


/*
|--------------------------------------------------------------------------
| latest_member_graph
|--------------------------------------------------------------------------
*/

$latest_member_graph['labels'] = array_reverse([
    date("F j, Y"),
    date("F j, Y", strtotime("-1 Day")),
    date("F j, Y", strtotime("-2 Day")),
    date("F j, Y", strtotime("-3 Day")),
    date("F j, Y", strtotime("-4 Day")),
    date("F j, Y", strtotime("-5 Day")),
    date("F j, Y", strtotime("-6 Day")),
]);

    if(Laralum::loggedInUser()->reseller_id==0){
	  $latest_member_graph['data'] = array_reverse([
		count(App\Lead::where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d"))->get()),
		count(App\Lead::where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-1 Day")))->get()),
		count(App\Lead::where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-2 Day")))->get()),
		count(App\Lead::where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-3 Day")))->get()),
		count(App\Lead::where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-4 Day")))->get()),
		count(App\Lead::where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-5 Day")))->get()),
		count(App\Lead::where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-6 Day")))->get()),
		]);
	}else{
	  $latest_member_graph['data'] = array_reverse([	
		count(App\Lead::where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d"))->get()),
		count(App\Lead::where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-1 Day")))->get()),
		count(App\Lead::where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-2 Day")))->get()),
		count(App\Lead::where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-3 Day")))->get()),
		count(App\Lead::where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-4 Day")))->get()),
		count(App\Lead::where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-5 Day")))->get()),
		count(App\Lead::where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d", strtotime("-6 Day")))->get()),
	  ]);
	}

$latest_member_graph['element_label'] = trans('laralum.members_total_graph');
$latest_member_graph['title'] = trans('laralum.members_graph_last_5_days');

/*
|--------------------------------------------------------------------------
| latest_users_graph
|--------------------------------------------------------------------------
*/

$latest_users_graph['labels'] = array_reverse([
    date("F j, Y"),
    date("F j, Y", strtotime("-1 Day")),
    date("F j, Y", strtotime("-2 Day")),
    date("F j, Y", strtotime("-3 Day")),
    date("F j, Y", strtotime("-4 Day")),
]);
$latest_users_graph['data'] = array_reverse([
    count(App\User::whereDate('created_at', '=', date("Y-m-d"))->get()),
    count(App\User::whereDate('created_at', '=', date("Y-m-d", strtotime("-1 Day")))->get()),
    count(App\User::whereDate('created_at', '=', date("Y-m-d", strtotime("-2 Day")))->get()),
    count(App\User::whereDate('created_at', '=', date("Y-m-d", strtotime("-3 Day")))->get()),
    count(App\User::whereDate('created_at', '=', date("Y-m-d", strtotime("-4 Day")))->get()),
]);
$latest_users_graph['element_label'] = trans('laralum.users_total_users');
$latest_users_graph['title'] = trans('laralum.users_graph1');

/*
|--------------------------------------------------------------------------
| latest_posts_graph
|--------------------------------------------------------------------------
*/

$latest_posts_graph['labels'] = array_reverse([
    date("F j, Y"),
    date("F j, Y", strtotime("-1 Day")),
    date("F j, Y", strtotime("-2 Day")),
    date("F j, Y", strtotime("-3 Day")),
    date("F j, Y", strtotime("-4 Day")),
]);
$latest_posts_graph['data'] = array_reverse([
    count(App\Post::whereDate('created_at', '=', date("Y-m-d"))->get()),
    count(App\Post::whereDate('created_at', '=', date("Y-m-d", strtotime("-1 Day")))->get()),
    count(App\Post::whereDate('created_at', '=', date("Y-m-d", strtotime("-2 Day")))->get()),
    count(App\Post::whereDate('created_at', '=', date("Y-m-d", strtotime("-3 Day")))->get()),
    count(App\Post::whereDate('created_at', '=', date("Y-m-d", strtotime("-4 Day")))->get()),
]);
$latest_posts_graph['element_label'] = trans('laralum.posts_new_posts');
$latest_posts_graph['title'] = trans('laralum.posts_graph3');

/*
|--------------------------------------------------------------------------
| users_per_roles_graph
|--------------------------------------------------------------------------
*/
$roles_users['labels'] = [];
$roles_users['data'] = [];
foreach(Laralum::roles() as $role) {
    array_push($roles_users['labels'], $role->name);
    array_push($roles_users['data'], count($role->users));
}
$roles_users['element_label'] = trans('laralum.users');
$roles_users['title'] = trans('laralum.roles_graph1');

/*
|--------------------------------------------------------------------------
| total_amount_per_payment_mode_graph
|--------------------------------------------------------------------------
*/
$payment_modes['labels'] = [];
$payment_modes['data'] = [];
$payment_modes['colors'] = [];
foreach(Laralum::paymentModes() as $mode) {
    array_push($payment_modes['labels'], $mode->name);
    array_push($payment_modes['data'], Laralum::donationAmount($type, $data, $mode->name));
    array_push($payment_modes['colors'], $mode->color);
}
$payment_modes['element_label'] = trans('laralum.users_total_donations');
$payment_modes['title'] = trans('laralum.donations_graph2');

/*
|--------------------------------------------------------------------------
| total_vehicle_per_vehicle_type_graph
|--------------------------------------------------------------------------
*/
$vehicle_type['labels'] = [];
$vehicle_type['data'] = [];
$vehicle_type['colors'] = [];
foreach(Laralum::vehicleType() as $types) {
    array_push($vehicle_type['labels'], $types->name);
    array_push($vehicle_type['data'], count(Laralum::vehicleCount($type, $data, $types->id)));
    array_push($vehicle_type['colors'], $types->color);
}
$vehicle_type['element_label'] = trans('laralum.vehicle_title');
$vehicle_type['title'] = trans('laralum.vehicle_graph1');


/*
|--------------------------------------------------------------------------
| users_country_pie_graph
|--------------------------------------------------------------------------
*/

$g_labels = [];
foreach(Laralum::users() as $user){
    $add = true;
    foreach($g_labels as $g_label) {
        if($g_label == $user->country_code){
            $add = false;
        }
    }
    if($add) {
        array_push($g_labels,$user->country_code);
    }
}


$users_country_pie_graph['title'] = trans('laralum.users_graph2');
$users_country_pie_graph['labels'] = [];
$users_country_pie_graph['data'] = [];
foreach($g_labels as $g_label){
    array_push($users_country_pie_graph['labels'],$countries[$g_label]);
    array_push($users_country_pie_graph['data'], count(Laralum::users('country_code', $g_label)) );
}

/*
|--------------------------------------------------------------------------
| users_country_geo_graph
|--------------------------------------------------------------------------
*/

$g_labels = [];
foreach(Laralum::users() as $user){
    $add = true;
    foreach($g_labels as $g_label) {
        if($g_label == $user->country_code){
            $add = false;
        }
    }
    if($add) {
        array_push($g_labels,$user->country_code);
    }
}

$users_country_geo_graph['title'] = trans('laralum.users_graph2');
$users_country_geo_graph['element_label'] = trans('laralum.users');
$users_country_geo_graph['data'] = [];
foreach($g_labels as $g_label){
    array_push($users_country_geo_graph['data'], [$g_label, count(Laralum::users('country_code', $g_label))] );
}
