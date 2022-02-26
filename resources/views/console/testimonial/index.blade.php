@extends('layouts.console.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <div class="active section">{{ trans('laralum.testimonials_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.testimonials_title'))
@section('icon', "star")
@section('subtitle', trans('laralum.testimonials_subtitle'))
@section('content')
  <div class="ui one column doubling stackable grid container">
  	<div class="column">	
	<a href="{{ route('console::testimonial_create') }}" class="res_ex ui {{ Laralum::settings()->button_color }} button">
    <i class="fa fa-plus icon_m" aria-hidden="true"></i><span>{{ trans('laralum.testimonials_create_title') }}</span></a>
  		<div class="ui very padded segment">
		 @if(count($testimonials) > 0)
  			<table class="ui table ">
  			  <thead>
  			    <tr>
                  <th>{{ trans('laralum.testimonials_id') }}</th>
                  <th>{{ trans('laralum.testimonials_name') }}</th>
                  <th>{{ trans('laralum.testimonials_created') }}</th>
                  <th>{{ trans('laralum.testimonials_updated') }}</th>
                  <th>{{ trans('laralum.options') }}</th>
  			    </tr>
  			  </thead>
  			  <tbody>
                @foreach($testimonials as $testimonial)
					<tr>
					    <td>{{ $testimonial->id }}</td>
						<td>
                            <div class="text">
                                {{ $testimonial->company_name }}
                            </div>
                        </td>
						<td>{{ $testimonial->created_at }}</td>
						<td>{{ $testimonial->updated_at }}</td>                        
                        <td>                          
						  <div class="ui {{ Laralum::settings()->button_color }} top icon left pointing dropdown button">
							<i class="configure icon"></i>
							<div class="menu">
							  <div class="header">{{ trans('laralum.editing_options') }}</div>
							  <a href="{{ route('console::testimonial_edit', ['id' => $testimonial->id]) }}" class="item">
								<i class="edit icon"></i>
								{{ trans('laralum.testimonials_edit') }}
							  </a>                                  
							  
							  <div class="header">{{ trans('laralum.advanced_options') }}</div>
							  <a href="javascript:void(0);" onclick="deleteTestimonial({{ $testimonial->id }});" class="item">
								<i class="trash bin icon"></i>
								{{ trans('laralum.testimonials_delete') }}
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
                        <p>{{ trans('laralum.missing_subtitle', ['element'  =>  "testimonial"]) }}</p>
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
/*delete testimonial*/
function deleteTestimonial(id){	
	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		})  
	
	 swal({
		title: "Are you sure?",
		text: "You will not be able to recover this testimonial!",
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
				text: 'Testimonial is successfully deleted!',
				type: 'success'
			}, function() {
				$.ajax({
					type: 'post',
					url: "{{ route('console::testimonial_delete') }}",
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
			swal("Cancelled", "Your testimonial is safe :)", "error");
			location.reload();
		}
	});
	
}
/*delete testimonial*/
</script>
@endsection