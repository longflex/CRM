@extends('layouts.console.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <a class="section" href="{{ url()->previous() }}">{{ trans('laralum.roles_title') }}</a>
        <i class="right angle icon divider"></i>
        <div class="active section">{{ trans('laralum.roles_edit_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.roles_edit_title'))
@section('icon', "edit")
@section('subtitle', trans('laralum.roles_edit_subtitle', ['name' => $row->name]))
@section('content')
<div class="ui doubling stackable grid container mb-20">
    <div class="three wide column"></div>
    <div class="ten wide column">
        <div class="ui very padded segment">
            <form class="ui form" method="POST">
                <input type="hidden" value="{{ url()->previous()}}" name="url">
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
