@extends('layouts.console.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <div class="active section">{{ trans('laralum.permissions_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.permissions_title'))
@section('icon', "lightning")
@section('subtitle', trans('laralum.permissions_subtitle'))
@section('content')
  <div class="ui one column doubling stackable grid container">
  	<div class="column">
	@if(Laralum::loggedInUser()->hasPermission('laralum.permissions.create'))
	<a href="{{ route('console::permissions_create') }}" class="res_ex ui {{ Laralum::settings()->button_color }} button">
    <i class="fa fa-plus icon_m" aria-hidden="true"></i><span>{{ trans('laralum.create_permission') }}</span></a>
	@endif
  		<div class="ui very padded segment">
        
  			<table class="ui table">
  			  <thead>
  			    <tr>
                  <th>{{ trans('laralum.name') }}</th>
                  <th>{{ trans('laralum.description') }}</th>
                  <th>{{ trans('laralum.slug') }}</th>
                  <th>{{ trans('laralum.roles') }}</th>
                  <!-- <th>{{ trans('laralum.options') }}</th> -->
  			    </tr>
  			  </thead>
  			  <tbody>
                @foreach($permissions as $perm)
					<tr>
						<td>
                            <div class="text">
                                {{ $perm->permission }}
                            </div>
                        </td>
                        <td>
                            <div class="text">
                                {{ $perm->slug }}
                            </div>
                        </td>
                        <td>
                            <div class="text">
                                {{ $perm->slug }}
                            </div>
                        </td>
                        <td>{{ trans('laralum.permissions_roles', ['number' => count($perm->roles)]) }}</td>
                      <!--   <td>
                          @if(Laralum::loggedInUser()->hasPermission('laralum.permissions.edit') or (Laralum::loggedInUser()->hasPermission('laralum.permissions.delete') and !$perm->su))
                              <div class="ui {{ Laralum::settings()->button_color }} top icon left pointing dropdown button">
                                <i class="configure icon"></i>
                                <div class="menu">
                                  <div class="header">{{ trans('laralum.editing_options') }}</div>
                                  <a href="{{ route('console::permissions_edit', ['id' => $perm->id]) }}" class="item">
                                    <i class="edit icon"></i>
                                    {{ trans('laralum.permissions_edit') }}
                                  </a>
                                  @if(Laralum::loggedInUser()->hasPermission('laralum.permissions.delete') and !$perm->su)
                                  <div class="header">{{ trans('laralum.advanced_options') }}</div>
                                  <a href="{{ route('console::permissions_delete', ['id' => $perm->id]) }}" class="item">
                                    <i class="trash bin icon"></i>
                                    {{ trans('laralum.permissions_delete') }}
                                  </a>
                                  @endif
                                </div>
                              </div>
                          @else
                              <div class="ui disabled {{ Laralum::settings()->button_color }} icon button">
                                  <i class="lock icon"></i>
                              </div>
                          @endif
						</td> -->
					</tr>
				@endforeach
  			  </tbody>
  			</table>
		
  		
        </div>
		
        <br>
  	</div>
  </div>
  <!--data-tables-->
  <!--link href="{{ asset(Laralum::publicPath() .'/css/bootstrap.min.css') }}" type="text/css" rel="stylesheet">
	<script src="{{ asset(Laralum::publicPath() .'/js/bootstrap.min.js') }}" type="text/javascript"></script-->
	
@endsection
