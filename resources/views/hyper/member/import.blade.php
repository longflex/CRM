@extends('hyper.layout.master')
@section('title', "Members Import")
@section('content')


<div class="px-2">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('Crm::members_dashboard') }}"><i class="uil-home-alt"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('Crm::members') }}">List</a></li>
                        <li class="breadcrumb-item active">Import</li>
                    </ol>
                </div>
                <h4 class="page-title">Import Members</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 
    
       
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        1. Your CSV data should be in the format below. The first line of your CSV file should be the column headers. Also make sure that your file is UTF-8 to avoid unnecessary encoding problems.<br/>
                        2. Duplicate mobile according to bussiness account(unique) rows will not be imported.<br/>
                        3. For Gender use Male, Female value.<br/>
                        3. For Married Status use Single, Married value.<br/>
                        <hr/>
                    </p>
                    <form method="POST" enctype="multipart/form-data" class="dropzone" id="importForm" data-plugin="dropzone" data-previews-container="#file-previews"
                    data-upload-preview-template="#uploadPreviewTemplate">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <input type="file" name="file" id="file" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group float-right">
                                <input type="submit" name="importSubmit" class="btn btn-primary button ml-5" value="Import">
                            </div>
                        </div>
                        
                    </div>
                        
                        
                    <div class="mb-15 mt-30 text-right">
                        <a href="{{ url('files/sample-csv-leads.csv') }}" download>Download Sample
                           Member File</a>
                    </div>
                    
                    
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>          
  
@endsection
@section('extrascripts')


<script>
$("#importForm").submit(function(event){
    event.preventDefault();
    $( ".btn" ).prop( "disabled", true );
    //var formData = $(this).serializeArray();
    var file_data = $("#file").prop("files")[0]; 
    var path = $('#file').val();
    var res = path.split(".");
    var length =  (res.length)-1;
    var format = res[length]; // Getting the properties of file from file field
    if(format=='csv'){
        // continue .
    }else{
        alert('Only csv formats are allowed !');
        $( ".btn" ).prop( "disabled", false );
        return;
    }
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })
    var formData=new FormData(this);
    formData.append("file", file_data);
    formData.append('action_type',"FILE");
    $.ajax({
        type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
        url:  "{{route('Crm::leads_import')}}",
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
            }, 3500);
            //$('#addModal').modal("hide");
            //$('#addModal').click();
            //$('#addForm').trigger("reset");
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