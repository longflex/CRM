@extends('layouts.crm.newLayout')
<!-- @section('breadcrumb')
<div class="ui breadcrumb">
    <div class="active section">Campaign</div>
</div>
@endsection -->
@section('title', "Campaign")
@section('icon', "mobile")
@section('content') 
<div class="ui one column doubling stackable grid container mb-20 p-0" style="background: #fff;">
    <div class="row">
        <div id="getcampaign">
            @include('crm/campaign/page')
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
    
        $(document).on('click', '.pagination a',function(event)
        {
            event.preventDefault();
            var page=$(this).attr('href').split('page=')[1];
  
            getData(page);
        });
  
        function getData(page) {
            
            $.ajax({
                type: "GET",
                url: "{{route('Crm::campaign-get')}}"+'?page=' + page,
                success:function(data){
                    console.log(data);
                    $('#getcampaign').html(data);
                    $("#customID").hide();
                    $("#customID").removeClass( "ui text loader" );
                    $("#customID").removeClass( "page transition visible active" );
                }
          });
        }
</script>
<script type="text/javascript">
    $(document).on('click', '.button', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    swal({
            title: "Are you sure!",
            type: "error",
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes!",
            showCancelButton: true,
        },
        function() {
            $.ajax({
                type: "GET",
                url: "{{route('Crm::delete-campaign')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id":id
                },
                success: function (data) {
                              if (data.success){
                                    swalWithBootstrapButtons.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        "success"
                                    );
                                    $("#id"+id+"").remove(); // you can add name div to remove
                                }

                    }         
            });
    });
});
</script>
@endsection



