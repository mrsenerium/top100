@extends('layouts.master')

@section('title', 'Results - Round 2')

@section('content')
    <div class="col-md-12">
    @include('partials/status')
    <form method="post" action="{{route('results::calculate')}}">
        {!! csrf_field() !!}
        <p>Results are not automatically calculated or updated. To refresh the results, press the Calculate button.</p>
        <button type="submit" class="btn btn-sm btn-info spinner" name="round" value="2">Calculate Round 2 Results</button>
    </form>
        <div class="table-responsive">
          <h2>Scores By Judge</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($results as $key => $value)
                    <tr>
                      <td>{{$value->id}}</td>
                      <td>{{$value->fullname}}</td>
                      <td>{{$value->round2_score}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
