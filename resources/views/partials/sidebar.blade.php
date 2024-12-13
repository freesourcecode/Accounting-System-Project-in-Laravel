<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ $user->avatar }}" class="img-circle" alt="Avatar" />
            </div>
            <div class="pull-left info">
                <p>{{ $user->first_name }} {{ $user->last_name }}</p>
                <!-- Status -->
                <a href="/user"><i class="fa fa-user fa-fw"></i> Edit Profile</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header"><i class="fa fa-home fa-fw"></i> HOME</li>
            <li class="overview"><a href="{{ URL('/') }}"><span><i class="fa fa-tachometer fa-fw"></i> Overview</span></a></li>
            <li class="messages"><a href="{{ URL('/messages') }}"><span><i class="fa fa-envelope fa-fw"></i> Messages</span></a></li>
            <li class="usermenu"><a href="{{ URL('/user') }}"><span><i class="fa fa-user fa-fw"></i> User Profile</span></a></li>

            <li class="header"><i class="fa fa-database fa-fw"></i> ACCOUNTING</li>
            <li class="accounts"><a href="{{ URL('/accounts') }}"><span><i class="fa fa-tags fa-fw"></i> Chart of Accounts</span></a></li>
            <li class="cars"><a href="{{ URL('/cars') }}"><span><i class="fa fa-car fa-fw"></i> Registered Cars</span></a></li>
            <li class="invoices"><a href="{{ URL('/invoices') }}"><span><i class="fa fa-files-o fa-fw"></i> Invoice Management</span></a></li>
            <li class="sales"><a href="{{ URL('/sales') }}"><span><i class="fa fa-money fa-fw"></i> Sales Management</span></a></li>
            <li class="vendors"><a href="{{ URL('/vendors') }}"><span><i class="fa fa-cubes fa-fw"></i> Vendor Management</span></a></li>

            <li class="header"><i class="fa fa-file fa-fw"></i> REPORTS</li>
            <li class="trial"><a href="{{ URL('/trial') }}"><span><i class="fa fa-list-alt fa-fw"></i> Trial Balance</span></a></li>
            <li class="balance"><a href="{{ URL('/balance') }}"><span><i class="fa fa-table fa-fw"></i> Balance Sheet</span></a></li>
            <li class="profitloss"><a href="{{ URL('/profitloss') }}"><span><i class="fa fa-line-chart fa-fw"></i> Profit and Loss</span></a></li>
            <li class="exsummary"><a href="{{ URL('/executivesummary') }}"><span><i class="fa fa-bar-chart fa-fw"></i> Executive Summary</span></a></li>

            <li class="header"><i class="fa fa-cogs fa-fw"></i> SYSTEM</li>
            <li class="settings"><a href="{{ URL('/settings') }}"><span><i class="fa fa-gear fa-fw"></i> System Settings</span></a></li>
            <li class="users"><a href="{{ URL('/users') }}"><span><i class="fa fa-users fa-fw"></i> User Management</span></a></li>
            <li class="logs"><a href="{{ URL('/logs') }}"><span><i class="fa fa-list fa-fw"></i> System Logs</span></a></li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>