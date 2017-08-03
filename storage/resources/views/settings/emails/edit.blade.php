@extends('layouts.master')

@section('title', 'Edit Email')

@section('content')

  <div class="col-md-12">
    @include('partials/status')
    <form method="post" action="{{route('emails::edit.post', ['id' => $email->id])}}">
      {!! csrf_field() !!}

      <p>{{$email->description}}</p>

      <div class="form-group {{$errors->has('subject') ? 'has-error' : ''}}">
        <label for="subject" class="required">Subject</label>
        <input type="text" id="subject" name="subject" class="form-control" value="{{old('subject', $email->subject)}}" />
        @if($errors->has('subject'))
          <div class="help-block">
            {{$errors->first('subject')}}
          </div>
        @endif
      </div>

      <div class="form-group {{$errors->has('body') ? 'has-error' : ''}}">
        <label for="body" class="required">Body</label>
        <textarea name="body" id="body" class="form-control wysiwyg-admin" rows="5">{{old('body', $email->body)}}</textarea>
        @if($errors->has('body'))
          <div class="help-block">
            {{$errors->first('body')}}
          </div>
        @endif
      </div>
      <hr/>
      <div class="form-group {{$errors->has('description') ? 'has-error' : ''}}">
        <label for="description" class="required">Description</label>
        <textarea name="description" id="description" class="form-control" rows="5">{{old('description', $email->description)}}</textarea>
        @if($errors->has('description'))
          <div class="help-block">
            {{$errors->first('description')}}
          </div>
        @endif
        <div class="help-block">
            This text is for administrative purposes only.
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Save</button>
      <a href="{{route('emails::index')}}" class="btn btn-default">Back</a>
    </form>
  </div>

@endsection

@push('scripts')
  <script src="//cdn.ckeditor.com/4.5.6/basic/ckeditor.js"></script>
@endpush
