@extends('layouts.app')

@section('scripts')
<script src="{{ asset('js/app.js') }}"></script>
@endsection

@section('content')
<div id="app">
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                        
                    You are logged in!

                        <br>
                        <a href="item">BROWSE ITEMS</a>

                </div>
            </div>
        </div>
    </div>
    
  <h2>Deals</h2>  
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div class="item active">
        <img src="https://www.wpfreeware.com/wp-content/uploads/2014/09/placeholder-images.jpg" alt="Los Angeles" style="width:100%;">
      </div>

      <div class="item">
        <img src="https://www.wpfreeware.com/wp-content/uploads/2014/09/placeholder-images.jpg" alt="Chicago" style="width:100%;">
      </div>
    
      <div class="item">
        <img src="https://www.wpfreeware.com/wp-content/uploads/2014/09/placeholder-images.jpg" alt="New york" style="width:100%;">
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>

</div>


@endsection
