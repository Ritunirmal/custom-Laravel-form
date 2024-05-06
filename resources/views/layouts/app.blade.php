<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Government Post</title>
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/style2.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('assets/css/jquery-ui.css')}}"/>
  



</head>

<body>
    <header class="header">
        <div class="ajax-loader ajax-busy-wrap" style="display:none">loading</div>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="logo"><img src="{{$HomeData->logo}}"></div>
                </div>
                <div class="col-sm-3 vcenter">
                    <div class="headerTitle">{{$HomeData->heading}}<br>
                        <span class=""><strong>POST </strong> - {{$HomeData->post}}</span>
                    </div>
                </div>
                <div class="col-sm-6 vbottom">
                    <nav id="customStyleNav" class="navbar navbar-expand-lg p-0">
                        <div class="container-fluid">
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation"> <span
                                    class="navbar-toggler-icon"></span> </button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav ms-auto">
                                    <li class="nav-item"> <a class="nav-link"
                                            href="/"><i
                                                class="fa-solid fa-house"></i> Home</a> </li>
                                    <li class="nav-item"> <a class="nav-link"
                                            href="#"><i
                                                class="fa-solid fa-calendar-days"></i> Important Dates</a> </li>

                                    <li class="nav-item"> <a class="nav-link" href="/register"><i
                                                class="fa-solid fa-pen-to-square"></i> Registration</a>
                                    <li class="nav-item"> <a class="nav-link" href="/login"><i
                                                class="fa-solid fa-right-to-bracket"></i> Login</a> </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @stack('scripts')
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
</body>

</html>
