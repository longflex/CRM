@section('breadcrumb')
@section('breadcrumb')
@extends('layouts.admin.panel')
<div class="ui breadcrumb">
	<div class="active section">{{  trans('laralum.senssms') }}</div>
</div>
@endsection
@section('title', trans('laralum.senssms'))
@section('content')
<div class="ui one column doubling stackable grid container mb-30">
<div class="ui very padded segment">
<div class="send_t_a">
<a href="{{ route('Laralum::buy') }}" class="ui teal submit button pull-right buy-credits">{{ trans('laralum.buy_credit') }}</a>
</div>

<div class="seven wide column padding_t_l">
<div class="ui very padded segment padding_1rem send_sms_position padding_t_l_0">

<form method="post" action="sendsms" name="sendsmsForm" onsubmit="return validateForm()" enctype="multipart/form-data">
  {{ csrf_field() }}
<!--final-area-->
<div class="f-area-send-sms">
@if(Laralum::loggedInUser()->su)
<div class="custom-radio1">
<span><input id="Promotional" class="rad" name="interviewradio" value="Promotional" checked="checked" type="radio">
<label for="Promotional">Promotional ({{ $adminpBal }})</label></span>
<span><input id="Transactional" class="rad" name="interviewradio" value="Transactional" type="radio">
<label for="Transactional">Transactional ({{ $admintBal }})</label></span></br>
</div>
@else
<div class="custom-radio1">
<span><input id="Promotional" class="rad" name="interviewradio" value="Promotional" checked="checked" type="radio">
<label for="Promotional">Promotional ({{{ isset($balance->promotional) ? $balance->promotional : 0 }}})</label></span>

<span><input id="Transactional" class="rad" name="interviewradio" value="Transactional" type="radio">
<label for="Transactional">Transactional ({{{ isset($balance->transactional) ? $balance->transactional : 0 }}})</label></span></br>

</div>
@endif
<div class="row">
<!----Promotional--Area--start--->
<div class="col-md-6 form-group" id="Promotionaldiv">
<div class="promotional-l">
<select class="inp select-style" id="promotional1" name="proute">
	<option value="">Select SenderID</option>
	@foreach($getpromo as $promo)
	 <option value="{{ $promo->sender_name }}">{{ $promo->sender_name }}</option>
	@endforeach
</select>
<span style="font-size: 12px; font-weight: bold;color:red;display:none;" id="routeReq">Sender id is required</span> 

</div>

</div>
<!----Promotional--Area--End--->
<!----Transactional--Area--start--->
<div class="form-group sender_id_d col-md-6" id="Transactionaldiv" style="display:none;">
<div class="promotional-l1">
@if(Laralum::loggedInUser()->is_openid_access==0)
<div id="trans-f-div">
<select class="inp select-style" id="promotional3" name="troute">
	<option value="">Select SenderID</option>
	@foreach($gettrans as $trans)
	<option value="{{ $trans->sender_name }}">{{ $trans->sender_name }}</option>
	@endforeach
</select>
<span style="font-size: 12px; font-weight: bold;color:red;display:none;" id="trouteReq" >Sender id is required</span> 
</div>
@else
<div id="trans-f-div">
<input type="text" class="trandiv inp" id="promotional4" name="troute" placeholder="Open Sender ID" />
<p class="trandiv sender_id" id="promotional6" style="display:none;">0/6-6</p>
<span style="font-size: 12px; font-weight: bold;color:red;display:none;" id="trouteReq" >Open Sender id is required and must be of length 6 and alphabet only</span>
</div>
@endif
</div>

</div>
<!----Transactional--Area--End--->
</div><!--row-->


<div class="row">
<!--left-area-->
<div class="col-md-6">
<div class="form-group">
<input type="text" class="inp" id="ShowgroupCampaign" name="campaignName" value="" placeholder="Campaign Name" />
<input type="hidden"  id="campaignid" name="campaignID" value="" />
</div>
<div class="form-group">
@foreach($group as $grp)
<a href="#" class="group-area-contact-list" id="grList{{ $grp->id }}" style="display:none;" ><i class="fa fa-user-o"></i>&nbsp;{{ $grp->name }}&nbsp;({{ $grp->Contactcount }})</a>
@endforeach
<textarea class="inp_txt" placeholder="Enter comma separated mobile numbers here.."  id="recipientList" name="recipientList"></textarea>
<span style="font-size: 12px; font-weight: bold;" id="display_count">0</span> <span style="font-size: 12px; font-weight: bold;">Total Recipients</span></br>
<span style="font-size: 12px; font-weight: bold;color:red;display:none;" id="mobReq" >Recipient List is required, please enter comma saperated numbers</span> 
<input type="hidden" id="temp_count" name="temp_count" value="" />
</div>
<div class="form-group count-textarea">

<div class="custom-radio count-textarea-btn">
<span><input type="radio" id="English" name="msgType" class="rad" value="english" checked="checked" />
<label for="English">English</label></span>

<span><input type="radio" id="Unicode" name="msgType" class="rad"  value="unicode">
<label for="Unicode">Unicode</label></span>

</div>

<textarea class="inp_txt count-textarea-txt" id="ShowsmsTemplet" name="ShowsmsTemplet" placeholder="Type message here.."></textarea>
<strong id="mainstr">(<span id="remaining"><span id="show_eng">0</span><span id="show_uni" style="display:none">0</span></span>/<span id="messages">0</span>)</strong>

<span style="font-size: 12px; font-weight: bold;color:red;display:none;" id="messageReq">Message body is required</span> 

<button type="submit" class="ui teal submit button">Send SMS Now</button>  <span class="or_txt">or</span>
<button type="button" id="myBtn" class="schedule_btn">Schedule SMS</button>

</div>
</div><!--col-md-6-->
<!--left-area-->

<!--right-area-->
<div class="col-md-6">
	<div class="nine wide column send_sms_position_right padding_none">
<div class="ui very padded segment padding_none group_list_send_sms">

<div class="group_list_file">
<input type="file" name="files[]" id="FilUploader" class="csvCount" style="width:190px;" multiple />  (Upload CSV file only.)
<span style="float:right;" id="showCsvCount"></span>
<span  class="ajaxloader" style="float:right;visibility:hidden;"><img src="{{ asset(Laralum::publicPath() . '/images/ajax-loader.gif') }}"/></span>
</div>
<div class="group_list">
<ul>
@foreach($group as $grp)
<li title="Click to Select">
   <input type="checkbox" value="{{ $grp->id }}" id="grpList{{ $grp->id }}" name="group[]" class="magic-checkbox " onclick="checkedList(this.value);"> <label for="grpList{{ $grp->id }}">{{ $grp->name }}</label><a href="javascript:void(0)" onclick="$('.dimmer').removeClass('dimmer')">{{ $grp->Contactcount }}</a>
</li>
@endforeach
</ul>
</div>


<!--templet-->
<div class="sms_templet" id="smsTempletdiv" style="display:none;">
<h4>Templates</h4>


<!--01-->
<div class="main_sms_temp">
<!--div class="form-group">

<p>You can run SMS campaign after approval of your text message, kindly send your message for an approval eee</p>
</div>
<div class="">
<input id="send" name="mAccess" class="magic-radio getCheckVal disabled" type="radio"> 
<label for="send" class="disabled">Send</label> 
</div-->
											</div>
											<!--01-->



										</div>
										<!--templet-->

										<!--campagin-name-->
										<div class="group_list" id="groupCampaigndiv" style="display:none;">

											<h4>Select Campaign</h4>
											<ul>
												@foreach($campaignName as $cname)
												<li title="Click to Select" id="cname">
													<input type="radio"
														value="{{ $cname->campaign_name }}-{{ $cname->id }}"
														id="{{ $cname->id }}" name="SelectCampaign" class="magic-radio">
													<label for="{{ $cname->id }}">{{ $cname->campaign_name }}</label>
												</li>
												@endforeach
											</ul>
										</div>
										<!--campagin-name-->


									</div>
								</div>
							</div>
							<!--col-md-6-->
							<!--right-area-->
						</div>
						<!--row-->

					</div>
					<!--final-area-->






					<!--modal-->
					<!-- The Modal -->
					<div id="mySchedule" class="modal1">

						<!-- Modal content -->
						<div class="modal-content1">
							<div class="modal-header1">
								<span class="close">&times;</span>
								<h2>Schedule SMS</h2>
							</div>
							<div class="modal-body1">

								<div class="form-group">
									<input type="text" class="inp" id="datepicker" name="scheduleDate"
										placeholder="Select Date" />
								</div>

								<div class="form-group">
									<input type="text" class="inp" id="time" name="scheduleTime"
										placeholder="Select Time" />
								</div>

								<div class="form-group">

								</div>

								<div class="">
									<input type="submit" class="ui teal submit button" value="Schedule" />

									<input type="reset" class="ui teal submit button" value="Cancel" />
								</div>

							</div>

						</div>

					</div>
					<!--modal-->
				</form>

			</div>
		</div>
	</div>
</div>
<script src="{{ asset(Laralum::publicPath() .'/js/sms-script.js') }}"></script>
<!--validate--form-->
@endsection