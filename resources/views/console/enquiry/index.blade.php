@extends('layouts.console.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <div class="active section">{{ trans('laralum.enquiry_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.enquiry_title'))
@section('icon', "star")
@section('subtitle', trans('laralum.enquiry_title'))
@section('content')
  <div class="ui one column doubling stackable grid container">
  	<div class="column">	
  		<div class="ui very padded segment">
		 @if(count($enquires) > 0)
  			<table class="ui table ">
  			  <thead>
  			    <tr>
                  <th>S.N.</th>
                  <th>Enquiry</th>
                  <th>Date</th>
                  <th>&nbsp;</th>
  			    </tr>
  			  </thead>
  			  <tbody>
                @foreach($enquires as $key=>$enquiry)
					<tr  class="{{ ($enquiry->is_new == 1) ? 'table-success' : 'table-warning' }}">
                        <td>
                            <div class="text">
							{{ $key+1 }}
                            </div>
                        </td>					
						<td>
                            <div class="text">
							{{ ($enquiry->is_new == 1) ? 'New' : '' }} Enquiry From <strong>{{ $enquiry->name }}</strong>
                            </div>
                        </td>
						<td>
                            <div class="text">
							{{  date("d/m/Y", strtotime($enquiry->created_at)) }}
                            </div>
                        </td>
						<td>
                         <a href="{{ route('console::enquiry_details', ['id' => $enquiry->id]) }}" class="res_ex ui {{ Laralum::settings()->button_color }} button">
                           <i class="fa fa-eye icon_m" aria-hidden="true"></i><span>VIEW</span></a>
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
                        <p>{{ trans('laralum.missing_subtitle', ['element'  =>  "enquiry"]) }}</p>
                    </div>
                </div>
            @endif
  		</div>
        <br>
  	</div>
  </div>
@endsection
@section('js')
@endsection