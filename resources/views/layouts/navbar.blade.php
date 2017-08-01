<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-main-navbar-collapse" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{route('home')}}">Top 100</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-main-navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="{{Route::currentRouteName() == 'home' ? 'active' : ''}}"><a href="{{route('home')}}">Home</a></li>

        @if(Gate::forUser('anonymous')->allows('recommend'))
            <li class="{{Route::currentRouteName() == 'recommendations::index' ? 'active' : ''}}">
                <a href="{{route('recommendations::index')}}">Recommend Candidates</a>
            </li>
        @endif
        @can('nominate')
            <li class="{{Route::currentRouteName() == 'candidates::nominate' ? 'active' : ''}}">
                <a href="{{route('candidates::nominate')}}">Nominations</a>
            </li>
        @endcan

        @can('round1-judging')
            <li class="{{Route::currentRouteName() == 'judging::round1' ? 'active' : ''}}">
                <a href="{{route('judging::round1')}}">Judge</a>
            </li>
        @endcan
        @can('round2-judging')
            <li class="{{Route::currentRouteName() == 'judging::round2' ? 'active' : ''}}">
                <a href="{{route('judging::round2')}}">Judge</a>
            </li>
        @endcan

        @can('apply')
            <li class="{{Route::currentRouteName() == 'application::form' ? 'active' : ''}}">
                <a href="{{route('application::form')}}">Application</a>
            </li>
        @endcan
        @can('view-own-app')
            <li class="{{Route::currentRouteName() == 'application::view' ? 'active' : ''}}">
                <a href="{{route('application::view')}}">Application</a>
            </li>
        @endcan

        @can('create-guest-list')
            <li class="{{Route::currentRouteName() == 'guests::manage' ? 'active' : ''}}">
                <a href="{{route('guests::manage')}}">Guests</a>
            </li>
        @endcan
        @can('request-recommendations')
            <li class="{{Route::currentRouteName() == 'recommendations::request' ? 'active' : ''}}">
                <a href="{{route('recommendations::request')}}">Request Recommendation</a>
            </li>
        @endcan

        @hasrole('admin')
            <li class="{{Route::currentRouteName() == 'admin::index' ? 'active' : ''}}"><a href="{{route('admin::index')}}">Admin</a></li>
            @include('layouts.navbars.admin')
        @endhasrole
      </ul>
      <ul class="nav navbar-nav navbar-right">
        @include('partials.login')
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
