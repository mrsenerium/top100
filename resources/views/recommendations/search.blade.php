@extends('layouts.master')

@section('title', 'Recommendations')

@section('content')
    <div class="col-md-12">
        @include('partials/status')
        <div class="jumbotron">
            <h2>I want to recommend...</h2>
            <form method="post" action="{{route('recommendations::search')}}">
                {!! csrf_field() !!}
                <label class="sr-only" for="search">Search for a candidate</label>
                <div class="input-group {{$errors->has('search') ? 'has-error' : ''}}">
                    <input type="search" name="search" placeholder="Search for a candidate" class="form-control input-lg" />
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-lg btn-primary"><i class="fa fa-search"></i><span class="sr-only">Search</span></button>
                    </span>
                </div>
                <div class="help-block">
                    Search for candidates by first name, last name, or Butler email.
                </div>
                @if($errors->has('search'))
                  <div class="help-block text-danger">
                    {{$errors->first('search')}}
                  </div>
                @endif
            </form>
        </div>
    </div>

@endsection
