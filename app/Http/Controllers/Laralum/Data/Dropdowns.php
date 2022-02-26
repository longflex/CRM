<?php

$dropdowns = [
    'users_default_active'  =>  [
        //Add all dropdown options
        [
            'value'     =>  0,
            'show'      =>  trans('laralum.dropdown_manual_activation'),
        ],
        [
            'value'     =>  1,
            'show'      =>  trans('laralum.dropdown_send_activation_mail'),
        ],
        [
            'value'     =>  2,
            'show'      =>  trans('laralum.dropdown_activated_by_default'),
        ],
    ],
    'colors_hex'  =>  [
        //Add all dropdown options
        [
            'value'     =>  '#DB2828',
            'show'      =>  trans('laralum.colors_red'),
        ],
        [
            'value'     =>  '#f26202',
            'show'      =>  trans('laralum.colors_orange'),
        ],
        [
            'value'     =>  '#eaae00',
            'show'      =>  trans('laralum.colors_yellow'),
        ],
        [
            'value'     =>  '#a7bd0d',
            'show'      =>  trans('laralum.colors_olive'),
        ],
        [
            'value'     =>  '#16ab39',
            'show'      =>  trans('laralum.colors_green'),
        ],
        [
            'value'     =>  '#009c95',
            'show'      =>  trans('laralum.colors_teal'),
        ],
        [
            'value'     =>  '#1678c2',
            'show'      =>  trans('laralum.colors_blue'),
        ],
        [
            'value'     =>  '#9627ba',
            'show'      =>  trans('laralum.colors_purple'),
        ],
        [
            'value'     =>  '#e61a8d',
            'show'      =>  trans('laralum.colors_pink'),
        ],
        [
            'value'     =>  '#975b33',
            'show'      =>  trans('laralum.colors_brown'),
        ],
        [
            'value'     =>  '#838383',
            'show'      =>  trans('laralum.colors_gray'),
        ],
        [
            'value'     =>  '#27292a',
            'show'      =>  trans('laralum.colors_black'),
        ],
    ],
    'colors_name'  =>  [
        //Add all dropdown options
        [
            'value'     =>  'red',
            'show'      =>  trans('laralum.colors_red'),
        ],
        [
            'value'     =>  'orange',
            'show'      =>  trans('laralum.colors_orange'),
        ],
        [
            'value'     =>  'yellow',
            'show'      =>  trans('laralum.colors_yellow'),
        ],
        [
            'value'     =>  'olive',
            'show'      =>  trans('laralum.colors_olive'),
        ],
        [
            'value'     =>  'green',
            'show'      =>  trans('laralum.colors_green'),
        ],
        [
            'value'     =>  'teal',
            'show'      =>  trans('laralum.colors_teal'),
        ],
        [
            'value'     =>  'blue',
            'show'      =>  trans('laralum.colors_blue'),
        ],
        [
            'value'     =>  'purple',
            'show'      =>  trans('laralum.colors_purple'),
        ],
        [
            'value'     =>  'pink',
            'show'      =>  trans('laralum.colors_pink'),
        ],
        [
            'value'     =>  'brown',
            'show'      =>  trans('laralum.colors_brown'),
        ],
        [
            'value'     =>  'gray',
            'show'      =>  trans('laralum.colors_gray'),
        ],
        [
            'value'     =>  'black',
            'show'      =>  trans('laralum.colors_black'),
        ],
    ],
    'settings_pie_chart_source' =>  [
        [
            'value' =>  'google',
            'show'  =>  'Google Charts',
        ],
        [
            'value' =>  'chartjs',
            'show'  =>  'Chart.js',
        ],
        [
            'value' =>  'highcharts',
            'show'  =>  'Highcharts',
        ],
    ],
    'settings_bar_chart_source' =>  [
        [
            'value' =>  'google',
            'show'  =>  'Google Charts',
        ],
        [
            'value' =>  'chartjs',
            'show'  =>  'Chart.js',
        ],
        [
            'value' =>  'highcharts',
            'show'  =>  'Highcharts',
        ],
    ],
    'settings_line_chart_source' =>  [
        [
            'value' =>  'google',
            'show'  =>  'Google Charts',
        ],
        [
            'value' =>  'chartjs',
            'show'  =>  'Chart.js',
        ],
        [
            'value' =>  'highcharts',
            'show'  =>  'Highcharts',
        ],
    ],
	
	'service_select_list' =>  [
        [
            'value' =>  'Promotional',
            'show'  =>  'Promotional',
        ],
        [
            'value' =>  'Transactional',
            'show'  =>  'Transactional',
        ],
        
    ],
	
	'industry_select_list' =>  [
        [
            'value' =>  'Agriculture',
            'show'  =>  'Agriculture',
        ],
        [
            'value' =>  'Automobile & Transport',
            'show'  =>  'Automobile & Transport',
        ],
		[
            'value' =>  'Ecommerce',
            'show'  =>  'Ecommerce',
        ],
		[
            'value' =>  'Education',
            'show'  =>  'Education',
        ],
		[
            'value' =>  'Financial Institution',
            'show'  =>  'Financial Institution',
        ],
		[
            'value' =>  'Gym',
            'show'  =>  'Gym',
        ],
		[
            'value' =>  'Hospitality',
            'show'  =>  'Hospitality',
        ],
		[
            'value' =>  'Information Technology',
            'show'  =>  'Information Technology',
        ],
		[
            'value' =>  'Lifestyle Clubs',
            'show'  =>  'Lifestyle Clubs',
        ],
		[
            'value' =>  'Logistics',
            'show'  =>  'Logistics',
        ],
		[
            'value' =>  'Marriage Bureau',
            'show'  =>  'Marriage Bureau',
        ],
		[
            'value' =>  'Media & Advertisement',
            'show'  =>  'Media & Advertisement',
        ],
        [
            'value' =>  'Personal Use',
            'show'  =>  'Personal Use',
        ],
		[
            'value' =>  'Political',
            'show'  =>  'Political',
        ],
		[
            'value' =>  'Public Sector',
            'show'  =>  'Public Sector',
        ],
		[
            'value' =>  'Real estate',
            'show'  =>  'Real estate',
        ],
		[
            'value' =>  'Retail & FMCG',
            'show'  =>  'Retail & FMCG',
        ],
		[
            'value' =>  'Stock and Commodity',
            'show'  =>  'Stock and Commodity',
        ],
		[
            'value' =>  'Telecom',
            'show'  =>  'Telecom',
        ],
		[
            'value' =>  'Tips And Alert',
            'show'  =>  'Tips And Alert',
        ],
		[
            'value' =>  'Travel',
            'show'  =>  'Travel',
        ],
    ],
	
	'method_select_list' =>  [
        [
            'value' =>  'POST',
            'show'  =>  'POST',
        ],
        [
            'value' =>  'GET',
            'show'  =>  'GET',
        ],
        
    ],
	
	'isSMPP_select_list' =>  [
        [
            'value' =>  '0',
            'show'  =>  'NO',
        ],
        [
            'value' =>  '1',
            'show'  =>  'YES',
        ],
        
    ],
	
	'64_encode_select_list' =>  [
        [
            'value' =>  '0',
            'show'  =>  'NO',
        ],
        [
            'value' =>  '1',
            'show'  =>  'YES',
        ],
        
    ],
	
    'settings_geo_chart_source' =>  [
        [
            'value' =>  'google',
            'show'  =>  'Google Charts',
        ],
        [
            'value' =>  'highcharts',
            'show'  =>  'Highcharts',
        ],
    ],
];
