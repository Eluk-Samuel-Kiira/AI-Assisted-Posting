<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AI Powered Job Posting | LaFab Solution</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #3498db;
            --primary-dark: #2980b9;
            --secondary: #2c3e50;
            --accent: #e74c3c;
            --light: #ecf0f1;
            --success: #27ae60;
            --text: #333;
            --text-light: #7f8c8d;
            --shadow: 0 10px 30px rgba(0,0,0,0.1);
            --gradient: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
        }
        
        body {
            background: var(--gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
        }
        
        .login-container {
            background: white;
            border-radius: 15px;
            box-shadow: var(--shadow);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
        }
        
        .login-header {
            background: var(--gradient);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .login-header h2 {
            margin: 0;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .login-header p {
            margin: 10px 0 0;
            opacity: 0.9;
        }
        
        .login-body {
            padding: 30px;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        
        .btn-login {
            background: var(--gradient);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s;
            width: 100%;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .login-footer {
            text-align: center;
            padding: 20px;
            border-top: 1px solid #e9ecef;
            background: #f8f9fa;
        }
        
        .login-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }
        
        .login-footer a:hover {
            text-decoration: underline;
        }
        
        .magic-link-icon {
            font-size: 3rem;
            margin-bottom: 15px;
            color: white;
            opacity: 0.9;
        }
        
        .alert {
            border-radius: 8px;
            border: none;
            padding: 12px 15px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background-color: #d5f4e6;
            color: #27ae60;
        }
        
        .alert-danger {
            background-color: #fadbd8;
            color: #e74c3c;
            border-left: 4px solid #e74c3c;
        }
        
        .back-to-home {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-to-home a {
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .back-to-home a:hover {
            text-decoration: underline;
        }
        
        .token-section {
            display: none;
        }
        
        .token-input-container {
            position: relative;
        }
        
        .token-input-container .input-group-text {
            cursor: pointer;
        }
        
        .countdown {
            font-size: 14px;
            color: var(--text-light);
            margin-top: 5px;
            text-align: center;
        }
        
        .resend-link {
            text-align: center;
            margin-top: 15px;
        }
        
        .resend-link a {
            color: var(--primary);
            cursor: pointer;
        }
        
        .resend-link a:hover {
            text-decoration: underline;
        }
        
        .resend-link a.disabled {
            color: var(--text-light);
            pointer-events: none;
        }
        
        .invalid-token-message {
            background-color: #fadbd8;
            color: #e74c3c;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #e74c3c;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .invalid-token-message i {
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="magic-link-icon">
                <i class="fas fa-magic"></i>
            </div>
            <h2><i class="fas fa-robot"></i> LaFab AI Posting</h2>
            <p id="header-message">Enter your email to receive a magic login link</p>
        </div>
        
        <div class="login-body">
            <!-- Invalid Token Message (shown when redirected from invalid token) -->
            <div id="invalid-token-alert" class="invalid-token-message" style="display: none;">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    <strong>Invalid or Expired Token</strong>
                    <p class="mb-0">The login token you used is invalid or has expired. Please request a new magic link.</p>
                </div>
            </div>
            
            <!-- Success/Error Messages -->
            <div id="alert-container">
                <!-- Messages will be inserted here dynamically -->
            </div>
            
            <!-- Email Input Section -->
            <div id="email-section">
                <form id="email-form">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email" 
                                   placeholder="Enter your email address" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-paper-plane"></i> Send Magic Link
                    </button>
                </form>
            </div>
            
            <!-- Token Verification Section -->
            <div id="token-section" class="token-section">
                <p>We've sent a verification token to your email. Please enter it below:</p>
                
                <form id="token-form">
                    <div class="mb-3">
                        <label for="token" class="form-label">Verification Token</label>
                        <div class="input-group token-input-container">
                            <input type="text" class="form-control" id="token" name="token" 
                                   placeholder="Enter 6-digit token" maxlength="6" required>
                            <span class="input-group-text" id="toggle-token-visibility">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                        <div class="countdown" id="countdown">Token expires in: <span id="timer">10:00</span></div>
                    </div>
                    
                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-check"></i> Verify Token
                    </button>
                </form>
                
                <div class="resend-link">
                    <a href="#" id="resend-link">Didn't receive the token? Resend</a>
                </div>
            </div>
        </div>
        
        <div class="login-footer">
            <p>Don't have an account? <a href="#" id="register-link">Register here</a></p>
        </div>
    </div>
    
    <div class="back-to-home">
        <a href="#"><i class="fas fa-arrow-left"></i> Back to Homepage</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DOM Elements
            const emailSection = document.getElementById('email-section');
            const tokenSection = document.getElementById('token-section');
            const emailForm = document.getElementById('email-form');
            const tokenForm = document.getElementById('token-form');
            const emailInput = document.getElementById('email');
            const tokenInput = document.getElementById('token');
            const headerMessage = document.getElementById('header-message');
            const alertContainer = document.getElementById('alert-container');
            const invalidTokenAlert = document.getElementById('invalid-token-alert');
            const toggleTokenVisibility = document.getElementById('toggle-token-visibility');
            const countdownTimer = document.getElementById('timer');
            const resendLink = document.getElementById('resend-link');
            const registerLink = document.getElementById('register-link');
            
            // State variables
            let countdown;
            let timeLeft = 600; // 10 minutes in seconds
            let tokenSent = false;
            
            // Check if we were redirected due to an invalid token
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('invalid_token')) {
                showInvalidTokenAlert();
            }
            
            // Email form submission
            emailForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const email = emailInput.value.trim();
                
                // Basic email validation
                if (!email) {
                    showAlert('Please enter your email address', 'danger');
                    emailInput.focus();
                    return;
                }
                
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    showAlert('Please enter a valid email address', 'danger');
                    emailInput.focus();
                    return;
                }
                
                // Simulate sending email (in a real app, this would be an API call)
                simulateSendEmail(email);
            });
            
            // Token form submission
            tokenForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const token = tokenInput.value.trim();
                
                if (!token || token.length !== 6) {
                    showAlert('Please enter a valid 6-digit token', 'danger');
                    tokenInput.focus();
                    return;
                }
                
                // Simulate token verification (in a real app, this would be an API call)
                simulateVerifyToken(token);
            });
            
            // Toggle token visibility
            toggleTokenVisibility.addEventListener('click', function() {
                if (tokenInput.type === 'password') {
                    tokenInput.type = 'text';
                    toggleTokenVisibility.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    tokenInput.type = 'password';
                    toggleTokenVisibility.innerHTML = '<i class="fas fa-eye"></i>';
                }
            });
            
            // Resend token
            resendLink.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (resendLink.classList.contains('disabled')) {
                    return;
                }
                
                // Reset timer and resend token
                resetTimer();
                simulateSendEmail(emailInput.value.trim());
                showAlert('Token has been resent to your email', 'success');
                
                // Disable resend for 30 seconds
                resendLink.classList.add('disabled');
                resendLink.textContent = 'Resend available in 30 seconds';
                
                setTimeout(function() {
                    resendLink.classList.remove('disabled');
                    resendLink.textContent = "Didn't receive the token? Resend";
                }, 30000);
            });
            
            // Register link
            registerLink.addEventListener('click', function(e) {
                e.preventDefault();
                showAlert('Registration functionality would be implemented here', 'info');
            });
            
            // Functions
            function showInvalidTokenAlert() {
                invalidTokenAlert.style.display = 'flex';
                emailInput.focus();
            }
            
            function simulateSendEmail(email) {
                // Show loading state
                const submitBtn = emailForm.querySelector('button');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
                submitBtn.disabled = true;
                
                // Hide invalid token alert if it's showing
                invalidTokenAlert.style.display = 'none';
                
                // Simulate API call delay
                setTimeout(function() {
                    // In a real app, this would be an API call to send the magic link
                    console.log(`Magic link would be sent to: ${email}`);
                    
                    // Show success message
                    showAlert('Magic link sent to your email! Please check your inbox.', 'success');
                    
                    // Switch to token verification section
                    emailSection.style.display = 'none';
                    tokenSection.style.display = 'block';
                    headerMessage.textContent = 'Enter your verification token';
                    tokenSent = true;
                    
                    // Start countdown timer
                    startCountdown();
                    
                    // Reset button state
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Send Magic Link';
                    submitBtn.disabled = false;
                    
                    // Focus on token input
                    tokenInput.focus();
                }, 1500);
            }
            
            function simulateVerifyToken(token) {
                // Show loading state
                const submitBtn = tokenForm.querySelector('button');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying...';
                submitBtn.disabled = true;
                
                // Simulate API call delay
                setTimeout(function() {
                    // Randomly simulate valid or invalid token (for demo purposes)
                    const isValid = Math.random() > 0.3; // 70% chance of valid token
                    
                    if (isValid) {
                        // Token is valid
                        showAlert('Token verified successfully! Redirecting to dashboard...', 'success');
                        
                        // In a real app, you would redirect to the dashboard
                        setTimeout(function() {
                            alert('Redirecting to dashboard... (This is a demo)');
                            // Reset form for next user
                            resetForm();
                        }, 2000);
                    } else {
                        // Token is invalid - redirect to login with invalid_token parameter
                        window.location.href = window.location.pathname + '?invalid_token=true';
                    }
                }, 1500);
            }
            
            function showAlert(message, type) {
                // Clear previous alerts
                alertContainer.innerHTML = '';
                
                // Create new alert
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${type}`;
                
                let icon = '';
                if (type === 'success') {
                    icon = '<i class="fas fa-check-circle"></i> ';
                } else if (type === 'danger') {
                    icon = '<i class="fas fa-exclamation-circle"></i> ';
                } else if (type === 'info') {
                    icon = '<i class="fas fa-info-circle"></i> ';
                }
                
                alertDiv.innerHTML = icon + message;
                alertContainer.appendChild(alertDiv);
                
                // Auto-remove success alerts after 5 seconds
                if (type === 'success') {
                    setTimeout(function() {
                        if (alertDiv.parentNode) {
                            alertDiv.parentNode.removeChild(alertDiv);
                        }
                    }, 5000);
                }
            }
            
            function startCountdown() {
                timeLeft = 600; // Reset to 10 minutes
                updateTimerDisplay();
                
                clearInterval(countdown);
                countdown = setInterval(function() {
                    timeLeft--;
                    updateTimerDisplay();
                    
                    if (timeLeft <= 0) {
                        clearInterval(countdown);
                        showAlert('Token has expired. Please request a new one.', 'danger');
                        resendLink.classList.remove('disabled');
                        resendLink.textContent = "Token expired? Request a new one";
                    }
                }, 1000);
            }
            
            function resetTimer() {
                clearInterval(countdown);
                startCountdown();
            }
            
            function updateTimerDisplay() {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                countdownTimer.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                
                // Change color when less than 2 minutes remain
                if (timeLeft < 120) {
                    countdownTimer.style.color = 'var(--accent)';
                } else {
                    countdownTimer.style.color = 'var(--text-light)';
                }
            }
            
            function resetForm() {
                // Reset to initial state
                emailSection.style.display = 'block';
                tokenSection.style.display = 'none';
                headerMessage.textContent = 'Enter your email to receive a magic login link';
                emailInput.value = '';
                tokenInput.value = '';
                tokenInput.type = 'password';
                toggleTokenVisibility.innerHTML = '<i class="fas fa-eye"></i>';
                clearInterval(countdown);
                alertContainer.innerHTML = '';
                invalidTokenAlert.style.display = 'none';
                resendLink.classList.remove('disabled');
                resendLink.textContent = "Didn't receive the token? Resend";
                
                // Reset button states
                emailForm.querySelector('button').innerHTML = '<i class="fas fa-paper-plane"></i> Send Magic Link';
                emailForm.querySelector('button').disabled = false;
                tokenForm.querySelector('button').innerHTML = '<i class="fas fa-check"></i> Verify Token';
                tokenForm.querySelector('button').disabled = false;
                
                // Focus on email input
                emailInput.focus();
                
                // Remove invalid_token parameter from URL
                if (urlParams.has('invalid_token')) {
                    const newUrl = window.location.pathname;
                    window.history.replaceState({}, document.title, newUrl);
                }
            }
            
            // Initialize
            emailInput.focus();
        });
    </script>
</body>
</html>