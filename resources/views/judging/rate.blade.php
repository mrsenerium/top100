@extends('layouts.master')

@section('title')
    Round 1 Judging For Applicant {{$candidate->id}}
@endsection

@section('content')
    <div class="col-md-12">
        <div class="col-md-4 col-md-push-8">
            @include('partials.candidate')
        </div>
        <form action="{{route('judging::round1.rate.save', ['candidateid' => $candidate->id])}}" method="post" class="col-md-8 col-md-pull-4">
            {!! csrf_field() !!}

            <p>Provide a score for each section where 0 is the worst and 10 is the best. You must provide a score for each section before saving.</p>
            <div class="alert alert-info"><i class="fa fa-info-circle"></i> To save, scroll to bottom and press "Save"</div>
            <fieldset>
                <legend>Academics</legend>
                <div class="form-group pull-right scale-container">
                    @include('judging.partials.scale', [
                        'field_name' => 'academics_score',
                        'score' => $score->academics_score
                    ])
                </div>
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
                <div class="form-group pull-right scale-container">
                    @include('judging.partials.scale', [
                        'field_name' => 'reflection_score',
                        'score' => $score->reflection_score
                    ])
                </div>
                @inject('app_settings', 'AppSettings')
                <label for="reflection" class="control-label">{{AppSettings::getReflectionQuestion()}}</label>
                {!! $candidate->application->reflection !!}
            </fieldset>
            <fieldset>
                <legend>Activities and Leadership</legend>
                <div class="form-group pull-right scale-container">
                    @include('judging.partials.scale', [
                        'field_name' => 'activities_score',
                        'score' => $score->activities_score
                    ])
                </div>
                @each('application.organization.view', $candidate->organizations()->where('organization_type', 'activity')->get(), 'organization', 'application.organization.empty')
            </fieldset>
            <fieldset>
                <legend>Service</legend>
                <div class="form-group pull-right scale-container">
                    @include('judging.partials.scale', [
                        'field_name' => 'services_score',
                        'score' => $score->services_score
                    ])
                </div>
                @each('application.organization.view', $candidate->organizations()->where('organization_type', 'service')->get(), 'organization', 'application.organization.empty')
            </fieldset>

            <div class="form-buttons well well-sm">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{route('judging::round1')}}" class="btn btn-default">Cancel</a>
            </div>
        </form>
    </div>

@endsection
