@extends('layouts.master')

@section('title', 'All Guests')

@section('content')
    <div class="col-md-12">
        @include('partials/status')
        <div class="well well-sm">
            <a href="{{route('guests::export')}}" class="btn btn-warning"><i class="fa fa-download"></i> Export</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name(s)</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Relationship(s)</th>
                        <th>Guest of</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($guests as $guest)
                        <tr>
                            <td>{{$guest->name->implode(', ')}}</td>
                            <td>{!!nl2br($guest->address)!!}</td>
                            <td>{{$guest->phone}}</td>
                            <td>{{$guest->relationship}}</td>
                            <td>{{$guest->candidate->fullname}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @include('partials.pagination', ['collection' => $guests])
    </div>
@endsection
