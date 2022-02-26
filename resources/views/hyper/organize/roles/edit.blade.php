@extends('hyper.layout.master')
@section('title', "Edit Role")
@section('content')
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 40px;
  height: 12px;
}

.switch input {display:none;}


.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #cccccc;
  -webkit-transition: .4s;
  transition: .4s;
   border-radius: 50px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 8px;
  width: 8px;
  left: 2px;
  bottom: 2px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
  border-radius: 50%;
}

input:checked + .slider {
  background-color: #398bf7;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(40px);
  -ms-transform: translateX(40px);
  -moz-transform: translateX(40px);
  transform: translateX(28px);
}

/*------ ADDED CSS ---------*/
.slider:after
{
 content:'';
 color: white;
 display: block;
 position: absolute;
 transform: translate(-50%,-50%);
 top: 50%;
 left: 50%;
 font-size: 10px;
 font-family: Verdana, sans-serif;
}

input:checked + .slider:after
{  
  content:'';
}
</style>

<div class="px-2">
    <!-- start page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('console::profile') }}"><i class="uil-home-alt"></i>Profile</a></li>
                        <li class="breadcrumb-item active">Role Edit</li>
                    </ol>
                </div>
                <h4 class="page-title">{{trans('laralum.roles_edit_subtitle', ['name' => $row->name])}}</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 
    <!-- start page content -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                  <div class="row">
                      <div class="col-md-2"></div> 
                      <div class="col-md-8">
                        <form class="ui form" method="POST">
                          <input type="hidden" value="{{ url()->previous()}}" name="url">
                          {{ csrf_field() }}

                          @if(!$fields)
                            <div class="ui  message segment">
                                <div class="header">
                                    {{ trans('laralum.form_no_fields_title') }}
                                </div>
                                <p>{{ trans('laralum.form_no_fields_subtitle') }}</p>
                            </div>
                          @endif
                          @foreach($fields as $field)
                            <?php

                             $error = false;
                             $warning = false;

                             $code_script = false;
                             $editor_script = false;
                             $relation = false;

                             # Setup the value
                             $empty_value = false;
                             if(isset($empty)) {
                                 foreach($empty as $emp) {
                                     if($field == $emp) {
                                         $empty_value = true;
                                     }
                                 }
                             }
                             if($empty_value or !isset($row)) {
                                 $value = "";
                             } else {
                                 $value = $row->$field;

                                 # Check if the value needs to be decrypted
                                 $decrypt = false;
                                 foreach($encrypted as $encrypt) {
                                     if($field == $encrypt) {
                                         if($value != ''){
                                             $decrypt = true;
                                         }
                                     }
                                 }
                                 if($decrypt) {
                                     try {
                                         $value = Crypt::decrypt($value);
                                     } catch (Exception $e) {
                                         $error = trans('laralum.decrypt_fail');
                                     }
                                 }

                                 # Check if it's a hashed value, to display it empty
                                 $hashed_value = false;
                                 foreach($hashed as $hash) {
                                     if($field == $hash) {
                                         $hashed_value = true;
                                     }
                                 }
                                 if($hashed_value) {
                                     $value = "";
                                 }
                             }

                             $show_field = str_replace('_', ' ', ucfirst($field));

                             $type = Schema::getColumnType($table, $field);


                             # Set the input type
                             if($type == 'string') {
                                 $input_type = "text";
                             } elseif($type == 'integer') {
                                 $input_type = "number";
                             } else {
                                 $input_type = "text";
                             }

                             # Check if it needs to be masked
                             foreach($masked as $mask) {
                                 if($mask == $field) {
                                     $input_type = "password";
                                 }
                             }

                             # Check if it's a code
                             foreach($code as $cd) {
                                 if($cd == $field) {
                                     $code_script = true;
                                 }
                             }

                             # Check for the editor values
                             foreach($wysiwyg as $ed) {
                                 if($ed == $field) {
                                     $editor_script = true;
                                 }
                             }

                             # Check if it's a relation
                             if(array_key_exists($field, $relations)) {
                                 $relation = true;
                             }

                            ?>

                            @if($editor_script or $code_script)
                              <div class="form-group">
                                <label>{{ $show_field }}</label>
                                @if($editor_script)
                                    <textarea  name="{{ $field }}" class="ckeditor">{{ $value }}</textarea>
                                @elseif($code_script)
                                    <pre class="code" id="{{ $field }}-code">{{ $value }}</pre>
                                    <textarea hidden name="{{ $field }}" id="{{ $field }}">{{ $value }}</textarea>
                                    <script>
                                        var editor = ace.edit("{{ $field }}-code");
                                        editor.getSession().on('change', function(){
                                            $("#{{ $field }}").val(editor.getSession().getValue());
                                        });
                                    </script>

                                @endif
                              </div>
                            @elseif($relation)
                              <div class="field">
                                <label>{{ $show_field }}</label>
                                <select name="{{ $field }}" id="{{ $field }}" class="form-control select2" data-toggle="select2" data-placeholder="Please select..">
                                    @foreach($relations[$field]['data'] as $relation_data)
                                        <?php $relation_value = $relations[$field]['value']; $relation_show = $relations[$field]['show']; ?>
                                        <option <?php if($value == $relation_data->$relation_value){ echo "selected"; } ?> value="{{ $relation_data->$relation_value }}">{{ $relation_data->$relation_show }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @else
                              @if($type == 'string')
                                @if($field == Laralum::countryCodeField())
                                  <?php $cc_value = $value; $cc_id = $field; ?>

                                  <?php $no_flags = Laralum::noFlags() ?>

                                  <?php
                                      $countries = Laralum::countries();
                                  ?>

                                  <div class="field">
                                    <label>{{ $show_field }}</label>
                                    <div class="ui fluid search selection dropdown" id="{{ $field }}_dropdown">
                                        <input type="hidden" name="{{ $field }}" id="{{ $field }}">
                                        <i class="dropdown icon"></i>
                                        <div class="default text">{{ $show_field }}</div>
                                        <div class="menu">
                                            @foreach($countries as $country)
                                            <?php $cc_field_value = array_search($country, $countries); ?>
                                                <div class="item" data-value="{{ $cc_field_value }}">@if(in_array($cc_field_value, $no_flags))<i class="help icon"></i>@else<i class="{{ strtolower($cc_field_value) }} flag"></i>@endif{{ $country }}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @else
                                  <!-- STRING COLUMN -->
                                  <div class="form-group @if($error) error @endif">
                                    <label>{{ $show_field }}</label>
                                    <input type="{{ $input_type }}"  id="{{ $field }}" name="{{ $field }}" placeholder="{{ $show_field }}" value="{{ $value }}" class="form-control">
                                    @if($error)
                                      <div class="invalid-tooltip">
                                        {{ $error }}
                                      </div>
                                    @endif
                                  </div>
                                @endif
                              @elseif($type == 'integer')
                                <?php
                                  if($field == 'created_by'){
                                ?>
                                    <input type="hidden" id="{{ $field }}" name="{{ $field }}" placeholder="{{ $show_field }}" value="{{Laralum::loggedInUser()->id}}">
                                <?php
                                }else{
                                ?>
                               <!-- INTEGER COLUMN -->
                                  <div class="form-group @if($error) error @endif">
                                    <label>{{ $show_field }}</label>
                                    <input type="{{ $input_type }}"  id="{{ $field }}" name="{{ $field }}" placeholder="{{ $show_field }}" value="{{ $value }}" class="form-control">
                                    @if($error)
                                      <div class="invalid-tooltip">
                                        {{ $error }}
                                      </div>
                                    @endif
                                  </div>
                                    <?php
                                }
                                    ?>
                              @elseif($type == 'boolean')
                              <!-- BOOLEAN COLUMN -->
                              <div class="row">
                                <div class="col-md-4 mt-1">
                                  <label class="switch" style="margin-bottom: 0.0rem !important">
                                    <input type="checkbox" tabindex="0" <?php if($value){ echo "checked='checked'"; } ?> name="{{ $field }}" >
                                    <div class="slider"></div>
                                  </label>
                                  <span>&nbsp;&nbsp;&nbsp; {{ $show_field }}  </span>
                                  @if($error)
                                    <div class="invalid-tooltip">
                                      {{ $error }}
                                    </div>
                                  @endif
                                </div>
                              </div>
                              @elseif($type == 'text')
                                <!-- TEXT COLUMN -->
                                <div class="form-group @if($error) error @endif">
                                    <label>{{ $show_field }}</label>
                                    <textarea class="form-control" placeholder="{{ $show_field }}" name="{{ $field }}" rows="3" id="{{ $field }}">{{ $value }}</textarea>
                                    @if($error)
                                      <div class="invalid-tooltip">
                                        {{ $error }}
                                      </div>
                                    @endif
                                </div>
                              @else
                                <!-- ALL OTHER COLUMN -->
                                <div class="form-group @if($error) error @endif">
                                  <label>{{ $show_field }}</label>
                                  <input type="{{ $input_type }}"  id="{{ $field }}" name="{{ $field }}" placeholder="{{ $show_field }}" value="{{ $value }}" class="form-control">
                                  @if($error)
                                    <div class="invalid-tooltip">
                                      {{ $error }}
                                    </div>
                                  @endif
                                </div>
                              @endif

                              @foreach($confirmed as $confirm)
                                @if($field == $confirm)
                                  @if($type == 'string')
                                    <!-- STRING CONFIRMATION -->
                                    <div class="form-group @if($error) error @endif">
                                      <label>{{ $show_field }} {{ trans('laralum.confirmation') }}</label>
                                      <input type="{{ $input_type }}"  id="{{ $field }}_confirmation" name="{{ $field }}_confirmation" placeholder="{{ $show_field }} confirmation" value="{{ $value }}" class="form-control">
                                      @if($error)
                                          <div class="invalid-tooltip">
                                              {{ $error }}
                                          </div>
                                      @endif
                                    </div>

                                  @elseif($type == 'integer')
                                    <!-- INTEGER COLUMN CONFIRMATION -->
                                    <div class="form-group @if($error) error @endif">
                                      <label>{{ $show_field }} {{ trans('laralum.confirmation') }}</label>
                                      <input type="{{ $input_type }}"  id="{{ $field }}_confirmation" name="{{ $field }}_confirmation" placeholder="{{ $show_field }} confirmation" value="{{ $value }}" class="form-control">
                                      @if($error)
                                          <div class="invalid-tooltip">
                                              {{ $error }}
                                          </div>
                                      @endif
                                    </div>

                                  @elseif($type == 'boolean')
                                    <!-- BOOLEAN CONFIRMATION -->
                                    <div class="row">
                                      <div class="col-md-4 mt-1">
                                        <label class="switch" style="margin-bottom: 0.0rem !important">
                                          <input type="checkbox" tabindex="0" <?php if($value){ echo "checked='checked'"; } ?> name="{{ $field }}_confirmation" >
                                          <div class="slider"></div>
                                        </label>
                                        <span>&nbsp;&nbsp;&nbsp; {{ $show_field }} {{ trans('laralum.confirmation') }}  </span>
                                        @if($error)
                                          <div class="invalid-tooltip">
                                            {{ $error }}
                                          </div>
                                        @endif
                                      </div>
                                    </div>

                                  @elseif($type == 'text')
                                    <!-- TEXT COLUMN -->
                                    <div class="form-group @if($error) error @endif">
                                      <label>{{ $show_field }} {{ trans('laralum.confirmation') }}</label>
                                      <textarea class="form-control" placeholder="{{ $show_field }}" name="{{ $field }}_confirmation" rows="3" id="{{ $field }}_confirmation">{{ $value }}</textarea>
                                      @if($error)
                                        <div class="invalid-tooltip">
                                          {{ $error }}
                                        </div>
                                      @endif
                                    </div>

                                  @else
                                    <!-- ALL OTHER COLUMN CONFIRMATION -->
                                    <div class="form-group @if($error) error @endif">
                                      <label>{{ $show_field }} {{ trans('laralum.confirmation') }}</label>
                                      <input type="{{ $input_type }}"  id="{{ $field }}_confirmation" name="{{ $field }}_confirmation" placeholder="{{ $show_field }} confirmation" value="{{ $value }}" class="form-control">
                                      @if($error)
                                          <div class="invalid-tooltip">
                                              {{ $error }}
                                          </div>
                                      @endif
                                    </div>

                                  @endif

                                @endif
                              @endforeach


                            @endif
                          @endforeach
                          <br>
                          <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{ trans('laralum.submit') }}</button>
                          </div>
                        </form>

                      </div>
                      <div class="col-md-2"></div>                   
                  </div>


                </div>
            </div>
        </div>
    </div>
    <!-- end page content --> 
</div> 










@endsection
@section('extrascripts')
@if(isset($cc_id) and isset($cc_value))
  <script>
      $("#{{ $cc_id }}_dropdown").dropdown("set selected", "{{ $cc_value }}");
      $("#{{ $cc_id }}_dropdown").dropdown("refresh");
  </script>
@endif

@endsection













