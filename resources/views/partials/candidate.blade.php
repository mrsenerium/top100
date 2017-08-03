<div class="form-horizontal well well-sm">
    <div class="form-group">
        <label class="col-sm-4 control-label">College</label>
        <div class="col-sm-8">
            <p class="form-control-static">{{$candidate->college}}</p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Major</label>
        <div class="col-sm-8">
        <p class="form-control-static">{{$candidate->major}}</p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Class</label>
        <div class="col-sm-8">
        <p class="form-control-static">@include('partials.class', ['class' => $candidate->class])</p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Total Hours</label>
        <div class="col-sm-8">
        <p class="form-control-static">{{$candidate->total_hours}}</p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">GPA</label>
        <div class="col-sm-8">
        <p class="form-control-static">{{$candidate->gpa}}</p>
        </div>
    </div>
</div>
