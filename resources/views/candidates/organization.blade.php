<div class="organization-block panel panel-default">
    <div class="panel-body">
        <input type="hidden" value="{{isset($organization) ? $organization->organization_type : $type}}" />
        <div class="form-group">
            <label for="organization[{{$key}}].name">Organization Name</label>
            <input type="text" name="organization_name" id="organization_name" class="form-control"
                    value="{{old('organization_name')}}" />
            @if($errors->has('organization_name'))
              <div class="help-block">
                {{$errors->first('organization_name')}}
              </div>
            @endif
        </div>
        <div class="form-group">
            <label for="position_held">Position Held</label>
            <input type="text" name="position_held" id="position_held" class="form-control"
                    value="{{old('position_held')}}" />
            @if($errors->has('position_held'))
              <div class="help-block">
                {{$errors->first('position_held')}}
              </div>
            @endif
        </div>
        <div class="form-group">
            <label for="organization_description">Description</label>
            <textarea id="organization_description" name="organization_description" class="form-control" rows="3">{{old('organization_description')}}</textarea>
        </div>
        <div class="row">
            <div class="form-group col-md-3">
                <label>Length of involvement</label>
                <input type="text" class="form-control" />
            </div>
            <div class="form-group col-md-4">
                <label>Duration</label>
                <select class="form-control">
                    <option value="hours">Hour(s)</option>
                    <option value="days">Day(s)</option>
                    <option value="months">Month(s)</option>
                    <option value="years">Year(s)</option>
                </select>
            </div>
        </div>
    </div>
</div>
