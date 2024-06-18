<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LogIn Form</title>
    <!-- custom css file link -->
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        /* Additional CSS for the image and form layout */
        .main-container {
            display: flex;
            align-items: center;
            justify-content: space-around; /* Adjust as needed */
            height: 100vh;
            background: #eee;
        }

        .img-container {
            flex: 1;
            text-align: center;
        }

        .img-container img {
            max-width: 100%;
            height: auto;
        }

        .form-container {
            flex: 1;
            padding: 20px;
            /* background: #eee; */
        }

        .form-container form {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="main-container">
    <div class="img-container">
        <img src="images/logo.png" alt="logo">
    </div>
    <div class="form-container">
        <form action="/login" method="POST">
            @csrf
            <h3>LogIn Now</h3>

            @if (session('success'))
            <span style="color: Green;">{{ session('success') }}</span>
            @elseif (session('error'))
            <span class="error-msg">{{ session('error') }}</span>
            @endif
            <input type="email" name="email" required placeholder="Enter your Email">
            <input type="password" name="password" required placeholder="Enter your Password">
            <input type="submit" name="submit" value="LogIn Now" class="form-btn">
            <p>Don't have an Account? <a href="/registration_form">Register Now</a> </p>
        </form>
    </div>
</div>
</body>
</html>