@extends('master')
@section('title', 'Reassign Permissions - ' . $reassignUser->email)

@section('content')
    <div class="row">
        <div class="col-md-12 top-padded">
            @include('partials.alerts')
            <form action="{{ URL('/users/reassign/save') }}" method="post">
                {!! csrf_field() !!}
                <input type="hidden" name="id" value="{{ $reassignUser->id }}" />
                <div class="box box-default">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="new">New Permission Set</label>
                            <select id="new" class="form-control" name="permission">
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="box-footer text-center">
                        <input type="submit" class="btn btn-success" value="Reassign" />
                    </div>
                </div>
            </form>
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
            $('li.users').addClass('active');
        });
    </script>
@endsection