@extends('master')
@section('title', 'Edit User')

@section('content')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['url' => '/users/edit/save', 'method' => 'post', 'files' => true]) !!}
            {!! csrf_field() !!}
            <input type="hidden" name="id" value="{{ $id }}" />
            <div class="box box-default">
                <div class="box-body">
                    @include('partials.alerts')
                    <div class="form-group">
                        <label for="email">E-mail address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="E-mail Address" value="@if (empty(old('email'))) {{ $editUser->email }} @else {{ old('email') }} @endif" required />
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Leave blank to remain unchanged" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label for="password">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" id="password" placeholder="Leave blank to remain unchanged" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label for="branch">Branch</label>
                                <select id="branch" class="form-control" name="branch">
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}" @if ($editUser->branch == $branch->id) selected @endif>{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label for="job">Job</label>
                                <input type="text" class="form-control" name="job" id="job" value="@if (empty(old('job'))) {{ $editUser->job }} @else {{ old('job') }} @endif" required />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" name="first_name" id="first_name" value="@if (empty(old('first_name'))){{ $editUser->first_name }}@else{{ old('first_name') }}@endif" required />
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" name="last_name" id="last_name" value="@if (empty(old('last_name'))){{ $editUser->last_name }}@else{{ old('last_name') }}@endif" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address" >Address</label>
                        <textarea id="address" name="address" class="form-control" rows="7" required>@if (empty(old('address'))){{ $editUser->address }}@else{{ old('address') }}@endif</textarea>
                    </div>

                    <div class="form-group">
                        <label for="contact">Contact Number <span class="text-muted">optional</span></label>
                        <input type="text" class="form-control" name="contact" id="contact" value="@if(empty(old('contact_no'))){{ $editUser->contact }}@else{{ old('contact_no') }}@endif" />
                    </div>

                    <div class="form-group">
                        <label for="photo">Photo</label>
                        {!! Form::file('image') !!}
                        <p class="help-block"><strong>Optional.</strong><br />Avatars uploaded here take priority over Gravatar.<br />Must not exceed {{ ini_get('upload_max_filesize') }}B. Images only (JPG, PNG, GIF).</p>
                    </div>
                </div>
                <div class="box-footer text-center">
                    <input type="submit" class="btn btn-success" value="Edit User" />
                </div>
            </div>
            {!! Form::close() !!}
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