<div class="organization-block panel panel-default">
    <div class="panel-body">
        <div class="form-group">
            <label for="name_{{$key}}" class="control-label">Organization Name</label>
            <p id="name_{{$key}}">{{$organization->name}}</p>
        </div>
        <div class="form-group">
            <label for="position_{{$key}}" class="control-label">Position Held</label>
            <p id="position_{{$key}}">{{$organization->position_held}}</p>
        </div>
        <div class="form-group">
            <label for="description_{{$key}}" class="control-label">Description</label>
            <p id="description_{{$key}}">{{$organization->description}}</p>
        </div>
        <div class="form-group">
            <label for="involvement_{{$key}}" class="control-label">Length of involvement</label>
            <p id="involvement_{{$key}}">{{$organization->involvement_length}} {{$organization->involvement_duration}}</p>
        </div>
    </div>
</div>
