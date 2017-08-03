@extends('layouts.master')

@section('title', 'Guests')

@section('content')
    <div class="col-md-12">
        @include('partials/status')
        <div class="col-md-6">
            @forelse($guests as $guest)
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form method="post" action="{{route('guests::delete', ['id' => $guest->id])}}" class="pull-right">
                            {!! csrf_field() !!}
                            <button type="submit" class="btn btn-xs btn-danger" title="Delete guest">
                                <i class="fa fa-trash"></i><span class="sr-only">Delete</span>
                            </button>
                        </form>
                        <strong>{!! $guest->name->implode('<br/>') !!}</strong>
                        <br/>
                        {!!nl2br($guest->address)!!}
                        <br/>
                        {{$guest->phone}}
                        <br/>
                        <em>{{$guest->relationship}}</em>
                    </div>
                </div>
            @empty
                <p>
                    Your guest list is empty. Add a guest using the form
                    <span class="hidden-md hidden-lg hidden-xl">below</span>
                    <span class="hidden-xs hidden-sm">on the right</span>.
                </p>
            @endforelse
        </div>
        <div class="well well-sm col-md-4 col-md-push-2">
            <form method="post" action="{{route('guests::add')}}">
                {!! csrf_field() !!}
                <fieldset>
                    <legend>Add guests</legend>
                    <p>List all guests in a single household below.</p>
                    <div class="form-group {{$errors->has('address') ? 'has-error' : ''}}">
                        <label for="address" class="required">Household address</label>
                        <textarea id="address" rows="3" name="address" class="form-control">{{old('address')}}</textarea>
                        @if($errors->has('address'))
                        <div class="help-block">
                            {{$errors->first('address')}}
                        </div>
                        @endif
                    </div>
                    <div class="form-group {{$errors->has('phone') ? 'has-error' : ''}}">
                        <label for="phone" class="required">Phone</label>
                        <input id="phone" type="phone" class="form-control" name="phone" value="{{old('phone')}}" />
                        @if($errors->has('phone'))
                        <div class="help-block">
                            {{$errors->first('phone')}}
                        </div>
                        @endif
                    </div>
                    <fieldset>
                        <legend>Guests</legend>
                        <p class="help-block">Please specify how each guest invitation should be addressed. (i.e. Mr. and Mrs. Smith, The Smith Family, etc.)</p>
                        @for($i=0; $i < 5; $i++)
                            <div class="form-group {{$errors->has("name.$i") ? 'has-error' : ''}}">
                                <label for="name[{{$i}}]" {{$i>0 ?: 'class=required'}}>Guest {{$i + 1}}</label>
                                <input id="name[{{$i}}]" type="text" name="name[{{$i}}]" class="form-control" value="{{old("name.$i")}}" placeholder="Name of guest" />
                                @if($errors->has("name.$i"))
                                <div class="help-block">
                                    {{$errors->first("name.$i")}}
                                </div>
                                @endif
                            </div>
                        @endfor
                    </fieldset>
                    <div class="form-group {{$errors->has('relationship') ? 'has-error' : ''}}">
                        <label for="relationship" class="required">Relationship</label>
                        <select id="relationship" name="relationship" class="form-control">
                            <option {{old('relationship') === 'Parent(s)' ? 'selected' : ''}}>Parent(s)</option>
                            <option {{old('relationship') === 'Sibling(s)' ? 'selected' : ''}}>Sibling(s)</option>
                            <option {{old('relationship') === 'Grandparent(s)' ? 'selected' : ''}}>Grandparent(s)</option>
                            <option {{old('relationship') === 'Guardian(s)' ? 'selected' : ''}}>Guardian(s)</option>
                            <option {{old('relationship') === 'Friend' ? 'selected' : ''}}>Friend</option>
                            <option {{old('relationship') === 'Other' ? 'selected' : ''}}>Other</option>
                        </select>
                        @if($errors->has('relationship'))
                        <div class="help-block">
                            {{$errors->first('relationship')}}
                        </div>
                        @endif
                    </div>
                </fieldset>
                <hr/>
                <button type="submit" class="btn btn-success">Save</button>
            </form>
        </div>

    </div>
@endsection
