@extends('layouts.master')

@push('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('title', 'Round 2 Judging')

@section('content')

    <div class="col-md-12 round-2-container">
        @include('partials/status')
        <div class="alert alert-warning no-js-warning">
            <i class="fa fa-warning"></i> You must enable javascript.
        </div>
        {{-- TODO: needs better help text --}}
        <p>Drag candidates to the list on the <span class="hidden-sm
        hidden-xs">right</span><span class="hidden-md hidden-lg">bottom</span> to rank.
        You may drag to reorder your ranking, with the top being the best. You must rank
        <strong>25</strong> candidates for your scores to count. Only the first <strong>25</strong>
        selected candidates will be saved.</p>
        <p>Click on a candidate's name to read the application.</p>
        <div class="well well-sm">
            <button type="button" class="btn btn-success btn-save">Save</button>
        </div>
        <div class="clearfix">
            <ul id="candidates" class="list-group col-md-5">
                <li class="list-group-item list-group-item-info">
                    <h4>Candidates</h4>
                </li>
                @foreach($available as $key => $candidate)
                    @unless(!empty($selected) && $selected->contains('id', $candidate->id))
                        <li class="list-group-item draggable" data-sort="{{$key}}" data-value="{{$candidate->id}}">
                            <i class="fa fa-bars handle"></i>
                            <a href="{{route('application::view', ['id' => $candidate->id])}}" class="link-candidate-app unread">{{$candidate->fullname}}</a>
                            <a href="#" class="pull-right btn-shift" title="Move to other list."><i class="fa fa-arrow-right text-success"></i></a>
                        </li>
                    @endunless
                @endforeach
            </ul>

            <ul id="selected" class="list-group col-md-5 col-md-push-1">
                <li class="list-group-item list-group-item-info">
                    <h4>Your Rankings</h4>
                </li>
                <?php $available_ids = $available->pluck('id'); ?>
                @foreach($selected as $candidate)
                    <li class="list-group-item draggable" data-sort="{{$available_ids->search($candidate->id)}}" data-value="{{$candidate->id}}">
                        <i class="fa fa-bars handle"></i>
                        <a href="{{route('application::view', ['id' => $candidate->id])}}" class="link-candidate-app unread">{{$candidate->fullname}}</a>
                        <a href="#" class="pull-right btn-shift" title="Move to other list."><i class="fa fa-arrow-left text-danger"></i></a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="well well-sm">
            <button type="button" class="btn btn-success btn-save">Save</button>
        </div>
    </div>

    <div id="view-dialog" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body row">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection

@push('scripts')
  <script src="//cdn.jsdelivr.net/sortable/1.4.2/Sortable.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/tinysort/2.2.4/tinysort.min.js"></script>
  <script src="{{asset('js/custom/storage-helper.js')}}"></script>
  <script src="{{asset('js/custom/round2-judging.js')}}"></script>
@endpush
