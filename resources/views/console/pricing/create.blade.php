@extends('layouts.console.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <a class="section" href="{{ route('console::pricing') }}">{{ trans('laralum.pricing_title') }}</a>
        <i class="right angle icon divider"></i>
        <div class="active section">{{ trans('laralum.pricing_create_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.pricing_create_title'))
@section('content')
<div class="ui doubling stackable grid container mb-20">
    <div class="three wide column"></div>
    <div class="ten wide column">
        <div class="ui very padded segment">
            <form class="ui form" action="{{ route('console::pricing_save') }}" method="POST" enctype="multipart/form-data">			   
                {{ csrf_field() }}
                 <div class="field">
					<label>Product <span style="color:red;">*</span></label>
					<select class="custom-select" name="product_type" id="product_type">
						 <option value="">Please select..</option>
						 <option value="1">CleverStack CRM</option>
						 <option value="2">SMS</option>
						 <option value="3">Voice Broadcasting</option>
						 <option value="4">WhatsApp</option>
						 <option value="5">IVR</option>
						 <option value="6">Audio Conference</option>
						 <option value="7">Video Conference</option>
						 <option value="8">Email Marketing</option>
					 </select>
                 </div>	
                 <div class="field" id="sms_type" style="display:none;">
					<label>SMS Type <span style="color:red;">*</span></label>
					<select class="custom-select" name="sms_type">
					 <option value="">Please select..</option>
					 <option value="Transactional">Transactional</option>
					 <option value="Promotional">Promotional</option>
					 </select>
                 </div>	
                 <div class="field">
					<label>Flat Price<span style="color:red;"></span></label>
					<input type="text" name="flat_price" class="form-control" placeholder="0.18/SMS INR" />
                 </div>				 
				 <div class="field">
					<label>GST Extra (%)<span style="color:red;"></span></label>
					<input type="text" name="gst_extra" class="form-control" placeholder="GST Extra in %" />
                 </div>
				 <div class="field">
					<label>Min. Purchase<span style="color:red;"></span></label>
					<input type="text" name="min_purchase" class="form-control" placeholder="Min. Purchase Credits" />
                 </div>
				 <div class="field">
				    <label>Price Range <span style="color:red;">*</span></label>
					  <div class="row">
						<div class="col-md-12">
							<div class="fieldmore row">
							    <div class="col-md-3">
								<div class="form-group">
								<input type="text" name="from_qty[]" class="form-control" placeholder="From quantity" />
								</div>
								</div>
								<div class="col-md-3">
								<div class="form-group">
								<input type="text" name="to_qty[]" class="form-control" placeholder="To quantity" />
								</div>
								</div>
								<div class="col-md-3">
								<div class="form-group">
								<input type="text" name="price[]" class="form-control" placeholder="Price" />
								</div>
								</div>
                                <div class="col-md-3">
								<div class="form-group">
									<a href="javascript:void(0);" style="margin-top: 4px !important;" class="btn btn-sm btn-primary family-add-btn addMore" onclick="$('.dimmer').removeClass('dimmer')"><i class="fa fa-plus"></i></a>
								</div>
								</div>									
							</div>
						</div>												
					</div>								  
				 </div>			 
                <br>
                <button type="submit" class="ui {{ Laralum::settings()->button_color }} submit button">{{ trans('laralum.submit') }}</button>
            </form>
        </div>
    </div>
    <div class="three wide column"></div>
</div>
<!-- copy of input fields group -->
<div class="fieldmoreCopy row" style="display: none;">
<div class="col-md-3">
<div class="form-group">
<input type="text" name="from_qty[]" class="form-control" placeholder="From quantity" />
</div>
</div>
<div class="col-md-3">
<div class="form-group">
<input type="text" name="to_qty[]" class="form-control" placeholder="To quantity" />
</div>
</div>
<div class="col-md-3">
<div class="form-group">
<input type="text" name="price[]" class="form-control" placeholder="Price" />
</div>
</div>
<div class="col-md-3">
<div class="form-group">
<a href="javascript:void(0);" style="margin-top: 4px !important;" class="btn btn-sm btn-danger family-add-btn remove" onclick="$('.dimmer').removeClass('dimmer')"><i class="fa fa-minus"></i></a>
</div>
</div>		
</div>
<script>
$('#product_type').change(function() {
    var selected = $(this).val();
    if(selected == 2){
      $('#sms_type').show();
    }
    else{
      $('#sms_type').hide();
    }
});
</script>
<script>
$(document).ready(function(){
    //group add limit
    var maxGroup = 15;
    
    //add more fields group
    $(".addMore").click(function(){
        if($('body').find('.fieldmore').length < maxGroup){
            var fieldHTML = '<div class="fieldmore row">'+$(".fieldmoreCopy").html()+'</div>';
            $('body').find('.fieldmore:last').after(fieldHTML);
        }else{
            alert('Maximum '+maxGroup+' groups are allowed.');
        }
    });
    
    //remove fields group
    $("body").on("click",".remove",function(){ 
        $(this).parents(".fieldmore").remove();
    });
	
	
});
</script>
@endsection
