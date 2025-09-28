<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - AI Powered Job Posting | LaFab Solution</title>

     <!-- Favicon References -->
    <link rel="icon" type="image/svg+xml" href="<?= base_url('favicon.svg') ?>">
    <link rel="shortcut icon" href="<?= base_url('favicon.svg') ?>" type="image/svg+xml">
    <link rel="apple-touch-icon" href="<?= base_url('favicon.svg') ?>">

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
            padding: 20px;
        }
        
        .register-container {
            background: white;
            border-radius: 15px;
            box-shadow: var(--shadow);
            overflow: hidden;
            max-width: 500px;
            width: 100%;
        }
        
        .register-header {
            background: var(--gradient);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
        }
        
        .register-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,202.7C672,203,768,181,864,170.7C960,160,1056,160,1152,170.7C1248,181,1344,203,1392,213.3L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
            background-size: cover;
            background-position: bottom;
        }
        
        .register-header-content {
            position: relative;
            z-index: 1;
        }
        
        .register-header h2 {
            margin: 0;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .register-header p {
            margin: 10px 0 0;
            opacity: 0.9;
        }
        
        .register-icon {
            font-size: 3rem;
            margin-bottom: 15px;
            color: white;
            opacity: 0.9;
        }
        
        .register-body {
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
        
        .input-group-text {
            background-color: #f8f9fa;
            border: 2px solid #e9ecef;
            border-right: none;
        }
        
        .form-control:focus + .input-group-text {
            border-color: var(--primary);
        }
        
        .btn-register {
            background: var(--gradient);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s;
            width: 100%;
            margin-top: 10px;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
        }
        
        .btn-register:active {
            transform: translateY(0);
        }
        
        .register-footer {
            text-align: center;
            padding: 20px;
            border-top: 1px solid #e9ecef;
            background: #f8f9fa;
        }
        
        .register-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }
        
        .register-footer a:hover {
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 8px;
            border: none;
            padding: 12px 15px;
            margin-bottom: 20px;
        }
        
        .alert-danger {
            background-color: #fadbd8;
            color: #e74c3c;
            border-left: 4px solid #e74c3c;
        }
        
        .alert-success {
            background-color: #d5f4e6;
            color: #27ae60;
            border-left: 4px solid #27ae60;
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
            font-weight: 500;
        }
        
        .back-to-home a:hover {
            text-decoration: underline;
        }
        
        .password-requirements {
            font-size: 0.85rem;
            color: var(--text-light);
            margin-top: 5px;
        }
        
        .requirement {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 3px;
        }
        
        .requirement i {
            font-size: 0.7rem;
        }
        
        .requirement.met {
            color: var(--success);
        }
        
        .requirement.unmet {
            color: var(--text-light);
        }
        
        .progress {
            height: 5px;
            margin-top: 10px;
        }
        
        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--secondary);
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <div class="register-header-content">
                <div class="register-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h2><i class="fas fa-robot"></i> Join LaFab AI Posting</h2>
                <p>Create your account to start automating job postings</p>
            </div>
        </div>
        
        <div class="register-body">
            <!-- Error Messages -->
            <?php if (session()->has('errors')): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <strong>Please correct the following:</strong>
                    <ul class="mb-0 mt-2">
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif ?>
            
            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?= session('error') ?>
                </div>
            <?php endif ?>
            
            <?php if (session()->has('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?= session('success') ?>
                </div>
            <?php endif ?>
            
            <form method="post" action="<?= base_url('auth/register') ?>">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" id="username" name="username" 
                               placeholder="Choose a username" value="<?= old('username') ?>" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="full_name" class="form-label">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        <input type="text" class="form-control" id="full_name" name="full_name" 
                               placeholder="Enter your full name" value="<?= old('full_name') ?>" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" 
                               placeholder="Enter your email address" value="<?= old('email') ?>" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="company" class="form-label">Company (Optional)</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                        <input type="text" class="form-control" id="company" name="company" 
                               placeholder="Your company name" value="<?= old('company') ?>">
                    </div>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                    <label class="form-check-label" for="terms">
                        I agree to the <a href="#" class="text-primary">Terms of Service</a> and <a href="#" class="text-primary">Privacy Policy</a>
                    </label>
                </div>
                
                <button type="submit" class="btn btn-register">
                    <i class="fas fa-paper-plane"></i> Register with Magic Link
                </button>
            </form>
        </div>
        
        <div class="register-footer">
            <p>Already have an account? <a href="<?= base_url('auth/login') ?>">Login here</a></p>
        </div>
    </div>
    
    <div class="back-to-home">
        <a href="<?= base_url() ?>"><i class="fas fa-arrow-left"></i> Back to Homepage</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const submitBtn = document.querySelector('.btn-register');
            const inputs = document.querySelectorAll('.form-control');
            
            // Add focus effects to inputs
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focus');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focus');
                });
            });
            
            // Form validation
            form.addEventListener('submit', function(e) {
                let isValid = true;
                const email = document.getElementById('email').value.trim();
                const username = document.getElementById('username').value.trim();
                const fullName = document.getElementById('full_name').value.trim();
                const terms = document.getElementById('terms').checked;
                
                // Basic validation
                if (!username) {
                    isValid = false;
                    showError('username', 'Username is required');
                }
                
                if (!fullName) {
                    isValid = false;
                    showError('full_name', 'Full name is required');
                }
                
                if (!email) {
                    isValid = false;
                    showError('email', 'Email is required');
                } else {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        isValid = false;
                        showError('email', 'Please enter a valid email address');
                    }
                }
                
                if (!terms) {
                    isValid = false;
                    alert('You must agree to the Terms of Service and Privacy Policy');
                }
                
                if (!isValid) {
                    e.preventDefault();
                } else {
                    // Change button text to indicate loading
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Account...';
                    submitBtn.disabled = true;
                }
            });
            
            function showError(fieldId, message) {
                const field = document.getElementById(fieldId);
                field.style.borderColor = '#e74c3c';
                
                // Remove existing error message
                let existingError = field.parentElement.nextElementSibling;
                if (existingError && existingError.classList.contains('error-message')) {
                    existingError.remove();
                }
                
                // Add error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message text-danger mt-1 small';
                errorDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> ' + message;
                field.parentElement.parentElement.appendChild(errorDiv);
            }
            
            // Real-time validation for username
            document.getElementById('username').addEventListener('input', function() {
                const username = this.value.trim();
                if (username.length > 0) {
                    this.style.borderColor = '#27ae60';
                    
                    // Remove error message if exists
                    const errorMsg = this.parentElement.parentElement.querySelector('.error-message');
                    if (errorMsg) errorMsg.remove();
                }
            });
            
            // Real-time validation for email
            document.getElementById('email').addEventListener('input', function() {
                const email = this.value.trim();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                
                if (email.length > 0 && emailRegex.test(email)) {
                    this.style.borderColor = '#27ae60';
                    
                    // Remove error message if exists
                    const errorMsg = this.parentElement.parentElement.querySelector('.error-message');
                    if (errorMsg) errorMsg.remove();
                }
            });
        });
    </script>
</body>
</html>