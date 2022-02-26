@extends('layouts.console.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <a class="section" href="{{ route('console::enquiry') }}">{{  trans('laralum.enquiry_title') }}</a>
        <i class="right angle icon divider"></i>
        <div class="active section">{{ trans('laralum.enquiry_subtitle', ['name' => $enquiry->name]) }}</div>
    </div>
@endsection
@section('title', trans('laralum.enquiry_title'))
@section('icon', "plus")
@section('subtitle', trans('laralum.enquiry_title'))
@section('content')
<div class="ui one column doubling stackable grid container">
    <div class="three wide column"></div>
	<div class="ui very padded segment">
    <div class="fifteen wide column">      
		 	
		<div class="row">
			<div class="col-md-6">
                    <table class="ui table">
						<tbody>
						
                        <tr>
                            <th>Name</th>
                            <td>{{ $enquiry->name }}</td>
                        </tr>
						
                        <tr>
                            <th>Email</th>
                            <td>{{ $enquiry->email }}</td>
                        </tr>
						
                        <tr>
                            <th>Phone No.</th>
                            <td>{{ $enquiry->phone }}</td>
                        </tr>
						
                        <tr>
                            <th>Message</th>
                            <td>{{ $enquiry->message }}</td>
                        </tr>
						
                        <tr>
                            <th>Date</th>
                            <td>{{ $enquiry->created_at }}</td>
                        </tr>
						
						</tbody>
					</table>
                </div>			
		</div>
     </div>
    </div>
    <div class="three wide column"></div>
</div>

<style>
.ui.table tr th {
    border-top: 1px solid rgba(34,36,38,.1);
}
</style>

<script>
$(document).ready(function() {
  $('.dimmer').removeClass('dimmer');
});
</script>
@endsection