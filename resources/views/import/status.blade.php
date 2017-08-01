@extends('layouts.master')

@section('title', 'Importing')

@section('content')

  <div class="col-md-12">
    @include('partials/status')
    Processing...
    <div class="progress">
        <div class="progress-bar progress-bar-striped active" role="progressbar"
            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: {{$percentage or 0}}%">
            <span class="sr-only"><span class="percentage">0</span>% Complete</span>
        </div>
    </div>
    <p class="text-muted">Import may take a couple minutes to complete. Progess will continue even if you leave this page.</p>
  </div>

@endsection

@push('scripts')
    <script>
        var statusUrl = "{{route('import::status')}}";
        $(document).ready(function() {
            (function poll() {
                setTimeout(function() {
                    $.ajax({
                        url: statusUrl,
                        type: "GET",
                        success: function(data) {
                            if(data['completed'] && data['total']) {
                                var $percent = (data['completed'] / data['total']) * 100;
                                var $bar = $('.progress-bar');
                                $bar.css('width', $percent + '%');
                                $bar.find('.percentage').html(Math.round($percent));
                                //TODO: update aria-valuenow tag

                                if($percent >= 100) {
                                    setTimeout(function () {
                                        window.location.href = "{{route('import::form')}}";
                                    }, 1000);
                                }
                            }
                        },
                        dataType: "json",
                        complete: poll,
                        timeout: 2500
                    })
                }, 2500);
            })();
        });
    </script>
@endpush
