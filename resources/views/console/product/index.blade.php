@extends('layouts.console.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <div class="active section">{{ trans('laralum.products_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.products_title'))
@section('icon', "star")
@section('subtitle', trans('laralum.products_subtitle'))
@section('content')
  <div class="ui one column doubling stackable grid container">
  	<div class="column">	
	<a href="{{ route('console::product_create') }}" class="res_ex ui {{ Laralum::settings()->button_color }} button">
    <i class="fa fa-plus icon_m" aria-hidden="true"></i><span>{{ trans('laralum.product_create') }}</span></a>
  		<div class="ui very padded segment">
		 @if(count($products) > 0)
  			<table class="ui table ">
  			  <thead>
  			    <tr>
                  <th>{{ trans('laralum.product_id') }}</th>
                  <th>{{ trans('laralum.product_name') }}</th>
                  <th>{{ trans('laralum.product_created') }}</th>                  
                  <th>{{ trans('laralum.options') }}</th>
  			    </tr>
  			  </thead>
  			  <tbody>
                @foreach($products as $product)
					<tr>
					    <td>{{ $product->id }}</td>
						<td>
                            <div class="text">
                                {{ ($product->product_type==9) ? 'Featured Product' : $product->title }}
                            </div>
                        </td>
						<td>{{ $product->created_at }}</td>						                    
                        <td>                          
						  <div class="ui {{ Laralum::settings()->button_color }} top icon left pointing dropdown button">
							<i class="configure icon"></i>
							<div class="menu">
							  <div class="header">{{ trans('laralum.editing_options') }}</div>
							  <a href="{{ route('console::product_edit', ['id' => $product->id]) }}" class="item">
								<i class="edit icon"></i>
								{{ trans('laralum.product_edit') }}
							  </a>                                  
							  
							  <div class="header">{{ trans('laralum.advanced_options') }}</div>
							  <a href="javascript:void(0);" onclick="deleteProduct({{ $product->id }});" class="item">
								<i class="trash bin icon"></i>
								{{ trans('laralum.product_delete') }}
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
                        <p>{{ trans('laralum.missing_subtitle', ['element'  =>  "product"]) }}</p>
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