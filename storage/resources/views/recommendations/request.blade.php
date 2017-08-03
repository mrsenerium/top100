@extends('layouts.master')

@section('title', 'Recommendations Request')

@section('content')
    <div class="col-md-12">
        @include('partials/status')
        <form method="post">
            {!! csrf_field() !!}
            <p>
            Please enter the email address of individual from whom you would like to request
            a recommendation in the "to" blank. You may use the "body" to construct your message
            requesting a recommendation.
            </p>
          <div class="form-group {{$errors->has('recommender_name') ? 'has-error' : ''}}">
            <label for="recommender_name" class="required">Name</label>
            <input type="text" id="recommender_name"
                    name="recommender_name" class="form-control"
                    value="{{old('recommender_name')}}" />
            @if($errors->has('recommender_name'))
              <div class="help-block">
                {{$errors->first('recommender_name')}}
              </div>
            @endif
          </div>

          <div class="form-group {{$errors->has('recommender_email') ? 'has-error' : ''}}">
            <label for="recommender_email" class="required">Email</label>
            <input type="text" id="recommender_email"
                    name="recommender_email" class="form-control"
                    value="{{old('recommender_email')}}" />
            @if($errors->has('recommender_email'))
              <div class="help-block">
                {{$errors->first('recommender_email')}}
              </div>
            @endif
          </div>

          <div class="form-group {{$errors->has('request_body') ? 'has-error' : ''}}">
            <label for="request_body" class="required">Your Request</label>
            <textarea name="request_body" id="recommendation_body" class="form-control wysiwyg" rows="5">{{old('request_body')}}</textarea>
            @if($errors->has('request_body'))
              <div class="help-block">
                {{$errors->first('request_body')}}
              </div>
            @endif
          </div>

          <div class="well well-sm">
              <button type="submit" class="btn btn-success">Send</button>
          </div>

        </form>
    </div>

@endsection

@push('scripts')
  <script src="//cdn.ckeditor.com/4.5.6/basic/ckeditor.js"></script>
@endpush
