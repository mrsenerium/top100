@extends('layouts.master')

@section('title', 'Results - Top 100')

@section('content')
    <div class="col-md-12">
        @include('partials/status')
        <form method="post" action="{{route('results::calculate')}}">
            {!! csrf_field() !!}
            <p>Results are not automatically calculated or updated. To refresh the results, press the Calculate button.</p>
            <button type="submit" class="btn btn-sm btn-info spinner" name="round" value="1">Calculate Top 100 Results</button>
        </form>
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
                    @foreach($results as $index => $candidate)
                        <tr>
                            <td>{{(($results->currentPage() - 1) * 10) + $index + 1}}</td>
                            <td>{{$candidate->fullname}}</td>
                            <td>{{number_format($candidate->round1_score, 2)}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @include('partials.pagination', ['collection' => $results])
        </div>
    </div>

@endsection
