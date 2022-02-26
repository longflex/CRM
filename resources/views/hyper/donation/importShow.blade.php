@extends('hyper.layout.master')
@section('title', "Donation Import")
@section('content')
<style>
/*.modal-dialog {
          width: 2000px;
        }*/
/*.modal-box {
  width: 500px;
  border: 1px solid black;
  padding: 10px;
  margin: 10px;
}
.modal-ku {
  width: 1200px;
  height:600px !important;
  margin: auto;
}*/
    </style>
<div class="px-2">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('Crm::donations') }}"><i class="uil-home-alt"></i>Donation</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('Crm::donations_report') }}">Donation Report</a></li>
                        <li class="breadcrumb-item active">Import</li>
                    </ol>
                </div>
                <h4 class="page-title">Import Donation</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 
    
       
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-7">
                    <p>
                        1. Your CSV data should be in the format below. The first line of your CSV file should be the column headers. Also make sure that your file is UTF-8 to avoid unnecessary encoding problems.<br/>
                        
                        2. Mobile no is mandatory.<br/>

                        3. Lead name,email,mobile and member id.<br/>

                        4. For Donation type use the text of "type" field.<br/>

                        3. For Donation Purpose use the text of "purpose" field.<br/>

                        4. For When Will Donate use the integer 0 for 'now' or 1 for  "Will Donate" and 2 for  "Already Donate".<br/>

                        5. If 'When Will Donate' is 1 then 'Willing To Donate' will be "As soon As Possible" or "This Week" or "This Year"  or "Next Year" or "online" or "Jan" or "Feb" or "Mar" or "Apr" or "May" or "Jun" or "July" or "Aug" or "Sep" or "Oct" or "Nov" or "Dec"  .<br/>

                        6. If 'When Will Donate' is 1 then fill the donation date .<br/>

                        7. For 'Payment Type' use the text "single" or "recurring".<br/>

                        8. If 'Payment Type' is 'recurring' then 'Payment Period' will be "daily" or "weekly" or "monthly" or "yearly" and fill the 'payment start date' and 'payment end date' fields.<br/>

                        9. 'Payment Mode' will be "CASH" or "CARD" or "CHEQUE" or "Razorpay" or "QRCODE" or "OTHER".<br/>

                        10. If 'Payment Mode' is 'CHEQUE' then fill fields 'Bank name' and 'Branch' and 'Cheque number' and 'Cheque date' <br/>

                        11. If 'Payment Mode' is 'QRCODE' then fill fields 'Reference no.'  <br/>

                        12. If 'Payment Mode' is 'OTHER' then fill fields 'Payment Method.'  <br/>

                        13. For Payment Status use 0 for 'Not Paid' and 1 for 'Paid'.<br/>

                        14. For Gift Issued use the text 'Yes' or 'No'.<br/>
                        <hr/>
                    </p>

                </div>
                <div class="col-md-5">
                    <form method="POST" enctype="multipart/form-data" class="dropzone" id="importForm" data-plugin="dropzone" data-previews-container="#file-previews"
                    data-upload-preview-template="#uploadPreviewTemplate">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <input type="hidden" value="{{ $client_id }}" name="import_donation_client_id" />
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
                            <a href="{{ url('files/sample-csv-donations.csv') }}" download>Download Sample
                               Donation File</a>
                        </div>
                    </form>
                    <button class="btn btn-primary" onclick="updateCallDetail('9934882487')">Launch modal</button>
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
        url:  "{{route('Crm::donations_import')}}",
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
            setTimeout(function(){
                //location.reload();
            }, 3500);
        
        }

        if(data.status==true){
            $.NotificationApp.send("Success",data.message,"top-center","green","success");
            setTimeout(function(){
                var url = "{{route('Crm::donations')}}";
                location.href=url;
            }, 3500);
            //$('#addModal').modal("hide");
            //$('#addModal').click();
            //$('#addForm').trigger("reset");
        }

    })
    // using the fail promise callback
    .fail(function(data) {
        $.NotificationApp.send("Error",data.message,"top-center","red","error");
        setTimeout(function(){
            //location.reload();
        }, 3500);
    });

})





</script>



@endsection