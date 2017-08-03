@extends('emails.master')

@section('body')
    <p>{{$user->firstname}} {{$user->lastname}},</p>
    <p>Thank you for nominating {{$candidate->fullname}}.</p>
    @if(isset($body))
        {!! $body !!}
    @endif

@endsection
