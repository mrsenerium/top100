@extends('layouts.master')

@section('title')
    Application - {{$candidate->user->firstname}} {{$candidate->user->lastname}}
@endsection

@section('content')
    <div class="col-md-12">
        @include('partials/status')
        <form method="post" action="{{route('candidates::application.update')}}">
            {!! csrf_field() !!}
            <div class="col-md-4 col-md-push-8">
                @include('partials.candidate')
            </div>
            <div class="col-md-8 col-md-pull-4">
                <fieldset>
                    <legend>Academics</legend>
                    <div class="form-group {{$errors->has('addition_majors') ? 'has-error' : ''}}">
                        <label for="addition_majors">Additional Majors</label>
                        <input type="text" name="addition_majors" id="addition_majors" class="form-control"
                                value="{{old('addition_majors', is_null($candidate->application) ? '' : $candidate->application->addition_major)}}" />
                        @if($errors->has('addition_majors'))
                          <div class="help-block">
                            {{$errors->first('addition_majors')}}
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
                        <div class="form-group">
                            @inject('app_settings', 'AppSettings')
                            <label for="reflection_question" class="required">{{AppSettings::getReflectionQuestion()}}</label>
                            <textarea id="reflection_question" name="reflection_question" class="form-control wysiwyg" rows="7">{{old('academic_honors', is_null($candidate->application) ? '' : $candidate->application->academic_honors)}}</textarea>
                        </div>
                </fieldset>
                {{dd($candidate->organizations()->where(['organization_type' => 'service'])->count())}}
                <fieldset>
                    <legend>Activities and Leadership</legend>
                    <p>
                        Please list student organizations, varsity teams, and any other activities, including
                        any leadership positions you have held, in which you have been involved during your
                        undergraduate career. Please use the following format for each organization that
                        you have been involved with: positions held, brief description of organization (1-2 sentences), description of your contribution.
                    </p>
                    @each('candidates.organization', $candidate->organizations()->where(['organization_type' => 'activity']), 'organization')
                    @include('candidates.organization', [
                        'type' => 'activity',
                        'key' => $candidate->organizations()->where(['organization_type' => 'activity'])->count()
                    ])
                    <p>
                    <button type="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add Activity</button>
                    </p>
                </fieldset>
                <fieldset>
                    <legend>Service</legend>
                    <p>
                        Have you participated in community service at Butler, within the Indianapolis community
                        and/or at home? If so, please use the following format for each organization that
                        you have been involved: positions held, brief description of organization (1-2 sentences), description of your contribution.
                    </p>
                    @each('candidates.organization', $candidate->organizations()->where(['organization_type' => 'service']), 'organization')
                    @include('candidates.organization', [
                        'type' => 'service',
                        'key' => $candidate->organizations()->where(['organization_type' => 'service'])->count()
                    ])
                    <p>
                    <button type="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add Service</button>
                    </p>
                </fieldset>
            </div>
            <div class="col-md-12">
                <div class="checkbox alert alert-warning">
                    <label>
                        <input type="checkbox" name="confirm" />
                        I have completed my application and I understand that after clicking the 'FINISH' button, I will no longer be able to make changes to my application. I also understand that by submitting this information I consent to release this information for the purposes of nomination for the Outstanding Student Recognition Program.
                    </label>
                </div>
            </div>
            <div class="col-md-12">
                <button type="submit" name="save_app" class="btn btn-success">Save for later</button>
                <button type="submit" name="submit_app" class="btn btn-primary">Finish</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
  <script src="//cdn.ckeditor.com/4.5.6/basic/ckeditor.js"></script>
@endpush
