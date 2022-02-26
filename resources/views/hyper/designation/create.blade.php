@extends('hyper.layout.master')
@section('title', "Designation Create")
@section('content')
<div class="contain er-fluid px-3">
    <!-- start page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('Crm::designation') }}"><i class="uil-home-alt"></i>Designation</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
                <h4 class="page-title">Create Designation</h4>
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
                        <form method="post" id="addForm" class="form-horizontal">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Designation <span class="red-txt">*</span></label>
                                        <input type="text" class="form-control" id="designation" name="designation" value="{{old('designation')}}" required>
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
$("#addForm").submit(function(event){
    event.preventDefault();
    $( ".btn" ).prop( "disabled", true );
    var designation = $('#designation').val();
    if (designation == '') {
        $.NotificationApp.send("Error","Designation field is required.","top-center","red","error");
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
        url:  "{{route('Crm::designation_store')}}",
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
                //location.reload();route('Crm::lead_details', ['id' => $lead->id])
                var url = "{{route('Crm::designation', '')}}";
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