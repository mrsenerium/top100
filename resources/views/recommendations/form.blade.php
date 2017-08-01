@extends('layouts.master')

@section('title')
Recommend {{$candidate->fullname}}
@endsection

@section('content')
    <div class="col-md-12">
        @include('partials/status')
        <form method="post">
            {!! csrf_field() !!}

          <div class="form-group {{$errors->has('recommender_name') ? 'has-error' : ''}}">
            <label for="recommender_name" class="required">Your Name</label>
            <input type="text" id="recommender_name"
                    name="recommender_name" class="form-control"
                    value="{{old('recommender_name', Auth::check() ? Auth::user()->firstname.' '.Auth::user()->lastname : '')}}" />
            @if($errors->has('recommender_name'))
              <div class="help-block">
                {{$errors->first('recommender_name')}}
              </div>
            @endif
          </div>

          <div class="form-group {{$errors->has('recommender_email') ? 'has-error' : ''}}">
            <label for="recommender_email" class="required">Your Email</label>
            <input type="text" id="recommender_email"
                    name="recommender_email" class="form-control"
                    value="{{old('recommender_email', Auth::check() ? Auth::user()->email : '')}}" />
            @if($errors->has('recommender_email'))
              <div class="help-block">
                {{$errors->first('recommender_email')}}
              </div>
            @endif
          </div>

          <div class="form-group {{$errors->has('recommendation_body') ? 'has-error' : ''}}">
            <label for="recommendation_body" class="required">Your Recommendation</label>
            <textarea name="recommendation_body" id="recommendation_body" class="form-control wysiwyg" rows="5">{{old('recommendation_body')}}</textarea>
            @if($errors->has('recommendation_body'))
              <div class="help-block">
                {{$errors->first('recommendation_body')}}
              </div>
            @endif
          </div>

          <div class="well well-sm">
              <button type="submit" class="btn btn-success">Submit</button>
              <a href="{{route('recommendations::index')}}" class="btn btn-default">Cancel</a>
          </div>

        </form>
    </div>

@endsection

@push('scripts')
  <script src="//cdn.ckeditor.com/4.5.6/basic/ckeditor.js"></script>
@endpush
