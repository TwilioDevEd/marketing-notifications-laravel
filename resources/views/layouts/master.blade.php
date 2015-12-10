<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SMS Notifications</title>

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
        <!--[if lt IE 9]>
        <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js" type="text/javascript"></script>
        <![endif]-->
    </head>
    <body>
        <div class="navbar navbar-default navbar-static-top">
            <div class="container">
                <a class="navbar-brand" href="#">SMS Notifications</a>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    @if (session('status') !== null)
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ session('status') }}
                        </div><!--alert-->
                    @endif
                    @yield('content')
                </div><!--/col-lg-9-->
            </div><!--/row-->

            <footer>
                Made with <i class="fa fa-heart"></i> by your pals
                <a href="http://www.twilio.com">@twilio</a>
            </footer>
        </div> <!-- /container -->

        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </body>
</html>
