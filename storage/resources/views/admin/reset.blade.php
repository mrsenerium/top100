@extends('layouts.master')

@section('title', 'Admin - Reset')

@section('content')

    <div class="col-md-12">
        @include('partials/status')
        <form method="post" action="{{route('admin::reset.post')}}">
            {!! csrf_field() !!}
            <p>Reset the application for a new year. All candidates will be deleted.</p>
            <div class="checkbox alert alert-warning">
                <label>
                    <input type="checkbox" name="confirm" />
                    <strong>I verify that I want to <em>permanently</em> delete all existing candidates.</strong>
                </label>
            </div>
            <div class="{{$errors->has('confirm') ? 'has-error' : ''}}">
                @if($errors->has('confirm'))
                  <div class="help-block">
                    {{$errors->first('confirm')}}
                  </div>
                @endif
            </div>
            <button type="submit" class="btn btn-danger"><i class="fa fa-bomb"></i> Reset</button>
            <a href="{{route('admin::index')}}" class="btn btn-default">Cancel</a>
        </form
    </div>

@endsection
