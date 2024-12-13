@extends('master')
@section('title', 'System Logs')

@section('content')
    <div class="row">
        <div class="col-md-12 top-padded">
            @include('partials.alerts')
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-list fa-fw"></i> System Logs</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th style="width: 50px;"></th>
                                <th>User</th>
                                <th>Action</th>
                                <th class="text-center">IP Address</th>
                                <th class="text-center">Date Performed</th>
                            </tr>
                            </thead>
                            @foreach ($logs as $log)
                                <tr>
                                    <td class="text-center">
                                        @if ($log->avatar == "")
                                            <img src="http://gravatar.com/avatar/{{ md5($log->email) }}" class="img-circle small-avatar" />
                                        @else
                                            <img src="{{ $log->avatar }}" class="img-circle small-avatar" />
                                        @endif
                                    </td>
                                    <td>
                                        <span>{{ $log->first_name }} {{ $log->last_name }}</span><br />
                                        <span class="text-muted">{{ $log->email }}</span>
                                    </td>
                                    <td>{{ $log->action }}</td>
                                    <td class="text-center">{{ $log->ip }}</td>
                                    <td class="text-center">{{ $log->created_at }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="box-footer">
                    <span class="text-right pull-right">{!! $logs->render() !!}</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            // Navigation
            $('li.logs').addClass('active');
        });
    </script>
@endsection