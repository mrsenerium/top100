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
          <h2>Top {{$results->count()}}</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Judge</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($results as $key => $value)
                    <tr>
                      <td>{{$value->candidate_id}}</td>
                      <td>{{$value->candidate->fullname}}</td>
                      <td>{{$value->judge->firstname}} {{$value->judge->lastname}}</td>
                      <td>{{$value->total()}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
