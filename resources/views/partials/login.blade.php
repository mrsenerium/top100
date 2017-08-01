@if(Auth::check())
  <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
      {{Auth::user()->firstname}} {{Auth::user()->lastname}} <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
      <li><a href="{{route('logout')}}"><i class="fa fa-sign-out"></i> Logout</a></li>
    </ul>
  </li>
@else
  <li class="{{Route::currentRouteName() == 'login' ? 'active' : ''}}"><a href="{{route('login')}}"><i class="fa fa-lock"></i> Login</a></li>
@endif
