@extends('layouts.master')

@section('title', 'Edit Candidate')

@section('content')
  <div class="col-md-12">
    @include('partials/status')
    <form method="post" action="{{route('candidates::edit.save', ['id' => $candidate->id])}}">
      {!! csrf_field() !!}
      <input type="hidden" name="id" value="{{$candidate->id}}" />
      <div class="row">
          <div class="form-group {{$errors->has('firstname') ? 'has-error' : ''}} col-md-6">
            <label for="firstname" class="required">First Name</label>
            <input type="text" name="firstname" id="firstname" class="form-control"
                    value="{{old('firstname', $candidate->user->firstname)}}" />
            @if($errors->has('firstname'))
              <div class="help-block">
                {{$errors->first('firstname')}}
              </div>
            @endif
          </div>
          <div class="form-group {{$errors->has('lastname') ? 'has-error' : ''}} col-md-6">
            <label for="lastname" class="required">Last Name</label>
            <input type="text" name="lastname" id="lastname" class="form-control"
                    value="{{old('lastname', $candidate->user->lastname)}}" />
            @if($errors->has('lastname'))
              <div class="help-block">
                {{$errors->first('lastname')}}
              </div>
            @endif
          </div>
      </div>

      <div class="row">
          <div class="form-group {{$errors->has('email') ? 'has-error' : ''}} col-md-6">
            <label for="email" class="required">Email</label>
            <input type="text" name="email" id="email" class="form-control" disabled
                    value="{{old('email', $candidate->user->email)}}" />
            @if($errors->has('email'))
              <div class="help-block">
                {{$errors->first('email')}}
              </div>
            @endif
          </div>
          <div class="form-group {{$errors->has('username') ? 'has-error' : ''}} col-md-6">
            <label for="username" class="required">Username</label>
            <input type="text" name="username" id="username" class="form-control" disabled
                    value="{{old('username', $candidate->user->username)}}" />
            @if($errors->has('username'))
              <div class="help-block">
                {{$errors->first('username')}}
              </div>
            @endif
          </div>
      </div>

      <div class="row">
          <div class="form-group {{$errors->has('college') ? 'has-error' : ''}} col-md-6">
            <label for="college" class="required">College</label>
            <input type="text" name="college" id="college" class="form-control"
                    value="{{old('college', $candidate->college)}}" />
            @if($errors->has('college'))
              <div class="help-block">
                {{$errors->first('college')}}
              </div>
            @endif
          </div>

          <div class="form-group {{$errors->has('major') ? 'has-error' : ''}} col-md-6">
            <label for="major" class="required">Major</label>
            <input type="text" name="major" id="major" class="form-control"
                    value="{{old('major', $candidate->major)}}" />
            @if($errors->has('major'))
              <div class="help-block">
                {{$errors->first('major')}}
              </div>
            @endif
          </div>
      </div>

      <div class="row">
          <div class="form-group {{$errors->has('class') ? 'has-error' : ''}} col-md-6">
            <label for="class" class="required">Class</label>
            <select id="class" name="class" class="form-control">
                <option value="30" {{30 == old('class', $candidate->class) ? 'selected' : ''}}>Junior</option>
                <option value="40" {{40 == old('class', $candidate->class) ? 'selected' : ''}}>Senior</option>
            </select>
            @if($errors->has('class'))
              <div class="help-block">
                {{$errors->first('class')}}
              </div>
            @endif
          </div>

          <div class="form-group {{$errors->has('total_hours') ? 'has-error' : ''}} col-md-6">
            <label for="total_hours" class="required">Total Hours</label>
            <input type="number" name="total_hours" id="total_hours" class="form-control"
                    value="{{old('total_hours', $candidate->total_hours)}}" />
            @if($errors->has('total_hours'))
              <div class="help-block">
                {{$errors->first('total_hours')}}
              </div>
            @endif
          </div>
      </div>

      <div class="row">
          <div class="form-group {{$errors->has('gpa') ? 'has-error' : ''}} col-md-6">
            <label for="gpa" class="required">GPA</label>
            <input type="text" name="gpa" id="gpa" class="form-control"
                    value="{{old('gpa', $candidate->gpa)}}" />
            @if($errors->has('gpa'))
              <div class="help-block">
                {{$errors->first('gpa')}}
              </div>
            @endif
          </div>
      </div>

      <div class="form-group {{$errors->has('gender') ? 'has-error' : ''}} col-md-12">
        <label for="gender" class="required">Gender</label>
        <div class="radio">
            <label><input type="radio" name="gender" value="M" {{old('gender', $candidate->gender) == 'M' ? 'checked' : ''}}/> M</label>
            <label><input type="radio" name="gender" value="F" {{old('gender', $candidate->gender) == 'F' ? 'checked' : ''}}/> F</label>
            <label><input type="radio" name="gender" value="U" {{old('gender', $candidate->gender) == 'U' ? 'checked' : ''}}/> U</label>
        </div>
        @if($errors->has('gender'))
          <div class="help-block">
            {{$errors->first('gender')}}
          </div>
        @endif
      </div>

      <div class="form-group {{$errors->has('nominated') ? 'has-error' : ''}} col-md-12">
        <label for="nominated" class="required">Nominated</label>
        <div class="radio">
            <label><input type="radio" name="nominated" value="1" {{old('nominated', $candidate->nominated) ? 'checked' : ''}}/> Yes</label>
            <label><input type="radio" name="nominated" value="0" {{!old('nominated', $candidate->nominated) ? 'checked' : ''}}/> No</label>
        </div>
        @if($errors->has('nominated'))
          <div class="help-block">
            {{$errors->first('nominated')}}
          </div>
        @endif
      </div>

      <div class="form-group {{$errors->has('disqualified') ? 'has-error' : ''}} col-md-12">
        <label for="disqualified" class="required">Disqualified</label>
        <div class="radio">
            <label><input type="radio" name="disqualified" value="1" {{old('disqualified', $candidate->disqualified) ? 'checked' : ''}}/> Yes</label>
            <label><input type="radio" name="disqualified" value="0" {{!old('disqualified', $candidate->disqualified) ? 'checked' : ''}}/> No</label>
        </div>
        @if($errors->has('disqualified'))
          <div class="help-block">
            {{$errors->first('disqualified')}}
          </div>
        @endif
      </div>

      @if(isset($candidate->application))
          <div class="form-group {{$errors->has('submitted') ? 'has-error' : ''}} col-md-12">
            <label for="submitted" class="required">Application Submitted</label>
            <div class="radio">
                <label><input type="radio" name="submitted" value="1" {{old('submitted', $candidate->application->submitted) ? 'checked' : ''}}/> Yes</label>
                <label><input type="radio" name="submitted" value="0" {{!old('submitted', $candidate->application->submitted) ? 'checked' : ''}}/> No</label>
            </div>
            @if($errors->has('submitted'))
              <div class="help-block">
                {{$errors->first('submitted')}}
              </div>
            @endif
          </div>
      @endif

      <div class="col-md-12">
          <button type="submit" class="btn btn-success">Save</button>
          <a href="{{route('candidates::index')}}" class="btn btn-default">Cancel</a>
      </div>
    </form>
  </div>

@endsection
