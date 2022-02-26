@extends('layouts.console.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <a class="section" href="{{ url()->previous()}}">{{ trans('laralum.roles_title') }}</a>
        <i class="right angle icon divider"></i>
        <div class="active section">{{ trans('laralum.roles_edit_permissions_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.roles_edit_permissions_title'))
@section('icon', "lightning")
@section('subtitle', trans('laralum.roles_edit_permissions_subtitle', ['name' => $role->name]))
@section('content')
<div class="ui one column doubling stackable grid container mb-20">
    <div class="column">
        <div class="ui very padded segment">
            <form method="POST" class="ui form">
                <input type="hidden" value="{{ url()->previous()}}" name="url">
                {{ csrf_field() }}
                @include('laralum.forms.permissions')
                <br>
                <div class="field">
                    <button type="submit" class="ui {{ Laralum::settings()->button_color }} submit button">{{ trans('laralum.submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
