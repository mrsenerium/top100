@extends('emails.master')

@section('body')
    <p><strong>Congratulations {{$candidate->fullname}}!</strong></p>
    @if(isset($body))
        {!! $body !!}
    @endif

@endsection
