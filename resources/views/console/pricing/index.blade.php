@extends('layouts.console.panel')
@section('breadcrumb')   
   <div class="ui breadcrumb">
		 <a class="section" href="{{ route('console::manage_module') }}">{{ trans('laralum.module_manager') }}</a>
          <i class="right angle icon divider"></i>
         <div class="active section">{{ trans('laralum.pricing_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.pricing_title'))
@section('icon', "star")
@section('subtitle', trans('laralum.products_subtitle'))
@section('content')
  <div class="ui one column doubling stackable grid container">
  	<div class="column">	
	<a href="{{ route('console::pricing_create') }}" class="res_ex ui {{ Laralum::settings()->button_color }} button">
    <i class="fa fa-plus icon_m" aria-hidden="true"></i><span>{{ trans('laralum.pricing_create') }}</span></a>
  		<div class="ui very padded segment">
		 @if(count($pricing) > 0)
  			<table class="ui table ">
  			  <thead>
  			    <tr>
                  <th>Product</th>
                  <th>Flat Price</th>
                  <th>GST Extra(%)</th>
                  <th>Min Purchase</th>
                  <th>&nbsp;</th>
  			    </tr>
  			  </thead>
  			  <tbody>
                @foreach($pricing as $price)
					<tr>
					    @if($price->product==2)
					    <td>{{ $price->product_type }} - {{ $price->sms_type }}</td>
					    @else
						<td>{{ $price->product_type }}</div>
						@endif
						<td>
                            <div class="text">
                                {{ $price->flat }}
                            </div>
                        </td>
						<td>
						   <div class="text">						      						   
                              {{ $price->gst_extra }} 
                            </div>
						</td>
                        <td>
						   <div class="text">						      						   
                              {{ $price->min_purchase }}
                            </div>
						</td>						
                        <td>                          
						  <div class="ui {{ Laralum::settings()->button_color }} top icon left pointing dropdown button">
							<i class="configure icon"></i>
							<div class="menu">
							  <div class="header">{{ trans('laralum.editing_options') }}</div>
								  <a href="{{ route('console::pricing_edit', ['id' => $price->id]) }}" class="item">
									<i class="edit icon"></i>
									{{ trans('laralum.pricing_edit') }}
								  </a>                                  							  
							  <div class="header">{{ trans('laralum.advanced_options') }}</div>
								  <a href="javascript:void(0);" onclick="deleteIndustry({{ $price->id }});" class="item">
									<i class="trash bin icon"></i>
									{{ trans('laralum.pricing_delete') }}
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
                        <p>{{ trans('laralum.missing_subtitle', ['element'  =>  "price range"]) }}</p>
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
		text: "You will not be able to recover this price range!",
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
				text: 'Price range has been deleted!',
				type: 'success'
			}, function() {
				$.ajax({
					type: 'post',
					url: "{{ route('console::pricing_delete') }}",
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
			swal("Cancelled", "Your price range is safe :)", "error");
			location.reload();
		}
	});
	
}
/*delete industry*/
</script>
@endsection