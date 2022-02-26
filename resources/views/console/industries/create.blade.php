@extends('layouts.console.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <a class="section" href="{{ route('console::testimonials') }}">{{ trans('laralum.industries_title') }}</a>
        <i class="right angle icon divider"></i>
        <div class="active section">{{ trans('laralum.industries_create_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.industries_create_title'))
@section('content')
<div class="ui doubling stackable grid container">
    <div class="three wide column"></div>
    <div class="ten wide column">
        <div class="ui very padded segment">
            <form class="ui form" action="{{ route('console::industries_save') }}" method="POST" enctype="multipart/form-data">			   
                {{ csrf_field() }}
                 <div class="field">
					<label>{{ trans('laralum.industries_name') }} <span style="color:red;">*</span></label>
					<input type="text" id="title" name="title" placeholder="{{ trans('laralum.industries_name') }}" />
                 </div>				
				 <div class="field">
				    <label>{{ trans('laralum.industries_icon') }} <span style="color:red;">*</span><small style="color:red;">( Size: 100px*100px, Max: 2MB )</small></label>
					  <div class="customFile" data-label="Choose File">
						<span class="selectedFile">Uplaod Icon</span>
						<input type="file" id="icon" name="icon"  />
					  </div>
					  
				 </div>
				 
				 <div class="field">
					<label>{{ trans('laralum.industries_descrption') }} <span style="color:red;">*</span> <small style="color:red;">( Enter up to 250 Characters )</small></label>
					<textarea id="description" name="description" rows="4" cols="50" placeholder="{{ trans('laralum.industries_descrption') }}"></textarea>
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
