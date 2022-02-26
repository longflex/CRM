@extends('layouts.console.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <a class="section" href="{{ route('console::testimonials') }}">{{ trans('laralum.industries_title') }}</a>
        <i class="right angle icon divider"></i>
        <div class="active section">{{ trans('laralum.industries_edit_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.industries_edit_title'))
@section('icon', "edit")
@section('subtitle', trans('laralum.industries_edit_subtitle', ['name' => $industries->title]))
@section('content')
<div class="ui doubling stackable grid container">
    <div class="three wide column"></div>
    <div class="ten wide column">
        <div class="ui very padded segment">
            <form class="ui form" action="{{ route('console::industries_update', [$industries->id]) }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="field">
					<label>{{ trans('laralum.industries_name') }} <span style="color:red;">*</span></label>
					<input type="text" id="title" name="title" value="{{ old('title', isset($industries) ? $industries->title : '') }}" placeholder="{{ trans('laralum.industries_name') }}" />
                 </div>
				 <div class="field">
				    <label>{{ trans('laralum.industries_icon') }}</label>
					  <div class="customFile" data-label="Choose File">
						<span class="selectedFile">Upload new icon</span>
						<input type="file" id="icon" name="icon" />
						<input type="hidden" id="icon_hidden" name="icon_hidden" value="{{ $industries->icon }}" />
					  </div>
				 </div>
				 
				 <div class="field">
					<label>{{ trans('laralum.industries_descrption') }} <span style="color:red;">*</span></label>
					<textarea id="description" name="description" rows="4" cols="50">{!! old('description', isset($industries) ? trim($industries->description) : '') !!}</textarea>					
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
