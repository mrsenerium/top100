@extends('layouts.master')

@section('title', 'All Users')

@section('content')
    <div class="col-md-12">
        @include('partials/status')
        <div class="well well-sm">
            <a href="{{route('users::add')}}" class="btn btn-success"><i class="fa fa-plus"></i> Add User</a>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Roles</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="text-right">
                            <a href="{{route('users::edit', ['id' => $user->id])}}" title="Edit"><i class="fa fa-pencil"></i></a>
                            <a href="#" data-user-id="{{$user->id}}" data-user-name="{{$user->firstname}} {{$user->lastname}}" title="Delete" class="link-delete">
                                <i class="fa fa-trash text-danger"></i>
                            </a>
                            <form method="post" action="{{route('users::delete', ['id' => $user->id])}}">
                                {!! csrf_field() !!}
                           </form>
                        </td>
                        <td>{{$user->lastname}}</td>
                        <td>{{$user->firstname}}</td>
                        <td><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
                        <td>{{$user->username}}</td>
                        <td>
                            @if($user->roles()->count() > 0)
                                {{implode(', ', $user->roles()->pluck('name')->all())}}
                            @endif
                            @if($user->candidate)
                                <em class="text-muted">Candidate</em>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @include('partials.pagination', ['collection' => $users])
    </div>
@endsection
@push('scripts')
    <script src="{{asset('js/custom/user-delete-confirmation.js')}}"></script>
    <script src="{{asset('js/vendor/bootbox.min.js')}}"></script>
@endpush
