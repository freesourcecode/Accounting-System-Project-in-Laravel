@extends('master')
@section('title', 'New Message')

@section('content')
    <div class="row">
        <div class="col-md-12 top-padded">
            <div class="box box-primary">
                <div class="box-body">
                    @include('partials.alerts')
                    {!! Form::open(array('url'=>'/messages/post','method'=>'POST', 'files'=>true)) !!}
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="recipient">Recipient</label>
                        <select name="recipient" id="recipient" class="form-control">
                            @foreach ($recipients as $recipient)
                                <option value="{{ $recipient->id }}" @if (!empty(old('recipient')) && (old('recipient') == $recipient->id)) selected @endif>{{ $recipient->first_name }} {{ $recipient->last_name }} &lt;{{ $recipient->email }}&gt;</option>
                            @endforeach
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