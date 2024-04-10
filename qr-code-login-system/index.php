<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System with QR Code Scanner</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');

        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
           
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100vh;
        }

        .login-container, .registration-container {
            backdrop-filter: blur(120px);
            color: rgb(255, 255, 255);
            padding: 25px 40px;
            width: 500px;
            border: 2px solid;
            border-radius: 10px;
        }
        .switch-form-link {
            text-decoration: underline;
            cursor: pointer;
            color: rgb(100, 100, 250);
        }

        .drawingBuffer {
            width: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    
    <div class="main">

        <!-- Login Area -->

        <div class="login-container">

                <div class="login-form" id="loginForm">
                <h2 class="text-center">Welcome Back!</h2>
                <p class="text-center">Login through QR code scanner.</p>

                <video id="interactive" class="viewport" width="415"></div>
                
                <div class="qr-detected-container" style="display: none;">
                    <form action="login.php" method="POST">
                        <h4 class="text-center">QR Code Detected!</h4>
                        <input type="hidden" id="detected-qr-code" name="qr-code">
                        <button type="submit" class="btn btn-dark form-control">Login</button>
                    </form>
                </div>
                <p class="mt-3">No Account? Register <span class="switch-form-link" onclick="customersignup.php">Here.</span></p>
            </div>
        </div>



        <!-- Registration Area -->
        <div class="registration-container">
            <div class="registration-form" id="registrationForm">
                <h2 class="text-center">Registration Form</h2>
                <p class="text-center">Fill in your personal details.</p>
                <form action="123.php" method="POST">
                    <div class="hide-registration-inputs">
                        <div class="form-group registration">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group registration row">
                            <div class="col-5">
                                <label for="contactNumber">Contact Number:</label>
                                <input type="number" class="form-control" id="contactNumber" name="contact_number" maxlength="11">
                            </div>
                            <div class="col-7">
                                <label for="email">Email:</label>
                                <input type="text" class="form-control" id="email" name="email">
                            </div>
                        </div>
                        <p>Already have a QR code account? Login <span class="switch-form-link" onclick="location.reload()">Here.</span></p>
                        <button type="button" class="btn btn-dark login-register form-control" onclick="generateQrCode()">Register and Generate QR Code</button>
                    </div>

                    <div class="qr-code-container text-center" style="display: none;">
                        <h3>Take a Picture of your QR Code and Login!</h3>
                        <input type="hidden" id="generatedCode" name="generated_code">
                        <div class="m-4" id="qrBox">
                            <img src="" id="qrImg">
                        </div>
                        <button type="submit" class="btn btn-dark">Back to Login Form.</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

<!-- Bootstrap Js -->   
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
<!-- instascan Js -->
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

<script>
    const loginCon = document.querySelector('.login-container');
    const registrationCon = document.querySelector('.registration-container');
    const registrationForm = document.querySelector('.registration-form');
    const qrCodeContainer = document.querySelector('.qr-code-container');
    let scanner;

    registrationCon.style.display = "none";
    qrCodeContainer.style.display = "none";

    function showRegistrationForm() {
        registrationCon.style.display = "";
        loginCon.style.display = "none";
        scanner.stop();
    }

    function startScanner() {
        scanner = new Instascan.Scanner({ video: document.getElementById('interactive') });

        scanner.addListener('scan', function (content) {
            $("#detected-qr-code").val(content);
            scanner.stop();
            document.querySelector(".qr-detected-container").style.display = '';
            document.querySelector(".viewport").style.display = 'none';
        });

        Instascan.Camera.getCameras()
            .then(function (cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                } else {
                    console.error('No cameras found.');
                    alert('No cameras found.');
                }
            })
            .catch(function (err) {
                console.error('Camera access error:', err);
                alert('Camera access error: ' + err);
            });
    }

    

    // Ensure the scanner starts after the page loads
    document.addEventListener('DOMContentLoaded', startScanner);
</script>


</body>
</html>
