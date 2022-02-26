@extends('layouts.crm.newLayout')
@section('breadcrumb')
<div class="ui breadcrumb">
    <div class="active section">Campaign</div>
</div>
@endsection
@section('title', "Campaign")
@section('icon', "mobile")
@section('content')
  <!--<div class="ui one column doubling stackable grid container mb-20">
    <div class="column">                  
      <div class="ui very padded segment">-->
        
<div class="container-fluid new-dashboard">
    <div class="row">
        <div class="col-lg-2 left-ivr-area">
            <div class="panel panel-default">
              <div class="panel-body p-0">
                <ul class="threecolumn-ul">
                <li class="text-left m-t-n4 min-hide">
                    <h1 class="f-22">Telephonic settings</h1>
                </li>
                </ul>
                
                <ul class="threecolumn-menu">
                    <li class="text-left active"><a href="javascript:void(0);">Campaign</a></li>
                    {{-- <li class="text-left"><a href="">Audio library</a></li>
                    <li class="text-left"><a href="">Advance setting</a></li> --}}
                </ul>
                
              </div>
            </div>
        </div>
        <div class="col-lg-10 right-ivr-area">
            <div class="panel panel-default">
              <div class="panel-body p-0">
                
                <div class="threecolumn-title2 boxinfo-head p-y-20 p-x-0">
                    <div class="col-lg-8 p-0 pull-left">
                        <h2 class="pull-left full-width">Outbound Campaign</h2>
                        <p class="pull-left full-width c-f m-t-n20 m-b-5">P2P calls and pre-recorded voice messages or IVR based campaigns for your customers</p>
                    </div>
                    <div class="col-lg-4 p-0 m-b-15 pull-left">
                    <a href="{{ route('Crm::create-campaign') }}" class="m-t-15 btn btn-primary">Create new Campaign</a>                                    </div>
                </div>
                
                    <div class="col-md-12">
                        <div class="full-width boxinfo-head p-y-0"> 
                            <?php //print_r($campaignValue); die;?>
                                @if(!empty($campaignValue))
                                @foreach($campaignValue as $campKey=>$campValue)    
                                
                                <?php
                                    $startDate = date_create($campValue['start_date']);
                                    $endDate = date_create($campValue['end_date']);
                                ?>
                                <div class="row" style="margin: 20px; border: 1px solid gray; border-radius: 10px;">
                                    <div class="col-sm-12" style="padding: 20px;">
                                        <div class="col-sm-12">
                                            <div class="media">
                                                <h3 class="pull-left full-width c-f m-t-n20 m-b-5">{{$campValue['name']}} | <span style="font-size:13px; color:gray;"><span style="margin-left: 3px;">{{date_format($startDate, "M d, Y")}} to {{date_format($endDate, "M d, Y")}}</span></h3>
                                            </div>
                                            <p class="pull-left full-width c-f m-t-n20 m-b-5 ml-3 text-muted">
                                                <i class="fa fa-calendar" style="font-size:14px"></i><span style="margin-left: 10px;">{{ucwords($campValue['days'])}} 
                                                <span style="margin-left: 30px;"></span>
                                                <i class="fa fa-clock" style="font-size:14px"></i><span style="margin-left: 10px;">{{$campValue['start_time']}} to {{$campValue['end_time']}}
                                            </p>
                                        </div>
                                           <div class="col-sm-1">
                                            <p>Dialed</p>
                                            <p>Fresh</p>
                                            <p>Retry</p>

                                        </div>
                                        <div class="col-sm-2">
                                            <p>0</p>
                                            <p>0</p>
                                            <p>0</p>

                                        </div>
                                        <div class="col-sm-1">
                                            <p>Remaining</p>
                                            <p>Fresh</p>
                                            <p>Retry</p>

                                        </div>
                                        <div class="col-sm-2">
                                            <p>0</p>
                                            <p>0</p>
                                            <p>0</p>

                                        </div>
                                        <div class="col-sm-2">
                                            <p>Both Answered</p>
                                            <p>Skipped</p>
                                            <p>Un-Answered</p>

                                        </div>
                                        <div class="col-sm-1">
                                            <p>0</p>
                                            <p>0</p>
                                            <p>0</p>

                                        </div>
                                        <div class="col-sm-2">
                                            <p>Status</p>
                                            @if($campValue['status'] == 0)
                                            <p class="badge" style="background-color: rgb(255 171 0);">Draft</p>
                                            @else
                                            <p class="badge badge-success">Active</p>
                                            @endif
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="dropdown">
                                                <button type="button" class="btn btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                  <div style="padding: 10px;">
                                                    <p><a href="{{route('Crm::view-campaign',$campValue['id'])}}" style="color: rgb(66, 141, 66);"> <i class="fa fa-eye"></i> View</a></p>
                                                    <p><a href="{{route('Crm::edit-campaign',$campValue['id'])}}" style="color: rgb(228, 188, 11);"> <i class="fa fa-pencil"></i> Edit</a></p>
                                                    <p><a href="{{route('Crm::delete-campaign',$campValue['id'])}}" onclick="myFunction()" style="color: rgb(165, 11, 5);" > 
                                                        <i class="fa fa-trash"></i> Delete</a></p>
                                                  </div>
                                                </div>
                                              </div>
                                              
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="row" style="margin: 20px; border: 1px solid gray; border-radius: 10px;">
                                    <div class="col-sm-12" style="padding: 20px; text-align: center;">
                                        <h2 class="text-muted">No campaigns created</h2>
                                        <div class="col-sm-12">
                                            <a style="float: none;" href="{{ route('Crm::create-campaign') }}" class="m-t-15 btn btn-primary">Create new Campaign</a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                        </div>
                    </div>
                </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

<?php ?>


@endsection
@section('js')
<!-- <script>
    function myFunction() {
        var txt;
        var r = confirm("Are you sure you want to delete");
        if (r == true) {
            window.location.href = this.getAttribute('href');
        } else {
            window.location.href = "{{ route('Crm::campaign') }}";
            event.preventDefault();
        }
        document.getElementById("demo").innerHTML = txt;
    }
</script> -->
@endsection

