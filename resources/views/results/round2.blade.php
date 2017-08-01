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
    @foreach($results as $key => $value)
        <h2>Top {{$value->count()}} {{$key}}</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 0 ?>
                    @foreach($value as $candidate)
                        <tr>
                            <td>{{++$count}}</td>
                            <td>{{$candidate->fullname}}</td>
                            <td>{{$candidate->round2_score}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
    </div>
@endsection
