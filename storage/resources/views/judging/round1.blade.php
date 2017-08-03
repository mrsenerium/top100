@extends('layouts.master')

@section('title', 'Round 1 Judging')

@section('content')

    <div class="col-md-12">
        @include('partials/status')
        <p>Click on a name below to judge the candidate. You must judge all candidates
           listed for your scores to count.
           Judged candidates will be marked with a <i class="fa fa-check text-success" title="check mark icon"></i>.
       </p>
        <div class="list-group">
            @foreach($candidates as $candidate)
                <a href="{{route('judging::round1.rate', ['candidateid' => $candidate->id])}}" class="list-group-item">
                    {{$candidate->fullname}}

                    @if($candidate->round1Scores->findBySecondary(Auth::user()->id))
                        @if($candidate->round1Scores->findBySecondary(Auth::user()->id)->hasScores())
                            <i class="fa fa-check text-success" title="Candidate has been scored."></i>
                            <span class="badge" title="Your score for {{$candidate->fullname}}">
                                {{$candidate->round1Scores->findBySecondary(Auth::user()->id)->total()}}
                            </span>
                        @endif
                    @endif
                </a>
            @endforeach
        </div>
    </div>

@endsection
