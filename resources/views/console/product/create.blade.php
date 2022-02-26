@extends('layouts.console.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <a class="section" href="{{ route('console::products') }}">{{ trans('laralum.products_title') }}</a>
        <i class="right angle icon divider"></i>
        <div class="active section">{{ trans('laralum.product_create_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.product_create_title'))
@section('icon', "plus")
@section('subtitle', trans('laralum.product_create_subtitle'))
@section('content')
<div class="ui container mb-20">
   <form class="ui form" action="{{ route('console::product_save') }}" method="POST" enctype="multipart/form-data">
        <div class="ui doubling stackable grid">
            <div class="row">
                <div class="eight wide column">
                    <div class="ui very padded segment">
                        {{ csrf_field() }}
                       <div class="field">
					<label>{{ trans('laralum.products_type') }}</label>
					<select class="custom-select" name="product_type" id="product_type">
						 <option value="">Please select..</option>
						 <option value="1">CleverStack CRM</option>
						 <option value="2">SMS</option>
						 <option value="3">Voice Broadcasting</option>
						 <option value="4">WhatsApp</option>
						 <option value="5">IVR</option>
						 <option value="6">Audio Conference</option>
						 <option value="7">Video Conference</option>
						 <option value="8">Email Marketing</option>
						 <option value="9">Featured Product</option>
					 </select>					
                 </div>	
                 <div class="field">
					<label>{{ trans('laralum.product_name') }}</label>
					<input type="text" id="product_name" name="product_name" placeholder="{{ trans('laralum.product_name') }}" />
                 </div>				 
				 <div class="field">
				    <label>{{ trans('laralum.product_img') }}</label>
					  <div class="customFile" data-label="Choose File">
						<span class="selectedFile">Uplaod Product Image</span>
						<input type="file" id="product_img" name="product_img" />
					  </div>
                        <small style="color:red;">Max Size: 2MB, Dimension: 800 X 660</small>					  
				 </div>
				 
				 <div class="field">
					<label>{{ trans('laralum.product_desc') }}</label>
					<textarea id="product_desc" name="product_desc" rows="4" cols="50"></textarea>
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
							    <div class="col-md-6">
								<div class="form-group">
									<input type="text" name="sub_product_title1" class="form-control" placeholder="{{ trans('laralum.sub_product_title') }}" />
								</div>
								</div>
								<div class="col-md-6">
								<div class="form-group">	
									<div class="field">
										<div class="customFile" data-label="Choose File">
											<span class="selectedFile">Uplaod Product Image</span>
											<input type="file" name="sub_product_image1" />
										</div>
									</div>
								</div>
								</div>								
								<div class="col-md-12">
								<div class="form-group">
									<textarea class="form-control height-60" name="sub_product_desc1" placeholder="{{ trans('laralum.sub_product_subtitle') }}"></textarea>
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
							    <div class="col-md-6">
								<div class="form-group">
									<input type="text" name="sub_product_title2" class="form-control" placeholder="{{ trans('laralum.sub_product_title') }}" />
								</div>
								</div>
								<div class="col-md-6">
								<div class="form-group">	
									<div class="field">
										<div class="customFile" data-label="Choose File">
											<span class="selectedFile">Uplaod Product Image</span>
											<input type="file" name="sub_product_image2" />
										</div>
									</div>
								</div>
								</div>
																
								<div class="col-md-12">
								<div class="form-group">
									<textarea class="form-control height-60" name="sub_product_desc2" placeholder="{{ trans('laralum.sub_product_subtitle') }}"></textarea>
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
							    <div class="col-md-6">
								<div class="form-group">
									<input type="text" name="sub_product_title3" class="form-control" placeholder="{{ trans('laralum.sub_product_title') }}" />
								</div>
								</div>
								<div class="col-md-6">
								<div class="form-group">	
									<div class="field">
										<div class="customFile" data-label="Choose File">
											<span class="selectedFile">Uplaod Product Image</span>
											<input type="file" name="sub_product_image3" />
										</div>
									</div>
								</div>
								</div>								
								<div class="col-md-12">
								<div class="form-group">
									<textarea class="form-control height-60" name="sub_product_desc3" placeholder="{{ trans('laralum.sub_product_subtitle') }}"></textarea>
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
							    <div class="col-md-6">
								<div class="form-group">
									<input type="text" name="sub_product_title4" class="form-control" placeholder="{{ trans('laralum.sub_product_title') }}" />
								</div>
								</div>
								<div class="col-md-6">
								<div class="form-group">	
									<div class="field">
										<div class="customFile" data-label="Choose File">
											<span class="selectedFile">Uplaod Product Image</span>
											<input type="file" name="sub_product_image4" />
										</div>
									</div>
								</div>
								</div>								
								<div class="col-md-12">
								<div class="form-group">
									<textarea class="form-control height-60" name="sub_product_desc4" placeholder="{{ trans('laralum.sub_product_subtitle') }}"></textarea>
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
