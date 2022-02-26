@extends('layouts.console.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <div class="active section">{{ trans('laralum.banners_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.banners_title'))
@section('icon', "star")
@section('subtitle', trans('laralum.banners_subtitle'))
@section('content')
  <div class="ui one column doubling stackable grid container">
  	<div class="column">	
	<a href="{{ route('console::banner_create') }}" class="res_ex ui {{ Laralum::settings()->button_color }} button">
    <i class="fa fa-plus icon_m" aria-hidden="true"></i><span>{{ trans('laralum.banners_create_title') }}</span></a>
  		<div class="ui very padded segment">
		 @if(count($banners) > 0)
  			<table class="ui table ">
  			  <thead>
  			    <tr>
                  <th>{{ trans('laralum.banners_id') }}</th>
                  <th>{{ trans('laralum.banners_name') }}</th>
                  <th>{{ trans('laralum.banners_created') }}</th>                  
                  <th>{{ trans('laralum.options') }}</th>
  			    </tr>
  			  </thead>
  			  <tbody>
                @foreach($banners as $banner)
					<tr>
					    <td>{{ $banner->id }}</td>
						<td>
                            <div class="text">
                                {{ $banner->title }}
                            </div>
                        </td>
						
						<td>{{ $banner->created_at }}</td>
						                 
                        <td>                          
						  <div class="ui {{ Laralum::settings()->button_color }} top icon left pointing dropdown button">
							<i class="configure icon"></i>
							<div class="menu">
							  <div class="header">{{ trans('laralum.editing_options') }}</div>
							  <a href="{{ route('console::banner_edit', ['id' => $banner->id]) }}" class="item">
								<i class="edit icon"></i>
								{{ trans('laralum.banners_edit_title') }}
							  </a>                                  
							  
							  <!--div class="header">{{ trans('laralum.advanced_options') }}</div>
							  <a href="javascript:void(0);" onclick="deleteTestimonial({{ $banner->id }});" class="item">
								<i class="trash bin icon"></i>
								{{ trans('laralum.testimonials_delete') }}
							  </a-->
							 
							</div>
						  </div>                         
						</td>
					</tr>
				@endforeach
  			  </tbody>
  			</table>
			@else
                <div class="ui negative icon message">
                    <i class="frown icon"></i>
                    <div class="content">
                        <div class="header">
                            {{ trans('laralum.missing_title') }}
                        </div>
                        <p>{{ trans('laralum.missing_subtitle', ['element'  =>  "banner"]) }}</p>
                    </div>
                </div>
            @endif
  		</div>
        <br>
  	</div>
  </div>
@endsection