@extends('layouts.console.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <a class="section" href="{{ route('console::banners') }}">{{ trans('laralum.banners_title') }}</a>
        <i class="right angle icon divider"></i>
        <div class="active section">{{ trans('laralum.banners_create_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.banners_create_title'))
@section('content')
<div class="ui doubling stackable grid container">
    <div class="three wide column"></div>
    <div class="ten wide column">
        <div class="ui very padded segment">
            <form class="ui form" action="{{ route('console::banner_save') }}" method="POST" enctype="multipart/form-data">			   
                {{ csrf_field() }}
                 <div class="field">
					<label>{{ trans('laralum.banners_name') }}</label>
					<input type="text" id="title" name="title" placeholder="{{ trans('laralum.banners_name') }}" />
                 </div>								
				 <div class="field">
				    <label>{{ trans('laralum.banners_img') }}</label>
					  <div class="customFile" data-label="Choose File">
						<span class="selectedFile">Uplaod Banner Image</span>
						<input type="file" id="banner_img" name="banner_img"  />
					  </div>
				 </div>
				 
				 <div class="field">
					<label>{{ trans('laralum.banners_desc') }}</label>
					<textarea id="banner_desc" name="banner_desc" placeholder="Type here...." rows="4" cols="50"></textarea>
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
</script>
@endsection
