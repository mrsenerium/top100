@extends('layouts.master')

@section('title', 'Add New User')

@section('content')
    <div class="col-md-12">
        @include('partials/status')
        <form method="post" action="{{route('users::add.save')}}">
            {!! csrf_field() !!}

            <div class="form-group col-md-6 {{$errors->has('firstname') ? 'has-error' : ''}}">
                <label for="firstname" class="required">First Name</label>
                <input type="text" name="firstname" id="firstname" class="form-control"
                        value="{{old('firstname')}}" />
                @if($errors->has('firstname'))
                  <div class="help-block">
                    {{$errors->first('firstname')}}
                  </div>
                @endif
            </div>

            <div class="form-group col-md-6 {{$errors->has('lastname') ? 'has-error' : ''}}">
                <label for="lastname" class="required">Last Name</label>
                <input type="text" name="lastname" id="lastname" class="form-control"
                        value="{{old('firstname')}}" />
                @if($errors->has('lastname'))
                  <div class="help-block">
                    {{$errors->first('lastname')}}
                  </div>
                @endif
            </div>

            <div class="form-group col-md-6 {{$errors->has('email') ? 'has-error' : ''}}">
                <label for="email" class="required">Email</label>
                <input type="email" name="email" id="email" class="form-control"
                        value="{{old('email')}}" />
                @if($errors->has('email'))
                  <div class="help-block">
                    {{$errors->first('email')}}
                  </div>
                @endif
            </div>

            <div class="form-group col-md-6 {{$errors->has('username') ? 'has-error' : ''}}">
                <label for="username" class="required">Username</label>
                <input type="text" name="username" id="username" class="form-control"
                        value="{{old('username')}}" />
                @if($errors->has('username'))
                  <div class="help-block">
                    {{$errors->first('username')}}
                  </div>
                @endif
            </div>

            <div class="form-group col-md-6 {{$errors->has('password') ? 'has-error' : ''}}">
                <label for="password" class="required">Password</label>
                <input type="password" name="password" id="password" class="form-control"
                        value="{{old('password')}}" />
                @if($errors->has('password'))
                  <div class="help-block">
                    {{$errors->first('password')}}
                  </div>
                @else
                    <div class="help-block">
                      Choose a password for non-Butler users.
                    </div>
                @endif
            </div>

            <div class="form-group col-md-6 {{$errors->has('password_confirmation') ? 'has-error' : ''}}">
                <label for="password_confirmation" class="required">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                        value="{{old('password_confirmation')}}" />
                @if($errors->has('password_confirmation'))
                  <div class="help-block">
                    {{$errors->first('password_confirmation')}}
                  </div>
                @endif
            </div>

            <fieldset class="col-md-12">
                <legend>Roles</legend>
                <p>Select all roles this user should have.</p>
                <div class="form-group">
                    <label for="roles" class="required">Available Roles</label>
                    @inject('roles', 'RoleList')
                    @foreach($roles->all() as $role)
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="roles[]" {{collect(old('roles'))->contains($role->id) ? 'checked' : ''}} value="{{$role->id}}" />
                                {{$role->name}}
                            </label>
                        </div>
                    @endforeach
                    @if($errors->has('roles'))
                    <div class="{{$errors->has('roles') ? 'has-error' : ''}}">
                      <div class="help-block">
                        {{$errors->first('roles')}}
                      </div>
                    </div>
                    @endif
                </div>
            </fieldset>

            <div class="col-md-12">
                <button type="submit"class="btn btn-success">Save</button>
                <a href="{{route('users::index')}}" class="btn btn-default">Cancel</a>
            </div>
        </form>
    </div>

@endsection
@push('scripts')
    <script src="{{asset('js/custom/user-form.js')}}"></script>
@endpush
