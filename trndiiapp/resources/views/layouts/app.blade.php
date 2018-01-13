<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Trndii') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
         
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="images/logo_small_white.png" alt="Trndii" height="100%">
                    </a>
                </div>
              
                <div class="collapse navbar-collapse" id="app-navbar-collapse">

                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-left">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a style="color: #ffffff;" href="{{ route('login') }}">Login</a></li>
                            <li><a style="color: #ffffff;" href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a style="color: #ffffff;" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="/editDetails">
                                            Edit Account
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/purchaseHistory">
                                            View My Orders
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            <!-- Currently not implementing tokens
                                <li><a href="#" style="font-size: 18px; color: #FDE706;"><img src="images/token.png" alt="Tokens" height="22">&nbsp; 100</a></li>
                            -->  
                        @endif
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a style="color: #ffffff;" href="/browseItemsByCategory">Browse Categories</a></li>
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <form class="navbar-form navbar-right">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search">
                            </div>
                        </div>
                            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
                    </form>
                </div>
            </div>
        </nav>
        @include('inc.messages')
        @yield('content')
    </div>
    
<!-- Start of FOOTER -->
    <div class="footer">
    <div class="container">
      <div class="row">
        <div class="p-4 col-md-3">
          <h2 class="mb-4 text-secondary">Trndii</h2>
          <p class="footer-text">A group buying service focused on making shopping fun.</p>
        </div>
        <div class="p-4 col-md-3">
          <h2 class="mb-4 text-secondary">Need help?</h2>
          <ul class="list-unstyled">
            <a href="/contact" class="footer-text">Send us a message</a>
            <br>
            <a href="#" class="footer-text">About us</a>
            <br>
            <a href="#" class="footer-text">FAQ</a>
          </ul>
        </div>
        <div class="p-4 col-md-3">
          <h2 class="mb-4">Contact</h2>
          <p>
            <a href="tel:+xxx - xxx xxx xxxx" class="footer-text"><i class="fa d-inline mr-3 text-secondary fa-phone"></i>(XXX) XXX-XXXX</a>
          </p>
          <p>
            <a href="mailto:support@trndii.com" class="footer-text"><i class="fa d-inline mr-3 text-secondary fa-envelope-o"></i>support@trndii.com</a>
          </p>
          <p>
            <a href="#" class="footer-text" target="_blank"><i class="fa d-inline mr-3 fa-map-marker text-secondary"></i>[Address Placeholder], QC</a>
          </p>
        </div>
        <div style="" class="p-4 col-md-3">
          <h2 class="mb-4 text-light">Subscribe</h2>
          <form>
            <fieldset class="form-group footer-text"> <label for="exampleInputEmail1">Get our newsletter</label>
              <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email"> </fieldset>
            <button type="submit" class="btn btn-outline-secondary">Submit</button>
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 mt-3">
          <p class="text-center footer-text">© Copyright 2017 Trndii - All rights reserved. </p>
        </div>
      </div>
    </div>
  </div> 
  <!-- Scripts -->
    @yield('scripts')
</body>
</html>