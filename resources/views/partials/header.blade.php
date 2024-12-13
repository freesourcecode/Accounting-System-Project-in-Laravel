<!-- Main Header -->
<header class="main-header">
    <!-- Logo -->
    <a href="{{ URL('/') }}" class="logo" style="background-color: green;"><b>Accounting System</b></a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation" style="background-color: green;">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <li class="messages-menu">
                    <!-- Menu toggle button -->
                    <a href="{{ URL('/messages') }}">
                        <i class="fa fa-envelope-o"></i>
                        @if ($unread > 0)
                        <span class="label label-success">{{ $unread }}</span>
                        @endif
                    </a>

                </li><!-- /.messages-menu -->
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="{{ $user->avatar }}" class="user-image" alt="Avatar" />
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{ $user->first_name }} {{ $user->last_name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="{{ $user->avatar }}" class="img-circle" alt="Avatar" />
                            <p>
                                {{ $user->first_name }} {{ $user->last_name }}
                                <small>{{ $user->job }}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ URL('/user') }}" class="btn btn-default btn-flat"><i class="fa fa-user fa-fw"></i> Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ URL('/auth/logout') }}" class="btn btn-default btn-flat" onclick="return confirm('Are you sure you want to sign out?');"><i class="fa fa-sign-out fa-fw"></i> Sign Out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>