@extends('master')
@section('title', 'View Message')

@section('content')
    <div class="row">
        <div class="col-md-12 top-padded">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ $message->subject }} </h3><br />
                    <span class="text-muted">@if ($sender->avatar == "")
                            <img src="http://gravatar.com/avatar/{{ md5($sender->email) }}" class="img-circle smaller-avatar" />
                        @else
                            <img src="{{ $sender->avatar }}" class="img-circle smaller-avatar" />
                        @endif
                        {{ $sender->first_name }} {{ $sender->last_name }} &lt;{{ $sender->email }}&gt; on {{ $message->created_at }}</span>
                </div>
                <div class="box-body">
                    {!! $message->message  !!}
                    @if ($message->attachments != "")
                    <hr />
                    <h4>Attachments</h4>
                    <ul>
                    @foreach ($attachments as $attachment)
                        <li><a href="{{ $attachment }}" target="_blank">{{ basename($attachment) }} ({{ number_format(filesize(substr($attachment, 1)) / 1024, 2) }} KB)</a></li>
                    @endforeach
                    </ul>
                    @endif
                </div>
                <div class="box-footer">
                    <a href="/messages" class="btn btn-xs btn-primary"><i class="fa fa-angle-left fa-fw"></i> Back to Messages</a>
                    <span class="pull-right">
                        <a href="#reply" class="btn btn-xs btn-success"><i class="fa fa-plus fa-fw"></i> Quick Reply</a>
                        <a href="{{ URL('/messages/delete/' . $message->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure you want to delete this message?');"><i class="fa fa-trash fa-fw"></i> Delete</a>
                    </span>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12 top-padded">
            <a name="reply"></a>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Quick Reply</h3>
                </div>
                <div class="box-body">
                    @include('partials.alerts')
                    {!! Form::open(array('url'=>'/messages/post','method'=>'POST', 'files'=>true)) !!}
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="recipient">Recipient</label>
                        <select name="recipient" id="recipient" class="form-control">
                           <option value="{{ $sender->id }}">{{ $sender->first_name }} {{ $sender->last_name }} &lt;{{ $sender->email }}&gt;</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject') }}" />
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea name="message" id="ck" class="form-control" rows="7">{{ old('subject') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="attachments">Attachments</label>
                        {!! Form::file('attachments[]', array('multiple'=>true)) !!}
                        <p class="help-block"><strong>Optional.</strong><br />Each file must not exceed {{ ini_get('upload_max_filesize') }}B.<br />Allowed files: Word, Excel, Powerpoint, ZIP, 7Z, RAR, Images.</p>
                    </div>

                    <div class="text-center top-padded">
                        <input type="submit" class="btn btn-success" value="Send Message" />
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
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