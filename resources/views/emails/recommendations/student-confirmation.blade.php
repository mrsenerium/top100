@extends('emails.master')

@section('body')
    <p>{{$candidate->fullname}},</p>
    <p>This email is to inform you that a recommendation has been received from {{$recommender}}.</p>
    @if(isset($body))
        {!! $body !!}
    @endif
@endsection
