@extends('layouts.console.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <a class="section" href="{{ route('console::pages') }}">{{ trans('laralum.pages_title') }}</a>
        <i class="right angle icon divider"></i>
        <div class="active section">{{ trans('laralum.page_create_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.page_create_subtitle'))
@section('content')
<div class="ui doubling stackable grid container mb-20">
    <div class="three wide column"></div>
    <div class="ten wide column">
        <div class="ui very padded segment">
            <form class="ui form" action="{{ route('console::page_save') }}" method="POST" enctype="multipart/form-data">			   
                {{ csrf_field() }}
				<div class="field">
				    <label>{{ trans('laralum.page_type') }}</label>
					  <select class="custom-select" name="page_type" id="page_type">
						 <option value="">Select Type</option>
						 <option value="1">About</option>
						 <option value="2">Terms of Use</option>
						 <option value="3">Privacy policy</option>
						 <option value="4">Home Page Section</option>
						 <option value="5">Resource</option>
						 <option value="6">Industries</option>
						 <option value="7">Contact Us</option>
					 </select>
				 </div>
				
                 <div class="field">
					<label>{{ trans('laralum.page_name') }}</label>
					<input type="text" id="page_title" name="page_title" placeholder="{{ trans('laralum.page_name') }}" />
                 </div>
				 
				 <div class="field" id="field_img">
				    <label>Image</label>
					  <div class="customFile" data-label="Choose File">
						<span class="selectedFile">Uplaod Image</span>
						<input type="file" id="home_page_image" name="home_page_image"  />
					  </div>
				 </div>
				 
				 <div class="field">
					<label>{{ trans('laralum.page_desc') }}</label>
					<textarea id="page_desc" name="page_desc" rows="4" cols="50"></textarea>
					<script>         
                     CKEDITOR.replace('page_desc');
                   </script>
                 </div>
                <br>
                <button type="submit" class="ui {{ Laralum::settings()->button_color }} submit button">{{ trans('laralum.submit') }}</button>
            </form>
        </div>
    </div>
    <div class="three wide column"></div>
</div>
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
 $('#field_img').hide(); 
    $('#page_type').change(function(){
        if($('#page_type').val() == 4) {
            $('#field_img').show(); 
        } else {
            $('#field_img').hide(); 
        } 
    });
</script>
@endsection
