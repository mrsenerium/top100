@extends('layouts.master')

@section('title', 'Application Emails')

@section('content')

  <div class="col-md-12">
    <p>Select an email below to edit the subject and body.</p>
    <ul class="nav nav-pills nav-stacked">
      @foreach($emails as $email)
        <li>
            <a href="{{route('emails::edit', ['id' => $email->id])}}">
                {{$email->subject}} <br/>
                <em class="text-muted">{{$email->description}}</em>
            </a>
        </li>
      @endforeach
    </ul>
  </div>

@endsection
