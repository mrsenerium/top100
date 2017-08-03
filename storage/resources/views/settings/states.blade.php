@extends('layouts.master')

@section('title', 'Application States')

@section('content')

  <div class="col-md-12">
    <p>Select a state below to edit the description and text that appears throughout the application.</p>
    <ul class="nav nav-pills nav-stacked">
      @foreach($states as $state)
        <li><a href="{{route('settings::state.get', ['id' => $state->id])}}">{{$state->name}}</a></li>
      @endforeach
    </ul>
  </div>

@endsection
