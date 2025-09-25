<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Advert Analyzer</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f0f2f5;
            color: #333;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 10px;
        }
        .subtitle {
            text-align: center;
            color: #7f8c8d;
            margin-bottom: 30px;
        }
        .input-group {
            margin-bottom: 20px;
        }
        textarea {
            width: 100%;
            height: 180px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            resize: vertical;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        textarea:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }
        button {
            background-color: #3498db;
            color: white;
            padding: 14px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            margin-bottom: 20px;
            transition: background-color 0.3s, transform 0.2s;
        }
        button:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        button:active {
            transform: translateY(0);
        }
        button:disabled {
            background-color: #bdc3c7;
            cursor: not-allowed;
            transform: none;
        }
        .response {
            margin-top: 30px;
            padding: 25px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border-left: 5px solid #3498db;
            transition: all 0.3s;
        }
        .loading {
            text-align: center;
            color: #7f8c8d;
            padding: 30px;
            font-size: 18px;
        }
        .error {
            border-color: #e74c3c;
            color: #c0392b;
            background-color: #fadbd8;
        }
        .success {
            border-color: #27ae60;
            background-color: #d5f4e6;
        }
        .usage-info {
            margin-top: 15px;
            padding: 12px;
            background-color: #e9ecef;
            border-radius: 6px;
            font-size: 14px;
            color: #495057;
        }
        .message-content {
            line-height: 1.6;
            white-space: pre-wrap;
        }
        .json-output {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 15px;
            border-radius: 6px;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            margin-top: 15px;
            max-height: 500px;
            overflow-y: auto;
        }
        .job-details {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .job-details h3 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-top: 0;
        }
        .detail-item {
            margin-bottom: 10px;
            display: flex;
        }
        .detail-label {
            font-weight: 600;
            min-width: 180px;
            color: #34495e;
        }
        .detail-value {
            flex: 1;
        }
        .list-item {
            margin-bottom: 5px;
            padding-left: 15px;
            position: relative;
        }
        .list-item:before {
            content: "•";
            color: #3498db;
            position: absolute;
            left: 0;
        }
        .tabs {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }
        .tab {
            padding: 12px 20px;
            cursor: pointer;
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-bottom: none;
            border-radius: 5px 5px 0 0;
            margin-right: 5px;
            transition: background 0.3s;
        }
        .tab.active {
            background: #3498db;
            color: white;
            border-color: #3498db;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        .sample-text {
            font-size: 14px;
            color: #7f8c8d;
            margin-top: 10px;
            cursor: pointer;
            text-decoration: underline;
        }
        .save-section {
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 5px solid #27ae60;
        }
        .save-button {
            background-color: #27ae60;
            width: auto;
            margin-bottom: 10px;
            padding: 12px 25px;
        }
        .save-button:hover {
            background-color: #219653;
        }
        .save-button:disabled {
            background-color: #95a5a6;
        }
        .save-status {
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            text-align: center;
            font-weight: 600;
        }
        .save-success {
            background-color: #d5f4e6;
            color: #27ae60;
            border: 1px solid #27ae60;
        }
        .save-error {
            background-color: #fadbd8;
            color: #e74c3c;
            border: 1px solid #e74c3c;
        }
        .backend-url-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .backend-url-input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Job Advert Analyzer</h1>
        <p class="subtitle">Extract structured job information from text using AI</p>
        
        <div class="input-group">
            <label for="messageInput"><strong>Paste job advertisement text:</strong></label>
            <textarea id="messageInput" placeholder="Paste job advertisement text here..."></textarea>
            <div class="sample-text" onclick="loadSampleText()">Load sample job advertisement text</div>
        </div>
        
        <!-- <div class="input-group">
            <label for="backendUrl"><strong>Backend API URL (CodeIgniter):</strong></label>
            <input type="text" id="backendUrl" class="backend-url-input" placeholder="https://yourdomain.com/api/jobs/save" value="">
            <small>Leave empty to use default: /api/jobs/save</small>
        </div> -->
        
        <button id="sendButton" onclick="analyzeJobAdvert()">Analyze Job Advertisement</button>
        
        <div id="responseArea"></div>
        
        <!-- This section will be shown after analysis -->
        <div id="saveSection" style="display: none;" class="save-section">
            <h3>Save to Backend</h3>
            <button id="saveButton" class="save-button" onclick="saveToBackend()">Save to Backend (CodeIgniter)</button>
            <div id="saveStatus"></div>
        </div>
    </div>

    <script>
        // Sample job advertisement text
        const sampleJobText = `Software Engineer at TechSolutions Inc.

            We are looking for a skilled Software Engineer to join our dynamic team at TechSolutions Inc. This is a full-time position based in San Francisco, CA, with the option for remote work.

            Job Description:
            As a Software Engineer, you will be responsible for designing, developing, and maintaining high-quality software solutions. You will collaborate with cross-functional teams to define, design, and ship new features.

            Key Responsibilities:
            - Design and build advanced applications
            - Collaborate with cross-functional teams to define, design, and ship new features
            - Work with outside data sources and APIs
            - Unit-test code for robustness, including edge cases, usability, and general reliability
            - Work on bug fixing and improving application performance

            Requirements:
            - Bachelor's degree in Computer Science or related field
            - 3+ years of software development experience
            - Proficiency in JavaScript, Python, or Java
            - Experience with cloud platforms (AWS, Azure, or GCP)
            - Strong problem-solving skills and ability to work in a team environment

            Preferred Qualifications:
            - Experience with React or Angular
            - Knowledge of database systems (SQL and NoSQL)
            - Familiarity with Agile development methodologies

            Salary and Benefits:
            - Competitive salary range: $120,000 - $150,000 per year
            - Comprehensive health, dental, and vision insurance
            - 401(k) with company matching
            - Flexible work hours and remote work options
            - Professional development opportunities

            Application Deadline: December 15, 2023

            To apply, please send your resume to careers@techsolutions.com or apply through our website.`;

        // Store the current job data globally
        let currentJobData = null;
        let currentOriginalText = '';

        function loadSampleText() {
            document.getElementById('messageInput').value = sampleJobText;
        }

        async function analyzeJobAdvert() {
            const messageInput = document.getElementById('messageInput');
            const sendButton = document.getElementById('sendButton');
            const responseArea = document.getElementById('responseArea');
            const saveSection = document.getElementById('saveSection');
            
            const jobText = messageInput.value.trim();
            
            if (!jobText) {
                alert('Please enter job advertisement text');
                return;
            }
            
            // Hide save section initially
            saveSection.style.display = 'none';
            
            // Disable button and show loading
            sendButton.disabled = true;
            sendButton.textContent = 'Analyzing...';
            responseArea.innerHTML = '<div class="loading">Analyzing job advertisement with AI...</div>';
            
            try {
                // Create the extensive prompt for job analysis
                const prompt = `Extract and structure all information from the following job advertisement into a comprehensive JSON object. 

                    IMPORTANT: Return ONLY valid JSON without any additional text, explanations, or markdown formatting.

                    Required JSON structure:
                    {
                    "jobTitle": "string",
                    "company": "string",
                    "jobDescription": "string",
                    "responsibilities": ["array of strings"],
                    "requirements": ["array of strings"],
                    "preferredQualifications": ["array of strings"],
                    "skills": ["array of strings"],
                    "salaryRange": "string",
                    "location": "string",
                    "employmentType": "string (e.g., Full-time, Part-time, Contract)",
                    "workArrangement": "string (e.g., On-site, Remote, Hybrid)",
                    "applicationDeadline": "string",
                    "contactInfo": "string",
                    "benefits": ["array of strings"],
                    "experienceLevel": "string (e.g., Entry-level, Mid-level, Senior)",
                    "educationRequirements": "string"
                    }

                    Rules for extraction:
                    1. Extract the job title exactly as mentioned
                    2. Identify the company name if mentioned
                    3. Summarize the job description in 2-3 sentences
                    4. List all responsibilities as separate array items
                    5. List all requirements as separate array items
                    6. List preferred qualifications separately from requirements
                    7. Extract specific skills mentioned (programming languages, tools, etc.)
                    8. Note salary range if mentioned
                    9. Extract location details
                    10. Identify employment type (full-time, part-time, etc.)
                    11. Note work arrangement (on-site, remote, hybrid)
                    12. Extract application deadline if mentioned
                    13. Extract contact information (email, phone, application link)
                    14. List all benefits mentioned
                    15. Determine experience level based on requirements
                    16. Note education requirements

                    Job Advertisement Text:
                ${jobText.substring(0, 4000)}`;

                const COHERE_API_KEY = "<?= env('COHERE_API_KEY') ?>";
                const COHERE_MODEL = "<?= env('COHERE_MODEL') ?>";

                const response = await fetch("https://api.cohere.com/v2/chat", {
                    method: "POST",
                    headers: {
                        "Authorization": "Bearer " + COHERE_API_KEY,
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        "stream": false,
                        "model": COHERE_MODEL,
                        "messages": [
                            {
                                "role": "user",
                                "content": prompt
                            }
                        ]
                    }),
                });

                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error(`HTTP error! status: ${response.status}, message: ${errorText}`);
                }

                const body = await response.json();
                console.log('Full API Response:', body);
                
                // Store the original text
                currentOriginalText = jobText;
                
                // Display the response
                displayJobAnalysis(body, jobText);
                
                // Show the save section after successful analysis
                saveSection.style.display = 'block';
                
            } catch (error) {
                console.error('Error:', error);
                responseArea.innerHTML = `<div class="response error">
                    <strong>Error:</strong><br>${error.message}
                </div>`;
            } finally {
                // Re-enable button
                sendButton.disabled = false;
                sendButton.textContent = 'Analyze Job Advertisement';
            }
        }

        async function saveToBackend() {
            const saveButton = document.getElementById('saveButton');
            const saveStatus = document.getElementById('saveStatus');
        
            
            if (!currentJobData) {
                alert('No job data to save. Please analyze a job first.');
                return;
            }
            
            // Disable save button and show loading
            saveButton.disabled = true;
            saveButton.textContent = 'Saving...';
            saveStatus.innerHTML = '<div class="save-status">Sending data to backend...</div>';
            
            try {
                // Prepare data for backend
                // console.log(currentJobData);
                const postData = {
                    job_data: currentJobData,
                    // original_text: currentOriginalText,
                    // analyzed_at: new Date().toISOString()
                };
                
                // console.log('Sending data to backend:', postData);
                
                let backendUrl = 'api/job-parser/process';
                const response = await fetch(backendUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest' // For CodeIgniter AJAX detection
                    },
                    body: JSON.stringify(postData)
                });
                
                const result = await response.json();
                
                if (response.ok) {
                    saveStatus.innerHTML = `<div class="save-status save-success">✓ Successfully saved to backend! ${result.message || ''}</div>`;
                    console.log('Backend response:', result.data);
                } else {
                    throw new Error(result.message || `HTTP ${response.status}: Failed to save job data`);
                }
                
            } catch (error) {
                console.error('Error saving to backend:', error);
                saveStatus.innerHTML = `<div class="save-status save-error">✗ Error saving to backend: ${error.message}</div>`;
            } finally {
                // Re-enable save button
                saveButton.disabled = false;
                saveButton.textContent = 'Save to Backend (CodeIgniter)';
            }
        }

        function displayJobAnalysis(responseData, originalText) {
            const responseArea = document.getElementById('responseArea');
            
            let html = '<div class="response success">';
            html += '<h2>Job Advertisement Analysis</h2>';
            
            // Extract JSON from the response
            const responseText = responseData.message.content[0].text;
            
            // Try to parse JSON from the response
            let jobData;
            try {
                // Extract JSON from the response (handling potential formatting)
                const jsonMatch = responseText.match(/\{[\s\S]*\}/);
                if (jsonMatch) {
                    jobData = JSON.parse(jsonMatch[0]);
                    currentJobData = jobData; // Store for saving
                } else {
                    throw new Error('No JSON found in response');
                }
            } catch (e) {
                // If JSON parsing fails, show the raw response
                html += `<div class="error">Failed to parse JSON response. Showing raw output:</div>`;
                html += `<div class="message-content">${responseText}</div>`;
                html += '</div>';
                responseArea.innerHTML = html;
                return;
            }
            
            // Create tabs for different views
            html += `
                <div class="tabs">
                    <div class="tab active" onclick="switchTab('structured')">Structured View</div>
                    <div class="tab" onclick="switchTab('json')">Raw JSON</div>
                    <div class="tab" onclick="switchTab('original')">Original Text</div>
                </div>
            `;
            
            // Structured View
            html += `<div id="structured-view" class="tab-content active">`;
            
            // Basic job info
            html += `
                <div class="job-details">
                    <h3>Job Information</h3>
                    <div class="detail-item">
                        <span class="detail-label">Job Title:</span>
                        <span class="detail-value">${jobData.jobTitle || 'Not specified'}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Company:</span>
                        <span class="detail-value">${jobData.company || 'Not specified'}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Location:</span>
                        <span class="detail-value">${jobData.location || 'Not specified'}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Employment Type:</span>
                        <span class="detail-value">${jobData.employmentType || 'Not specified'}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Work Arrangement:</span>
                        <span class="detail-value">${jobData.workArrangement || 'Not specified'}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Experience Level:</span>
                        <span class="detail-value">${jobData.experienceLevel || 'Not specified'}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Salary Range:</span>
                        <span class="detail-value">${jobData.salaryRange || 'Not specified'}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Application Deadline:</span>
                        <span class="detail-value">${jobData.applicationDeadline || 'Not specified'}</span>
                    </div>
                </div>
            `;
            
            // Job Description
            if (jobData.jobDescription) {
                html += `
                    <div class="job-details">
                        <h3>Job Description</h3>
                        <div class="detail-value">${jobData.jobDescription}</div>
                    </div>
                `;
            }
            
            // Responsibilities
            if (jobData.responsibilities && jobData.responsibilities.length > 0) {
                html += `
                    <div class="job-details">
                        <h3>Key Responsibilities</h3>
                        ${jobData.responsibilities.map(resp => `<div class="list-item">${resp}</div>`).join('')}
                    </div>
                `;
            }
            
            // Requirements
            if (jobData.requirements && jobData.requirements.length > 0) {
                html += `
                    <div class="job-details">
                        <h3>Requirements</h3>
                        ${jobData.requirements.map(req => `<div class="list-item">${req}</div>`).join('')}
                    </div>
                `;
            }
            
            // Skills
            if (jobData.skills && jobData.skills.length > 0) {
                html += `
                    <div class="job-details">
                        <h3>Required Skills</h3>
                        ${jobData.skills.map(skill => `<div class="list-item">${skill}</div>`).join('')}
                    </div>
                `;
            }
            
            // Benefits
            if (jobData.benefits && jobData.benefits.length > 0) {
                html += `
                    <div class="job-details">
                        <h3>Benefits</h3>
                        ${jobData.benefits.map(benefit => `<div class="list-item">${benefit}</div>`).join('')}
                    </div>
                `;
            }
            
            // Contact Information
            if (jobData.contactInfo) {
                html += `
                    <div class="job-details">
                        <h3>Contact Information</h3>
                        <div class="detail-value">${jobData.contactInfo}</div>
                    </div>
                `;
            }
            
            html += `</div>`; // End structured view
            
            // JSON View
            html += `
                <div id="json-view" class="tab-content">
                    <h3>Raw JSON Output</h3>
                    <div class="json-output">${JSON.stringify(jobData, null, 2)}</div>
                </div>
            `;
            
            // Original Text View
            html += `
                <div id="original-view" class="tab-content">
                    <h3>Original Job Advertisement Text</h3>
                    <div class="message-content">${originalText}</div>
                </div>
            `;
            
            // API Usage Information
            if (responseData.usage) {
                html += '<div class="usage-info">';
                html += '<strong>API Usage:</strong><br>';
                
                if (responseData.usage.billed_units) {
                    html += `Billed - Input: ${responseData.usage.billed_units.input_tokens}, Output: ${responseData.usage.billed_units.output_tokens}<br>`;
                }
                
                if (responseData.usage.tokens) {
                    html += `Actual - Input: ${responseData.usage.tokens.input_tokens}, Output: ${responseData.usage.tokens.output_tokens}`;
                }
                
                html += '</div>';
            }
            
            html += '</div>'; // End response
            
            responseArea.innerHTML = html;
        }

        function switchTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Deactivate all tabs
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Activate selected tab
            document.getElementById(`${tabName}-view`).classList.add('active');
            event.target.classList.add('active');
        }

        // Allow sending message with Enter key (Ctrl+Enter or Cmd+Enter)
        document.getElementById('messageInput').addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                analyzeJobAdvert();
            }
        });

        // Also allow Enter to send (with shift+enter for new line)
        document.getElementById('messageInput').addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                analyzeJobAdvert();
            }
        });

        // Load sample text on page load for demonstration
        window.onload = function() {
            loadSampleText();
        };
    </script>
</body>
</html>