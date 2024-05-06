<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">

    <title>Kalyan Singh Super Specialty Cancer Institute</title>
    <link href="https://kssscidirect.cbtexamportal.in/assests/images/favicon.ico" rel="shortcut icon" />
    <link href="https://kssscidirect.cbtexamportal.in/assests/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://kssscidirect.cbtexamportal.in/assests/css/jquery-ui.min.css" rel="stylesheet">
    <link href="https://kssscidirect.cbtexamportal.in/assests/css/all.min.css" rel="stylesheet">
    <link href="https://kssscidirect.cbtexamportal.in/assests/css/style.css" rel="stylesheet" />
    


</head>

<body>
    <header class="header">
        <div class="ajax-loader ajax-busy-wrap" style="display:none">loading</div>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                <div class="logo"><img src="https://rmlrecruit.cbtexamportal.in//assests/images/logo.png"></div>
                </div>
                <div class="col-sm-3 vcenter">
                <div class="headerTitle"> Dr. Ram Manohar Lohia Institute of Medical Sciences <br>
                        <span class=""><strong>POST </strong> - NURSING OFFICER </span>
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
                                            href="https://kssscidirect.cbtexamportal.in/"><i
                                                class="fa-solid fa-house"></i> Home</a> </li>
                                    <li class="nav-item"> <a class="nav-link"
                                            href="https://kssscidirect.cbtexamportal.in/View/important-date"><i
                                                class="fa-solid fa-calendar-days"></i> Important Dates</a> </li>

                                    <li class="nav-item"> <a class="nav-link"
                                            href="https://kssscidirect.cbtexamportal.in/View/email-mobile-verification"><i
                                                class="fa-solid fa-pen-to-square"></i> Registration</a>
                                       
                                            @guest
                                            <!-- Show login link if the user is not authenticated (guest) -->
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                    href="https://kssscidirect.cbtexamportal.in/View/login">
                                                    <i class="fa-solid fa-right-to-bracket"></i> Login
                                                </a>
                                            </li>
                                            @else
                                            <!-- Show logout link if the user is authenticated -->
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('logout') }}"
                                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    <i class="fa-solid fa-pen-to-square"></i> Logout
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                    class="d-none">
                                                    @csrf
                                                </form>
                                            </li>
                                            @endguest
                                       

                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <main>
        
        @yield('content')

    </main>
    <footer>
        <p>&copy; 2023 My Laravel App</p>

    </footer>
  <!-- Bootstrap JavaScript (Popper.js is required for dropdowns, tooltips, and popovers) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.min.js"></script>
<script src="https://oilspe.cbtexamportal.in//assests/js/bootstrap.bundle.min.js"></script>
<!-- <script src="https://oilspe.cbtexamportal.in/assests/js/jquery-1.8.3.min.js"></script>
    <script src="https://oilspe.cbtexamportal.in/assests/js/jquery-ui.min.js"></script> -->

    <!-- Include jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Include jQuery UI library -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
@stack('scripts')
</body>

</html>