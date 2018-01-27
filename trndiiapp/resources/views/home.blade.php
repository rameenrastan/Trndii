@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <img src="images/logo_full.png" width="100%">
                        <h3 align="center">
                            Welcome to Trndii! If you're not sure where to start, click <a href="#"> here </a>
                        </h3>
                    </div>

                    <div class="panel-body" style="border:none;">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h2 align="center" style="margin-top: 0;">
                            Featured Items
                        </h2>
                        <div class="col-md-12">
                            <div class="thumbnail">
                                <a href="#" target="_blank">
                                    <img src="images/placeholders/botw_wide.jpg" alt="PLACEHOLDER" style="width:100%">
                                </a>
                                <div class="caption" style="position: relative">
                                    <p>
                                        Breath of the Wild: Explorer's Edition.<br>
                                        Threshold: 20
                                    </p>
                                    <button type="button" class="btn btn-success" href="#">More Info</button>
                                </div>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="thumbnail">
                                    <a href="#" target="_blank">
                                        <img src="images/placeholders/inteli9.jpg" alt="PLACEHOLDER"
                                             style="width:100%;">
                                    </a>
                                    <div class="caption" style="position: relative">
                                        <p>
                                            Intel<sup>&reg;</sup> CORE<sup>&trade;</sup> i9 EXTREME Processor.<br>
                                            Threshold: 12
                                        </p>
                                        <button type="button" class="btn btn-success" href="#">More Info</button>
                                    </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="thumbnail">
                                    <a href="#" target="_blank">
                                        <img src="images/placeholders/iphonex.jpg" alt="PLACEHOLDER"
                                             style="width: 100%;">
                                    </a>
                                    <div class="caption" style="position: relative">
                                        <p>
                                            iPhone X.<br>
                                            Threshold: 40
                                        </p>
                                        <button type="button" class="btn btn-success" href="#">More Info</button>
                                    </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <h4 align="left" style="margin-top: 0;">
                            <a href="/item">
                                See more items...
                            </a>
                        </h4>
                    </div>
                    <!-- END of class-panel-body -->
                </div>
            </div>
        </div>
    </div>
@endsection