<div class="left-stick-menu">
       <ul>
       <li><a href="{{ route('api::route-Balance') }}" class="{{ $nav_routebal or '' }}">Check Balance</a></li>
       <li><a href="{{ route('api::change-password') }}" class="{{ $nav_changepwd or '' }}">Change Password</a></li>
       <li><a href="{{ route('api::validation') }}" class="{{ $nav_validation or '' }}">Validation</a></li>
       <li><a href="{{ route('api::opt-out') }}" class="{{ $nav_optout or '' }}">Opt Out</a></li>
       <li><a href="{{ route('api::error-code-basic') }}" class="{{ $nav_basicerrorcode or '' }}">Error Code</a></li>
       </ul>       
       </div>	