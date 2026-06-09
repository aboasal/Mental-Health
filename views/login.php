<!-- views/login.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Holistic Wellness Portal</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .login-wrapper {
            max-width: 400px;
            margin: 100px auto;
        }
    </style>
</head>

<body>

    <div class="container login-wrapper card">
        <h2 style="text-align: center; color: #4A90E2;">Welcome Back</h2>
        <p style="text-align: center; color: #666;">Please log in to your account.</p>

        <form action="/login-process" method="POST">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required placeholder="you@example.com">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required placeholder="••••••••">

            <button type="submit">Secure Login</button>
        </form>

        <p style="text-align: center; margin-top: 15px;">
            <a href="/register" style="color: var(--primary-color);">Need an account? Sign up</a>
        </p>
    </div>

</body>

</html>