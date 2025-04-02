<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .logo-container {
            text-align: center;
            padding: 20px 0;
        }
        .company-logo {
            max-height: 80px;
        }
        .scanner-box {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .scanner-container {
            margin-bottom: 20px;
        }
        .viewport {
            border: 2px solid #ddd;
            border-radius: 5px;
            background: #000;
        }
        .login-link {
            margin-top: 20px;
        }
        .qr-detected-container {
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="logo-container">
            <img src="{{ asset('images/logo.png') }}" alt="Company Logo" class="company-logo">
        </div>

        <div class="scanner-box">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="scanner-container">
                <h5 class="text-center mb-4">Scan your QR Code to Log In</h5>
                <video id="interactive" class="viewport" width="100%"></video>
            </div>

            <div class="qr-detected-container" style="display: none;">
                <h4 class="text-center mb-4">QR Code Detected!</h4>
                <form action="{{ route('qr.scan') }}" method="POST" id="qr-login-form">
                    @csrf
                    <input type="hidden" id="detected-qr-code" name="qr_code">
                    <button type="submit" class="btn btn-dark form-control mb-2" id="login-btn">
                        <i class="fas fa-sign-in-alt"></i> Log In
                    </button>
                    <button type="button" class="btn btn-outline-secondary form-control" onclick="restartScanner()">
                        <i class="fas fa-sync-alt"></i> Rescan
                    </button>
                </form>
            </div>

            <div class="login-link text-center mt-4">
                <a href="{{ route('login') }}" class="text-decoration-none"><i class="fas fa-arrow-left"></i> Back to Regular Login</a>
            </div>
        </div>
    </div>

    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script>
        let scanner;
        let isScanning = false;

        function startScanner() {
            if (isScanning) return;
            
            scanner = new Instascan.Scanner({ 
                video: document.getElementById('interactive'),
                mirror: false
            });
            
            scanner.addListener('scan', function (content) {
                if (!content) return;
                
                document.getElementById('detected-qr-code').value = content;
                stopScanner();
                document.querySelector(".qr-detected-container").style.display = '';
                document.querySelector(".scanner-container").style.display = 'none';
            });

            Instascan.Camera.getCameras()
                .then(function (cameras) {
                    if (cameras.length > 0) {
                        const selectedCamera = cameras.find(c => c.name.toLowerCase().includes('back')) || 
                                              cameras[0];
                        scanner.start(selectedCamera);
                        isScanning = true;
                    } else {
                        showError('No cameras found. Please ensure you have granted camera permissions.');
                    }
                })
                .catch(function (err) {
                    console.error('Camera error:', err);
                    showError('Camera access error. Please ensure you have granted camera permissions.');
                });
        }

        function stopScanner() {
            if (scanner && isScanning) {
                scanner.stop();
                isScanning = false;
            }
        }

        function restartScanner() {
            document.querySelector(".qr-detected-container").style.display = 'none';
            document.querySelector(".scanner-container").style.display = '';
            document.getElementById('detected-qr-code').value = '';
            startScanner();
        }

        function showError(message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger';
            alertDiv.textContent = message;
            document.querySelector('.scanner-box').prepend(alertDiv);
        }

        document.addEventListener('DOMContentLoaded', function() {
            startScanner();
            
            // Add loading state to form submission
            document.getElementById('qr-login-form').addEventListener('submit', function() {
                const btn = document.getElementById('login-btn');
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Logging in...';
            });
            
            // Stop scanner when going back
            document.querySelector('.login-link a').addEventListener('click', stopScanner);
        });
    </script>
</body>
</html>