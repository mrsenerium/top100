<?php
    $value = filter_var(old($field_name, $score), FILTER_VALIDATE_INT);
?>
<div class="btn-group" data-toggle="buttons">
    @for($i=0; $i < 6; $i++)
        <label class="btn btn-info {{$value === $i ? 'active' : ''}}">
            <input type="radio" name="{{$field_name}}"
                    autocomplete="off" value="{{$i}}"
                    {{$value === $i ? 'checked' : ''}} /> {{$i}}
        </label>
    @endfor
    <div class="progress clear-both">
        <div class="progress-bar progress-bar-danger" title="Poor" style="width: 33.375%">
            <span class="sr-only">Poor</span>
        </div>
        <div class="progress-bar progress-bar-warning" title="Average" style="width: 33.25%">
            <span class="sr-only">Average</span>
        </div>
        <div class="progress-bar progress-bar-success" title="Good" style="width: 33.375%">
            <span class="sr-only">Good</span>
        </div>
    </div>
@if($errors->has($field_name))
  <div class="help-block text-danger">
    {{$errors->first($field_name)}}
  </div>
@endif    
</div>
