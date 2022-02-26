@extends('layouts.console.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <div class="active section">{{ trans('laralum.industries_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.industries_title'))
@section('icon', "star")
@section('subtitle', trans('laralum.industries_subtitle'))
@section('content')
  <div class="ui one column doubling stackable grid container">
  	<div class="column">	
	<a href="{{ route('console::industries_create') }}" class="res_ex ui {{ Laralum::settings()->button_color }} button">
    <i class="fa fa-plus icon_m" aria-hidden="true"></i><span>{{ trans('laralum.industries_create_title') }}</span></a>
  		<div class="ui very padded segment">
		 @if(count($industries) > 0)
  			<table class="ui table ">
  			  <thead>
  			    <tr>
                  <th>{{ trans('laralum.industries_id') }}</th>
                  <th>{{ trans('laralum.industries_name') }}</th>
                  <th>{{ trans('laralum.industries_descrption') }}</th>
                  <th>{{ trans('laralum.options') }}</th>
  			    </tr>
  			  </thead>
  			  <tbody>
                @foreach($industries as $industry)
					<tr>
					    <td>{{ $industry->id }}</td>
						<td>
                            <div class="text">
                                {{ $industry->title }}
                            </div>
                        </td>
						<td>
						   <div class="text">						      						   
                              {{ Illuminate\Support\Str::limit($industry->description, 80, $end=' ....') }}  
                            </div>
						</td>						                   
                        <td>                          
						  <div class="ui {{ Laralum::settings()->button_color }} top icon left pointing dropdown button">
							<i class="configure icon"></i>
							<div class="menu">
							  <div class="header">{{ trans('laralum.editing_options') }}</div>
								  <a href="{{ route('console::industries_edit', ['id' => $industry->id]) }}" class="item">
									<i class="edit icon"></i>
									{{ trans('laralum.industries_edit') }}
								  </a>                                  							  
							  <div class="header">{{ trans('laralum.advanced_options') }}</div>
								  <a href="javascript:void(0);" onclick="deleteIndustry({{ $industry->id }});" class="item">
									<i class="trash bin icon"></i>
									{{ trans('laralum.industries_delete') }}
								  </a>							 
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
                        <p>{{ trans('laralum.missing_subtitle', ['element'  =>  "industry"]) }}</p>
                    </div>
                </div>
            @endif
  		</div>
        <br>
  	</div>
  </div>
@endsection
@section('js')
<script>
/*delete industry*/
function deleteIndustry(id){	
	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		})  
	
	 swal({
		title: "Are you sure?",
		text: "You will not be able to recover this industry!",
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
				text: 'Industry has been deleted!',
				type: 'success'
			}, function() {
				$.ajax({
					type: 'post',
					url: "{{ route('console::industries_delete') }}",
					data: {id:id},
					success: function (data) {			
						if(data.status=='success'){
							 location.reload();
						}else {				
							alert(data.message);
						}
					}
				})
			});
			
		} else {
			swal("Cancelled", "Your industry is safe :)", "error");
			location.reload();
		}
	});
	
}
/*delete industry*/
</script>
@endsection