@extends('master')
@section('title', 'Messages')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div>
                <a href="{{ URL('/messages/new') }}" class="btn btn-success text-right pull-right"><i class="fa fa-plus fa-fw"></i> New Message</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 top-padded">
            @include('partials.alerts')
            @if (count($messages) == 0)
                You have no messages.
            @else
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-envelope fa-fw"></i> Inbox @if (count($messages) > 0) ({{ count(\App\Messages::all()) }}) @endif</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th style="width: 50px;"></th>
                                    <th>From</th>
                                    <th>Message</th>
                                    <th class="text-center">Received On</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($messages as $message)
                                    <tr>
                                        <td class="text-center">
                                            @if ($message->sender_avatar == "")
                                                <img src="http://gravatar.com/avatar/{{ md5($message->sender_email) }}" class="img-circle small-avatar" />
                                            @else
                                                <img src="{{ $message->sender_avatar }}" class="img-circle small-avatar" />
                                            @endif
                                        </td>
                                        <td>
                                            {{ $message->sender_fname }} {{ $message->sender_lname }}<br />
                                            <span class="text-muted">{{ $message->sender_email }}</span>
                                        </td>
                                        <td @if ($message->unread) class="text-bold" @endif>
                                            @if ($message->attachments != "") <i class="fa fa-paperclip fa-fw"></i> @endif
                                            <a href="{{ URL('/messages/view/' . $message->id) }}">{{ $message->subject }}</a><br />
                                            <span class="ellipsis">{{ str_limit(strip_tags($message->message), $limit = 100, $end = '...') }}</span>
                                        </td>
                                        <td class="text-center">
                                            {{ $message->created_at }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ URL('/messages/delete/' . $message->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this message?');">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box-footer">
                        <span class="text-right pull-right">{!! $messages->render() !!}</span>
                    </div>
                </div>

            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset("/bower_components/ckeditor/ckeditor.js") }}" type="text/javascript"></script>
    <script>
        CKEDITOR.replace('ck', {
            height: '400px',
        });
    </script>
    <script>
        $(function() {
            // Navigation
            $('li.messages').addClass('active');
        })
    </script>
@endsection