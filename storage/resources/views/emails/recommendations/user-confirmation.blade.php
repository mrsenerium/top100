@extends('emails.master')

@section('body')
    <p>{{$recommender}},</p>
    <p>Thank you for submitting a recommendation for {{$candidate->fullname}}.</p>
    @if(isset($body))
        {!! $body !!}
    @endif
@endsection
