<div id="check_all" class="ui button">{{ trans('laralum.check_all') }}</div>
<div id="uncheck_all" class="ui button">{{ trans('laralum.uncheck_all') }}</div><br><br>
<?php $found = false; ?>

@foreach($permissions as $perms)
<h3>{{$perms->name}}</h3>
<div class="three fields">

    <?php $counter = 0; ?>
    @foreach($perms->module as $perm)
    <?php $found = true ?>
    <div class="inline field">

        <div class="ui slider checkbox">
            <input name="{{ $perm->id }}" type="checkbox" tabindex="0" class=" checkable  hidden"
                {{$perm->selected?'checked':""}}>
            <label>{{ Laralum::permissionName($perm->permission) }}</label>
        </div>
        {{-- <i data-variation="wide" data-title="{{ $perm->permission }}"
        data-content="{{ Laralum::permissionDescription($perm->permission) }}" data-position="right center"
        class="grey question pop icon"></i> --}}
        {{-- @if(!$perm->assignable and !Laralum::loggedInUser()->su)<i data-variation="wide" class="red lock icon pop"
            data-position="right center" data-title="{{ trans('laralum.unassignable_permission') }}"
        data-content="{{ trans('laralum.unassignable_permission_desc') }}"></i>@endif --}}
        {{-- @if(!$perm->assignable and Laralum::loggedInUser()->su and !$disabled)<i data-variation="wide"
            class="red unlock icon pop" data-position="right center"
            data-title="{{ trans('laralum.unassignable_permission_unlocked') }}"
        data-content="{{ trans('laralum.unassignable_permission_unlocked_desc') }}"></i>@endif
        @if(Laralum::loggedInUser()->su and $disabled)<i data-variation="wide" class="red asterisk icon pop"
            data-position="right center" data-title="{{ trans('laralum.su_permission_and_role') }}"
            data-content="{{ trans('laralum.su_permission_and_role_desc') }}"></i>@endif --}}
    </div>
    <?php if($counter == 2){echo "</div><div class='two fields'>";$counter=0;}else{$counter++;} ?>
    @endforeach
    <?php if($counter == 2){echo "<div class='inline field'></div>";}    ?>
</div>
@endforeach
@if(!$found)
<div class="col-md-6 col-lg-4 down-spacer">
    <p>No permissions found</p>
</div>
@endif