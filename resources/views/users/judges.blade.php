@extends('layouts.master')

@section('title', 'Judge Assignments')

@section('content')
    <div class="col-md-12">
        @include('partials/status')

        <ul class="nav nav-tabs" role="tablist">
            <li class="active" role="presentation">
                <a href="#round1" aria-controls="profile" role="tab" data-toggle="tab">Round 1</a>
            </li>
            <li role="presentation">
                <a href="#round2" aria-controls="profile" role="tab" data-toggle="tab">Round 2</a>
            </li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="round1">
                <h2>Round 1 Judges</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Total Assigned</th>
                            <th>Total Judged</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($round1 as $judge)
                            <tr {{ ($judge['totalAssigned'] > $judge['totalJudged']) ? 'class=text-muted' : '' }}>
                                <td>{{$judge['user']->firstname}} {{$judge['user']->lastname}}</td>
                                <td>{{$judge['totalAssigned']}}</td>
                                <td>{{$judge['totalJudged']}}</td>
                                <td>{{implode(', ', $judge['user']->roles()->pluck('name')->all())}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="round2">
                <h2>Round 2 Judges</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Total Judged</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($round2 as $judge)
                            <tr {{ ($judge['totalRequired'] > $judge['totalJudged']) ? 'class=text-muted' : '' }}>
                                <td>{{$judge['user']->firstname}} {{$judge['user']->lastname}}</td>
                                <td>{{$judge['totalJudged']}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
