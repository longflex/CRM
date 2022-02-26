@extends('layouts.master')
@section('title', $content->title)
@section('content')
   <!--page-content-start-->
<div class="container pt-40 pb-40">
  <!-- Grid row -->
  @if(session('success'))
	<div class="alert alert-success" role="alert">
     {!! session('success') !!}
    </div>
	@endif
  <div class="row mt-30">
    <!-- Grid column -->
    <div class="col-lg-5 mb-lg-0 mb-4">
	
      <!-- Form with header -->
      <div class="card">
        <div class="card-body">
          <!-- Header -->
          <div class="form-header blue accent-1">
            <h3 class="mt-2"><i class="fas fa-envelope"></i> Write to us:</h3>
          </div>
          <p class="dark-grey-text">Get in touch with us</p>
          <!-- Body -->
            <form id="contact-form" method="post" action="{{ url('/sendContact') }}">
			    {{ csrf_field() }}	
                <div class="form-group input-material">
                    <input type="text" class="form-control" id="name-field" name="name_field" />
                    <label for="name-field">Name&nbsp;<span style="color:red;">*</span></label>
			    @if ($errors->has('name_field'))
                    <span class="text-danger">{{ $errors->first('name_field') }}</span>
                @endif
                </div>
                <div class="form-group input-material">
                    <input type="email" class="form-control" id="email-field" name="email_field" />
                    <label for="email-field">Email&nbsp;<span style="color:red;">*</span></label>
				@if ($errors->has('email_field'))
                    <span class="text-danger">{{ $errors->first('email_field') }}</span>
                @endif
                </div>
				<div class="form-group input-material">
                    <input type="text" class="form-control" id="mobile-field" name="mobile_field" />
                    <label for="contact-field">Mobile No.&nbsp;<span style="color:red;">*</span></label>
				@if ($errors->has('mobile_field'))
                    <span class="text-danger">{{ $errors->first('mobile_field') }}</span>
                @endif
                </div>
                <div class="form-group input-material">
                    <textarea class="form-control" id="msg-field" rows="3" name="msg_field" ></textarea>
                    <label for="textarea-field">Your Message&nbsp;<span style="color:red;">*</span></label>
				@if ($errors->has('msg_field'))
                    <span class="text-danger">{{ $errors->first('msg_field') }}</span>
                @endif
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">SEND</button>
                </div>
            </form>        
        </div>
      </div>
      <!-- Form with header -->
    </div>
    <!-- Grid column -->
    <!-- Grid column -->
    <div class="col-lg-7">     
      <!-- Buttons-->
      <div class="row">
		<div class="col-md-12 ml-20">
		 {!! $content->description !!}
        </div>		
		<div class="col-md-12 mb-10">
		  <div class="media">
			   <a class="btn-floating blue accent-1 mr-3 mt-0">
				<i class="fas fa-map-marker-alt"></i>
			  </a>
			  <div class="media-body">
				<p>1024, 4th Floor, Repunjaya Building,<br> Madhapur, Hyderabad 500081 IND</p>
				
			  </div>
			</div>
        </div>
		
		<div class="col-md-12 mb-10">
		  <div class="media">
			   <a class="btn-floating blue accent-1 mr-3 mt-0">
				<i class="fas fa-phone"></i>
			  </a>
			  <div class="media-body">
				<p>6527567804</p>
				
			  </div>
			</div>
        </div>
		
		<div class="col-md-12 mb-10">
		  <div class="media">
			   <a class="btn-floating blue accent-1 mr-3 mt-0">
				<i class="fas fa-envelope"></i>
			  </a>
			  <div class="media-body">
				<p>info@technodreams.in</p>				
			  </div>
			</div>
        </div>
		
		<div class="col-md-12 mb-10">
		  <div class="media">
			   <a class="btn-floating blue accent-1 mr-3 mt-0">
				<i class="fas fa-clock"></i>
			  </a>
			  <div class="media-body">
				<p>9.00 am to 9.00 pm in a day, 7 days a week</p>				
			  </div>
			</div>
        </div>		
      </div>
    </div>
  </div>					
</div>
<!--page-content-end-->
<style>
.map-container-section {
  overflow:hidden;
  padding-bottom:56.25%;
  position:relative;
  height:0;
}
.map-container-section iframe {
  left:0;
  top:0;
  height:100%;
  width:100%;
  position:absolute;
}
.form-header {
    padding: 1rem;
    margin-top: -3.13rem;
    margin-bottom: 3rem;
    color: #fff;
    text-align: center;
    border-radius: .125rem;
    -webkit-box-shadow: 0 5px 11px 0 rgba(0,0,0,0.18),0 4px 15px 0 rgba(0,0,0,0.15);
    box-shadow: 0 5px 11px 0 rgba(0,0,0,0.18),0 4px 15px 0 rgba(0,0,0,0.15);
}
.blue {
    background-color: #f9ba48 !important;
}

.btn-floating {
    position: relative;
    z-index: 1;
    display: inline-block;
    padding: 0;
    margin: 10px;
    overflow: hidden;
    vertical-align: middle;
    cursor: pointer;
    border-radius: 50%;
    -webkit-box-shadow: 0 5px 11px 0 rgba(0,0,0,0.18),0 4px 15px 0 rgba(0,0,0,0.15);
    box-shadow: 0 5px 11px 0 rgba(0,0,0,0.18),0 4px 15px 0 rgba(0,0,0,0.15);
    -webkit-transition: all .2s ease-in-out;
    transition: all .2s ease-in-out;
    width: 47px;
    height: 47px;
}

.btn-floating i {
    display: inline-block;
    width: inherit;
    color: #fff;
    text-align: center;
}

.btn-floating i {
    font-size: 1.25rem;
    line-height: 47px;
}

.btn-primary
{
	background:#26476c;
	color:#fff;
	border-color:#26476c;
	transition: 0.5s;
}

.btn-primary:hover
{
	background:#f9ba48;
	color:#fff;
	border-color:#f9ba48;
}

/*floting-label*/
.form-group.input-material {
  position: relative;
  margin-top: 32px;
  margin-bottom: 32px; }
  .form-group.input-material label {
    color: #b1bbc4;
    font-size: 16px;
    font-weight: normal;
    position: absolute;
    pointer-events: none;
    left: 5px;
    top: 7px;
    transition: 0.1s ease all;
    -moz-transition: 0.1s ease all;
    -webkit-transition: 0.1s ease all; }
  .form-group.input-material .form-control {
    border: none;
    border-bottom: 2px solid #ced4da;
    border-radius: 0px;
    background: transparent;
    padding-left: 5px;
    box-shadow: none;
    /* active state */
    /* invalid state */ }
    .form-group.input-material .form-control:focus, .form-group.input-material .form-control[value]:not([value=""]) {
      border-bottom-color: #26476c;
      color: #000; }
    .form-group.input-material .form-control:focus ~ label, .form-group.input-material .form-control[value]:not([value=""]) ~ label {
      top: -10px;
      font-size: 14px;
      color: #26476c;
      font-weight: 500; }
    .form-group.input-material .form-control:focus.invalid, .form-group.input-material .form-control.invalid, .form-group.input-material .form-control:focus.parsley-error, .form-group.input-material .form-control[value]:not([value=""]).parsley-error {
      border-bottom-color: #dc3545; }
    .form-group.input-material .form-control:focus.invalid ~ label, .form-group.input-material .form-control.invalid ~ label, .form-group.input-material .form-control:focus.parsley-error ~ label, .form-group.input-material .form-control[value]:not([value=""]).parsley-error ~ label {
      color: #dc3545; }
  .form-group.input-material .parsley-errors-list {
    color: #dc3545;
    list-style: none;
    font-size: 0.7em;
    padding-left: 5px; }

.mb-50
{
	margin-bottom: 50px !important;
}

</style>
@endsection
