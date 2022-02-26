@extends('hyper.layout.master')
@section('title', "Department Update")
@section('content')
<div class="contain er-fluid px-3">
    <!-- start page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('Crm::department') }}"><i class="uil-home-alt"></i>Department</a></li>
                        <li class="breadcrumb-item active">Update</li>
                    </ol>
                </div>
                <h4 class="page-title">Update Department</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- start page body -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="container">
                        <form method="post" id="editForm" class="form-horizontal">
                            <input type="hidden" name="edit_id" value="{{$id}}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Department <span class="red-txt">*</span></label>
                                        <input type="text" class="form-control" id="department" name="department" value="{{ old('department', isset($department) ? $department->department : '') }}" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-success float-right">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end page body -->
</div>
@endsection
@section('extrascripts')
<script>
$("#editForm").submit(function(event){
    event.preventDefault();
    $( ".btn" ).prop( "disabled", true );
    var edit_id=$('#edit_id').val();
    var department = $('#department').val();
    if (department == '' ) {
        $.NotificationApp.send("Error","Department fields are required.","top-center","red","error");
        $( ".btn" ).prop( "disabled", false );
        return false;
    }
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })
    var formData=new FormData(this);
    $.ajax({
        type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
        url:  "{{route('Crm::department_update')}}",
        data:formData ,
        dataType: 'json', // what type of data do we expect back from the server
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        dataType: 'json',
    })
    // using the done promise callback
    .done(function(data) {
        if(data.status==false){
            $.NotificationApp.send("Error",data.message,"top-center","red","error");
            $( ".btn" ).prop( "disabled", false );
            setTimeout(function(){
                //location.reload();
            }, 3500);
        
        }

        if(data.status==true){
            $.NotificationApp.send("Success",data.message,"top-center","green","success");
            $( ".btn" ).prop( "disabled", false );
            setTimeout(function(){
                //location.reload();
                var url = "{{route('Crm::department')}}";
                location.href=url;
            }, 3500);
        }

    })
    // using the fail promise callback
    .fail(function(data) {
        $.NotificationApp.send("Error",data.message,"top-center","red","error");
        $( ".btn" ).prop( "disabled", false );
        setTimeout(function(){
            //location.reload();
        }, 3500);
    });

})
</script>
@endsection