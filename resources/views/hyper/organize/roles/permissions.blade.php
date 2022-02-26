@extends('hyper.layout.master')
@section('title', "Edit Permissions")
@section('content')
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 40px;
  height: 12px;
}

.switch input {display:none;}


.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #cccccc;
  -webkit-transition: .4s;
  transition: .4s;
   border-radius: 50px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 8px;
  width: 8px;
  left: 2px;
  bottom: 2px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
  border-radius: 50%;
}

input:checked + .slider {
  background-color: #398bf7;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(40px);
  -ms-transform: translateX(40px);
  -moz-transform: translateX(40px);
  transform: translateX(28px);
}

/*------ ADDED CSS ---------*/
.slider:after
{
 content:'';
 color: white;
 display: block;
 position: absolute;
 transform: translate(-50%,-50%);
 top: 50%;
 left: 50%;
 font-size: 10px;
 font-family: Verdana, sans-serif;
}

input:checked + .slider:after
{  
  content:'';
}
</style>

<div class="px-2">
    <!-- start page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('console::profile') }}"><i class="uil-home-alt"></i>Profile</a></li>
                        <li class="breadcrumb-item active">Permissions Edit</li>
                    </ol>
                </div>
                <h4 class="page-title">{{trans('laralum.roles_edit_permissions_subtitle', ['name' => $role->name])}}</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 
    <!-- start page content -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                  <div class="row">
                      <div class="col-md-1"></div> 
                      <div class="col-md-10">
                        <form method="POST" class="ui form">
                        <input type="hidden" value="{{ url()->previous()}}" name="url">
                        {{ csrf_field() }}
                          <div id="check_all" class="btn btn-sm btn-secondary">{{ trans('laralum.check_all'). " / " . trans('laralum.uncheck_all')}}</div>
                          <!-- <div id="uncheck_all" class="btn btn-sm btn-secondary">{{ trans('laralum.uncheck_all') }}</div> -->
                          <br><br>
                          <?php $found = false; ?>
                          <div class="row">

                            @foreach($permissions as $perms)
                            <div class="col-lg-12">
                              <h3>{{$perms->name}}</h3>
                            </div>
                            
                            <div class="col-lg-4">
                              <?php $counter = 0; ?>
                              @foreach($perms->module as $perm)
                              <?php $found = true ?>
                                <div class="row">
                                  <div class="col-md-12 mt-1">
                                    <label class="switch" style="margin-bottom: 0.0rem !important">
                                      <input type="checkbox" tabindex="0" {{$perm->selected?'checked':''}} name="{{ $perm->id }}"  >
                                      <div class="slider"></div>
                                    </label>
                                    <span>&nbsp;&nbsp;&nbsp; {{ Laralum::permissionName($perm->permission) }}  </span>
                                  </div>
                                </div>
                              <?php if($counter == 2){echo "</div><div class='col-md-4'>";$counter=0;}else{$counter++;} ?>
                              @endforeach
                              <?php if($counter == 2){echo "<div class='inline field'></div>";}    ?>
                            </div>


                            @endforeach
                            @if(!$found)
                            <div class="col-md-6 col-lg-4 down-spacer">
                                <p>No permissions found</p>
                            </div>
                            @endif

                          </div>

                          <br>
                          <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{ trans('laralum.submit') }}</button>
                          </div>
                        </form>
                      </div>
                      <div class="col-md-1"></div>                   
                  </div>


                </div>
            </div>
        </div>
    </div>
    <!-- end page content --> 
</div> 

@endsection
@section('extrascripts')
<script>
  $(document).ready(function() {
    $("#check_all").click(function() {
        $(':checkbox').each(function () { this.checked = !this.checked; });
    });                 
  });
</script>
@endsection





