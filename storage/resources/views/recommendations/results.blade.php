@extends('layouts.master')

@section('title', 'Recommend Candidates')

@section('content')
    <div class="col-md-12">
        @include('partials/status')
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
                            <a class="btn btn-xs btn-success" href="{{route('recommendations::recommend', ['id' => $candidate->id])}}">Recommend</a>
                        </span>
                    </div>
                </li>
            @empty
                <li class="list-group-item">
                    No candidates found. If you feel this is a mistake, contact <a href="mailto:top100@butler.edu?subject=Recommend+Candidate">top100@butler.edu</a>.
                </li>
            @endforelse
        </ul>
        {{-- {!! $candidates->links() !!} --}}
        <a href="{{route('recommendations::index')}}" class="btn btn-primary btn-lg btn-block">Search Again</a>
    </div>
@endsection
