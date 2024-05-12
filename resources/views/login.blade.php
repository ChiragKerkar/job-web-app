<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <style>
        /* Custom CSS */
        .centered-form {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f9f9f9; /* Light background color */
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row centered-form">
        <div class="col-md-6">
            <div id="loginAlert" class="alert d-none" role="alert"></div>
            <div class="text-center mb-4">
                <h2 class="font-weight-bold">Login</h2>
            </div>
            <form id="loginForm" class="g-3">
                @csrf
            <input type="hidden" id="url" value="<?= url('/') ?>">
                <div class="mb-3">
                    <label for="loginEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="loginPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="text-center">
                    <button type="button" id="loginBtn" class="btn btn-primary">Login</button>
                </div>
            </form>
            <div class="text-center mt-3">
                <p>Don't have an account? <a href="<?= url('/') ?>">Register</a></p>
            </div>
        </div>
    </div>
</div>
<script src="<?= url('js/form_submission/form_submit.js') ?>"></script>
</body>
</html>
