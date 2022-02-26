@extends('layouts.console.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <div class="active section">{{ trans('laralum.pages_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.pages_subtitle'))
@section('icon', "star")
@section('subtitle', trans('laralum.pages_subtitle'))
@section('content')
  <div class="ui one column doubling stackable grid container">
  	<div class="column">	
	<a href="{{ route('console::page_create') }}" class="res_ex ui {{ Laralum::settings()->button_color }} button">
    <i class="fa fa-plus icon_m" aria-hidden="true"></i><span>{{ trans('laralum.page_create') }}</span></a>
  		<div class="ui very padded segment">
		 @if(count($pages) > 0)
  			<table class="ui table ">
  			  <thead>
  			    <tr>
                  <th>{{ trans('laralum.page_id') }}</th>
                  <th>{{ trans('laralum.page_name') }}</th>
                  <th>{{ trans('laralum.product_created') }}</th>                  
                  <th>{{ trans('laralum.options') }}</th>
  			    </tr>
  			  </thead>
  			  <tbody>
                @foreach($pages as $page)
					<tr>
					    <td>{{ $page->id }}</td>
						<td>
                            <div class="text">
                                {{ $page->title }}
                            </div>
                        </td>
						<td>{{ $page->created_at }}</td>						                    
                        <td>                          
						  <div class="ui {{ Laralum::settings()->button_color }} top icon left pointing dropdown button">
							<i class="configure icon"></i>
							<div class="menu">
							  <div class="header">{{ trans('laralum.editing_options') }}</div>
							  <a href="{{ route('console::page_edit', ['id' => $page->id]) }}" class="item">
								<i class="edit icon"></i>
								{{ trans('laralum.page_edit') }}
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
                        <p>{{ trans('laralum.missing_subtitle', ['element'  =>  "page"]) }}</p>
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
/*delete product*/
function deleteProduct(id){	
	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		})  
	
	 swal({
		title: "Are you sure?",
		text: "You will not be able to recover this product!",
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
				text: 'Product is successfully deleted!',
				type: 'success'
			}, function() {
				$.ajax({
					type: 'post',
					url: "{{ route('console::product_delete') }}",
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
			swal("Cancelled", "Your product is safe :)", "error");
			$('.dimmer').removeClass('dimmer');
		}
	});
	
}
/*delete testimonial*/
</script>
@endsection