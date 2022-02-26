<div class="col-sm-2 mb-2 mb-sm-0">
    <div class="card">
        <div class="card-head">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">
                    <i class="mdi mdi-home-variant d-md-none d-block"></i>
                    <span class="d-none d-md-block">Telephonic settings</span>
                </a>
                <a class="nav-link active show" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                    <i class="mdi mdi-account-circle d-md-none d-block"></i>
                    <span class="d-none d-md-block">Campaign</span>
                </a>
            </div>
        </div>
    </div>
</div> 

<div class="col-sm-10">
    <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade " id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <div class="card">
                <div class="card-body">
                    <p class="mb-0">Nothing to show..</p>
                </div>
            </div>
        </div>
        <div class="tab-pane fade active show" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
            <div class="card">
                <div class="card-body">
                    <a class="btn btn-danger float-right mr-1" href="{{ route('Crm::create-campaign') }}"><i class="uil-plus-circle"></i></a>
                    <h4 class="header-title">Outbound Campaign</h4>
                    <p class="">P2P calls and pre-recorded voice messages or IVR based campaigns for your customers</p>
                    <div class="table-responsive" id="renderpage">
                        @forelse($campaigns as $campKey => $camp)
                        @php
                            if($camp->start_date != NULL &&  $camp->start_date != ""){
                                $startDate = date('M d, Y', strtotime($camp->start_date));
                                }else{
                                $startDate = "";
                            }

                            if($camp->end_date != NULL &&  $camp->end_date != ""){
                                $endDate = date('M d, Y', strtotime($camp->end_date));
                            }else{
                                $endDate = "";
                            }
                        @endphp
                            <div class="mb-3 p-3 border border-secondary rounded">
                                <div class="row">
                                    <div class="col-lg-12">
                                        {{ $camp->name }} &nbsp;|&nbsp; 
                                        <span class="bg-gray">
                                            {{ $startDate}} to 
                                            {{ $endDate}}
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-11">
                                        <i class="uil-calendar-alt"></i>&nbsp; 
                                        {{ @ucwords($camp->days) }}   
                                        &nbsp;<i class="uil-clock"></i>&nbsp; 
                                        <span class="bg-gray">
                                        </span>
                                    </div>
                                    <div class="col-lg-1 dropdown">
                                        <a href="javascript:void(0);" class="dropdown-toggle arrow-none btn btn-secondary" role="button" id="vieweditdelete" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="uil-comment-alt-edit"></i>
                                        </a>
                                        <div class="dropdown-menu p-0 m-0" aria-labelledby="vieweditdelete">
                                            <a class="btn btn-success dropdown-item" href="{{ route('Crm::view-campaign', $camp->id) }}">
                                                <i class="uil-eye"></i>&nbsp; View
                                            </a>
                                            <a class="btn btn-info dropdown-item" href="{{ route('Crm::edit-campaign', ['id' => $camp->id]) }}">
                                                <i class="uil-edit"></i>&nbsp; Edit
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-warning  dropdown-item" onclick="campaigndestroy({{ $camp->id }})">
                                                <i class="uil-trash-alt"></i>&nbsp; Delete
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    // $available_leads = 0;
                                    // if(isset($camp->total_leads)){
                                    //     $available_leads = $camp->total_leads;
                                    //     if(isset($camp->completed)){
                                    //         $available_leads = $available_leads - $camp->completed;
                                    //     }
                                    //     if(isset($camp->follow_up)){
                                    //         $available_leads = $available_leads - $camp->follow_up;
                                    //     }
                                    // }


                                ?>

                                <div class="row">
                                    <div class="col-lg-2">Total Record</div>
                                    <div class="col-lg-1">{{ isset($camp->total_record) ? $camp->total_record : 'N.A' }}</div>
                                    <div class="col-lg-2">Available</div>
                                    <div class="col-lg-1">{{ isset($camp->total_leads) ? $camp->total_leads : 'N.A' }}</div>
                                    
                                    <div class="col-lg-2">Dialed</div>
                                    <div class="col-lg-1">{{ isset($camp->dialed) ? $camp->dialed : 'N.A' }}</div>
                                    <div class="col-lg-1">Status</div>
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-1">
                                        <!-- <a class="btn btn-success btn-sm" href="{{ route('Crm::view-campaign',$camp->id) }}">
                                            <i class="uil-eye"></i>
                                        </a> -->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-2">Completed</div>
                                    <div class="col-lg-1">{{ isset($camp->completed_leads) ? $camp->completed_leads : 'N.A' }}</div>
                                    <div class="col-lg-2">Both Answered</div>
                                    <div class="col-lg-1">{{ isset($camp->connected) ? $camp->connected : 'N.A' }}</div>
                                    <div class="col-lg-2">
                                        @if($camp->status == 1)
                                            <span class="badge badge-success badge-pill">Pause</span>
                                        @elseif($camp->status == 2)
                                            <span class="badge badge-warning badge-pill">Stop</span>
                                        @elseif($camp->status == 3)
                                            <span class="badge badge-danger badge-pill">Resume</span>
                                        @else
                                            <span class="badge badge-warning badge-pill">N.A</span>   
                                        @endif
                                    </div>
                                    <div class="col-lg-1">
                                        <!-- <a class="btn btn-info btn-sm" href="{{ route('Crm::edit-campaign',$camp->id) }}">
                                            <i class="uil-edit"></i>
                                        </a> -->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-2">Follow Up</div>
                                    <div class="col-lg-1">{{ isset($camp->follow_up_leads) ? $camp->follow_up_leads : 'N.A' }}</div>
                                    <div class="col-lg-2">Un-Answered</div>
                                    <div class="col-lg-1">{{ isset($camp->busy) ? $camp->busy : 'N.A' }}</div>
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-1">
                                        <!-- <a href="javascript:void(0);" class="btn btn-warning btn-sm" onclick="destroy({{ $camp->id }})">
                                            <i class="uil-trash-alt"></i>
                                        </a> -->
                                    </div>
                                </div>
                            </div>
                        @empty
                        <div>No Data Found.</div>
                        @endforelse
                        {!! $campaigns->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>