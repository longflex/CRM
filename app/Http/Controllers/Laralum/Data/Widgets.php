<?php

// Operations here
require('WidgetsOperations.php');

// Widgets here
if(Laralum::loggedInUser()->reseller_id==0){
	$type = 'client_id';
	$data = Laralum::loggedInUser()->id;
}else{
	$type = 'created_by';
	$data = Laralum::loggedInUser()->id;
}
$widgets = [
    'latest_users_graph' =>  Laralum::lineChart($latest_users_graph['title'], $latest_users_graph['element_label'], $latest_users_graph['labels'], $latest_users_graph['data']),
    'latest_posts_graph' =>  Laralum::lineChart($latest_posts_graph['title'], $latest_posts_graph['element_label'], $latest_posts_graph['labels'], $latest_posts_graph['data']),
    'users_country_pie_graph'  =>   Laralum::pieChart($users_country_pie_graph['title'], $users_country_pie_graph['labels'], $users_country_pie_graph['data']),
    'users_country_geo_graph'  =>   Laralum::geoChart($users_country_geo_graph['title'], $users_country_geo_graph['element_label'], $users_country_geo_graph['data']),
    'roles_users'   =>  Laralum::barChart($roles_users['title'], $roles_users['element_label'], $roles_users['labels'], $roles_users['data']),
	'payment_modes'   =>  Laralum::barChart($payment_modes['title'], $payment_modes['element_label'], $payment_modes['labels'], $payment_modes['data'], $payment_modes['colors']),
	'vehicle_type_graph'   =>  Laralum::barChart($vehicle_type['title'], $vehicle_type['element_label'], $vehicle_type['labels'], $vehicle_type['data'], $vehicle_type['colors']),
	'latest_appointment_graph' =>  Laralum::lineChart($latest_appointment_graph['title'], $latest_appointment_graph['element_label'], $latest_appointment_graph['labels'], $latest_appointment_graph['data']),
	'latest_donation_graph' =>  Laralum::lineChart($latest_donation_graph['title'], $latest_donation_graph['element_label'], $latest_donation_graph['labels'], $latest_donation_graph['data']),
	'latest_member_graph' =>  Laralum::lineChart($latest_member_graph['title'], $latest_member_graph['element_label'], $latest_member_graph['labels'], $latest_member_graph['data']),
	'latest_vehicles_graph' =>  Laralum::lineChart($latest_vehicles_graph['title'], $latest_vehicles_graph['element_label'], $latest_vehicles_graph['labels'], $latest_vehicles_graph['data']),
    'basic_stats_1'   =>  "
        <div class='ui doubling stackable three column grid container'>
            <div class='column'>
                <center>
                    <div class='ui statistic'>
                        <div class='value'>
                            " . count(Laralum::users()) . "
                        </div>
                        <div class='label'>
                            " . trans('laralum.users') . "
                        </div>
                    </div>
                </center>
            </div>
            <div class='column'>
                <center>
                    <div class='ui statistic'>
                        <div class='value'>
                            " . count(Laralum::roles()) . "
                        </div>
                        <div class='label'>
                            " . trans('laralum.roles') . "
                        </div>
                    </div>
                </center>
            </div>
            <div class='column'>
                <center>
                    <div class='ui statistic'>
                        <div class='value'>
                            " . count(Laralum::permissions()) . "
                        </div>
                        <div class='label'>
                            " . trans('laralum.permissions') . "
                        </div>
                    </div>
                </center>
            </div>
        </div>
    ",
    'basic_stats_2'   =>  "
        <div class='ui doubling stackable three column grid container'>
            <div class='column'>
                <center>
                    <div class='ui statistic'>
                        <div class='value'>
                            " . count(Laralum::group('client_id', Laralum::loggedInUser()->id)) . "
                        </div>
                        <div class='label'>
                            " . trans('laralum.posts') . "
                        </div>
                    </div>
                </center>
            </div>
            <div class='column'>
                <center>
                    <div class='ui statistic'>
                        <div class='value'>
                            " . count(Laralum::postViews()) . "
                        </div>
                        <div class='label'>
                            " . trans('laralum.post_views') . "
                        </div>
                    </div>
                </center>
            </div>
            <div class='column'>
                <center>
                    <div class='ui statistic'>
                        <div class='value'>
                            " . count(Laralum::comments()) . "
                        </div>
                        <div class='label'>
                            " . trans('laralum.comments') . "
                        </div>
                    </div>
                </center>
            </div>
        </div>
    ",
	'crm_basic_stats_1'   =>  "
        <div class='ui doubling two column grid container dashboard-menu-list'>
            <div class='column dashboard-section'>
				<div class='row'>
				<div class='col-lg-8 col-lg-offset-2'>
				<div class='row'>
					<div class='col-xs-6 text-center'>
						 <i class='fa fa-address-book-o' aria-hidden='true'></i>
					</div><!--col-md-6-->
					<div class='col-xs-6 text-center'>
						
                    <div class='ui statistic'>					 
                        <div class='value'>
                          
						   " . count(Laralum::leads($type, $data)) . "
                        </div>
                        <div class='label'>
                            " . trans('laralum.leads') . "
                        </div>
                    </div>
                
					</div><!--col-md-6-->
				</div><!--row-->
				</div><!--col-md-8-->
				</div><!--row-->
            </div><!--column-->
			</hr>
			<div class='column dashboard-section'>
				<div class='row'>
				<div class='col-md-12'>
				<div class='row'>
					<div class='col-md-4 col-xs-6 text-center'>
						 <i class='far fa-calendar-check'></i>
					</div><!--col-md-4-->
					<div class='col-md-7 col-xs-6 text-center'>
						
                    <div class='ui statistic'>					 
                        <div class='value'>
						   " . count(Laralum::appointments($type, $data)) . "
                        </div>
                        <div class='label'>
                            " . trans('laralum.appointments') . "
                        </div>
                    </div>
                
					</div><!--col-md-7-->
				</div><!--row-->
				</div><!--col-md-12-->
				</div><!--row-->
            </div><!--column-->
        </div>
    ",
	'crm_basic_stats_2'   =>  "
        <div class='ui doubling stackable two column grid container dashboard-menu-list'> 
            <div class='column dashboard-section'>
				<div class='row'>
				<div class='col-md-12'>
				<div class='row'>
					<div class='col-md-4 col-xs-6 text-center'>
						 <i class='fas fa-donate' aria-hidden='true'></i>
					</div><!--col-md-4-->
					<div class='col-md-6 col-xs-6 text-center'>
						
                    <div class='ui statistic'>					 
                        <div class='value'>
                            " . count(Laralum::donations($type, $data)) . "
                        </div>
                        <div class='label'>
                            " . trans('laralum.donations') . "
                        </div>
                    </div>
                
					</div><!--col-md-6-->
				</div><!--row-->
				</div><!--col-md-12-->
				</div><!--row-->
            </div><!--column-->
			
			<div class='column dashboard-section'>
				<div class='row'>
				<div class='col-md-12'>
				<div class='row'>
					<div class='col-md-4 col-xs-6 text-center'>
						 <i class='fa fa-car' aria-hidden='true'></i>
					</div><!--col-md-4-->
					<div class='col-md-6 col-xs-6 text-center'>
						
                    <div class='ui statistic'>					 
                        <div class='value'>
                            " . count(Laralum::vehicles($type, $data)) . "
                        </div>
                        <div class='label'>
                            " . trans('laralum.vehicle_title') . "
                        </div>
                    </div>
                
					</div><!--col-md-6-->
				</div><!--row-->
				</div><!--col-md-12-->
				</div><!--row-->
            </div><!--column-->
			
        </div>
    ",
];
