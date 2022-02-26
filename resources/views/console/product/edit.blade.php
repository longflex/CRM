@extends('layouts.console.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <a class="section" href="{{ route('console::products') }}">{{ trans('laralum.products_title') }}</a>
        <i class="right angle icon divider"></i>
        <div class="active section">{{ trans('laralum.product_edit_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.product_edit_subtitle', ['name' => $product->title]))
@section('icon', "edit")
@section('subtitle', trans('laralum.product_edit_subtitle', ['name' => $product->title]))
@section('content')
<div class="ui container mb-20">
   <form class="ui form" action="{{ route('console::product_update', [$product->id]) }}" method="POST" enctype="multipart/form-data">
         {{ csrf_field() }}
        <div class="ui doubling stackable grid">
            <div class="row">
                <div class="eight wide column">
                    <div class="ui very padded segment">
                        
                    <div class="field">
					<label>{{ trans('laralum.products_type') }}</label>
					<select class="custom-select" name="product_type" id="product_type" disabled>
						 <option value="">Please select..</option>
						 <option value="1" {{ ($product->product_type == 1) ? 'selected' : '' }}>CleverStack CRM</option>
						 <option value="2" {{ ($product->product_type == 2) ? 'selected' : '' }}>SMS</option>
						 <option value="3" {{ ($product->product_type == 3) ? 'selected' : '' }}>Voice Broadcasting</option>
						 <option value="4" {{ ($product->product_type == 4) ? 'selected' : '' }}>WhatsApp</option>
						 <option value="5" {{ ($product->product_type == 5) ? 'selected' : '' }}>IVR</option>
						 <option value="6" {{ ($product->product_type == 6) ? 'selected' : '' }}>Audio Conference</option>
						 <option value="7" {{ ($product->product_type == 7) ? 'selected' : '' }}>Video Conference</option>
						 <option value="8" {{ ($product->product_type == 8) ? 'selected' : '' }}>Email Marketing</option>
						 <option value="9" {{ ($product->product_type == 9) ? 'selected' : '' }}>Featured Product</option>
					 </select>					
                 </div>	
                 <div class="field">
					<label>{{ trans('laralum.product_name') }}</label>
					<input type="text" id="product_name" name="product_name" value="{{ old('product_name', isset($product) ? $product->title : '') }}" placeholder="{{ trans('laralum.product_name') }}" />
                 </div>				 
				 <div class="field">
				    <label>{{ trans('laralum.product_img') }}</label>
						<div class="form-group">
							<img src="{{ asset('console_public/data/products/') }}/{{ $product->image }}" class="" width="100%" height="200" />
						</div>
					  <div class="customFile" data-label="Choose File">
						<span class="selectedFile">Uplaod Product Image</span>
						<input type="file" id="product_img" name="product_img" />
						<input type="hidden" id="product_img_hidden" name="product_img_hidden" value="{{ $product->image }}" />
					  </div>
					  <small style="color:red;">Max Size: 2MB, Dimension: 800 X 660</small>
				 </div>
				 
				 <div class="field">
					<label>{{ trans('laralum.product_desc') }}</label>
					<textarea id="product_desc" name="product_desc" rows="4" cols="50">
					{{ old('product_desc', isset($product) ? $product->description : '') }}
					</textarea>
					<script>         
                     CKEDITOR.replace('product_desc');
                   </script>
                 </div>
                    </div>
                </div>
                <div class="eight wide column"> 				
                  <div class="ui very padded segment">
				   <small style="color:red;">Max Size: 2MB, Dimension: 62 X 62</small>
				  <!--1--->
                   <div class="field">
					<label>{{ trans('laralum.sub_product') }} 1</label>					
					<div class="row">
						<div class="col-md-12">
							<div class="row">
							    <div class="col-md-12">
								<div class="form-group">
									<input type="text" name="sub_product_title1" value="{{ old('sub_product_title1', isset($product) ? $product->sub_product_title1 : '') }}" class="form-control" placeholder="{{ trans('laralum.sub_product_title') }}" />
								</div>
								</div>
								<div class="col-md-8">
								<div class="form-group">	
									<div class="field">
										<div class="customFile" data-label="Choose File">
											<span class="selectedFile">Update Image</span>
											<input type="file" name="sub_product_image1" />
											<input type="hidden" name="sub_product_image1_hidden" value="{{ $product->sub_product_icon1 }}" />
										</div>
									</div>
								</div>
								</div>
								<div class="col-md-4">
									<a href="javascript:void(0);" class="btn btn-sm btn-primary" data-html="true" data-toggle="popover"   data-placement="top" data-trigger="focus" data-content="<img src='{{ asset('console_public/data/products/sub_product') }}/{{ $product->sub_product_icon1 }}' width='100px' />" onclick="$('.dimmer').removeClass('dimmer')">View Uploaded Image</a>
								</div>
								<div class="col-md-12">
								<div class="form-group">
									<textarea class="form-control height-60" name="sub_product_desc1" placeholder="{{ trans('laralum.sub_product_subtitle') }}">{!! old('sub_product_desc1', isset($product) ? trim($product->sub_product_desc1) : '') !!}</textarea>																		
								</div>
								</div>
							</div>
						</div>												
					</div>					
                    </div>
					<!--1--->
					<!--2-->
					<div class="field">
					<label>{{ trans('laralum.sub_product') }} 2</label>					
					<div class="row">
						<div class="col-md-12">
							<div class="row">
							    <div class="col-md-12">
								<div class="form-group">
									<input type="text" name="sub_product_title2" value="{{ old('sub_product_title2', isset($product) ? $product->sub_product_title2 : '') }}" class="form-control" placeholder="{{ trans('laralum.sub_product_title') }}" />
								</div>
								</div>
								<div class="col-md-8">
								<div class="form-group">	
									<div class="field">
										<div class="customFile" data-label="Choose File">
											<span class="selectedFile">Update Image</span>
											<input type="file" name="sub_product_image2"  />
											<input type="hidden" name="sub_product_image2_hidden" value="{{ $product->sub_product_icon2 }}" />
										</div>
									</div>
								</div>
								</div>
								
								<div class="col-md-4">
									<a href="javascript:void(0);" class="btn btn-sm btn-primary" data-html="true" data-toggle="popover"   data-placement="top" data-trigger="focus" data-content="<img src='{{ asset('console_public/data/products/sub_product') }}/{{ $product->sub_product_icon2 }}' width='100px' />" onclick="$('.dimmer').removeClass('dimmer')">View Uploaded Image</a>
								</div>
																
								<div class="col-md-12">
								<div class="form-group">
									<textarea class="form-control height-60" name="sub_product_desc2" placeholder="{{ trans('laralum.sub_product_subtitle') }}">{!! old('sub_product_desc2', isset($product) ? trim($product->sub_product_desc2) : '') !!}</textarea>									
								</div>
								</div>
							</div>
						</div>												
					  </div>					
                     </div>
					  <!--2-->
					  
					  <!--3-->
					  <div class="field">
					<label>{{ trans('laralum.sub_product') }} 3</label>					
					<div class="row">
						<div class="col-md-12">
							<div class="row">
							    <div class="col-md-12">
								<div class="form-group">
									<input type="text" name="sub_product_title3" value="{{ old('sub_product_title3', isset($product) ? $product->sub_product_title3 : '') }}" class="form-control" placeholder="{{ trans('laralum.sub_product_title') }}" />
								</div>
								</div>
								<div class="col-md-8">
								<div class="form-group">	
									<div class="field">
										<div class="customFile" data-label="Choose File">
											<span class="selectedFile">Update Image</span>
											<input type="file" name="sub_product_image3" />
											<input type="hidden" name="sub_product_image3_hidden" value="{{ $product->sub_product_icon3 }}" />
										</div>
									</div>
								</div>
								</div>	
									<div class="col-md-4">
									<a href="javascript:void(0);" class="btn btn-sm btn-primary" data-html="true" data-toggle="popover"   data-placement="top" data-trigger="focus" data-content="<img src='{{ asset('console_public/data/products/sub_product') }}/{{ $product->sub_product_icon3 }}' width='100px' />" onclick="$('.dimmer').removeClass('dimmer')">View Uploaded Image</a>
								</div>
								<div class="col-md-12">
								<div class="form-group">
									<textarea class="form-control height-60" name="sub_product_desc3" placeholder="{{ trans('laralum.sub_product_subtitle') }}">{!! old('sub_product_desc3', isset($product) ? trim($product->sub_product_desc3) : '') !!}</textarea>																		
								</div>
								</div>
							</div>
						</div>												
					  </div>					
                     </div>
					  <!--3-->
					  
					  <!--4-->
					  <div class="field">
					<label>{{ trans('laralum.sub_product') }} 4</label>					
					<div class="row">
						<div class="col-md-12">
							<div class="row">
							    <div class="col-md-12">
								<div class="form-group">
									<input type="text" name="sub_product_title4" value="{{ old('sub_product_title4', isset($product) ? $product->sub_product_title4 : '') }}" class="form-control" placeholder="{{ trans('laralum.sub_product_title') }}" />
								</div>
								</div>
								<div class="col-md-8">
								<div class="form-group">	
									<div class="field">
										<div class="customFile" data-label="Choose File">
											<span class="selectedFile">Update Image</span>
											<input type="file" name="sub_product_image4" />
											<input type="hidden" name="sub_product_image4_hidden" value="{{ $product->sub_product_icon4 }}" />
										</div>
									</div>
								</div>
								</div>
								<div class="col-md-4">
									<a href="javascript:void(0);" class="btn btn-sm btn-primary" data-html="true" data-toggle="popover"   data-placement="top" data-trigger="focus" data-content="<img src='{{ asset('console_public/data/products/sub_product') }}/{{ $product->sub_product_icon4 }}' width='100px' />" onclick="$('.dimmer').removeClass('dimmer')">View Uploaded Image</a>
								</div>								
								<div class="col-md-12">
								<div class="form-group">
									<textarea class="form-control height-60" name="sub_product_desc4" placeholder="{{ trans('laralum.sub_product_subtitle') }}">{!! old('sub_product_desc4', isset($product) ? trim($product->sub_product_desc4) : '') !!}</textarea>																		
								</div>
								</div>
							</div>
						</div>												
					  </div>					
                     </div>
					  <!--4-->
					
					
                        <br>
                        <button type="submit" class="ui {{ Laralum::settings()->button_color }} submit button">{{ trans('laralum.submit') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('js')
<script>
    (function($) {
    $.fn.mnFileInput = function(params) {
        this.change(function(e) {
          $valueDom = $(this).closest('.customFile').find('.selectedFile');
          // $valueDom.addClass('inProgress');
          var filename = $('.customFile').data('label');
          if(e.target){
            var fullPath = e.target.value;
            filename = fullPath.replace(/^.*[\\\/]/, '');
            $valueDom.text(filename);
            
            e.target.onprogress = function (e) {
              if (e.lengthComputable) {
                  console.log(e.loaded+  " / " + e.total)
              }
          }
            
            // $valueDom.removeClass('inProgress');
            console.log('>>>', this, e);
          }
        });
    };
})(jQuery);

$(".customFile > input").mnFileInput();
</script>
@endsection
