<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS for gradient background, glassmorphism, and logo hover -->
    
</head>
<body>
<div>
    <!-- Logo at the Top -->
    <div class="logo-container text-center mb-4">
        <img src="{{ asset('images/logo.png') }}" alt="Company Logo" class="company-logo">
    </div>

    <!-- Login Box -->
    <div class="login-box">
        <div class="d-flex flex-column gap-3 mb-4">
            <a href="login" class="btn btn-dark d-flex align-items-center justify-content-center gap-3 py-3">
                <i class="fas fa-user"></i> Login
            </a>
            <a href="login-qr" class="btn btn-light d-flex align-items-center justify-content-center gap-3 py-3">
                <i class="fas fa-user-plus"></i> QR
            </a>
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<style>
    body {
        background: linear-gradient(135deg, #8CADFF, #E5A2FF);
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .company-logo {
        max-width: 160px;
        max-height: 110px;
        transition: transform 0.3s ease;
    }

    .company-logo:hover {
        transform: scale(1.05);
    }

    .login-box {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        border-radius: 16px;
        padding: 2rem;
        width: 350px;
    }
</style>
</html>