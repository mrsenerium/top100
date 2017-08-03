{{-- <div class="list-group">
    <h3 class="list-group-item">Admin Menu</h3>
    <div class="list-group-item list-group-item-info">
        <i class="fa fa-mortar-board"></i> Candidates
    </div>
    <a href="{{route('candidates::index')}}" class="{{Route::currentRouteName() == 'candidates::index' ? 'active' : ''}} list-group-item">All Candidates</a>
    <a href="{{route('candidates::add')}}" class="{{Route::currentRouteName() == 'candidates::add' ? 'active' : ''}} list-group-item">Add Candidate</a>
    <a href="{{route('import::form')}}" class="{{Route::currentRouteName() == 'import::form' ? 'active' : ''}} list-group-item">Import Candidates</a>

    <div class="list-group-item list-group-item-info">
        <i class="fa fa-calculator"></i> Results
    </div>
    <a href="{{route('results::top100')}}" class="{{Route::currentRouteName() == 'results::top100' ? 'active' : ''}} list-group-item">Top 100 Results</a>
    <a href="{{route('results::round2')}}" class="{{Route::currentRouteName() == 'results::round2' ? 'active' : ''}} list-group-item">Round 2 Results</a>

    <div class="list-group-item list-group-item-info">
        <i class="fa fa-group"></i> Users
    </div>
    <a href="{{route('users::index')}}" class="{{Route::currentRouteName() == 'users::index' ? 'active' : ''}} list-group-item">All Users</a>
    <a href="{{route('users::add')}}" class="{{Route::currentRouteName() == 'users::add' ? 'active' : ''}} list-group-item">Add User</a>

    <div class="list-group-item list-group-item-info" >
        <i class="fa fa-gears"></i> Settings
    </div>
    <a href="{{route('settings::application')}}" class="{{Route::currentRouteName() == 'settings::application' ? 'active' : ''}} list-group-item">Application Settings</a>
    <a href="{{route('settings::states')}}" class="{{Route::currentRouteName() == 'settings::states' ? 'active' : ''}} list-group-item">Application States</a>
    <a href="{{route('emails::index')}}" class="{{Route::currentRouteName() == 'emails::index' ? 'active' : ''}} list-group-item">Application Emails</a>
</div> --}}

{{-- <li class="{{Route::currentRouteName() == 'admin::index' ? 'active' : ''}}"><a href="{{route('admin::index')}}">Admin</a></li> --}}

<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Candidates <span class="caret"></span></a>
  <ul class="dropdown-menu">
    <li class="{{Route::currentRouteName() == 'candidates::index' ? 'active' : ''}}">
        <a href="{{route('candidates::index')}}">All Candidates</a>
    </li>
    <li class="{{Route::currentRouteName() == 'candidates::add' ? 'active' : ''}}">
      <a href="{{route('candidates::add')}}">Add Candidate</a>
    </li>
    <li class="{{Route::currentRouteName() == 'import::form' ? 'active' : ''}}">
      <a href="{{route('import::form')}}">Import Candidates</a>
    </li>
    <li role="separator" class="divider"></li>
    <li class="{{Route::currentRouteName() == 'guests::admin' ? 'active' : ''}}">
      <a href="{{route('guests::admin')}}">Guests</a>
    </li>
    <li role="separator" class="divider"></li>
    <li class="{{Route::currentRouteName() == 'results::top100' ? 'active' : ''}}">
        <a href="{{route('results::top100')}}">Top 100 Results</a>
    </li>
    <li class="{{Route::currentRouteName() == 'results::round2' ? 'active' : ''}}">
        <a href="{{route('results::round2')}}">Round 2 Results</a>
    </li>
  </ul>
</li>

<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Users <span class="caret"></span></a>
  <ul class="dropdown-menu">
    <li class="{{Route::currentRouteName() == 'users::index' ? 'active' : ''}}">
        <a href="{{route('users::index')}}">All Users</a>
    </li>
    <li class="{{Route::currentRouteName() == 'users::add' ? 'active' : ''}}">
      <a href="{{route('users::add')}}">Add User</a>
    </li>
    <li role="separator" class="divider"></li>
    <li class="{{Route::currentRouteName() == 'users::judges' ? 'active' : ''}}">
      <a href="{{route('users::judges')}}">Judge statuses</a>
    </li>
  </ul>
</li>

<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Settings <span class="caret"></span></a>
  <ul class="dropdown-menu">
    <li class="{{Route::currentRouteName() == 'settings::application' ? 'active' : ''}}">
      <a href="{{route('settings::application')}}">Application Settings</a>
    </li>
    <li class="{{Route::currentRouteName() == 'settings::states' ? 'active' : ''}}">
      <a href="{{route('settings::states')}}">Application States</a>
    </li>
    <li class="{{Route::currentRouteName() == 'emails::index' ? 'active' : ''}}">
        <a href="{{route('emails::index')}}">Application Emails</a>
    </li>
  </ul>
</li>
