<?= $this->extend('layouts/dashboard_layout') ?>

<?= $this->section('title') ?>Job Advert Analyzer - LaFab AI Posting<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Mobile Header -->
<div class="d-lg-none bg-primary text-white p-3">
    <div class="d-flex align-items-center">
        <button class="btn btn-light me-3" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <div>
            <h5 class="mb-0">Job Posting</h5>
            <small>Welcome back, <?= session()->get('username') ?? 'User' ?></small>
        </div>
    </div>
</div>

<!-- Desktop Header -->
<div class="content-header bg-white shadow-sm d-none d-lg-block">
    <div class="container-fluid py-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h2 mb-1 text-primary">Job Posting Overview</h1>
                <p class="text-muted mb-0">Welcome back, <?= session()->get('username') ?? 'User' ?>! Here's your AI-powered hiring insights.</p>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary sidebar-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars me-2"></i>
                    <span>Menu</span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Main Content -->
<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <label for="messageInput" class="form-label fw-semibold">Paste job advertisement text:</label>
                        <textarea id="messageInput" class="form-control" placeholder="Paste job advertisement text here..." rows="8" style="resize: vertical;"></textarea>
                        <div class="text-muted mt-2 small">
                            <i class="fas fa-lightbulb me-1"></i>
                            <span class="sample-text" onclick="loadSampleText()" style="cursor: pointer; text-decoration: underline;">Load sample job advertisement text</span>
                            • Press Ctrl+Enter to analyze
                        </div>
                    </div>

                    <button id="sendButton" class="btn btn-primary btn-lg w-100 mb-4" onclick="analyzeJobAdvert()">
                        <i class="fas fa-robot me-2"></i>Analyze Job Advertisement
                    </button>
                    
                    <div id="responseArea"></div>
                    
                    <!-- Save Section -->
                    <div id="saveSection" style="display: none;" class="mt-4 p-4 bg-light rounded-3 border-start border-4 border-success">
                        <h4 class="mb-3">Save to Database</h4>
                        <button id="saveButton" class="btn btn-success btn-lg" onclick="saveToBackend()">
                            <i class="fas fa-save me-2"></i>Save to Database
                        </button>
                        <div id="saveStatus" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
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
        sendButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Analyzing...';
        responseArea.innerHTML = '<div class="text-center p-4"><div class="spinner-border text-primary mb-3"></div><p>Analyzing job advertisement with AI...</p></div>';
        
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
            responseArea.innerHTML = `<div class="alert alert-danger">
                <h4><i class="fas fa-exclamation-triangle me-2"></i>Error</h4>
                <p class="mb-0">${error.message}</p>
            </div>`;
        } finally {
            // Re-enable button
            sendButton.disabled = false;
            sendButton.innerHTML = '<i class="fas fa-robot me-2"></i>Analyze Job Advertisement';
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
        saveButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';
        saveStatus.innerHTML = '<div class="alert alert-info">Sending data to backend...</div>';
        
        try {
            // Prepare data for backend
            const postData = {
                job_data: currentJobData,
            };
            
            let backendUrl = '<?= base_url("api/job-parser/process") ?>';
            const response = await fetch(backendUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(postData)
            });
            
            const result = await response.json();
            
            if (response.ok) {
                saveStatus.innerHTML = `<div class="alert alert-success">
                    <h4><i class="fas fa-check-circle me-2"></i>Success!</h4>
                    <p class="mb-0">Job data successfully saved to database. ${result.message || ''}</p>
                </div>`;
                console.log('Backend response:', result.data);
            } else {
                throw new Error(result.message || `HTTP ${response.status}: Failed to save job data`);
            }
            
        } catch (error) {
            console.error('Error saving to backend:', error);
            saveStatus.innerHTML = `<div class="alert alert-danger">
                <h4><i class="fas fa-exclamation-triangle me-2"></i>Error</h4>
                <p class="mb-0">Error saving to database: ${error.message}</p>
            </div>`;
        } finally {
            // Re-enable save button
            saveButton.disabled = false;
            saveButton.innerHTML = '<i class="fas fa-save me-2"></i>Save to Database';
        }
    }

    function displayJobAnalysis(responseData, originalText) {
        const responseArea = document.getElementById('responseArea');
        
        let html = '<div class="alert alert-success">';
        html += '<h3 class="alert-heading"><i class="fas fa-chart-bar me-2"></i>Job Advertisement Analysis</h3>';
        
        // Extract JSON from the response
        const responseText = responseData.message.content[0].text;
        
        // Try to parse JSON from the response
        let jobData;
        try {
            const jsonMatch = responseText.match(/\{[\s\S]*\}/);
            if (jsonMatch) {
                jobData = JSON.parse(jsonMatch[0]);
                currentJobData = jobData;
            } else {
                throw new Error('No JSON found in response');
            }
        } catch (e) {
            html += `<div class="alert alert-warning">Failed to parse JSON response. Showing raw output:</div>`;
            html += `<pre class="mt-3 bg-light p-3 rounded">${responseText}</pre>`;
            html += '</div>';
            responseArea.innerHTML = html;
            return;
        }
        
        // Create tabs for different views
        html += `
            <ul class="nav nav-tabs mb-4" id="analysisTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="structured-tab" data-bs-toggle="tab" data-bs-target="#structured" type="button" role="tab">Structured View</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="json-tab" data-bs-toggle="tab" data-bs-target="#json" type="button" role="tab">Raw JSON</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="original-tab" data-bs-toggle="tab" data-bs-target="#original" type="button" role="tab">Original Text</button>
                </li>
            </ul>
            
            <div class="tab-content" id="analysisTabContent">
        `;
        
        // Structured View
        html += `<div class="tab-pane fade show active" id="structured" role="tabpanel">`;
        
        // Basic job info
        html += `
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Job Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Job Title:</strong><br>${jobData.jobTitle || 'Not specified'}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Company:</strong><br>${jobData.company || 'Not specified'}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Location:</strong><br>${jobData.location || 'Not specified'}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Employment Type:</strong><br>${jobData.employmentType || 'Not specified'}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Work Arrangement:</strong><br>${jobData.workArrangement || 'Not specified'}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Experience Level:</strong><br>${jobData.experienceLevel || 'Not specified'}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Salary Range:</strong><br>${jobData.salaryRange || 'Not specified'}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Application Deadline:</strong><br>${jobData.applicationDeadline || 'Not specified'}
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Job Description
        if (jobData.jobDescription) {
            html += `
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Job Description</h5>
                    </div>
                    <div class="card-body">
                        <p>${jobData.jobDescription}</p>
                    </div>
                </div>
            `;
        }
        
        // Responsibilities
        if (jobData.responsibilities && jobData.responsibilities.length > 0) {
            html += `
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Key Responsibilities</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            ${jobData.responsibilities.map(resp => `<li class="list-group-item">${resp}</li>`).join('')}
                        </ul>
                    </div>
                </div>
            `;
        }
        
        // Requirements
        if (jobData.requirements && jobData.requirements.length > 0) {
            html += `
                <div class="card mb-4">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0"><i class="fas fa-requirements me-2"></i>Requirements</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            ${jobData.requirements.map(req => `<li class="list-group-item">${req}</li>`).join('')}
                        </ul>
                    </div>
                </div>
            `;
        }
        
        // Skills
        if (jobData.skills && jobData.skills.length > 0) {
            html += `
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Required Skills</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2">
                            ${jobData.skills.map(skill => `<span class="badge bg-primary">${skill}</span>`).join('')}
                        </div>
                    </div>
                </div>
            `;
        }
        
        // Benefits
        if (jobData.benefits && jobData.benefits.length > 0) {
            html += `
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="fas fa-gift me-2"></i>Benefits</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            ${jobData.benefits.map(benefit => `
                                <div class="col-md-6 mb-2">
                                    <i class="fas fa-check text-success me-2"></i>${benefit}
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </div>
            `;
        }
        
        html += `</div>`; // End structured view
        
        // JSON View
        html += `
            <div class="tab-pane fade" id="json" role="tabpanel">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="fas fa-code me-2"></i>Raw JSON Output</h5>
                    </div>
                    <div class="card-body">
                        <pre class="bg-dark text-light p-3 rounded" style="max-height: 500px; overflow-y: auto;">${JSON.stringify(jobData, null, 2)}</pre>
                    </div>
                </div>
            </div>
        `;
        
        // Original Text View
        html += `
            <div class="tab-pane fade" id="original" role="tabpanel">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="fas fa-file-text me-2"></i>Original Job Advertisement Text</h5>
                    </div>
                    <div class="card-body">
                        <pre style="max-height: 500px; overflow-y: auto; white-space: pre-wrap;">${originalText}</pre>
                    </div>
                </div>
            </div>
        `;
        
        html += '</div></div>'; // End tab content and alert
        
        responseArea.innerHTML = html;
        
        // Initialize Bootstrap tabs
        var analysisTabs = new bootstrap.Tab(document.getElementById('structured-tab'));
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
        const messageInput = document.getElementById('messageInput');
        
        if (messageInput) {
            // Allow sending message with Enter key (Ctrl+Enter or Cmd+Enter)
            messageInput.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                    analyzeJobAdvert();
                }
            });

            // Also allow Enter to send (with shift+enter for new line)
            messageInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    analyzeJobAdvert();
                }
            });

            // Load sample text on page load for demonstration
            loadSampleText();
        }
    });
</script>

<style>
    .sample-text:hover {
        color: #0d6efd !important;
    }
    
    .nav-tabs .nav-link {
        color: #495057;
        font-weight: 500;
    }
    
    .nav-tabs .nav-link.active {
        font-weight: 600;
    }
    
    pre {
        font-family: 'Courier New', monospace;
        font-size: 0.9em;
    }
    
    .card-header {
        font-weight: 600;
    }
    
    .list-group-item {
        border: none;
        padding: 0.5rem 0;
    }
    
    .badge {
        font-size: 0.85em;
    }
</style>
<?= $this->endSection() ?>