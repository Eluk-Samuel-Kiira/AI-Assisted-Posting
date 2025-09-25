<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            padding: 40px 0;
            color: white;
        }
        
        .header h1 {
            font-size: 3rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .header p {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        .card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin: 20px 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        
        .stat-card {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin: 40px 0;
        }
        
        .feature {
            text-align: center;
            padding: 20px;
        }
        
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #667eea;
        }
        
        .cta-buttons {
            text-align: center;
            margin: 40px 0;
        }
        
        .btn {
            display: inline-block;
            padding: 15px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 50px;
            margin: 0 10px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
        }
        
        .btn:hover {
            background: #5a67d8;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .btn-secondary {
            background: transparent;
            border: 2px solid white;
            color: white;
        }
        
        .btn-secondary:hover {
            background: white;
            color: #667eea;
        }
        
        .footer {
            text-align: center;
            color: white;
            padding: 20px;
            margin-top: 40px;
            opacity: 0.8;
        }
        
        /* Modal Styles */
        #processingModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        
        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            max-width: 400px;
        }
        
        .modal-icon {
            font-size: 3rem;
            margin-bottom: 20px;
        }
        
        /* Results Container */
        #resultsContainer {
            margin: 20px 0;
        }
        
        .success-box {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }


        /* Modal Styles */
        #processingModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            max-width: 500px;
            width: 90%;
            position: relative;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        .modal-close {
            position: absolute;
            top: 15px;
            right: 20px;
            background: none;
            border: none;
            font-size: 28px;
            font-weight: bold;
            color: #999;
            cursor: pointer;
            padding: 5px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .modal-close:hover {
            color: #ff4757;
            background: #f8f9fa;
            transform: rotate(90deg);
        }

        .modal-icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .modal-content h3 {
            font-size: 1.8rem;
            margin-bottom: 15px;
            color: #333;
        }

        .modal-content p {
            font-size: 1.1rem;
            margin-bottom: 25px;
            color: #666;
        }

        /* Progress Bar */
        .progress-container {
            width: 100%;
            height: 8px;
            background: #f1f3f4;
            border-radius: 4px;
            margin: 25px 0;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 4px;
            transition: width 0.5s ease;
        }

        .processing-details {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            text-align: center;
        }

        .processing-details p {
            margin: 5px 0;
            font-size: 0.95rem;
        }

        #statusDetails {
            color: #667eea;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📧 LinkedIn Mail Processor</h1>
            <p>Automatically extract promotional emails from LinkedIn and store them in your database</p>
        </div>
        
        <div class="card">
            <h2>Welcome to Your Email Processing System</h2>
            <p>This application helps you collect, process, and analyze promotional emails sent from LinkedIn to your mailbox.</p>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number" id="processedCounter"><?= $stats['processed_emails'] ?></div>
                    <div class="stat-label">Emails Processed</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?= $stats['active_campaigns'] ?></div>
                    <div class="stat-label">Active Campaigns</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?= $stats['database_entries'] ?></div>
                    <div class="stat-label">Database Entries</div>
                </div>
            </div>
        </div>
        
        <!-- Results Container -->
        <div id="resultsContainer"></div>
        
        <div class="features">
            <div class="feature">
                <div class="feature-icon">📨</div>
                <h3>Email Collection</h3>
                <p>Automatically fetch promotional emails from your LinkedIn-connected mailbox</p>
            </div>
            <div class="feature">
                <div class="feature-icon">💾</div>
                <h3>Database Storage</h3>
                <p>Store extracted data in organized database tables for easy access</p>
            </div>
            <div class="feature">
                <div class="feature-icon">🌐</div>
                <h3>Web Integration</h3>
                <p>Display processed content on your website or application</p>
            </div>
        </div>
        
        <div class="cta-buttons">
            <button id="processBtn" class="btn">Start Processing Emails</button>
            <a href="<?= site_url('job-parser') ?>" class="btn btn-secondary">View Dashboard</a>

        </div>
    </div>
    
    <div class="footer">
        <p>&copy; 2024 LinkedIn Mail Processor. Built with CodeIgniter 4</p>
    </div>

    <!-- Processing Modal -->
    <div id="processingModal">
        <div class="modal-content">
            <!-- Close Button -->
            <button class="modal-close" onclick="closeModal()">×</button>
            
            <div class="modal-icon">⏳</div>
            <h3>Processing Emails</h3>
            <p id="processingMessage">Starting email processing...</p>
            
            <!-- Progress Bar -->
            <div class="progress-container">
                <div class="progress-bar" id="progressBar"></div>
            </div>
            
            <div class="processing-details">
                <p><small>This may take a few moments...</small></p>
                <p><small id="statusDetails">Initializing email processor</small></p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Processing modal
            const processingModal = document.getElementById('processingModal');
            const processBtn = document.getElementById('processBtn');
            const processingMessage = document.getElementById('processingMessage');
            const progressBar = document.getElementById('progressBar');
            const statusDetails = document.getElementById('statusDetails');
            const resultsContainer = document.getElementById('resultsContainer');
            
            // Close modal function
            window.closeModal = function() {
                processingModal.style.display = 'none';
            }
            
            if (processBtn) {
                processBtn.addEventListener('click', function() {
                    // Show processing modal
                    processingModal.style.display = 'flex';
                    processingMessage.innerHTML = '🔄 Connecting to email server...';
                    progressBar.style.width = '10%';
                    progressBar.style.background = '#4caf50';
                    statusDetails.textContent = 'Establishing secure connection...';
                    
                    // Make AJAX call to process emails
                    fetch('<?= site_url('process-email') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                        }
                    })
                    .then(response => {
                        progressBar.style.width = '40%';
                        statusDetails.textContent = 'Connected! Processing emails...';
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            progressBar.style.width = '80%';
                            processingMessage.innerHTML = '✅ ' + data.message;
                            statusDetails.textContent = 'Finalizing processing...';
                            
                            // Update stats after 2 seconds
                            setTimeout(() => {
                                progressBar.style.width = '100%';
                                
                                setTimeout(() => {
                                    processingModal.style.display = 'none';
                                    
                                    // Show success results
                                    resultsContainer.innerHTML = `
                                        <div class="success-box" style="padding:20px; background:#e8f9e8; border:1px solid #b2e0b2; border-radius:8px;">
                                            <h3>🎉 Processing Complete!</h3>
                                            <p>${data.message}</p>
                                            <p><strong>Processed:</strong> ${data.processed_count} emails</p>
                                            <p><strong>Time:</strong> ${data.processing_time}</p>
                                            <p><strong>New Total:</strong> ${data.new_total} emails processed</p>
                                        </div>
                                    `;
                                    
                                    // Update stats counter animation
                                    animateCounter('processedCounter', <?= $stats['processed_emails'] ?>, data.new_total);
                                }, 500);
                            }, 2000);
                        }
                    })
                    .catch(error => {
                        processingMessage.innerHTML = '❌ Error processing emails';
                        statusDetails.textContent = 'Please try again later';
                        progressBar.style.background = '#ff4757';
                        
                        setTimeout(() => {
                            processingModal.style.display = 'none';
                        }, 3000);
                        
                        console.error('Error:', error);
                    });
                });
            }
            
            // Counter animation function
            function animateCounter(elementId, start, end) {
                const element = document.getElementById(elementId);
                if (!element) return;
                
                let current = start;
                const duration = 2000;
                const increment = (end - start) / (duration / 50);
                
                const timer = setInterval(() => {
                    current += increment;
                    if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
                        current = end;
                        clearInterval(timer);
                    }
                    element.textContent = Math.round(current).toLocaleString();
                }, 50);
            }
            
            // Close modal when clicking outside
            processingModal.addEventListener('click', function(e) {
                if (e.target === processingModal) {
                    closeModal();
                }
            });
            
            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && processingModal.style.display === 'flex') {
                    closeModal();
                }
            });
        });
    </script>
</body>
</html>