<div class="topnav shadow-sm bg-dark">
    <div class="container-fluid">
        <nav class="navbar navbar-dark navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    @if(Laralum::hasPermission('laralum.admin.dashboard'))
                    <li class="nav-item dropdown {{ request()->is('crm/admin') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('Crm::dashboard') }}"  >
                            <i class="uil-dashboard mr-1"></i>Dashboard 
                        </a>
                    </li>
                    @endif
                    @if(Laralum::hasPermission('laralum.member.access'))
                    <li class="nav-item dropdown {{ request()->is('crm/admin/members/dashboard') || request()->is('crm/admin/members*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle arrow-none" href="javascript:void(0);" id="topnav-members" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="uil-user-square mr-1"></i>Members <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-members">
                            <a href="{{ route('Crm::members_dashboard') }}" class="dropdown-item">Members Dashboard</a>
                            <a href="{{ route('Crm::members') }}" class="dropdown-item">Members List</a>
                        </div>
                    </li>
                    @endif
                    
                    <li class="nav-item dropdown {{ request()->is('crm/admin/leads/dashboard') || request()->is('crm/admin/leads*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle arrow-none" href="javascript:void(0);" id="topnav-leads" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="uil-user-circle mr-1"></i>Leads <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-leads">
                            @if(Laralum::hasPermission('laralum.lead.dashboard'))
                            <a href="{{ route('Crm::leads_dashboard') }}" class="dropdown-item">Leads Dashboard</a>
                            @endif
                            @if(Laralum::hasPermission('laralum.lead.create'))
                            <a href="{{ route('Crm::leads_create') }}" class="dropdown-item">Create Lead</a>
                            @endif
                            @if(Laralum::hasPermission('laralum.lead.list'))
                            <a href="{{ route('Crm::leads') }}" class="dropdown-item">Leads List</a>
                            @endif
                        </div>
                    </li>
                    @if(Laralum::hasPermission('laralum.donation.access') && Laralum::permissionToAccessModule() === true)
                    <li class="nav-item dropdown {{ request()->is('crm/admin/donations') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle arrow-none" href="javascript:void(0);" id="topnav-staff" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="uil-parcel mr-1"></i>Donations <div class="arrow-down"></div>
                        </a>
                        
                        <div class="dropdown-menu" aria-labelledby="topnav-layouts">
                            @if(Laralum::hasPermission('laralum.donation.list'))
                            <a href="{{ route('Crm::donations') }}" class="dropdown-item">Donations</a>
                            <a href="{{ route('Crm::donations_report') }}" class="dropdown-item">Donations Report</a>
                            @endif
                        </div>
                        
                    </li>
                    @endif
                    @if(Laralum::hasPermission('laralum.campaign.access'))
                    <li class="nav-item dropdown {{ request()->is('crm/admin/campaign') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle arrow-none" href="javascript:void(0);" id="topnav-campaign" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="uil-desktop-alt mr-1"></i>Campaign <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-campaign">
                            @if(Laralum::hasPermission('laralum.campaign.list'))
                            <a href="{{ route('Crm::campaign') }}" class="dropdown-item">Campaign List</a>
                            @endif
                            @if(Laralum::hasPermission('laralum.campaign.create'))
                            <a href="{{ route('Crm::create-campaign') }}" class="dropdown-item">Create Campaign</a>
                            @endif
                        </div>
                    </li>
                    @endif
                    @if(Laralum::hasPermission('laralum.staff.access'))
                    <li class="nav-item dropdown {{ request()->is('crm/admin/staff') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle arrow-none" href="javascript:void(0);" id="topnav-staff" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="uil-desktop-alt mr-1"></i>Staff <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-staff">
                            @if(Laralum::hasPermission('laralum.staff.list'))
                            <a href="{{ route('Crm::staff') }}" class="dropdown-item">Employees</a>
                            @endif
                            @if(Laralum::hasPermission('laralum.staff.list'))
                            <a href="{{ route('Crm::staff.payruns') }}" class="dropdown-item">Pay Runs</a>
                            @endif
                            @if(Laralum::hasPermission('laralum.department.list'))
                            <a href="{{ route('Crm::department') }}" class="dropdown-item">Department</a>
                            @endif
                            @if(Laralum::hasPermission('laralum.designation.list'))
                            <a href="{{ route('Crm::designation') }}" class="dropdown-item">Designation</a>
                            @endif
                            @if(!Laralum::hasAdminPermission('laralum.attendance.list'))
                            <a href="{{ route('Crm::attendance.summary') }}" class="dropdown-item">Attendance</a>
                            @endif

                            @if(Laralum::hasAdminPermission('laralum.attendance.list'))
                            <a href="{{ route('Crm::staff.attendance.index') }}" class="dropdown-item">Staff Attendance</a>
                            @endif
                            @if(Laralum::hasPermission('laralum.staff.list'))
                            <a href="{{ route('Crm::staff.dashboard') }}" class="dropdown-item">Dashboard</a>
                            @endif
                            @if(!Laralum::hasAdminPermission('laralum.holiday.list'))
                            <a href="{{ route('Crm::holidays') }}" class="dropdown-item">Holiday</a>
                            @endif
                            @if(Laralum::hasAdminPermission('laralum.holiday.list'))
                            <a href="{{ route('Crm::staff.holidays') }}" class="dropdown-item">Staff Holiday</a>
                            @endif
                            @if(!Laralum::hasAdminPermission('laralum.leave.access'))
                            <a href="{{ route('Crm::leaves.pending') }}" class="dropdown-item">Leaves</a>
                            @endif
                            @if(Laralum::hasAdminPermission('laralum.leave.list'))
                            <a href="{{ route('Crm::staff.leaves') }}" class="dropdown-item">Staff Leaves</a>
                            @endif
                        </div> 
                    </li> 
                    @endif
                    @if(Laralum::hasPermission('laralum.activity.access'))
                    <li class="nav-item dropdown {{ request()->is('crm/admin/') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle arrow-none" href="javascript:void(0);" id="topnav-staff" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="uil-archive mr-1"></i>Activities <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-layouts">
                            <a href="{{ route('Crm::leads.call.log.reports') }}" class="dropdown-item">Call Log Reports</a>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</div>
