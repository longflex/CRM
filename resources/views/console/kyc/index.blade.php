@extends('layouts.console.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <div class="active section">KYC Verification</div>
    </div>
@endsection
@section('title', "KYC Verification")
@section('icon', "star")
@section('subtitle', "KYC Verification")
@section('content')
  <div class="ui one column doubling stackable grid container">
  	<div class="column">	
  		<div class="ui very padded segment">
		 @if(count($kyc_info) > 0)
  			<table class="ui table ">
  			  <thead>
  			    <tr>
                  <th>Client</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Created at</th>
				  <th>Action</th>
  			    </tr>
  			  </thead>
  			  <tbody>
                @foreach($kyc_info as $info)
					<tr>
						<td>
                            <div class="text">
                                {{ $info->client }}
                            </div>
                        </td>
						<td>
						   <div class="text">						      						   
                               {{ $info->email }}
                            </div>
						</td>
                        <td>
						   <div class="text">						      						   
                               {{ $info->mobile }}
                            </div>
						</td>
                        <td>
						   <div class="text">						      						   
                               {{ $info->created_at }}
                            </div>
						</td>							
                        <td>                          
						  <div class="ui {{ Laralum::settings()->button_color }} top icon left pointing dropdown button">
							<i class="configure icon"></i>
							<div class="menu">
							  <div class="header">{{ trans('laralum.editing_options') }}</div>
								  <a href="{{ route('console::kyc_edit', ['id' => $info->id]) }}" class="item">
									<i class="edit icon"></i>
									Edit
								  </a>                                  							 						 
							</div>
						  </div>                         
						</td>
					</tr>
				@endforeach
  			  </tbody>
  			</table>
			@else
                <div class="ui negative icon message">
                    <i class="frown icon"></i>
                    <div class="content">
                        <div class="header">
                            {{ trans('laralum.missing_title') }}
                        </div>
                        <p>{{ trans('laralum.missing_subtitle', ['element'  =>  "industry"]) }}</p>
                    </div>
                </div>
            @endif
  		</div>
        <br>
  	</div>
  </div>
@endsection
@section('js')
@endsection