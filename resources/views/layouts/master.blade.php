<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @stack('meta')
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Top 100 - @striptags('title')</title>

    <!-- Bootstrap -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>
        window.BASE_URL = "{{url('/')}}";
    </script>
  </head>
  <body>
    @include('layouts.navbar')
    @include('partials.testmode')
    <div class="container-fluid">
        <h1 class="page-header">@yield('title')</h1>
        <div class="row">
            @yield('content')
        </div>
    </div>
    <footer>
        <p class="text-center text-muted">
            If you have any questions about Top 100 or this application, send an email to <a href="mailto:top100@butler.edu">top100@butler.edu</a>.
        </p>
    </footer>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{asset('js/app.js')}}"></script>
    @stack('scripts')
  </body>
</html>
