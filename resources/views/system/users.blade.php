@extends('master')
@section('title', 'User Management')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div>
                <a href="{{ URL('/users/new') }}" class="btn btn-success text-right pull-right"><i class="fa fa-plus fa-fw"></i> New User</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 top-padded">
            @include('partials.alerts')
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-users fa-fw"></i> System Users</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th style="width: 50px;"></th>
                                <th>User Information</th>
                                <th class="text-center">Branch</th>
                                <th class="text-center">Registered On</th>
                                <th class="text-center">Last Updated</th>
                                <th class="text-center">Account Standing</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $sysUser)
                                <tr>
                                    <td>
                                        @if ($sysUser->avatar == "")
                                            <img src="http://gravatar.com/avatar/{{ md5($sysUser->email) }}" class="img-circle small-avatar" />
                                        @else
                                            <img src="{{ $sysUser->avatar }}" class="img-circle small-avatar" />
                                        @endif
                                    </td>
                                    <td>
                                        {{ $sysUser->first_name }} {{ $sysUser->last_name }}<br />
                                        <span class="text-muted">{{ $sysUser->email }}</span>
                                    </td>
                                    <td class="text-center">
                                        {{ $sysUser->branch_name }}
                                    </td>
                                    <td class="text-center">
                                        {{ $sysUser->created_at }}
                                    </td>
                                    <td class="text-center">
                                        {{ $sysUser->updated_at }}
                                    </td>
                                    <td class="text-center">
                                        @if ($sysUser->deleted_at == null) Active @else Suspended @endif @if(!$sysUser->confirmed) / Unconfirmed @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ URL('/users/edit/' . $sysUser->id) }}" class="btn btn-primary"><i class="fa fa-pencil fa-fw"></i> Edit</a>
                                        @if ($sysUser->deleted_at == null)
                                            <a href="{{ URL('/users/suspend/' . $sysUser->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to suspend this user?');"><i class="fa fa-ban fa-fw"></i> Suspend</a>
                                        @else
                                            <a href="{{ URL('/users/unsuspend/' . $sysUser->id) }}" class="btn btn-success" onclick="return confirm('Are you sure you want to unsuspend this user?');"><i class="fa fa-unlock fa-fw"></i> Unsuspend</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer">
                    <span class="text-right pull-right">{!! $users->render() !!}</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <div id="branchSpecific" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-info-circle"></i> Branch-Specific Users</h4>
                </div>
                <div class="modal-body">
                    <p>Users that are <strong>branch-specific</strong> can only add, update or view records from their own branch. This is recommended for users whose branches are not the main office, or for users that have no authority to view records of branches other than their own.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <script src="{{ asset("/bower_components/ckeditor/ckeditor.js") }}" type="text/javascript"></script>
    <script>
        CKEDITOR.replace('ck', {
            height: '400px',
        });
    </script>
    <script>
        $(function() {
            // Navigation
            $('li.users').addClass('active');
        });
    </script>
@endsection