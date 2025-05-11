<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'QuickHire')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .header {
            background-color: #6183FF;
            color: white;
            padding: 15px 20px;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 9999;
        }

        .logo {
            height: 70px;
        }
        
        body {
            margin-top: 100px; 
            background: url('{{ asset('images/hero.jpg') }}') no-repeat center center fixed; /* Picture */
            background-size: cover;
            padding-bottom: 50px; 
            color: black;
        }

        /* Registration form */
        .form-container {
            background-color: rgba(255, 255, 255, 0.9); 
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            max-width: 400px;  
            margin: 0 auto;
            min-height: 500px; 
            color: black;
        }

        .container {
            padding-top: 30px;
        }
    </style>
</head>
<body>

<!-- Blue Header -->
<div class="header d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo me-3">
        <h3 class="mb-0">QUICKHIRE</h3>
    </div>

    @if (Request::is('login'))
        <div>
            <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">Register</a>
        </div>
    @elseif (!Request::is('register'))
        <div>
            <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm me-2">Home</a>
            <form method="POST" action="{{ url('/logout') }}" class="d-inline">
                @csrf
                <button class="btn btn-light btn-sm" type="submit">Logout</button>
            </form>
        </div>
    @endif
</div>




<!-- Page Content (Registration Form) -->
<div class="container my-5">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
