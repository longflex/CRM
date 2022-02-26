@extends('layouts.admin.panel')
@section('breadcrumb')
     <div class="ui breadcrumb">
        <div class="active section">{{  trans('laralum.receipt_request') }}</div>
    </div>
@endsection
@section('title', trans('laralum.receipt_request'))
@section('content')
  <div class="ui one column doubling stackable grid container">
  	<div class="column">
	
  		<div class="ui very padded segment">
		    <div class="table-responsive">
			<table class="table1 table-striped table-bordered" id="example">
  			  <thead>
  			    <tr class="table-head">
				  <th width="5%">S.N</th>
				  <th width="13%">Client</th>
                  <th width="15%">Receipt</th>
                  <th width="15%">Description</th>
				 
  			    </tr>
  			  </thead>
  			  <tbody>
                  @foreach($receipts as $key=>$val)
					<tr>
					
						<td>
                          <div class="text">
						  {{ ++$key }}
                          </div>
                        </td>
                        <td>
                           <div class="text">
                            {{ $val->user_id  }}
                           </div>
                        </td>
                        <td>
                           <div class="text">
                              {{ $val->image }}
                           </div>
                        </td>
                        <td>
                          <div class="text">
                              {{ $val->description }}
                           </div>
                        </td>
                        
					</tr>
				@endforeach
  			  </tbody>
  			</table>
			
  		</div>
  		</div>
		
        <br>
  	</div>
  </div>

<!--contact-table-only-search-->
<script>
$(document).ready(function() {
    $('#example').DataTable( {
        "ordering": false,
    } );
} );

</script>
@endsection
