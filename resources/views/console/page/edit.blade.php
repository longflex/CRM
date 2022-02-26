@extends('layouts.console.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <a class="section" href="{{ route('console::pages') }}">{{ trans('laralum.pages_title') }}</a>
        <i class="right angle icon divider"></i>
        <div class="active section">{{ trans('laralum.page_edit_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.page_edit_subtitle', ['name' => $page->title]))
@section('icon', "edit")
@section('content')
<div class="ui doubling stackable grid container">
    <div class="three wide column"></div>
    <div class="ten wide column">
        <div class="ui very padded segment">
            <form class="ui form" action="{{ route('console::page_update', [$page->id]) }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
				<div class="field">
				    <label>{{ trans('laralum.page_type') }}</label>
					  <select class="custom-select" name="page_type" id="page_type">
						 <option value="">Select Type</option>
						 <option value="1" {{ ($page->type == 1) ? 'selected' : '' }}>About</option>
						 <option value="2" {{ ($page->type == 2) ? 'selected' : '' }}>Terms of Use</option>
						 <option value="3" {{ ($page->type == 3) ? 'selected' : '' }}>Privacy policy</option>
						 <option value="4" {{ ($page->type == 4) ? 'selected' : '' }}>Home Page Section</option>
						 <option value="5" {{ ($page->type == 5) ? 'selected' : '' }}>Resource</option>
						 <option value="6" {{ ($page->type == 6) ? 'selected' : '' }}>Industries</option>
						 <option value="7" {{ ($page->type == 7) ? 'selected' : '' }}>Contact Us</option>
					 </select>
				 </div>
                <div class="field">
					<label>{{ trans('laralum.page_name') }}</label>
					<input type="text" id="page_title" name="page_title" value="{{ old('page_title', isset($page) ? $page->title : '') }}" placeholder="{{ trans('laralum.product_name') }}" />
                 </div>
				
				 <div class="field" id="field_img">
				    <label>Image</label>
					  <div class="customFile" data-label="Choose File">
						<span class="selectedFile">Uplaod Image</span>
						<input type="file" id="home_page_image" name="home_page_image"  />
						<input type="hidden" id="home_page_image_hidden" name="home_page_image_hidden"  />
					  </div>
					@if($page->type == 4)
					 <script> $('#field_img').show(); </script>
				    @else
					 <script> $('#field_img').hide(); </script>
					@endif
				 </div>
				  				 
				 <div class="field">
					<label>{{ trans('laralum.page_desc') }}</label>
					<textarea id="page_desc" name="page_desc" rows="4" cols="50">
					{{ old('page_desc', isset($page) ? $page->description : '') }}
					</textarea>
                 </div>
                <br>
                <button type="submit" class="ui {{ Laralum::settings()->button_color }} submit button">{{ trans('laralum.submit') }}</button>
            </form>
        </div>
    </div>
    <div class="three wide column"></div>
</div>
<script>         
 CKEDITOR.replace('page_desc');
</script>
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
    $('#page_type').change(function(){
        if($('#page_type').val() == 4) {
            $('#field_img').show(); 
        } else {
            $('#field_img').hide(); 
        } 
    });
</script>
@endsection