@extends('layouts.admin.panel')
@section('breadcrumb')
     <div class="ui breadcrumb">
        <div class="active section">{{  trans('laralum.bank_list') }}</div>
    </div>
@endsection
@section('title', trans('laralum.bank_details'))
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
  <div class="ui one column doubling stackable grid container">
  	<div class="column">
	 <a href="{{ route('Laralum::bank_create') }}" class="res_ex ui {{ Laralum::settings()->button_color }} button">
      <i class="fa fa-plus icon_m" aria-hidden="true"></i><span>{{ trans('laralum.create_bank') }}</span>
     </a>
  		<div class="ui very padded segment">
		    <div class="table-responsive">
			<table class="table1 table-striped table-bordered" id="example">
  			  <thead>
  			    <tr class="table-head">
				  <th width="5%">S.N</th>
				  <th width="13%">Bank</th>
                  <th width="15%">IFSC Code</th>
                  <th width="15%">Ac/No</th>
				  <th width="15%">Ac/Name</th>
				  <th width="30%">Address</th>
				  <th width="7%">Action</th>
  			    </tr>
  			  </thead>
  			  <tbody>
                  @foreach($banks as $key=>$val)
					<tr id="bankList{{ $val->id }}">
					
						<td>
                          <div class="text">
						  {{ ++$key }}
                          </div>
                        </td>
                        <td>
                           <div class="text">
                            {{ $val->bank }}
                           </div>
                        </td>
                        <td>
                           <div class="text">
                              {{ $val->ifsc_code }}
                           </div>
                        </td>
                        <td>
                          <div class="text">
                              {{ $val->ac_number }}
                           </div>
                        </td>
                        <td>
                          <div class="text">
                               {{ $val->ac_name  }}
                           </div>
						</td>
						 <td>
                          <div class="text">
						     {{ $val->address }}
                           </div>
						</td>
						 <td>
                          <div class="text">
						      <button class="ui teal top icon left pointing button" value="{{ $val->id }}" id="deleteBank" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                           </div>
						</td>
						
					</tr>
				@endforeach
  			  </tbody>
  			</table>
			
  		</div>
  		</div>
		
        <br>
  	</div>
  </div>

<!--contact-table-only-search-->
<script>
$(document).ready(function() {
    $('#example').DataTable( {
        "ordering": false,
    } );
} );
//deletebank and remove it from list
$(document).on('click','#deleteBank',function(){
	var my_url = "{{ url('admin/bankDeleteAction') }}";
	var urldashboard = "{{ url('admin') }}";
	var entry_id = $(this).val();
	var type = "POST"; 
	 $.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		}
	})
	var formData = {
		entry_id: entry_id,
	}
	 swal({
		title: "Are you sure?",
		text: "You will not be able to recover this!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Yes, I am sure!',
		cancelButtonText: "No, cancel it!",
		closeOnConfirm: false,
		closeOnCancel: false
	},
	function(isConfirm) {
		if (isConfirm) {
			swal({
				title: 'Confirmed!',
				text: 'Bank details is successfully deleted!',
				type: 'success'
			}, function() {
				$.ajax({
					type: type,
					url: my_url,
					data: formData,
					dataType: 'json',
					success: function (data) {
						console.log(data);
						$("#bankList" + entry_id).remove();
					
					},
					error: function (data) {
						console.log('Error:', data);
					}
				});
			});
			
		} else {
			swal("Cancelled", "Your details is safe :)", "error");
		}
	});
	
});
</script>
	
<style>
.inp
{
	width:100%;
	height:40px;
	line-height:40px;
	padding-left:7px;
	border:1px #ccc solid;
	border-radius:3px;
}

.inp:focus
{
	border:1px #008c86 solid;
	outline:none;
	text-align:left;
}

</style>
<!--editable-table-->
<!--contact-table-only-search-->
@endsection
