<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Title -->
    <title>Savings Management System</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('img/save-money.png') }}">
    <link rel="stylesheet" href="{{ asset('css/graindashboard.css') }}">
</head>

<body class="">

<main class="main">
    <div class="content">
        <div class="container-fluid pb-5">
            <div class="row justify-content-md-center">
                <div class="card-wrapper col-12 col-md-4 mt-5">
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #eef6f9; text-align: center;">
                            <h4>Login</h4>
                        </div>
                        <div class="card-body">
                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('login.submit') }}">
                                @csrf
                                <!-- Email Input -->
                                <div class="form-group">
                                    <label for="email">E-Mail</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                </div>

                                <!-- Password Input -->
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input id="password" type="password" class="form-control" name="password" required>
                                </div>

                                <!-- Submit Button -->
                                <div class="form-group no-margin">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Sign In
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <footer class="footer mt-3">
                        <div class="container-fluid">
                            <div class="footer-content text-center small">
                                <span class="text-muted">&copy; 2025 Nasim Mahmud. All Rights Reserved.</span>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="{{ asset('js/graindashboard.js') }}"></script>
<script src="{{ asset('js/graindashboard.vendor.js') }}"></script>
</body>
</html>
