@extends('layouts.admin.panel')
@section('breadcrumb')

    <div class="ui breadcrumb">
        <a class="section" href="{{ route('Laralum::groups') }}">{{ trans('laralum.group_title') }}</a>
        <i class="right angle icon divider"></i>
		 <a class="section" href="{{ route('Laralum::contacts', ['id' => $id]) }}">{{ trans('laralum.contact_list') }}</a>
        <i class="right angle icon divider"></i>
        <div class="active section">{{ trans('laralum.import_contact') }}</div>
    </div>
@endsection
@section('title', trans('laralum.import_contact'))
@section('icon', "upload")
@section('subtitle', trans('laralum.import_file'))
@section('content')
<div class="ui doubling stackable two column grid container">
    <div class="column">
        <div class="ui very padded segment">
            <h3>{{ trans('laralum.information') }}</h3>
			<ul>
            <li><p>{{ trans('laralum.files_max_upload_size', ['size' => ini_get('upload_max_filesize')]) }}</p></li>
            <li><p>{{ trans('laralum.files_max_execution_time', ['time' => ini_get('max_execution_time')]) }}</p></li>
			<li><p>{{ trans('laralum.ext_allowed') }}</p></li>
			<li><p>{{ trans('laralum.multiple') }}</p></li>
			</ul>
			
			 <h3>{{ trans('laralum.sample_info') }}</h3>
			<a href="{{ url('/sample/sample.xls') }}" onClick="reloadpage();">XLS</a> | 
			<a href="{{ url('/sample/sample.xlsx') }}" onClick="reloadpage();">XLSX</a> | 
			<a href="{{ url('/sample/sample.csv') }}" onClick="reloadpage();">CSV</a> | 
			<a href="{{ url('/sample/sample.txt') }}" onClick="reloadpage();" target="_blank">TXT</a>
        </div>
		
           
       
    </div>
    <div class="column">
        <div class="ui very padded segment">
            <form class="ui form" method="POST" enctype="multipart/form-data">
                <h3>{{ trans('laralum.files_select_files') }}</h3>
                <input required type="file" name="files[]" id="files" multiple="true"><br><br>
				 <input type="hidden" name="group_id" value="{{ $id }}" />
                {{ csrf_field() }}
                <button type="submit" class="ui {{ Laralum::settings()->button_color }} submit button">{{ trans('laralum.submit') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection
