@extends('layouts.master')

@section('title', 'Login')


@section('content')
  <div class="col-md-push-3 col-md-6 col-lg-push-4 col-lg-4">
    <form method="post" action="{{route('login')}}" class="well">
      {!! csrf_field() !!}
      <div class="form-group {{$errors->has('username') ? 'has-error' : ''}}">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" class="form-control" />
      </div>
      <div class="form-group {{$errors->has('username') ? 'has-error' : ''}}">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control" />
      </div>
      <div>
          <button type="submit" class="btn btn-primary">Login</button>
      </div>
    </form>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  </div>
@endsection
