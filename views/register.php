<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Wellness Portal</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .register-wrapper {
            max-width: 450px;
            margin: 60px auto;
        }
    </style>
</head>

<body>

    <div class="container register-wrapper card">
        <h2 style="text-align: center; color: var(--primary-color);">Create Your Account</h2>
        <p style="text-align: center; color: #666;">Join our secure ecosystem.</p>

        <form action="/register-process" method="POST">
            <label for="full_name">Legal Full Name</label>
            <input type="text" id="full_name" name="full_name" required placeholder="Jane Doe">

            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required placeholder="you@example.com">

            <label for="password">Create Password</label>
            <input type="password" id="password" name="password" required placeholder="••••••••">

            <label for="role">I am registering as a:</label>
            <select id="role" name="role" required>
                <option value="Patient">Patient (Seeking Care)</option>
                <option value="Therapist">Licensed Therapist (Providing Care)</option>
            </select>

            <button type="submit" style="margin-top: 15px;">Continue to Intake</button>
        </form>

        <p style="text-align: center; margin-top: 15px;">
            <a href="/login" style="color: var(--primary-color);">Already have an account? Log in</a>
        </p>
    </div>

</body>

</html>