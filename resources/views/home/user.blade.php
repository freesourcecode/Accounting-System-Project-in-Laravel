@extends('master')
@section('title', 'User Profile')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                @include('partials.alerts')
                {!! Form::open(['url' => '/user/save', 'method' => 'post', 'files' => true]) !!}
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="email">E-mail address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="E-mail Address" value="@if (empty(old('email'))) {{ $user->email }} @else {{ old('email') }} @endif" required />
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

                <div class="form-group">
                    <label for="job">Job</label>
                    <input type="text" class="form-control" name="job" id="job" value="@if (empty(old('job'))){{ $user->job }}@else{{ old('job') }}@endif" required />
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" name="first_name" id="first_name" value="@if (empty(old('first_name'))){{ $user->first_name }}@else{{ old('first_name') }}@endif" required />
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" name="last_name" id="last_name" value="@if (empty(old('last_name'))){{ $user->last_name }}@else{{ old('last_name') }}@endif" required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address" >Address</label>
                    <textarea id="address" name="address" class="form-control" rows="7" required>@if (empty(old('address'))){{ $user->address }}@else{{ old('address') }}@endif</textarea>
                </div>

                <div class="form-group">
                    <label for="contact">Contact Number <span class="text-muted">optional</span></label>
                    <input type="text" class="form-control" name="contact" id="contact" value="@if(empty(old('contact_no'))){{ $user->contact }}@else{{ old('contact_no') }}@endif" />
                </div>

                <div class="form-group">
                    <label for="photo">Photo</label>
                    {!! Form::file('image') !!}
                    <p class="help-block"><strong>Leave blank to remain unchanged.</strong><br />Avatars uploaded here take priority over Gravatar.<br />Must not exceed {{ ini_get('upload_max_filesize') }}B. Images only (JPG, PNG, GIF).</p>
                </div>

            </div>
            <div class="box-footer">
                <div class="text-center spacer">
                    <button type="submit" class="btn btn-success">Edit Profile</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
    $('li.usermenu').addClass('active');
</script>
@endsection