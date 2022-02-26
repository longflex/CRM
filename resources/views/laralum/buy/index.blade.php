@extends('layouts.admin.panel') 
@section('breadcrumb')
<div class="ui breadcrumb">
        <div class="active section">{{ trans('laralum.group_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.delivery_manager'))
@section('content')
<div class="ui one column doubling stackable grid container mb-20 mt-20">
<div class="column">
 <div class="ui very padded segment">
<div class="col-md-12">
<h3>Pay online via</h3>
<img src="{{ asset(Laralum::publicPath() .'/images/payment-option.jpg') }}" class="img-responsive payment-img" />
<button type="submit" class="ui teal submit button">Proceed</button>
<div class="text-center">
<h2 class="background-or"><span>OR</span></h2>
</div>
<h3>Pay Manually into one of our following bank account:</h3>
<p>Note: Please mention your username in descreption while making payment via bank transfer or cash deposit</p>
<div class="table-responsive mt-20">
  <table class="table">
    <thead>
      <tr>
        <th>Bank</th>
        <th>IFSC Code</th>
        <th>A/c No.</th>
         <th>A/C Name</th>
        <th>Address</th>
      </tr>
    </thead>
    <tbody>
	@foreach($banks as $bank)
      <tr>
        <td>{{ $bank->bank }}</td>
        <td>{{ $bank->ifsc_code }}</td>
        <td>{{ $bank->ac_number }}</td>
        <td>{{ $bank->ac_name }}</td>
        <td>{{ $bank->address }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<h3 class="mt-0 mb-15">and let us know by uploading receipt:</h3>
<form method="POST" enctype="multipart/form-data">
   <input type="hidden" name="_token" value="{{ csrf_token() }}">  
	<div class="row">
	<div class="form-group col-md-4 mb-5">
	<label>Upload your receipt:</label>
	<input type="file"  name="image" class="inp_file" />
	</div>
    
	<div class="form-group col-md-12">
	Max size: 50 KB. Supported Formates .jpg, .png, .gif, .jpeg, .txt, .doc, docx
	</div>

	<div class="form-group col-md-4">
	<label>Comments:</label>
	<textarea class="inp_txt" name="desc"></textarea>
	</div>

	<div class="form-group col-md-12">
	<button type="submit" class="ui teal submit button">Submit</button>
	</div>
	</div>
</form>

</div>   
</div>   
</div>   
    

    
    

    

    

    
    
</div>
<script>
$(document).ready(function() {
  $('.dimmer').removeClass('dimmer');
});
</script>
@endsection


<style>
.menu-margin 
{
    background: #fff;
}

.page-content 
{
    padding-top: 0 !important;
}

.content-title
{
	padding:0 !important;
}

</style>
