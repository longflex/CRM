@extends('layouts.console.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <a class="section" href="{{ route('console::testimonials') }}">{{ trans('laralum.testimonials_title') }}</a>
        <i class="right angle icon divider"></i>
        <div class="active section">{{ trans('laralum.testimonials_edit_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.testimonials_edit_title'))
@section('icon', "edit")
@section('subtitle', trans('laralum.testimonials_edit_subtitle', ['name' => $testimonial->company_name]))
@section('content')
<div class="ui doubling stackable grid container">
    <div class="three wide column"></div>
    <div class="ten wide column">
        <div class="ui very padded segment">
            <form class="ui form" action="{{ route('console::testimonial_update', [$testimonial->id]) }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="field">
					<label>{{ trans('laralum.testimonials_name') }}</label>
					<input type="text" id="company_name" name="company_name" value="{{ old('company_name', isset($testimonial) ? $testimonial->company_name : '') }}" placeholder="{{ trans('laralum.testimonials_name') }}" />
                 </div>
				 <div class="field">
					<label>{{ trans('laralum.testimonials_url') }}</label>
					<input type="text" id="company_url" name="company_url" value="{{ old('company_url', isset($testimonial) ? $testimonial->company_url : '') }}" placeholder="{{ trans('laralum.company_url') }}" />
                 </div>
				
				 <div class="field">
				    <label>{{ trans('laralum.testimonials_logo') }}</label>
					  <div class="customFile" data-label="Choose File">
						<span class="selectedFile">Uplaod company logo</span>
						<input type="file" id="company_logo" name="company_logo" />
						<input type="hidden" id="company_logo_hidden" name="company_logo_hidden" value="{{ $testimonial->company_logo }}" />
					  </div>
				 </div>
				 
				 <div class="field">
					<label>{{ trans('laralum.testimonials_comment') }}</label>
					<textarea id="company_comment" name="company_comment" rows="4" cols="50">
					{{ old('company_comment', isset($testimonial) ? $testimonial->comments : '') }}
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
