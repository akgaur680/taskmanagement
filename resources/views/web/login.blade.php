<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="{{ asset('/assets/style.css') }}">

</head>

<body>
  <div class="container ">
    <div class="">
      <div style="width: 50%; margin:auto;" class="mt-5 p-5">
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success</strong> {{session('success')}}.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="card">
          <div class="card-body bg-secondary" style="border-radius: 10px;" >
            <div class=" ">
              <div class="brand-logo">
                <img src="{{asset('storage/images/task.png')}}" height="120em"  alt="Logo">
              </div>
              <h4>Hello! let's get started</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>

              @if ($errors->any())
              <div class="alert alert-danger" id="error-alert">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif

              <form class="pt-3" method="POST" action="{{ route('login.submit') }}">
                @csrf
                <div class="form-group m-3">
                  <input type="email" name="email" class="form-control form-control-lg" id="email" placeholder="Email" required>
                </div>
                <div class="form-group m-3">
                  <input type="password" name="password" class="form-control form-control-lg" id="password" placeholder="Password" required>
                </div>
                <div class="m-3">
                  <button type="submit" class="btn btn-success btn-gradient">SIGN IN</button>
                </div>
                <div class="m-3">
                  <h5>If you are not registered, Please <a href="{{route('register')}}">Sign Up Here</a></h5>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>