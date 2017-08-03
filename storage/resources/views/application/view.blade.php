@extends('layouts.master')

@section('title')
    Application for {{$candidate->user->firstname}} {{$candidate->user->lastname}}
@endsection

@section('content')
    <div class="col-md-12">
        @include('partials/status')
        @can('apply')
            <div class="col-md-12">
                <a href="{{route('application::form')}}" class="btn btn-info pull-right">Edit Application</a>
            </div>
        @endcan
        <div class="col-md-4 col-md-push-8">
            @include('partials.candidate')
        </div>
        <div class="col-md-8 col-md-pull-4">
            {{-- TODO: check if user can read recommendations --}}
            @if($candidate->recommendations->count() > 0)
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#candidate-view" aria-controls="candidate-view" role="tab" data-toggle="tab">Candidate</a>
                    </li>
                    <li>
                        <a href="#recommendation-view" aria-controls="recommendation-view" role="tab" data-toggle="tab">Recommendations</a>
                    </li>
                </ul>
            @endif
            <div class="tab-content">
                <div id="candidate-view" role="tabpanel" class="tab-pane active">
                    <fieldset>
                        <legend>Academics</legend>
                        <div class="form-group">
                            <label for="additional_majors" class="control-label">Additional Majors</label>
                            <p id="additional_majors">{{$candidate->application->additional_majors}}</p>
                        </div>
                        <div class="form-group">
                            <label for="academic_honors" class="control-label">Academic Honors</label>
                            <p id="academic_honors">{{$candidate->application->academic_honors}}</p>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Reflection</legend>
                        @inject('app_settings', 'AppSettings')
                        <label for="reflection" class="control-label">{{AppSettings::getReflectionQuestion()}}</label>
                        {!! $candidate->application->reflection !!}
                    </fieldset>
                    <fieldset>
                        <legend>Activities and Leadership</legend>
                        @each('application.organization.view', $candidate->organizations()->where('organization_type', 'activity')->get(), 'organization', 'application.organization.empty')
                    </fieldset>
                    <fieldset>
                        <legend>Service</legend>
                        @each('application.organization.view', $candidate->organizations()->where('organization_type', 'service')->get(), 'organization', 'application.organization.empty')
                    </fieldset>
                </div>

                @if($candidate->recommendations->count() > 0)
                    <div id="recommendation-view" role="tabpanel" class="tab-pane">
                        <p></p>
                        @foreach($candidate->recommendations as $recommendation)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">{{$recommendation->name}}</h3>
                                </div>
                                <div class="panel-body">
                                    {!! $recommendation->message !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
