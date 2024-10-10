<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Task Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('/assets/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">

</head>

<body class="varela-round-regular" style="background-color: #E9ECF2;">
    
    <div class="mb-5">
        <!-- Navigation Bar -->
        <nav class="navbar fixed-top navbar-expand-lg text-white" style="background-color: #5B2C6F;">
            <div class="container-fluid text-white">
               
                <a class="navbar-brand fw-bolder text-white" href="/" > 
                 <img src="{{asset('storage/images/task.png')}}" height="60em" >Task Management</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarScroll">
                    <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                        <li class="nav-item fs-5 fw-normal text-light">
                            <a role="button" class="nav-link active btn  text-white" aria-current="page" href="{{url('/')}}">Home</a>
                        </li>
                        <li class="nav-item  fs-5 fw-normal text-light">
                            <a class="nav-link text-white" href="/tasks">Tasks</a>
                        </li>
                        <li class="nav-item  fs-5 fw-normal text-light dropdown">
                            <a class="nav-link text-white" href="{{url('/subtasks')}}" role="button"  aria-expanded="false">
                                Subtasks
                            </a>
                            <!-- <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{url('/subtasks')}}">Today's Subtask</a></li>
                                <li><a class="dropdown-item" href="{{url('/subtasks')}}">Pending Subtask</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            </ul> -->
                        </li>
                        <li class="nav-item  fs-5 fw-normal text-light">
                            <a class="nav-link text-white" href="/report">Daily Report</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link disabled text-white" aria-disabled="true">Link</a>
                        </li> -->
                    </ul>
                    <form action="{{route('search')}}" class="d-flex" role="search">
                        <input class="form-control me-2" type="search" name="keyword" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-light text-white" type="submit">Search</button>
                    </form>
                    <div class="d-flex" style="margin-left: 10px;">
                        <div class="text-center m-auto dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Welcome, {{Auth::user()['name']}}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{url('/profile')}}">Profile</a></li>
                                <li>
                                    <form action="{{route('logout')}}" method="post">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>

                                    </form>
                            </ul>

                        </div>
                        <form action="" method="post">
                            @csrf
                            <input type="hidden" name="subscription" value="500">
                            <button type="submit" class="btn btn-primary m-2">Subscribe</button>
                        </form>

                    </div>
                </div>
            </div>
        </nav>
    </div>
    <br>
<div class="mt-4">
    @yield('content')
    </div>
    <!-- Footer Starts Here -->
    <footer class="footer bg-purple text-white py-4 mt-2">
  <div class="container">
    <div class="row">
      <!-- Column 1: About -->
      <div class="col-lg-4 col-md-6 mb-4">
        <h5>About Us</h5>
        <p>
          We are dedicated to providing top-notch task management solutions to improve your productivity and workflow.
        </p>
      </div>
      <!-- Column 2: Useful Links -->
      <div class="col-lg-4 col-md-6 mb-4">
        <h5>Useful Links</h5>
        <ul class="list-unstyled lh-lg">
          <li><a href="#" class="text-white">Home</a></li>
          <li><a href="#" class="text-white">Tasks</a></li>
          <li><a href="#" class="text-white">Subtasks</a></li>
          <li><a href="#" class="text-white">Contact Us</a></li>
        </ul>
      </div>
      <!-- Column 3: Contact -->
      <div class="col-lg-4 col-md-6 mb-4">
        <h5>Contact Us</h5>
        <p><i class="fas fa-envelope"></i> akgaur680@gmail.com</p>
        <p><i class="fas fa-phone"></i> +91 98036 60559</p>
        <p><i class="fas fa-map-marker-alt"></i> #240 Moti Nagar Ludhiana</p>
      </div>
    </div>
  </div>
  <div class="footer-bottom text-center py-3">
    <p class="mb-0">&copy; 2024 Task Management. All Rights Reserved.</p>
  </div>
</footer>


</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="{{asset('assets/ajax.js')}}"></script>


</html>