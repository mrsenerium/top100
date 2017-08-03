@extends('layouts.master')

@section('title', 'Import Candidates')

@section('content')

  <div class="col-md-12">
    @include('partials/status')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{route('import::upload')}}" enctype="multipart/form-data" >
      {!! csrf_field() !!}
      <p>Import candidates from a CSV file. To generate a CSV file from an excel
            spreadsheet, select "Save As" from the File menu and select CSV (Comma delmitted) as the file type.</p>
      <p>File must have a first row header with the following columns:
          <strong>firstname, lastname, username, email, gender, college, major, class, totalHours, gpa</strong>.
          If the file contains different heading columns, you may specifiy them below by clicking "Edit column headings."
      </p>
        <div class="form-group">
            <button class="btn btn-default btn-xs" type="button" data-toggle="collapse" data-target="#headings-collapse" aria-expanded="false" aria-controls="headings-collapse">
                Edit column headings
            </button>
        </div>
        <fieldset class="collapse" id="headings-collapse">
            <legend>Headings</legend>
            <p>Specify the column headings if different from below. All columns must be present in file for import to succeed. Additional columns will be ignored.</p>
            <div class="form-group {{$errors->has('firstname_heading') ? 'has-error' : ''}} col-md-2 col-xl-1">
                <label for="firstname_heading" class="required">firstname</label>
                <input type="text" name="firstname_heading" id="firstname_heading" class="form-control"
                      value="{{old('firstname_heading', 'firstname')}}" />
                @if($errors->has('firstname_heading'))
                <div class="help-block">
                  {{$errors->first('firstname_heading')}}
                </div>
                @endif
            </div>
            <div class="form-group {{$errors->has('lastname_heading') ? 'has-error' : ''}} col-md-2 col-xl-1">
                <label for="lastname_heading" class="required">lastname</label>
                <input type="text" name="lastname_heading" id="lastname_heading" class="form-control"
                      value="{{old('lastname_heading', 'lastname')}}" />
                @if($errors->has('lastname_heading'))
                <div class="help-block">
                  {{$errors->first('lastname_heading')}}
                </div>
                @endif
            </div>
            <div class="form-group {{$errors->has('username_heading') ? 'has-error' : ''}} col-md-2 col-xl-1">
                <label for="username_heading" class="required">username</label>
                <input type="text" name="username_heading" id="username_heading" class="form-control"
                      value="{{old('username_heading', 'username')}}" />
                @if($errors->has('username_heading'))
                <div class="help-block">
                  {{$errors->first('username_heading')}}
                </div>
                @endif
            </div>
            <div class="form-group {{$errors->has('email_heading') ? 'has-error' : ''}} col-md-2 col-xl-1">
                <label for="email_heading" class="required">email</label>
                <input type="text" name="email_heading" id="email_heading" class="form-control"
                      value="{{old('email_heading', 'email')}}" />
                @if($errors->has('email_heading'))
                <div class="help-block">
                  {{$errors->first('email_heading')}}
                </div>
                @endif
            </div>
            <div class="form-group {{$errors->has('gender_heading') ? 'has-error' : ''}} col-md-2 col-xl-1">
                <label for="gender_heading" class="required">gender</label>
                <input type="text" name="gender_heading" id="gender_heading" class="form-control"
                      value="{{old('gender_heading', 'gender')}}" />
                @if($errors->has('gender_heading'))
                <div class="help-block">
                  {{$errors->first('gender_heading')}}
                </div>
                @endif
            </div>
            <div class="form-group {{$errors->has('college_heading') ? 'has-error' : ''}} col-md-2 col-xl-1">
                <label for="college_heading" class="required">college</label>
                <input type="text" name="college_heading" id="college_heading" class="form-control"
                      value="{{old('college_heading', 'college')}}" />
                @if($errors->has('college_heading'))
                <div class="help-block">
                  {{$errors->first('college_heading')}}
                </div>
                @endif
            </div>
            <div class="form-group {{$errors->has('major_heading') ? 'has-error' : ''}} col-md-2 col-xl-1">
                <label for="major_heading" class="required">major</label>
                <input type="text" name="major_heading" id="major_heading" class="form-control"
                      value="{{old('major_heading', 'major')}}" />
                @if($errors->has('major_heading'))
                <div class="help-block">
                  {{$errors->first('major_heading')}}
                </div>
                @endif
            </div>
            <div class="form-group {{$errors->has('class_heading') ? 'has-error' : ''}} col-md-2 col-xl-1">
                <label for="class_heading" class="required">class</label>
                <input type="text" name="class_heading" id="class_heading" class="form-control"
                      value="{{old('class_heading', 'class')}}" />
                @if($errors->has('class_heading'))
                <div class="help-block">
                  {{$errors->first('class_heading')}}
                </div>
                @endif
            </div>
            <div class="form-group {{$errors->has('hours_heading') ? 'has-error' : ''}} col-md-2 col-xl-1">
                <label for="hours_heading" class="required">total hours</label>
                <input type="text" name="hours_heading" id="hours_heading" class="form-control"
                      value="{{old('hours_heading', 'totalHours')}}" />
                @if($errors->has('hours_heading'))
                <div class="help-block">
                  {{$errors->first('hours_heading')}}
                </div>
                @endif
            </div>
            <div class="form-group {{$errors->has('gpa_heading') ? 'has-error' : ''}} col-md-2 col-xl-1">
                <label for="gpa_heading" class="required">gpa</label>
                <input type="text" name="gpa_heading" id="gpa_heading" class="form-control"
                      value="{{old('gpa_heading', 'gpa')}}" />
                @if($errors->has('gpa_heading'))
                <div class="help-block">
                  {{$errors->first('gpa_heading')}}
                </div>
                @endif
            </div>
        </fieldset>

      <div class="form-group {{$errors->has('import') ? 'has-error' : ''}}">
        <label for="import" class="required">Import File</label>
        <div>
          <div class="btn btn-info btn-file">
            Browse <input type="file" name="import" class="bs-file-upload" />
          </div>
          <span class='file-upload-info'>No file selected.</span>
        </div>
        @if($errors->has('import'))
          <div class="help-block">
            {{$errors->first('import')}}
          </div>
        @endif
      </div>
      <div class="help-block">
        Select a <strong>.csv</strong> file to import candidates.
      </div>

      <button type="submit" class="btn btn-primary has-spinner">Import <i class="fa fa-spinner fa-pulse hidden"></i></button>
    </form>
  </div>

@endsection
