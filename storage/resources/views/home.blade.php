@extends('layouts.master')

@section('title')
Home <small class="pull-right">{{$current_state->name}}</small>
@endsection

@section('content')
  <div class="col-md-12">
    {!! $current_state->description !!}

    @if(Auth::check() && $current_state->help_text !== '')
      <h2>Instructions</h2>
      {!! $current_state->help_text !!}
    @endif

  </div>
@endsection
