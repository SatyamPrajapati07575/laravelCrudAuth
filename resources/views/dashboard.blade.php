<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" >
</head>
<body class="bg-light">

    <div class="container my-5">
        <!-- Flash messages for success or errors -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Dashboard Content -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2>Welcome, {{ Auth::user()->name }}!</h2>
            </div>
            <div class="card-body">
                <p>This is your dashboard. You are logged in.</p>

                <!-- Profile Image -->
                <div class="mb-4">
                    <img src="{{ asset('storage/' . Auth::user()->profile_img) }}" alt="Profile Image" class="img-thumbnail" width="150">
                </div>

                <h4>Your Skills</h4>
                <p>{{ Auth::user()->skills }}</p>

                <!-- Logout Button -->
                <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" ></script>
</body>
</html>
