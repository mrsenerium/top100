@extends('layouts.master')

@section('title', 'All Candidates')

@section('content')
    <div class="col-md-12">
        @include('partials/status')
        <div class="well well-sm">
            <a href="{{route('candidates::add')}}" class="btn btn-success"><i class="fa fa-plus"></i> Add Candidate</a>
            <a href="{{route('import::form')}}" class="btn btn-success"><i class="fa fa-plus"></i> Import</a>
            <a href="{{route('candidates::export')}}" class="btn btn-warning"><i class="fa fa-download"></i> Export</a>
        </div>
        <form id="filter-form" method="get" class="form-inline">
            <div class="form-group">
                <label for="perPage">Show:</label>
                <select id="perPage" name="perPage" class="form-control">
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nominated">Nominated:</label>
                <select id="nominated" name="nominated" class="form-control">
                    <option value="all">All</option>
                    <option value="true">Yes</option>
                    <option value="false">No</option>
                </select>
            </div>
            <div class="form-group">
                <label for="disqualified">Disqualified:</label>
                <select id="disqualified" name="disqualified" class="form-control">
                    <option value="all">All</option>
                    <option value="true">Yes</option>
                    <option value="false">No</option>
                </select>
            </div>
            <div class="form-group">
                <label for="submitted">Submitted:</label>
                <select id="submitted" name="submitted" class="form-control">
                    <option value="all">All</option>
                    <option value="true">Yes</option>
                    <option value="false">No</option>
                </select>
            </div>
            <div class="form-group">
                <label for="top100">Top 100:</label>
                <select id="top100" name="top100" class="form-control">
                    <option value="all">All</option>
                    <option value="true">Yes</option>
                    <option value="false">No</option>
                </select>
            </div>
            <div class="form-group">
                <label for="search">Search:</label>
                <input type="text" name="search" id="search" class="form-control"  />
                <button type="submit" id="apply-search" class="btn btn-info"><i class="fa fa-search"></i></button>
            </div>
            <a href="{{route('candidates::index')}}" class="btn btn-default">Reset</a>
        </form>
        <hr/>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th class="hidden-xs hidden-sm">Email</th>
                        <th>ID</th>
                        <th>Nominated</th>
                        <th>Disqualified</th>
                        <th>Submitted</th>
                        <th class="hidden-xs hidden-sm hidden-md">College</th>
                        <th class="hidden-xs hidden-sm hidden-md">Major</th>
                        <th class="hidden-xs hidden-sm hidden-md">Class</th>
                        <th class="hidden-xs hidden-sm hidden-md">Total Hours</th>
                        <th>Round 1</th>
                        <th>Round 2</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($candidates as $candidate)
                        <tr>
                            <td class="text-right">
                                @if($candidate->application)
                                <a href="{{route('application::view', ['id' => $candidate->id])}}" title="View Application"><i class="fa fa-file-text text-info"></i></a>
                                @endif
                                <a href="{{route('candidates::edit', ['id' => $candidate->id])}}" title="Edit"><i class="fa fa-pencil text-warning"></i></a>
                            </td>
                            <td>{{$candidate->user->lastname}}</td>
                            <td>{{$candidate->user->firstname}}</td>
                            <td class="hidden-xs hidden-sm"><a href="mailto:{{$candidate->user->email}}">{{$candidate->user->email}}</a></td>
                            <td>{{$candidate->id}}</td>
                            <td>@include('partials.boolean', ['bool' => $candidate->nominated])</td>
                            <td>@include('partials.boolean', ['bool' => $candidate->disqualified])</td>
                            <td>@include('partials.boolean', ['bool' => $candidate->application && $candidate->application->submitted])</td>
                            <td class="hidden-xs hidden-sm hidden-md">{{$candidate->college}}</td>
                            <td class="hidden-xs hidden-sm hidden-md">{{$candidate->major}}</td>
                            <td class="hidden-xs hidden-sm hidden-md">@include('partials.class', ['class' => $candidate->class])</td>
                            <td class="hidden-xs hidden-sm hidden-md">{{$candidate->total_hours}}</td>
                            <td>
                                {{$candidate->round1_score}}
                                @if($candidate->top100)
                                    <i class="text-warning fa fa-trophy" title="Top 100"></i>
                                @endif
                            </td>
                            <td>{{$candidate->round2_score}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @include('partials.pagination', ['collection' => $candidates])
    </div>
@endsection

@push('scripts')
  <script src="{{asset('js/custom/table-filter.js')}}"></script>
@endpush
