<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>To Do List</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/3472/3472580.png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
   
    <!-- Custom CSS -->
    <style>
   body {
        font-family: 'Nunito', sans-serif;
        margin: 0;
        padding: 0;
        overflow-y: scroll;
        position: relative;
    }

    body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('https://img.freepik.com/free-vector/light-blue-abstract-background_1077-3.jpg?w=2000');
        background-size: cover;
        background-repeat: no-repeat;
        filter: blur(3px);
        z-index: -1;
    }



.container.dark-theme .card {
    background-color:grey;
    border: none;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
    color:white;
}

.container.dark-theme .card-header {
    background-color: #444;
    border-bottom: none;
    color: #fff;
}

.container.dark-theme .card-body {
    padding: 30px;
}

.container.dark-theme .form-group.row {
    margin-bottom: 20px;
}

.container.dark-theme .form-group label {
    font-weight: bold;
}

.card-header {
        background-color: #343a40;
        color: white;
    }

    .form-group {
        margin-bottom: 20px;
    }

    #newNoteBtn {
        width: 100%;
    }
    #showtable {
        width: 100%;
    }

    #noteFormContainer {
        margin-top: 20px;
    }
    .action-buttons {
    display: flex;
    justify-content: flex-start;
    align-items: center;
}


    #taskTable {
        width: 100%;
    }

    .table thead th {
        background-color: #343a40;
        color: white;
        font-weight: bold;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8f9fa;
    }

    .table-hover tbody tr:hover {
        background-color: #e9ecef;
    }



.container.dark-theme .btn-primary {
    background-color: #007bff;
    border: none;
    color: #fff;
}

.container.dark-theme .btn-primary:hover {
    background-color: #0056b3;
}



        .navbar {
            background-color:black;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
        }

        .navbar-nav .nav-link {
            font-weight: 1000;
            color:black;
        }
        .bg-white{
               background-color: #444;
    border-bottom: none;
    color: #fff;
        }
        .container {
        position: relative;
        z-index: 1;
    }
    .footer {
  position: relative;
  left: 0;
  bottom: 0;
  width: 100%;
  background-color: #f8f9fa; /* Customize the background color */
  color: #000; /* Customize the text color */
  text-align: center;
  padding: 15px;
}
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    <i class="fas fa-list-ul"></i>&nbsp;&nbsp;To Do List
                </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                    
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                    
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                    
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                    
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS -->
   
      
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <script src="{{ asset('datatables/jquery.dataTables.min.js') }}"></script>
 <script src="{{ asset('datatables/datatable.custom.js') }}"></script>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{ asset('datatables/jquery.dataTables.min.js') }}"></script>
 <script src="{{ asset('datatables/datatable.custom.js') }}"></script>
</body>
</html>
