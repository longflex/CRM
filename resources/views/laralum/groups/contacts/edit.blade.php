@extends('layouts.admin.panel')
@section('breadcrumb')
   <div class="ui breadcrumb">
        <a class="section" href="{{ route('Laralum::groups') }}">{{ trans('laralum.group_title') }}</a>
        <i class="right angle icon divider"></i>
		 <a class="section" href="{{ route('Laralum::contacts', ['id' => $group_id]) }}">{{ trans('laralum.contact_list') }}</a>
        <i class="right angle icon divider"></i>
        <div class="active section">{{ trans('laralum.edit_contact') }}</div>
    </div>
@endsection
@section('title', trans('laralum.group_edit_title'))
@section('icon', "edit")
@section('subtitle', trans('laralum.group_edit_subtitle', ['name' => $row->name]))
@section('content')
<div class="ui doubling stackable grid container">
    <div class="three wide column"></div>
    <div class="ten wide column">
        <div class="ui very padded segment">
            <form class="ui form" method="POST">
                {{ csrf_field() }}
                @include('laralum/forms/master')
                <br>
                <button type="submit" class="ui {{ Laralum::settings()->button_color }} submit button">{{ trans('laralum.submit') }}</button>
            </form>
        </div>
    </div>
    <div class="three wide column"></div>
</div>
@endsection
