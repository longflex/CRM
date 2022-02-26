@extends('layouts.admin.panel') 
@section('breadcrumb')
@endsection
@section('title', trans('laralum.delivery_manager'))


@section('content')





<div class="ui doubling stackable two column grid container">
    

<div class="col-md-12 margin_top_20">
<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#Domain">Domain</a></li>
  <li><a data-toggle="tab" href="#Theme">Theme</a></li>
  <li><a data-toggle="tab" href="#Banner">Banner</a></li>
  <li><a data-toggle="tab" href="#Features">Features</a></li>
  <li><a data-toggle="tab" href="#Clientele">Clientele</a></li>
  <li><a data-toggle="tab" href="#Aboutus">About us</a></li>
  <li><a data-toggle="tab" href="#Contact">Contact</a></li>
  <li><a data-toggle="tab" href="#Sociallinks">Social links</a></li>
  <li><a data-toggle="tab" href="#SEO">SEO</a></li>
  <li><a data-toggle="tab" href="#TagManager">Tag-Manager</a></li>
  <li><a data-toggle="tab" href="#Other">Other</a></li>
</ul>

<div class="tab-content">

  <!--domain-->
  <div id="Domain" class="tab-pane fade in active">
  
  <div class="row">
  <div class="col-md-3">
  <div class="form-group">
  <label>Company Name</label>
  <input type="text" class="inp" id="" name="" value="" placeholder="">
  </div>
  </div>
  </div>
  
   <div class="row">
  <div class="col-md-3">
  <div class="form-group">
  <label>Domain Name</label>
  <input type="text" class="inp" id="" name="" value="" placeholder="">
  </div>
  </div>
  
  <div class="col-md-9">
  <div class="form-group">
  <label class="res_none">&nbsp;</label>
  <p class="red_txt invalid_domain"><i class="fa fa-refresh"></i>&nbsp; Invalid domain or CNAME pointing not found</p>
  </div>
  </div>
  </div>
  
  
   <div class="row">
  <div class="col-md-12">
  <div class="form-group">
  Correct domain to be pointed is: map.txtapi.com
  </div>
  </div>
  </div>
  
     <div class="row">
  <div class="col-md-12">
  <div class="form-group">
 <button type="submit" class="ui teal submit button">Save Changes</button>
  </div>
  </div>
  </div>
  
   <div class="row">
  <div class="col-md-12">
  <div class="form-group my_web_ul">
  <ul>
  <li>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</li>
  <li>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</li>
  </ul>
  </div>
  </div>
  </div>
  
  
  
  
  
  </div>
 <!--domain-->
 
 <!--Theme-->
  <div id="Theme" class="tab-pane fade">
    <h3>Theme</h3>
    <p>Some content in menu 1.</p>
  </div>
  <!--Theme-->
  
   <!--Banner-->
  <div id="Banner" class="tab-pane fade">
    <h3>Banner</h3>
    <p>Some content.</p>
  </div>
 <!--Banner-->
 
 <!--Features-->
  <div id="Features" class="tab-pane fade">
    <h3>Features</h3>
    <p>Some content in menu 1.</p>
  </div>
  <!--Features-->
  
   <!--Clientele-->
  <div id="Clientele" class="tab-pane fade">
    <h3>Clientele</h3>
    <p>Some content.</p>
  </div>
 <!--Clientele-->
 
 <!--Aboutus-->
  <div id="Aboutus" class="tab-pane fade">
    <h3>About us</h3>
    <p>Some content in menu 1.</p>
  </div>
  <!--Aboutus-->
  
   <!--Contact-->
  <div id="Contact" class="tab-pane fade">
    <h3>Contact</h3>
    <p>Some content.</p>
  </div>
 <!--Contact-->
 
 <!--Sociallinks-->
  <div id="Sociallinks" class="tab-pane fade">
    <h3>Social links</h3>
    <p>Some content in menu 1.</p>
  </div>
  <!--Sociallinks-->
  
   <!--SEO-->
  <div id="SEO" class="tab-pane fade">
    <h3>SEO</h3>
    <p>Some content.</p>
  </div>
 <!--SEO-->
 
 <!--TagManager-->
  <div id="TagManager" class="tab-pane fade">
    <h3>Tag-Manager</h3>
    <p>Some content in menu 1.</p>
  </div>
  <!--TagManager-->
  
   <!--Other-->
  <div id="Other" class="tab-pane fade">
    <h3>Other</h3>
    <p>Some content in menu 1.</p>
  </div>
  <!--Other-->
  
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
