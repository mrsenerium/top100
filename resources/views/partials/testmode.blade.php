@if(AppSettings::getTestMode() == true)
  <div class="container-fluid">
    <div class="alert alert-warning">
      <i class="fa fa-warning"></i> Application is currently in <strong>test mode</strong>. Emails will not be sent.
      <em class="pull-right">{{env('APP_ENV')}}</em>
    </div>
  </div>
@endif
