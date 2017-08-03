@extends('layouts.master')

@section('title', 'Nominate Candidates')

@section('content')
    <div class="col-md-12">
        @include('partials/status')
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <ul class="list-group">
            <li class="list-group-item list-group-item-info">
                <h4>Search Results</h4>
            </li>
            @forelse($candidates as $candidate)
                <li class="list-group-item">
                    <div class="row">
                        <span class="col-xs-8 col-sm-4">
                            {{$candidate->user->firstname}} {{$candidate->user->lastname}} <br/>
                            <em class="text-muted">{{$candidate->user->email}}</em>
                        </span>
                        <span class="col-xs-4">
                            <form method="post" action="{{route('candidates::nominate.save', ['id' => $candidate->id])}}">
                                {!! csrf_field() !!}
                                <button type="submit" class="btn btn-xs btn-success">Nominate</button>
                            </form>
                        </span>
                    </div>
                </li>
            @empty
                <li class="list-group-item">
                    No candidates found. If you feel this is a mistake, contact <a href="mailto:top100@butler.edu?subject=Missing+Candidate">top100@butler.edu</a>.
                </li>
            @endforelse
        </ul>
        <p class="help-block">Can't find who you're looking for or see a mistake? Contact <a href="mailto:top100@butler.edu?subject=Nominations">top100@butler.edu</a>.</p>
        <a href="{{route('candidates::nominate')}}" class="btn btn-primary btn-lg btn-block">Search Again</a>
    </div>
@endsection
