@extends('emails.master')

@section('body')
    <p>{{$request['recommender_name']}},</p>
    <p>You are being asked to write a recommendation for {{$candidate->fullname}} who has been selected for Butler's Top 100 Outstanding Student Recognition Program. Go to <a href="{{$recommendation_url}}">{{$recommendation_url}}</a> if you wish to follow through with this request.
    </p>

    @if(isset($body))
        {!! $body !!}
    @endif

    {{$candidate->fullname}} writes: <br/>
    {!! $request['request_body'] !!}
@endsection
