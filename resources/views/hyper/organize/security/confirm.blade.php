@extends('hyper.layout.master')
@section('title', trans('laralum.security_confirm_title'))
@section('content')


<div class="px-2">
    <!-- start page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title-box">
                <!-- <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="uil-home-alt"></i> {{ config('app.name') }}</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Permissions</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div> -->
                <h4 class="page-title">{{trans('laralum.security_confirm_title')}}</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 
    <!-- start page content -->
    <div class="row">
      <div class="col-lg-3">
      </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-2"></div> 
                    <div class="col-md-8">
                      <h2 class="ui header">{{ trans('laralum.security_description_title') }}</h2>
                      <p>{{ trans('laralum.security_description') }}</p>
                    </div> 
                    <div class="col-md-2"></div> 
                  </div>
                  <div class="row">
                    <div class="col-md-2"></div> 
                    <div class="col-md-4">
                      <center>
                        <a href="{{ URL::previous() }}" class="btn btn-secondary">{{ trans('laralum.back') }}</a>
                      </center>
                      
                    </div>
                     <div class="col-md-4">
                      <form method="POST" class="ui form">
                        <input type="hidden" value="{{ url()->previous()}}" name="url">
                        {{ csrf_field() }}
                        <div class="field">
                          <center>
                            <button id="security_continue" type="submit" class="btn btn-success">{{ trans('laralum.continue') }}</button>
                          </center>
                            
                        </div>
                    </form>
                    </div> 

                    <div class="col-md-2"></div> 
                  </div>



                </div>
            </div>
        </div>
        <div class="col-lg-3">
      </div>
    </div>
    <!-- end page content --> 
</div> 










@endsection
@section('extrascripts')
<script>
$('#security_progress').fadeIn(750)
var interval = setInterval(function(){
    var success = $('#security_progress').progress('is success');
    if(success) {
        $('#security_progress').fadeOut(750)
        setTimeout(function(){
            $('#security_continue').removeClass('disabled');
            $('#security_continue').removeClass('loading');
            clearInterval(interval);
        }, 250);
    } else {
        $('#security_progress').progress('increment');
    }
}, 50);
</script>
@endsection
