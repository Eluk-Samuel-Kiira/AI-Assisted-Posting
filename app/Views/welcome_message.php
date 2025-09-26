<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI-Powered Job Posting | LaFab Solution</title>
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
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f9fbfd;
            color: var(--text);
            line-height: 1.6;
            overflow-x: hidden;
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Header Styles */
        header {
            background: white;
            box-shadow: var(--shadow);
            position: fixed;
            width: 100%;
            z-index: 1000;
        }
        
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 24px;
            font-weight: 700;
            color: var(--secondary);
        }
        
        .logo i {
            color: var(--primary);
        }
        
        .nav-links {
            display: flex;
            gap: 30px;
        }
        
        .nav-links a {
            text-decoration: none;
            color: var(--text);
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .nav-links a:hover {
            color: var(--primary);
        }
        
        .login-btn {
            background: var(--gradient);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }
        
        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
        }
        
        /* Hero Section */
        .hero {
            padding: 160px 0 100px;
            background: var(--gradient);
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
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
        
        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        
        .hero p {
            font-size: 1.3rem;
            margin-bottom: 30px;
            opacity: 0.9;
        }
        
        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 40px;
        }
        
        .btn {
            padding: 15px 35px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
            cursor: pointer;
        }
        
        .btn-primary {
            background: white;
            color: var(--primary);
            box-shadow: 0 4px 15px rgba(255,255,255,0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255,255,255,0.4);
        }
        
        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }
        
        .btn-secondary:hover {
            background: white;
            color: var(--primary);
        }
        
        /* Features Section */
        .features {
            padding: 100px 0;
            background: white;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }
        
        .section-title h2 {
            font-size: 2.5rem;
            color: var(--secondary);
            margin-bottom: 15px;
        }
        
        .section-title p {
            color: var(--text-light);
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
        }
        
        .feature-card {
            background: white;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: var(--shadow);
            text-align: center;
            transition: transform 0.3s;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            background: var(--gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            color: white;
            font-size: 2rem;
        }
        
        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--secondary);
        }
        
        .feature-card p {
            color: var(--text-light);
        }
        
        /* How It Works */
        .how-it-works {
            padding: 100px 0;
            background: #f5f9ff;
        }
        
        .steps {
            display: flex;
            justify-content: space-between;
            position: relative;
            max-width: 900px;
            margin: 60px auto 0;
        }
        
        .steps::before {
            content: '';
            position: absolute;
            top: 40px;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--primary);
            z-index: 1;
        }
        
        .step {
            text-align: center;
            position: relative;
            z-index: 2;
            flex: 1;
        }
        
        .step-number {
            width: 80px;
            height: 80px;
            background: white;
            border: 3px solid var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
        }
        
        .step h3 {
            margin-bottom: 10px;
            color: var(--secondary);
        }
        
        .step p {
            color: var(--text-light);
            max-width: 250px;
            margin: 0 auto;
        }
        
        /* Benefits Section */
        .benefits {
            padding: 100px 0;
            background: white;
        }
        
        .benefits-content {
            display: flex;
            align-items: center;
            gap: 60px;
        }
        
        .benefits-text {
            flex: 1;
        }
        
        .benefits-text h2 {
            font-size: 2.5rem;
            color: var(--secondary);
            margin-bottom: 25px;
        }
        
        .benefits-text p {
            color: var(--text-light);
            margin-bottom: 30px;
            font-size: 1.1rem;
        }
        
        .benefits-list {
            list-style: none;
        }
        
        .benefits-list li {
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }
        
        .benefits-list i {
            color: var(--success);
            font-size: 1.2rem;
            margin-top: 3px;
        }
        
        .benefits-visual {
            flex: 1;
            text-align: center;
        }
        
        .benefits-visual img {
            max-width: 100%;
            border-radius: 15px;
            box-shadow: var(--shadow);
        }
        
        /* CTA Section */
        .cta-section {
            padding: 100px 0;
            background: var(--gradient);
            color: white;
            text-align: center;
        }
        
        .cta-section h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        
        .cta-section p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 40px;
            opacity: 0.9;
        }
        
        /* Footer */
        footer {
            background: var(--secondary);
            color: white;
            padding: 60px 0 30px;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .footer-column h3 {
            font-size: 1.3rem;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-column h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--primary);
        }
        
        .footer-column p {
            opacity: 0.8;
            margin-bottom: 20px;
        }
        
        .footer-links {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 12px;
        }
        
        .footer-links a {
            color: white;
            text-decoration: none;
            opacity: 0.8;
            transition: opacity 0.3s;
        }
        
        .footer-links a:hover {
            opacity: 1;
        }
        
        .copyright {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.1);
            opacity: 0.7;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .hero h1 {
                font-size: 2.8rem;
            }
            
            .benefits-content {
                flex-direction: column;
            }
            
            .steps {
                flex-direction: column;
                gap: 40px;
            }
            
            .steps::before {
                display: none;
            }
        }
        
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            
            .hero h1 {
                font-size: 2.2rem;
            }
            
            .hero p {
                font-size: 1.1rem;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn {
                width: 100%;
                max-width: 300px;
                text-align: center;
            }
        }
        
        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in {
            animation: fadeInUp 0.8s ease-out;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <nav>
                <div class="logo">
                    <i class="fas fa-robot"></i>
                    <span>LaFab AI Posting</span>
                </div>
                <div class="nav-links">
                    <a href="#features">Features</a>
                    <a href="#how-it-works">How It Works</a>
                    <a href="#benefits">Benefits</a>
                    <a href="#contact">Contact</a>
                </div>
                <button class="login-btn" onclick="scrollToLogin()">Login</button>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content fade-in">
                <h1>Revolutionize Your Hiring with AI-Powered Job Posting</h1>
                <p>Automate, optimize, and accelerate your recruitment process with minimal human intervention. LaFab Solution's AI technology creates compelling job descriptions that attract top talent.</p>
                <div class="cta-buttons">
                    <a href="#cta" class="btn btn-primary">Get Started Free</a>
                    <a href="#how-it-works" class="btn btn-secondary">Learn More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features">
        <div class="container">
            <div class="section-title">
                <h2>Powerful Features</h2>
                <p>Our AI-powered platform is designed to streamline your entire job posting workflow</p>
            </div>
            <div class="features-grid">
                <div class="feature-card fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3>Lightning Fast</h3>
                    <p>Generate optimized job postings in seconds, not hours. Reduce your time-to-hire significantly.</p>
                </div>
                <div class="feature-card fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h3>AI-Optimized</h3>
                    <p>Our advanced algorithms create compelling job descriptions that attract qualified candidates.</p>
                </div>
                <div class="feature-card fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Performance Tracking</h3>
                    <p>Monitor application rates and optimize your postings based on real performance data.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="how-it-works">
        <div class="container">
            <div class="section-title">
                <h2>How It Works</h2>
                <p>Transforming job posting from a time-consuming task to an automated process</p>
            </div>
            <div class="steps">
                <div class="step fade-in">
                    <div class="step-number">1</div>
                    <h3>Input Job Details</h3>
                    <p>Provide basic information about the position, skills required, and company culture.</p>
                </div>
                <div class="step fade-in">
                    <div class="step-number">2</div>
                    <h3>AI Generation</h3>
                    <p>Our AI analyzes your requirements and creates multiple optimized job description options.</p>
                </div>
                <div class="step fade-in">
                    <div class="step-number">3</div>
                    <h3>Review & Post</h3>
                    <p>Select your preferred version, make any tweaks, and publish across multiple platforms instantly.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="benefits" class="benefits">
        <div class="container">
            <div class="benefits-content">
                <div class="benefits-text">
                    <h2>Why Choose Our AI Job Posting Tool?</h2>
                    <p>LaFab Solution's AI technology is designed specifically to address the challenges of modern recruitment.</p>
                    <ul class="benefits-list">
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong>Save 80% of Your Time</strong>
                                <p>Reduce job description creation from hours to minutes</p>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong>Improve Candidate Quality</strong>
                                <p>AI-optimized postings attract more qualified applicants</p>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong>Consistent Brand Voice</strong>
                                <p>Maintain consistent messaging across all your job postings</p>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong>Multi-Platform Publishing</strong>
                                <p>Post to multiple job boards with a single click</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="benefits-visual">
                    <!-- Placeholder for an illustration -->
                    <div style="background: var(--gradient); height: 300px; border-radius: 15px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                        <i class="fas fa-chart-bar" style="font-size: 4rem; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="cta" class="cta-section">
        <div class="container">
            <h2>Ready to Transform Your Hiring Process?</h2>
            <p>Join hundreds of companies already using LaFab AI Posting to streamline their recruitment and find better candidates faster.</p>
            <button class="login-btn" onclick="scrollToLogin()" style="font-size: 1.2rem; padding: 18px 45px;">Start Posting with AI</button>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>LaFab AI Posting</h3>
                    <p>Revolutionizing recruitment through AI-powered automation and optimization.</p>
                    <p>LaFab Solution Company Limited</p>
                </div>
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="#features">Features</a></li>
                        <li><a href="#how-it-works">How It Works</a></li>
                        <li><a href="#benefits">Benefits</a></li>
                        <li><a href="#contact">Contact Us</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Contact Info</h3>
                    <ul class="footer-links">
                        <li><i class="fas fa-envelope"></i> admin@lafabsolution.com</li>
                        <li><i class="fas fa-phone"></i> +256 704 912354</li>
                        <li><i class="fas fa-map-marker-alt"></i> Kampala, Uganda</li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2025 LaFab Solution Company Limited. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Simple scroll animation for elements
        function isElementInViewport(el) {
            const rect = el.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }
        
        function handleScrollAnimation() {
            const elements = document.querySelectorAll('.fade-in');
            elements.forEach(el => {
                if (isElementInViewport(el)) {
                    el.style.opacity = 1;
                    el.style.transform = 'translateY(0)';
                }
            });
        }
        
        // Initialize elements for animation
        document.querySelectorAll('.fade-in').forEach(el => {
            el.style.opacity = 0;
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
        });
        
        // Scroll to login function
        function scrollToLogin() {
            // In a real implementation, this would redirect to the login page
            // alert('Redirecting to login page...');
            window.location.href = '/auth/login'; // Uncomment in actual implementation
        }
        
        // Handle scroll events
        window.addEventListener('scroll', handleScrollAnimation);
        window.addEventListener('load', handleScrollAnimation);
        
        // Initial check on page load
        document.addEventListener('DOMContentLoaded', handleScrollAnimation);
    </script>
</body>
</html>