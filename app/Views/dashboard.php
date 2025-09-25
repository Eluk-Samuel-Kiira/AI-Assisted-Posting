<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Description Parser</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .upload-area {
            border: 3px dashed #ccc;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            margin: 20px 0;
            background: #f9f9f9;
            transition: all 0.3s;
        }
        
        .upload-area:hover {
            border-color: #667eea;
            background: #f0f4ff;
        }
        
        .results-area {
            display: none;
            margin-top: 30px;
        }
        
        .log-container {
            max-height: 300px;
            overflow-y: auto;
            background: #2c3e50;
            color: #ecf0f1;
            padding: 15px;
            border-radius: 5px;
            font-family: monospace;
        }
        
        .spinner {
            display: none;
            width: 3rem;
            height: 3rem;
            margin: 20px auto;
        }
        
        .formatted-data {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .api-key-container {
            margin-bottom: 20px;
        }
        
        .nav-tabs .nav-link.active {
            background-color: #f8f9fa;
            border-bottom: 1px solid #f8f9fa;
        }
        
        .prompt-presets {
            margin-top: 15px;
        }
        
        .preset-btn {
            margin-right: 8px;
            margin-bottom: 8px;
        }
        
        .whatsapp-textarea {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 150px;
        }
        
        .api-status {
            margin-top: 5px;
            font-size: 0.9rem;
        }
        
        .image-preview {
            max-width: 100%;
            max-height: 300px;
            margin-top: 15px;
            border-radius: 5px;
            display: none;
        }
        
        .ocr-progress {
            margin-top: 10px;
        }
        
        .progress {
            height: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="<?= site_url('/') ?>" class="back-btn">← Back to Home</a>
        
        <div class="header">
            <h1>📋 Job Description Parser</h1>
            <p>Extract job details from files, images, or WhatsApp messages using AI</p>
        </div>
        
        <div class="content">
            <div class="api-key-container">
                <div class="alert alert-info">
                    <h5><i class="fas fa-key"></i> OpenRouter API Key Required</h5>
                    <p>You need an API key from <a href="https://openrouter.ai/" target="_blank">OpenRouter</a> to use this tool.</p>
                    <div class="mb-3">
                        <label for="apiKey" class="form-label">Your OpenRouter API Key:</label>
                        <input type="password" class="form-control" id="apiKey" placeholder="Enter your API key" value="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">
                        <div class="api-status" id="apiKeyStatus"></div>
                    </div>
                </div>
            </div>
            
            <ul class="nav nav-tabs" id="inputTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="file-tab" data-bs-toggle="tab" data-bs-target="#file" type="button" role="tab">File Upload</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="text-tab" data-bs-toggle="tab" data-bs-target="#text" type="button" role="tab">Text Input</button>
                </li>
            </ul>
            
            <div class="tab-content p-3 border border-top-0 rounded-bottom" id="inputTabsContent">
                <div class="tab-pane fade show active" id="file" role="tabpanel">
                    <div class="upload-area">
                        <h4><i class="fas fa-file-upload"></i> Upload Job Description</h4>
                        <p class="text-muted">Supported formats: TXT, PDF, DOC, DOCX, PNG, JPEG, JPG</p>
                        <input type="file" id="fileInput" class="form-control" accept=".txt,.pdf,.doc,.docx,.png,.jpeg,.jpg">
                        <img id="imagePreview" class="image-preview" alt="Image preview">
                        <div id="ocrProgress" class="ocr-progress" style="display: none;">
                            <div class="d-flex justify-content-between">
                                <small>OCR Progress:</small>
                                <small id="ocrProgressText">0%</small>
                            </div>
                            <div class="progress">
                                <div id="ocrProgressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="text" role="tabpanel">
                    <div class="mb-3">
                        <label for="whatsappText" class="form-label">Paste Job Description:</label>
                        <textarea class="form-control whatsapp-textarea" id="whatsappText" rows="6" placeholder="Paste job description text here..."></textarea>
                    </div>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Customize Extraction Prompt</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="customPrompt" class="form-label">AI Prompt:</label>
                        <textarea class="form-control" id="customPrompt" rows="3">Extract the following fields from job descriptions: company_name, job_title, role, responsibilities, requirements, location, salary_range, and contact_email. Always return a valid JSON object with these fields. If a field is not found, set it to an empty string.</textarea>
                    </div>
                    
                    <div class="prompt-presets">
                        <small class="text-muted">Quick presets:</small><br>
                        <button class="btn btn-sm btn-outline-secondary preset-btn" data-preset="standard">Standard Extraction</button>
                        <button class="btn btn-sm btn-outline-secondary preset-btn" data-preset="detailed">Detailed Extraction</button>
                        <button class="btn btn-sm btn-outline-secondary preset-btn" data-preset="minimal">Minimal Fields</button>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <button id="processBtn" class="btn btn-primary btn-lg"><i class="fas fa-cogs"></i> Process Job Description</button>
            </div>
            
            <div class="spinner-border text-primary spinner" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            
            <div id="resultsArea" class="results-area">
                <h3><i class="fas fa-file-alt"></i> Extracted Information</h3>
                <div id="formattedData" class="formatted-data"></div>
                
                <h4 class="mt-4"><i class="fas fa-list"></i> API Log</h4>
                <div id="logContainer" class="log-container"></div>
                
                <div class="text-center mt-4">
                    <button id="saveToDbBtn" class="btn btn-success"><i class="fas fa-database"></i> Save to Database</button>
                    <button id="copyJsonBtn" class="btn btn-info"><i class="fas fa-copy"></i> Copy JSON</button>
                    <button id="resetBtn" class="btn btn-outline-secondary"><i class="fas fa-redo"></i> Reset</button>
                </div>
                <div id="saveResult" class="mt-3"></div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Using a more stable version of Tesseract.js -->
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@4/dist/tesseract.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('fileInput');
            const imagePreview = document.getElementById('imagePreview');
            const whatsappText = document.getElementById('whatsappText');
            const apiKeyInput = document.getElementById('apiKey');
            const apiKeyStatus = document.getElementById('apiKeyStatus');
            const customPrompt = document.getElementById('customPrompt');
            const processBtn = document.getElementById('processBtn');
            const spinner = document.querySelector('.spinner');
            const resultsArea = document.getElementById('resultsArea');
            const logContainer = document.getElementById('logContainer');
            const formattedData = document.getElementById('formattedData');
            const saveToDbBtn = document.getElementById('saveToDbBtn');
            const copyJsonBtn = document.getElementById('copyJsonBtn');
            const resetBtn = document.getElementById('resetBtn');
            const saveResult = document.getElementById('saveResult');
            const ocrProgress = document.getElementById('ocrProgress');
            const ocrProgressBar = document.getElementById('ocrProgressBar');
            const ocrProgressText = document.getElementById('ocrProgressText');
            
            let extractedData = null;
            let activeTab = 'file';
            let ocrWorker = null;
            
            // Initialize Tesseract worker
            async function initOCR() {
                try {
                    logMessage('Initializing OCR engine...');
                    ocrWorker = await Tesseract.createWorker('eng');
                    await ocrWorker.initialize('eng');
                    logMessage('OCR engine ready');
                } catch (error) {
                    logMessage('Error initializing OCR: ' + error.message);
                    console.error('OCR initialization error:', error);
                }
            }
            
            // Initialize OCR on page load
            initOCR();
            
            // Show image preview when an image is selected
            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.style.display = 'none';
                }
            });
            
            // Validate API key format
            apiKeyInput.addEventListener('input', function() {
                const key = this.value.trim();
                if (key.startsWith('sk-or-v1-') && key.length > 50) {
                    apiKeyStatus.innerHTML = '<span class="text-success"><i class="fas fa-check-circle"></i> Valid API key format</span>';
                } else if (key.length > 0) {
                    apiKeyStatus.innerHTML = '<span class="text-danger"><i class="fas fa-exclamation-circle"></i> Invalid API key format</span>';
                } else {
                    apiKeyStatus.innerHTML = '';
                }
            });
            
            // Trigger validation on page load
            if (apiKeyInput.value) {
                apiKeyInput.dispatchEvent(new Event('input'));
            }
            
            // Set up tab switching
            document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
                tab.addEventListener('shown.bs.tab', event => {
                    activeTab = event.target.id.split('-')[0];
                });
            });
            
            // Set up prompt presets
            document.querySelectorAll('.preset-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const preset = this.getAttribute('data-preset');
                    
                    switch(preset) {
                        case 'standard':
                            customPrompt.value = 'Extract the following fields from job descriptions: company_name, job_title, role, responsibilities, requirements, location, salary_range, and contact_email. Always return a valid JSON object with these fields. If a field is not found, set it to an empty string.';
                            break;
                        case 'detailed':
                            customPrompt.value = 'Extract detailed job information including: company_name, job_title, role, department, responsibilities, requirements, qualifications, experience_level, location, remote_policy, salary_range, benefits, application_deadline, contact_email, and application_process. Return a comprehensive JSON object with all these fields.';
                            break;
                        case 'minimal':
                            customPrompt.value = 'Extract only the most essential job details: company_name, job_title, location, and contact_email. Return a concise JSON object with these fields.';
                            break;
                    }
                    
                    logMessage(`Prompt preset applied: ${preset}`);
                });
            });
            
            // Log messages to the log container
            function logMessage(message) {
                const logEntry = document.createElement('div');
                logEntry.textContent = '> ' + message;
                logContainer.appendChild(logEntry);
                logContainer.scrollTop = logContainer.scrollHeight;
            }
            
            // Format extracted data for display
            function formatData(data) {
                let html = '<div class="row">';
                
                for (const [key, value] of Object.entries(data)) {
                    let displayValue = value;
                    
                    if (Array.isArray(value)) {
                        displayValue = '<ul>' + value.map(item => `<li>${item}</li>`).join('') + '</ul>';
                    } else if (typeof value === 'object' && value !== null) {
                        displayValue = JSON.stringify(value, null, 2);
                    } else if (!value) {
                        displayValue = 'Not specified';
                    }
                    
                    html += `
                        <div class="col-md-6 mb-3">
                            <strong>${key.replace(/_/g, ' ').toUpperCase()}:</strong>
                            <div>${displayValue}</div>
                        </div>
                    `;
                }
                
                html += '</div>';
                return html;
            }
            
            // Read file as text
            function readFileAsText(file) {
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        resolve(e.target.result);
                    };
                    
                    reader.onerror = function(e) {
                        reject(new Error('Failed to read file: ' + e.target.error));
                    };
                    
                    reader.readAsText(file);
                });
            }
            
            // Extract text from image using OCR
            async function extractTextFromImage(file) {
                logMessage('Extracting text from image using OCR...');
                ocrProgress.style.display = 'block';
                ocrProgressBar.style.width = '0%';
                ocrProgressText.textContent = '0%';
                
                try {
                    const result = await Tesseract.recognize(
                        file,
                        'eng',
                        { 
                            logger: progress => {
                                if (progress.status === 'recognizing text') {
                                    const percent = Math.round(progress.progress * 100);
                                    ocrProgressBar.style.width = percent + '%';
                                    ocrProgressText.textContent = percent + '%';
                                    logMessage(`OCR Progress: ${percent}%`);
                                }
                            }
                        }
                    );
                    
                    ocrProgressBar.style.width = '100%';
                    ocrProgressText.textContent = '100%';
                    logMessage('OCR extraction completed');
                    return result.data.text;
                } catch (error) {
                    logMessage('OCR Error: ' + error.message);
                    throw new Error('Failed to extract text from image: ' + error.message);
                } finally {
                    setTimeout(() => {
                        ocrProgress.style.display = 'none';
                    }, 2000);
                }
            }
            
            // Process job description
            processBtn.addEventListener('click', async function() {
                const apiKey = apiKeyInput.value.trim();
                const prompt = customPrompt.value.trim();
                
                if (!apiKey) {
                    alert('Please enter your OpenRouter API key');
                    return;
                }
                
                if (!apiKey.startsWith('sk-or-v1-')) {
                    alert('Invalid API key format. It should start with "sk-or-v1-"');
                    return;
                }
                
                if (!prompt) {
                    alert('Please enter a prompt for the AI');
                    return;
                }
                
                let content = '';
                
                if (activeTab === 'file') {
                    const file = fileInput.files[0];
                    if (!file) {
                        alert('Please select a file first');
                        return;
                    }
                    
                    try {
                        // Check if it's an image file
                        if (file.type.startsWith('image/')) {
                            content = await extractTextFromImage(file);
                        } else {
                            // For text-based files
                            content = await readFileAsText(file);
                        }
                    } catch (error) {
                        alert('Error reading file: ' + error.message);
                        return;
                    }
                } else {
                    content = whatsappText.value.trim();
                    if (!content) {
                        alert('Please enter job description text');
                        return;
                    }
                }
                
                // Reset UI
                logContainer.innerHTML = '';
                resultsArea.style.display = 'none';
                spinner.style.display = 'block';
                saveResult.innerHTML = '';
                
                logMessage('Starting processing...');
                logMessage('Content to process: ' + content.substring(0, 200) + (content.length > 200 ? '...' : ''));
                
                try {
                    logMessage('Sending to OpenRouter API...');
                    
                    // Send to OpenRouter API for processing
                    const response = await fetch('https://openrouter.ai/api/v1/chat/completions', {
                        method: 'POST',
                        headers: {
                            'Authorization': 'Bearer ' + apiKey,
                            'HTTP-Referer': window.location.href,
                            'X-Title': 'Job Description Parser',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            model: 'google/gemini-pro-1.5', // Free model that works well
                            messages: [
                                {
                                    role: 'system',
                                    content: prompt
                                },
                                {
                                    role: 'user',
                                    content: "Extract job information from this text: " + content.substring(0, 4000) // Limit content length
                                }
                            ],
                            temperature: 0.1
                        })
                    });
                    
                    if (!response.ok) {
                        const errorText = await response.text();
                        logMessage('API Error Response: ' + errorText);
                        
                        let errorMessage = `API error: ${response.status} ${response.statusText}`;
                        try {
                            const errorData = JSON.parse(errorText);
                            errorMessage = errorData.error?.message || errorMessage;
                        } catch (e) {
                            // Couldn't parse JSON, use the text as is
                        }
                        
                        throw new Error(errorMessage);
                    }
                    
                    const data = await response.json();
                    logMessage('Received response from OpenRouter API');
                    
                    // Check if choices array exists and has at least one element
                    if (!data.choices || data.choices.length === 0) {
                        throw new Error('Invalid response format from API: No choices found');
                    }
                    
                    // Extract JSON from response
                    const responseContent = data.choices[0].message.content;
                    logMessage('Processing response...');
                    
                    // Try to parse JSON from the response
                    try {
                        // Look for JSON pattern in the response
                        const jsonMatch = responseContent.match(/\{[\s\S]*\}/);
                        if (jsonMatch) {
                            extractedData = JSON.parse(jsonMatch[0]);
                            logMessage('Data extracted successfully!');
                            
                            // Display formatted data
                            formattedData.innerHTML = formatData(extractedData);
                            resultsArea.style.display = 'block';
                        } else {
                            throw new Error('No JSON found in response. Raw response: ' + responseContent);
                        }
                    } catch (e) {
                        logMessage('Error parsing response: ' + e.message);
                    }
                    
                } catch (error) {
                    logMessage('Error: ' + error.message);
                    console.error('Full error details:', error);
                } finally {
                    spinner.style.display = 'none';
                }
            });
            
            // Save to database
            saveToDbBtn.addEventListener('click', async function() {
                if (!extractedData) {
                    alert('No data to save. Please process a job description first.');
                    return;
                }
                
                saveResult.innerHTML = '<div class="alert alert-info">Saving to database...</div>';
                logMessage('Sending data to server...');
                
                try {
                    // Send to CodeIgniter backend to save to database
                    const response = await fetch('<?= site_url('job-parser/save') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify(extractedData)
                    });
                    
                    const result = await response.json();
                    
                    if (response.ok && result.success) {
                        saveResult.innerHTML = '<div class="alert alert-success">Data successfully saved to database!</div>';
                        logMessage('Data saved to database successfully.');
                    } else {
                        throw new Error(result.message || 'Failed to save data');
                    }
                    
                } catch (error) {
                    saveResult.innerHTML = '<div class="alert alert-danger">Error saving to database: ' + error.message + '</div>';
                    logMessage('Error saving to database: ' + error.message);
                }
            });
            
            // Copy JSON to clipboard
            copyJsonBtn.addEventListener('click', function() {
                if (!extractedData) {
                    alert('No data to copy. Please process a job description first.');
                    return;
                }
                
                const jsonString = JSON.stringify(extractedData, null, 2);
                navigator.clipboard.writeText(jsonString).then(() => {
                    alert('JSON copied to clipboard!');
                }).catch(err => {
                    alert('Failed to copy JSON: ' + err);
                });
            });
            
            // Reset form
            resetBtn.addEventListener('click', function() {
                fileInput.value = '';
                imagePreview.style.display = 'none';
                whatsappText.value = '';
                resultsArea.style.display = 'none';
                logContainer.innerHTML = '';
                saveResult.innerHTML = '';
                extractedData = null;
            });
            
            // Clean up OCR worker when page is unloaded
            window.addEventListener('beforeunload', async () => {
                if (ocrWorker) {
                    await ocrWorker.terminate();
                }
            });
        });
    </script>
</body>
</html>

