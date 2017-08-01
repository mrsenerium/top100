@extends('layouts.master')

@section('title', 'Admin')

@section('content')

    <div class="col-md-12">
        @include('partials/status')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Overview</h3>
                    </div>
                    <div class="panel-body">
                        @inject('dashboard', 'App\Services\DashboardService')
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> {{$dashboard->getCurrentApplicationState()}}
                        </div>
                        <div class="form-inline">
                        <div class="form-group">
                            <label class="control-label">Total Candidates</label>
                            <div class="form-control-static">{{$dashboard->getTotalCandidates()}}</div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Total Nominated</label>
                            <span class="form-control-static">{{$dashboard->getTotalNominated()}}</span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Total Submitted</label>
                            <span class="form-control-static">{{$dashboard->getTotalSubmitted()}}</span>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Candidates <i class="fa fa-mortar-board text-muted pull-right"></i></h3>
                    </div>
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="{{route('candidates::index')}}">View all candidates</a></li>
                            <li><a href="{{route('import::form')}}">Import candidates</a></li>
                            <li><a href="{{route('candidates::add')}}">Add a candidate</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Results <i class="fa fa-calculator text-muted pull-right"></i></h3>
                    </div>
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="{{route('results::top100')}}">Top 100 results</a></li>
                            <li><a href="{{route('results::round2')}}">Round 2 results</a></li>
                        </ul>
                        <hr/>
                        <form method="post" action="{{route('results::calculate')}}">
                            {!! csrf_field() !!}
                            <button type="submit" class="btn btn-sm btn-info spinner" name="round" value="1">Calculate Top 100 Results</button>
                            <button type="submit" class="btn btn-sm btn-info spinner" name="round" value="2">Calculate Round 2 Results</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Users <i class="fa fa-group text-muted pull-right"></i></h3>
                    </div>
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="{{route('users::index')}}">View all users</a></li>
                            <li><a href="{{route('users::add')}}">Add a new judge or admin</a></li>
                            <li><a href="{{route('users::judges')}}">View judges and assignment counts</a></li>
                        </ul>
                        @if(true)
                        <hr/>
                        <form method="post" action="{{route('judging::assign')}}">
                            {!! csrf_field() !!}
                            <button type="submit"
                                class="btn btn-sm btn-warning spinner"
                                {{AppSettings::getCurrentState() == \App\ApplicationStates::ApplicationsClosed ?: 'disabled'}}
                                name="round"
                                value="1">
                                Assign Round 1 Judges
                            </button>
                            <p class="help-block">
                                <i class="fa fa-exclamation-triangle text-warning"></i>
                                @if(AppSettings::getCurrentState() == \App\ApplicationStates::ApplicationsClosed)
                                    Warning: Assigning judges will <em>permanently</em> delete any existing scores.
                                @else
                                    Judges may only be assigned while the application is in the <strong>Applications Closed</strong> state.
                                @endif
                            </p>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Settings <i class="fa fa-gears text-muted pull-right"></i></h3>
                    </div>
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="{{route('settings::application')}}">Change application settings</a></li>
                            <li><a href="{{route('settings::states')}}">Change application state text and instructions</a></li>
                            <li><a href="{{route('emails::index')}}">Edit application emails</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- <span class="alert alert-warning">Reset will <em>permanently</em> wipe out all existing data.</span> --}}
        <a href="{{route('admin::reset')}}" class="btn btn-danger" title="Wipe and Reset"><i class="fa fa-bomb"></i> Reset</a>
    </div>

@endsection
