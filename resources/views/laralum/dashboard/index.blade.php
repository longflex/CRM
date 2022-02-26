@extends('layouts.admin.panel')
@section('breadcrumb')
<div class="ui breadcrumb">
    <div class="active section">{{ trans('laralum.dashboard') }}</div>
</div>
@endsection
@section('title', trans('laralum.dashboard'))
@section('icon', "dashboard")
@section('subtitle')
{{ trans('laralum.welcome_user', ['name' => Laralum::loggedInUser()->name]) }}
@endsection
@section('content')
<style>
.ui[class*="two column"].grid>.column:not(.row), .ui[class*="two column"].grid>.row>.column {
width: 49%;
}
.ui[class*="three column"].grid>.column:not(.row), .ui[class*="three column"].grid>.row>.column {
width: 32.33%;
}
</style>
<div class="ui doubling stackable two column grid container">
    <div class="column">
        <div class="ui padded segment">
            {!! Laralum::widget('basic_stats_1') !!}
        </div>
        <br>
        <div class="ui padded segment">
            {!! Laralum::widget('latest_users_graph') !!}
        </div>
        <br>
        <div class="ui padded segment">
            {!! Laralum::widget('latest_posts_graph') !!}
        </div>
        <br>
    </div>
    <div class="column">
        <div class="ui padded segment">
            {!! Laralum::widget('basic_stats_2') !!}
        </div>
        <br>
        <div class="ui padded segment">
            {!! Laralum::widget('users_country_geo_graph') !!}
        </div>
        <br>
        <div class="ui padded segment">
            {!! Laralum::widget('roles_users') !!}
        </div>
        <br>
    </div>
</div>
@endsection
