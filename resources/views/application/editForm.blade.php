@extends('layouts.master')

@section('title')
    Application - {{$candidate->user->firstname}} {{$candidate->user->lastname}}
@endsection

@section('content')
    <div class="col-md-12">
        @include('partials/status')
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <p>You must correct the following errors before submitting.</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="post" action="{{route('application::form.update')}}">
            {!! csrf_field() !!}
            <div class="col-md-4 col-md-push-8">
                @include('partials.candidate')
            </div>
            <div class="col-md-8 col-md-pull-4">
                <fieldset>
                    <legend>Academics</legend>
                    <div class="form-group {{$errors->has('additional_majors') ? 'has-error' : ''}}">
                        <label for="additional_majors">Additional Majors</label>
                        <input type="text" name="additional_majors" id="additional_majors" class="form-control"
                                value="{{old('additional_majors', is_null($candidate->application) ? '' : $candidate->application->additional_majors)}}" />
                        @if($errors->has('additional_majors'))
                          <div class="help-block">
                            {{$errors->first('additional_majors')}}
                          </div>
                        @endif
                    </div>
                    <div class="form-group {{$errors->has('academic_honors') ? 'has-error' : ''}}">
                        <label for="academic_honors">Academic Honors</label>
                        <input type="text" name="academic_honors" id="academic_honors" class="form-control"
                                value="{{old('academic_honors', is_null($candidate->application) ? '' : $candidate->application->academic_honors)}}" />
                        @if($errors->has('academic_honors'))
                          <div class="help-block">
                            {{$errors->first('academic_honors')}}
                          </div>
                        @endif
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Reflection</legend>
                        <div class="form-group {{$errors->has('reflection') ? 'has-error' : ''}}">
                            @inject('app_settings', 'AppSettings')
                            <label for="reflection" class="required">{{AppSettings::getReflectionQuestion()}}</label>
                            <textarea id="reflection" name="reflection" class="form-control wysiwyg" rows="7">{{old('reflection', is_null($candidate->application) ? '' : $candidate->application->reflection)}}</textarea>
                            @if($errors->has('reflection'))
                              <div class="help-block">
                                {{$errors->first('reflection')}}
                              </div>
                            @endif
                        </div>
                </fieldset>
                <fieldset>
                    <legend>Activities and Leadership</legend>
                    <p>
                        Please list student organizations, varsity teams, and any other activities, including
                        any leadership positions you have held, in which you have been involved during your
                        undergraduate career. Please use the following format for each organization that
                        you have been involved with: positions held, brief description of organization (1-2 sentences), description of your contribution.
                    </p>
                    @each('application.organization.edit', $candidate->organizations()->where('organization_type', 'activity')->get(), 'organization')
                    @if($candidate->organizations()->where('organization_type', 'activity')->count() < AppSettings::getOrganizationMax())
                        @include('application.organization.edit', [
                            'type' => 'activity',
                            'key' => $candidate->organizations()->where('organization_type', 'activity')->count()
                        ])
                    @endif
                    <p>
                    <button type="button" class="btn btn-success btn-xs add-org"><i class="fa fa-plus"></i> Add Activity</button>
                    </p>
                </fieldset>
                <fieldset>
                    <legend>Service</legend>
                    <p>
                        Have you participated in community service at Butler, within the Indianapolis community
                        and/or at home? If so, please use the following format for each organization that
                        you have been involved: positions held, brief description of organization (1-2 sentences), description of your contribution.
                    </p>
                    @each('application.organization.edit', $candidate->organizations()->where('organization_type', 'service')->get(), 'organization')
                    @if($candidate->organizations()->where('organization_type', 'service')->count() < AppSettings::getOrganizationMax())
                        @include('application.organization.edit', [
                            'type' => 'service',
                            'key' => $candidate->organizations()->where('organization_type', 'service')->count()
                        ])
                    @endif
                    <p>
                    <button type="button" class="btn btn-success btn-xs add-org"><i class="fa fa-plus"></i> Add Service</button>
                    </p>
                </fieldset>
            </div>
            <div class="col-md-12">
                <div class="checkbox alert alert-warning">
                    <label>
                        <input type="checkbox" name="confirm" id="confirm" />
                        I have completed my application and I understand that after clicking the 'FINISH' button, I will no longer be able to make changes to my application. I also understand that by submitting this information I consent to release this information for the purposes of nomination for the Outstanding Student Recognition Program.
                    </label>
                </div>
            </div>
            <div class="col-md-12">
                <button type="submit" name="save_app" class="btn btn-success">Save for later</button>
                <button type="submit" name="preview_app" class="btn btn-info">Preview</button>
            </div>
        </form>
    </div>
@endsection
