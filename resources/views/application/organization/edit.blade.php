<?php
    $org_type = isset($organization) ? $organization->organization_type : $type; //this feels so wrong
?>
<div class="organization-block panel panel-default">
    <div class="panel-body">
        {{-- <input type="hidden" value="{{isset($organization) ? $organization->organization_type : $type}}" /> --}}
        <div class="form-group {{$errors->has($org_type.'.'.$key.'.name') ? 'has-error' : ''}}">
            <label for="{{$org_type}}[{{$key}}][name]">Organization Name</label>
            <input type="text" name="{{$org_type}}[{{$key}}][name]" id="{{$org_type}}[{{$key}}][name]" class="form-control"
                    value="{{old($org_type.'.'.$key.'.name', isset($organization) ? $organization->name : '')}}" />
            @if($errors->has($org_type.'.'.$key.'.name'))
              <div class="help-block">
                {{$errors->first($org_type.'.'.$key.'.name')}}
              </div>
            @endif
        </div>
        <div class="form-group {{$errors->has($org_type.'.'.$key.'.position_held') ? 'has-error' : ''}}">
            <label for="{{$org_type}}[{{$key}}][position_held]">Position Held</label>
            <input type="text" name="{{$org_type}}[{{$key}}][position_held]" id="{{$org_type}}[{{$key}}][position_held]" class="form-control"
                    value="{{old($org_type.'.'.$key.'.position_held', isset($organization) ? $organization->position_held : '')}}" />
            @if($errors->has($org_type.'.'.$key.'.position_held'))
              <div class="help-block">
                {{$errors->first($org_type.'.'.$key.'.position_held')}}
              </div>
            @endif
        </div>
        <div class="form-group {{$errors->has($org_type.'.'.$key.'.description') ? 'has-error' : ''}}">
            <label for="{{$org_type}}[{{$key}}][description]">Description</label>
            <textarea id="{{$org_type}}[{{$key}}][description]" name="{{$org_type}}[{{$key}}][description]" class="form-control" rows="3">{{old($org_type.'.'.$key.'.description', isset($organization) ? $organization->description : '')}}</textarea>
            @if($errors->has($org_type.'.'.$key.'.description'))
              <div class="help-block">
                {{$errors->first($org_type.'.'.$key.'.description')}}
              </div>
            @endif
        </div>
        <div class="row">
            <div class="form-group col-lg-3 col-md-4 col-sm-6 {{$errors->has($org_type.'.'.$key.'.involvement') ? 'has-error' : ''}}">
                <label for="{{$org_type}}[{{$key}}][involvement]">Length of involvement</label>
                <input type="text" id="{{$org_type}}[{{$key}}][involvement]" name="{{$org_type}}[{{$key}}][involvement]" class="form-control"
                        value="{{old($org_type.'.'.$key.'.trim(involvement, " ")', isset($organization) ? $organization->involvement_length : '')}}" />
                @if($errors->has($org_type.'.'.$key.'.trim(involvement, " ")'))
                  <div class="help-block">
                    {{$errors->first($org_type.'.'.$key.'.trim(involvement, " ")')}}
                  </div>
                @endif
            </div>
            <div class="form-group col-lg-3 col-md-4 col-sm-6 {{$errors->has($org_type.'.'.$key.'.duration') ? 'has-error' : ''}}">
                <label for="{{$org_type}}[{{$key}}][duration]">Duration</label>
                <select id="{{$org_type}}[{{$key}}][duration]" name="{{$org_type}}[{{$key}}][duration]" class="form-control">
                    <option {{old($org_type.'.'.$key.'.duration',
                        isset($organization) ? $organization->involvement_duration : '') === 'hours' ? 'selected' : ''}}
                            value="hours">Hour(s)</option>
                    <option {{old($org_type.'.'.$key.'.duration',
                        isset($organization) ? $organization->involvement_duration : '') === 'days' ? 'selected' : ''}}
                            value="days">Day(s)</option>
                    <option {{old($org_type.'.'.$key.'duration',
                        isset($organization) ? $organization->involvement_duration : '') === 'months' ? 'selected' : ''}}
                            value="months">Month(s)</option>
                    <option {{old($org_type.'.'.$key.'duration',
                        isset($organization) ? $organization->involvement_duration : '') === 'years' ? 'selected' : ''}}
                            value="years">Year(s)</option>
                </select>
                @if($errors->has($org_type.'.'.$key.'.duration'))
                  <div class="help-block">
                    {{$errors->first($org_type.'.'.$key.'.duration')}}
                  </div>
                @endif
            </div>
        </div>
    </div>
</div>
