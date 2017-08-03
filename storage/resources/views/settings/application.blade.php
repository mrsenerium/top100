@extends('layouts.master')

@section('title', 'Application Settings')

@section('content')

  <div class="col-md-12">
    @include('partials/status')

    <form method="post" action="{{route('settings::application.update')}}">
      {!! csrf_field() !!}

      <div class="form-group {{$errors->has('current_state') ? 'has-error' : ''}}">
        <label for="current_state" class="required">Current State</label>
        <select id="current_state" name="current_state" class="form-control">
          @foreach($states as $id => $name)
            <option value="{{$id}}" {{$id == old('current_state', AppSettings::getCurrentState()) ? 'selected' : ''}}>{{$name}}</option>
          @endforeach
        </select>
        @if($errors->has('current_state'))
          <div class="help-block">
            {{$errors->first('current_state')}}
          </div>
        @endif
      </div>

      <div class="form-group {{$errors->has('reflection_question') ? 'has-error' : ''}}">
        <label for="reflection_question" class="required">Reflection Question</label>
        <textarea name="reflection_question" id="reflection_question" class="form-control" rows="3">{{old('reflection_question', AppSettings::getReflectionQuestion())}}</textarea>
        @if($errors->has('reflection_question'))
          <div class="help-block">
            {{$errors->first('reflection_question')}}
          </div>
        @endif
      </div>

      <div class="form-group {{$errors->has('organization_max') ? 'has-error' : ''}}">
        <label for="organization_max" class="required">Max Organization Count</label>
        <input type="text" name="organization_max" id="organization_max" class="form-control" value="{{old('organization_max', AppSettings::getOrganizationMax())}}" />
        @if($errors->has('organization_max'))
          <div class="help-block">
            {{$errors->first('organization_max')}}
          </div>
        @endif
      </div>

      <div class="form-group">
        <div class="{{$errors->has('separate_genders') ? 'has-error' : ''}}">
          <label for="separate_genders" class="required">Separate round 2 by gender?</label>
          <div class="radio">
            <label><input type="radio" name="separate_genders" value="1" {{old('separate_genders', AppSettings::getSeparateGenders()) ? 'checked' : ''}}/> Yes</label>
            <label><input type="radio" name="separate_genders" value="0" {{!old('separate_genders', AppSettings::getSeparateGenders()) ? 'checked' : ''}}/> No</label>
          </div>
          @if($errors->has('separate_genders'))
            <div class="help-block">
              {{$errors->first('separate_genders')}}
            </div>
          @endif
        </div>
      </div>

      <button type="submit" class="btn btn-success">Save</button>
    </form>
  </div>

@endsection
