@extends('hyper.layout.master')
@section('title', "Staff Dashboard")
@section('content')


<div class="px-2">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="uil-home-alt"></i> {{ config('app.name') }}</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Staff</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
                <h4 class="page-title">Add Staff</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 
    
       
    <div class="card">
        <div class="card-body">

            <form class="ui form" id="save_staff" method="POST" enctype="multipart/form-data">
                
                <h3 class="header-title">Personal Details</h3>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            <label>Name <span class="red-txt">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required value="{{old('name')}}">
                        
                        </div>
                    </div>

                    


                    <div class="col-md-4">
                        <div class="form-group ">
                            <label>Nick Name</label>
                            <input type="text" class="form-control" id="nick_name" name="nick_name" value="{{old('nick_name')}}">
                
                        </div>
                    </div>
                
                    <div class="col-md-4">
                        <div class="form-group ">
                            <label>PAN card number</label>
                            <input type="text" class="form-control" id="pan_no" name="pan_no" value="{{old('pan_no')}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group ">
                            <label>Adhar card number</label>
                            <input type="text" class="form-control" id="adhar_no" name="adhar_no" value="{{old('adhar_no')}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group ">
                            <label>Tags</label>
                            <input type="text" class="form-control" id="tags" name="tags" value="{{old('tags')}}">
                            
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group ">
                            <label>Gender</label>
                            <select class="form-control custom-select" id="gender" name="gender">
                                <option value="Male" {{ (old('gender') == "Male" ? 'selected': '') }}>Male</option>
                                <option value="Female" {{ (old('gender') == "Female" ? 'selected': '') }}>Female
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group ">
                            <label>Marital Status</label>
                            <select class="form-control custom-select" id="marriedstatus" name="marriedstatus">
                                <option value="Single" {{ (old('marriedstatus') == "Single" ? 'selected': '') }}>Single
                                </option>
                                <option value="Married" {{ (old('marriedstatus') == "Married" ? 'selected': '') }}>
                                    Married</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{old('address')}}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Age</label>
                            <input type="text" class="form-control" id="age" name="age" value="{{old('age')}}">
                        </div>
                    </div>
                </div>

                <h3 class="header-title">Contact Details</h3>
                <hr>
              
                <div class="numbermore row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Email <span class="red-txt">*</span> </label>
                            <input type="email" class="form-control" id="email" name="email" required value="{{old('email')}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div style="display: inline-block; width: 100%;">
                                <div id="verify_mobile" style="display: none;float: right;">
                                    <button class="btn btn-danger" type="button" id="verify_label">Verify</button>
                                </div>
                                <label>Mobile <span class="red-txt">*</span></label>
                            </div>
                                <input type="text" class="form-control" id="mobile" name="mobile" value="{{old('mobile')}}">
                                <input type="number" class="form-control" id="otp" name="otp" value="" placeholder="Enter Otp" style="display: none; margin-top: 10px">
                                <input type="hidden" id="sender_id" value="{{ auth()->user()->id }}" />
                        </div>
                    </div>
                    <div class="col-md-3 add-inp-div">
                        <div class="form-group">
                            <label>Alternate Number</label>
                            <input type="text" class="form-control" name="alt_mobile[]" />
                        </div>
                    </div>

                    <div class="col-md-1 add-btn-div">
                        <button class="btn btn-sm btn-primary family-add-btn addAlternate" type="button"><i class="uil-plus-circle"></i></button>
                    </div>
                </div>

                <div class="row" id="alternetcontainer"></div>

                <h3 class="header-title">Work</h3>
                <hr>

                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Department</label>
                            <select class="form-control custom-select" name="department" id="department">
                                <option value="">Please select..</option>
                                @if(!empty($departments))
                                @foreach($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ (old('department') == $department->id ? 'selected': '') }}>
                                    {{ $department->department }}
                                </option>
                                @endforeach
                                @endif
                                <option value="add">Add Value</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group ">
                            <label>Location <span class="red-txt">*</span></label>
                            <input type="text" class="form-control" id="location" name="location" value="{{old('location')}}">
                
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group ">
                            <label>Reporting To</label>
                            <select class="form-control custom-select" name="reporting_to" id="reporting_to">
                                <option value="">Please select..</option>
                                <option value="Test User" {{ (old('reporting_to') == "Test User" ? 'selected': '') }}>Test User</option>
                    
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row"> 

                    <div class="col-md-4">
                        <div class="form-group ">
                            <label>Title</label>
                            <input type="text" class="form-control" id="work_title" name="work_title" value="{{old('work_title')}}">
                
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group ">
                            <label>Source of hire</label>
                            <select class="form-control custom-select" name="hire_source" id="hire_source">
                                <option value="">Please select..</option>
                                <option value="Direct" {{ (old('hire_source') == "Direct" ? 'selected': '') }}>Direct</option>
                                <option value="Web" {{ (old('hire_source') == "Web" ? 'selected': '') }}>Web</option>
                                <option value="Referral" {{ (old('hire_source') == "Referral" ? 'selected': '') }}>Referral</option>
                                <option value="Newspaper" {{ (old('hire_source') == "Newspaper" ? 'selected': '') }}>Newspaper</option>
                                <option value="Advertisement" {{ (old('hire_source') == "Advertisement" ? 'selected': '') }}>Advertisement</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Date of Joining</label>
                            <input type="date" class="form-control" id="joining_date" name="joining_date" value="{{old('joining_date')}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Seating Location <span class="red-txt">*</span></label>
                            <input type="text" class="form-control" id="seating_location" name="seating_location" value="{{old('seating_location')}}">
                
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group ">
                            <label>Staff status</label>
                            <select class="form-control custom-select" name="work_status" id="work_status">
                                <option value="">Please select..</option>
                                <option value="Active" {{ (old('work_status') == "Active" ? 'selected': '') }}>Active</option>
                                <option value="Terminated" {{ (old('work_status') == "Terminated" ? 'selected': '') }}>Terminated</option>
                                <option value="Deceased" {{ (old('work_status') == "Deceased" ? 'selected': '') }}>Deceased</option>
                                <option value="Resigned" {{ (old('work_status') == "Resigned" ? 'selected': '') }}>Resigned</option>
                            </select>
                        </div>
                    </div>

                    
                    <div class="col-md-4">
                        <div class="form-group ">
                            <label>Staff type</label>
                            <select class="form-control custom-select" name="staff_type" id="staff_type">
                                <option value="">Please select..</option>
                                <option value="Permanent" {{ (old('staff_type') == "Permanent" ? 'selected': '') }}>Permanent</option>
                                <option value="On Contract" {{ (old('staff_type') == "On Contract" ? 'selected': '') }}>On Contract</option>
                                <option value="Temporary" {{ (old('staff_type') == "Temporary" ? 'selected': '') }}>Temporary</option>
                                <option value="Trainee" {{ (old('staff_type') == "Trainee" ? 'selected': '') }}>Trainee</option>
                                
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Work phone</label>
                            <input type="text" class="form-control" id="work_phone" name="work_phone" value="{{old('work_phone')}}">
                
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Extension</label>
                            <input type="text" class="form-control" id="extension" name="extension" value="{{old('extension')}}">
                
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Role</label>
                            <select class="form-control custom-select" name="work_role" id="work_role">
                                <option value="">Please select..</option>
                                @if(!empty($roles))
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ (old('work_role') == $role->id ? 'selected': '') }}>
                                    {{ $role->name }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Experience</label>
                            <input type="text" class="form-control" id="experience" name="experience" value="{{old('experience')}}">
                
                        </div>
                    </div>

                </div>

                <h3 class="header-title">Summary</h3>
                <hr>
                <div class="row">
                         
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Job Description</label>
                            <input type="text" class="form-control" id="job_desc" name="job_desc" value="{{old('job_desc')}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>AboutMe</label>
                            <input type="text" class="form-control" id="about_me" name="about_me" value="{{old('about_me')}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <label>Ask me about/Expertise</label>
                            <input type="text" class="form-control" id="expertise" name="expertise" value="{{old('expertise')}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <label>Date of exit</label>
                            <input type="date" class="form-control" id="exit_date" name="exit_date" value="{{old('exit_date')}}">
                        </div>
                    </div>

                </div>
                <br>
                <h3 class="header-title">Work experience</h3>
                <hr>
                <div class="work_fieldmore row">
                    <div class="add2-inp-div">
                        <div class="form-group">
                            <label>Previous Company Name</label>
                            <input type="text" class="form-control" name="exp_company_name[]" value="{{old('exp_company_name')}}">
                        </div>
                    </div>

                    <div class="add2-inp-div">
                        <div class="form-group">
                            <label>Job Title</label>
                            <input type="text" class="form-control" name="exp_job_title[]" value="{{old('exp_job_title')}}">
                        </div>
                    </div>
                    
                    <div class="add2-inp-div">
                        <div class="form-group">
                            <label>From Date</label>
                            <input type="date" class="form-control" name="exp_from_date[]" value="{{old('exp_from_date')}}">
                        </div>
                    </div>
                    <div class="add2-inp-div">
                        <div class="form-group">
                            <label>To Date</label>
                            <input type="date" class="form-control" name="exp_to_date[]" value="{{old('exp_to_date')}}">
                        </div>
                    </div>
                    <div class="add2-inp-div">
                        <div class="form-group">
                            <label>Job Description</label>
                            <input type="text" class="form-control" name="exp_job_desc[]" value="{{old('exp_job_desc')}}">
                        </div>
                    </div>

                    <div class="add-btn-div">
                        <a href="javascript:void(0);" class="btn btn-sm btn-primary family-add-btn addMoreWork"
                            onclick="$('.dimmer').removeClass('dimmer')"><i class="uil-plus-circle"></i></a>
                    </div>
                </div>

                <h3 class="header-title">Education</h3>
                <hr>


                <div class="education_fieldmore row">
                    <div class="add1-inp-div">
                        <div class="form-group">
                            <label>School Name</label>
                            <input type="text" class="form-control" name="edu_school_name[]" value="{{old('edu_school_name')}}">
                        </div>
                    </div>

                    <div class="add1-inp-div">
                        <div class="form-group">
                            <label>Degree/Diploma</label>
                            <input type="text" class="form-control" name="edu_degree[]" value="{{old('edu_degree')}}">
                        </div>
                    </div>



                    <div class="add1-inp-div">
                        <div class="form-group">
                            <label>Field(s) of Study</label>
                            <input type="text" class="form-control" name="edu_branch[]" value="{{old('edu_branch')}}">
                        </div>
                    </div>

                    <div class="add1-inp-div">
                        <div class="form-group">
                            <label>Date of Completion</label>
                            <input type="date" class="form-control" name="edu_completion_date[]" value="{{old('edu_completion_date')}}">
                        </div>
                    </div>
                        
                    <div class="add1-inp-div">
                        <div class="form-group">
                            <label>Additional Notes</label>
                            <input type="text" class="form-control" name="edu_add_note[]" value="{{old('edu_add_note')}}">
                        </div>
                    </div>
                    <div class="add1-inp-div">
                        <div class="form-group">
                            <label>Interests</label>
                            <input type="text" class="form-control" name="edu_interest[]" value="{{old('edu_interest')}}">
                        </div>
                    </div>

                    <div class="add-btn-div">
                        <a href="javascript:void(0);" class="btn btn-sm btn-primary family-add-btn addMoreEducation"
                            onclick="$('.dimmer').removeClass('dimmer')"><i class="uil-plus-circle"></i></a>
                    </div>
                </div>
                
                <h3 class="header-title">Family Details</h3>
                <hr>
                <div class="fieldmore row">
                    <div class="addfamily-inp-div">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="staff_relation_name[]" value="{{old('staff_relation_name')}}">
                        </div>
                    </div>

                    <div class="addfamily-inp-div">
                        <div class="form-group">
                            <label>Relationship</label>
                            <input type="text" class="form-control" name="staff_relation[]" value="{{old('staff_relation')}}">
                        </div>
                    </div>

                    <div class="addfamily-inp-div">
                        <div class="form-group">
                            <label>Date of Birth</label>
                            <input type="date" class="form-control" name="staff_relation_dob[]" value="{{old('staff_relation_dob')}}">
                        </div>
                    </div>

                    <div class="addfamily-inp-div">
                        <div class="form-group">
                            <label>Mobile</label>
                            <input type="text" class="form-control" name="staff_relation_mobile[]" value="{{old('staff_relation_mobile')}}">
                        </div>
                    </div>

                    <div class="add-btn-div">
                        <a href="javascript:void(0);" class="btn btn-sm btn-primary family-add-btn addMore"
                            onclick="$('.dimmer').removeClass('dimmer')"><i class="uil-plus-circle"></i></a>
                    </div>
                </div>
                <div class="my-2 float-right">
                    <button type="submit" class="btn btn-primary float-right mb-3 mt-3 mr-4" >Submit</button>
                </div>
                
                

            </form>

        </div>
    </div>
</div>


<!-- copy of input fields group -->
<div class="numberCopy" style="display: none;">
    <div class="addnum-inp-div">
        <div class="form-group">
            <label>Alternate Number</label>
            <input type="text" class="form-control" name="alt_mobile[]" />
        </div>
    </div>

    <div class="addnum-btn-div">
        <button class="btn btn-sm btn-danger family-add-btn remove_alt" type="button"><i class="uil-minus-circle"></i></button>    
    </div>
</div>


<!-- copy of experience input fields group -->

<div class="work_fieldmoreCopy row"  style="display: none;">
    <div class="add2-inp-div">
        <div class="form-group">
            <label>Previous Company Name</label>
            <input type="text" class="form-control" name="exp_company_name[]">
        </div>
    </div>

    <div class="add2-inp-div">
        <div class="form-group">
            <label>Job Title</label>
            <input type="text" class="form-control" name="exp_job_title[]">
        </div>
    </div>
    
    <div class="add2-inp-div">
        <div class="form-group">
            <label>From Date</label>
            <input type="date" class="form-control" name="exp_from_date[]">
        </div>
    </div>
    <div class="add2-inp-div">
        <div class="form-group">
            <label>To Date</label>
            <input type="date" class="form-control" name="exp_to_date[]">
        </div>
    </div>
    <div class="add2-inp-div">
        <div class="form-group">
            <label>Job Description</label>
            <input type="text" class="form-control" name="exp_job_desc[]">
        </div>
    </div>

    <div class="add-btn-div">
        <a href="javascript:void(0);" class="btn btn-sm btn-danger family-add-btn remove"
            onclick="$('.dimmer').removeClass('dimmer')"><i class="uil-minus-circle"></i></a>
    </div>
</div>
<!-- copy of experience input fields group -->

<!-- copy of education input fields group -->
<div class="education_fieldmoreCopy row"  style="display: none;">
    <div class="add1-inp-div">
        <div class="form-group">
            <label>School Name</label>
            <input type="text" class="form-control" name="edu_school_name[]">
        </div>
    </div>

    <div class="add1-inp-div">
        <div class="form-group">
            <label>Degree/Diploma</label>
            <input type="text" class="form-control" name="edu_degree[]">
        </div>
    </div>



    <div class="add1-inp-div">
        <div class="form-group">
            <label>Field(s) of Study</label>
            <input type="text" class="form-control" name="edu_branch[]">
        </div>
    </div>

    <div class="add1-inp-div">
        <div class="form-group">
            <label>Date of Completion</label>
            <input type="date" class="form-control" name="edu_completion_date[]">
        </div>
    </div>
        
    <div class="add1-inp-div">
        <div class="form-group">
            <label>Additional Notes</label>
            <input type="text" class="form-control" name="edu_add_note[]">
        </div>
    </div>
    <div class="add1-inp-div">
        <div class="form-group">
            <label>Interests</label>
            <input type="text" class="form-control" name="edu_interest[]">
        </div>
    </div>

    <div class="add-btn-div">
        <a href="javascript:void(0);" class="btn btn-sm btn-danger family-add-btn remove"
            onclick="$('.dimmer').removeClass('dimmer')"><i class="uil-minus-circle"></i></a>
    </div>
</div>
<!-- copy of education input fields group -->


<!-- copy of input fields group -->
<div class="fieldmoreCopy row" style="display: none;">

    <div class="add-inp-div">
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="staff_relation_name[]">
        </div>
    </div>

    <div class="add-inp-div">
        <div class="form-group">
            <label>Relationship</label>
            <input type="text" class="form-control" name="staff_relation[]">
        </div>
    </div>

    <div class="add-inp-div">
        <div class="form-group">
            <label>Date of Birth</label>
            <input type="date" class="form-control" name="staff_relation_dob[]">
        </div>
    </div>

    <div class="add-inp-div">
        <div class="form-group">
            <label>Mobile</label>
            <input type="text" class="form-control" name="staff_relation_mobile[]">
        </div>
    </div>

    <div class="add-btn-div">
        <a href="javascript:void(0);" class="btn btn-sm btn-danger family-add-btn remove"
            onclick="$('.dimmer').removeClass('dimmer')"><i class="uil-minus-circle"></i></a>
    </div>
</div>

                            


                      
                        
                        
                        
                    
                
  
@endsection
@section('extrascripts')
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
<script>

    $(document).ready(function () {
    $('#save_staff').submit(function (e) {
        e.preventDefault();

        var name = $('#name').val();
        var email = $('#email').val();
        //var mobile = $('#mobile').val();
        if (name == '' && email == '') {
            // swal('Warning!', 'All fields are required', 'warning');
            $.NotificationApp.send("Error","Name and email fields are required.","top-center","red","error");
            return false;
        }

        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })

        var formData=new FormData(this);
        
         my_url = "{{ route('Crm::save_staff') }}";
        var type = "POST";
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $.NotificationApp.send("Success","Staff has been created successfully!","top-center","green","success");
                setTimeout(function(){
                    location.href = "{{ route('Crm::staff') }}";
                }, 3500);
            }, error: function (data) {
                $.NotificationApp.send("Error","Something is wroung. Please try again!","top-center","red","error");
                setTimeout(function(){
                    //location.reload();
                }, 3500);
            },
        });
    });
    
    
    });
    $(document).ready(function(){
        
    //group add limit
    var maxGroup = 3;


    //add more fields group
    $(".addMoreWork").click(function(){
        if($('body').find('.work_fieldmore').length < maxGroup){
            var fieldHTML = '<div class="work_fieldmore row">'+$(".work_fieldmoreCopy").html()+'</div>';
            $('body').find('.work_fieldmore:last').after(fieldHTML);
        }else{
            alert('Maximum '+maxGroup+' groups are allowed.');
        }
    });

    //remove fields group
    $("body").on("click",".remove",function(){ 
        $(this).parents(".work_fieldmore").remove();
    });

    //add more fields group
    $(".addMoreEducation").click(function(){
        if($('body').find('.education_fieldmore').length < maxGroup){
            var fieldHTML = '<div class="education_fieldmore row">'+$(".education_fieldmoreCopy").html()+'</div>';
            $('body').find('.education_fieldmore:last').after(fieldHTML);
        }else{
            alert('Maximum '+maxGroup+' groups are allowed.');
        }
    });

    //remove fields group
    $("body").on("click",".remove",function(){ 
        $(this).parents(".education_fieldmore").remove();
    });
    
    //add more fields group
    $(".addMore").click(function(){
        if($('body').find('.fieldmore').length < maxGroup){
            var fieldHTML = '<div class="fieldmore row">'+$(".fieldmoreCopy").html()+'</div>';
            $('body').find('.fieldmore:last').after(fieldHTML);
        }else{
            alert('Maximum '+maxGroup+' groups are allowed.');
        }
    });
     //add more address group
     $(".addAddress").click(function(){
         var length=$('body').find('.addressmore').length;
        if( length< maxGroup){
            var clone = $(".addressmore:last").clone();
            clone.find("#state_"+length).attr("id","state_"+(length+1));
            clone.find("#district_"+length).attr("id","district_"+(length+1));
            var btn=clone.find(".addAddress");
            var type=clone.find('.header_title');
            var address_type=clone.find('#address_type');
            address_type.val('temp');
            type.text('Temporary Address');
            btn.html('<i class="fa fa-minus"></i>');
            btn.addClass('btn-danger').removeClass('btn-primary');
            btn.attr("id","remove_address");
            
            $('body').find('.addressmore:last').after(clone);
        }else{
            alert('Maximum '+maxGroup+' address are allowed.');
        }
    });
    //add AlternateNumbers
    $(".addAlternate").click(function(){
        if($('body').find('.numbermore').length < maxGroup){
            var fieldHTML = '<div class="col-md-4 numbermore">'+$(".numberCopy").html()+'</div>';
            //$('body').find('.numbermore:last').after(fieldHTML);
            $('#alternetcontainer').append(fieldHTML);
        }else{
            alert('Maximum '+maxGroup+' numbers are allowed.');
        }
    });
    
    $('#mobile').on('input',function(e){
        var value=$(this).val();
        if(value.length>=10){
            $('#verify_mobile').show();
        }
    });
    /*send otp*/
$('#verify_mobile').click(function () {
    if($('#verify_label').text()=='Verified')   {
        return;
    }
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })       
    
    var sender = $("#sender_id").val();
    var receiver_mobile = $("#mobile").val();
    if($('#verify_label').text()!='Verify') {
        if ($('#otp').val() == '') {
            swal('Warning!', 'Please enter Otp!', 'warning')
            return false;
        }
        $('#verify_label').html('Verifying..');
        $.ajax({
        type: 'post',
        url: "{{ route('Crm::verify_otp') }}",
        data: {receiver_mobile:receiver_mobile,otp:$('#otp').val()},
        success: function (data) {          
            if(data.status=='success'){
                 $('#verify_label').html('Verified');
                 $('#otp').hide(); 
                
            }else {             
                $('#verify_label').html('Wrong Otp! Reverify');
            }
        }
    });
    }   
    else{
    $('#verify_label').html('SENDING..');
    $.ajax({
        type: 'post',
        url: "{{ route('Crm::send_otp') }}",
        data: {sender:sender,receiver_mobile:receiver_mobile},
        success: function (data) {          
            if(data.status=='success'){
                 $('#verify_label').html('Verify Otp');
                 $('#otp').show(); 
                //  setTimeout(function(){                          
                //     location.reload();
                // }, 3000);
            }else {             
                $('#verify_label').html('Resend');
            }
        }
    });
}
    
});
    //remove fields group
    $("body").on("click",".remove",function(){ 
        $(this).parents(".fieldmore").remove();
    });
     //remove address group
     $("body").on("click","#remove_address",function(){ 
        $(this).parents(".addressmore").remove();
    });
    $("body").on("click",".remove_alt",function(){ 
        $(this).parents(".numbermore").remove();
    });

    $('#account_type_id').change(function(){
                //Selected value
                var inputValue = $(this).val();
                //Ajax for calling php function
                 if ('add' == inputValue){
                    $("#detail_type").val(0);
              $("#AddDetails").modal("show");
          }
            });
    $('#sms').change(function () {
        if(this.checked)
        $('#sms_language').show();
        else
        $('#sms_language').hide();
    });
    $('#department').change(function(){
                //Selected value
                var inputValue = $(this).val();
                //Ajax for calling php function
                 if ('add' == inputValue){
                    $("#detail_type").val(3);
              $("#AddDetails").modal("show");
          }
    });
    $('#branch').change(function(){
                //Selected value
                var inputValue = $(this).val();
                //Ajax for calling php function
                 if ('add' == inputValue){
                    $("#detail_type").val(4);
              $("#AddDetails").modal("show");
          }
    });
    $('#member_type_id').change(function(){
                //Selected value
                var inputValue = $(this).val();
                //Ajax for calling php function
                 if ('add' == inputValue){
                    $("#detail_type").val(1);
              $("#AddDetails").modal("show");
          }
    });
    $('#source_id').change(function(){
                //Selected value
                var inputValue = $(this).val();
                //Ajax for calling php function
                 if ('add' == inputValue){
                    $("#detail_type").val(2);
              $("#AddDetails").modal("show");
          }
            });
    $('#add_detail').submit(function (e) {
        e.preventDefault();
        //  e.preventDefault();
        $("#AddDetails").modal("hide");

        var detail = $('#detail').val();
        if (detail == '') {
            swal('Warning!', 'Please enter value', 'warning');
            return false;
        }

        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        var formData=new FormData(this);
        var my_url='';
        
        if($('#detail_type').val()==3){
            my_url=APP_URL + '/console/manage/departmentData';
            formData.append('department',detail);
        }
        else if($('#detail_type').val()==4){
            my_url=APP_URL + '/console/manage/branchData';
            formData.append('branch',detail);
        }
        else
         my_url = APP_URL + '/console/manage/memberData';
        var type = "POST";
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                swal({
                    title: "Success!",
                    text: "Account details has been submited!",
                    type: "success"
                }, function () {
                    location.reload();
                });
            },
            error: function (data) {
                swal('Error!', data, 'error')
            }
        });
    });
    
    
});
</script>
@endsection