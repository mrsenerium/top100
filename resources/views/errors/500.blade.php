@extends('layouts.master')

@section('title', 'Server Error')

@section('content')

  <div class="col-md-12">
    <div class="jumbotron">
      <p>Something has gone wrong.</p>
      {{-- TODO: Provide instructions for users to contact help desk and proper information to send. --}}
      <p>If this problem persists, <a href="https://www.butler.edu/it/help">contact the IT Help Desk</a>.</p>
    </div>
  </div>

@endsection
