@extends('layouts.master')

@section('title', 'Edit '.$state->name.' State')

@section('content')

  <div class="col-md-12">
    @include('partials/status')
    <form method="post" action="{{route('settings::state.update', ['id' => $state->id])}}">
      {!! csrf_field() !!}

      <div class="form-group {{$errors->has('description') ? 'has-error' : ''}}">
        <label for="description" class="required">Description</label>
        <textarea name="description" id="description" class="form-control wysiwyg-admin" rows="5">{{old('description', $state->description)}}</textarea>
        <div class="help-block">
          This text will be displayed on the homepage and will be visible to all site visitors.
        </div>
        @if($errors->has('description'))
          <div class="help-block">
            {{$errors->first('description')}}
          </div>
        @endif
      </div>

      <div class="form-group">
        <div class="{{$errors->has('help_text') ? 'has-error' : ''}}">
        <label for="help_text">Help Text</label>
        <textarea name="help_text" id="help_text" class="form-control wysiwyg-admin" rows="5">{{old('help_text', $state->help_text)}}</textarea>
        @if($errors->has('help_text'))
          <div class="help-block">
            {{$errors->first('help_text')}}
          </div>
        @endif
        </div>
        <div class="help-block">
          This text will also be displayed on the homepage and will only be visible to authenticated users. It can be used to provide further
          instructions to users.
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Save</button>
      <a href="{{route('settings::states')}}" class="btn btn-default">Back</a>
    </form>
  </div>

@endsection

@push('scripts')
  <script src="//cdn.ckeditor.com/4.5.6/basic/ckeditor.js"></script>
@endpush
