<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Advert Analyzer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .upload-section {
            border: 2px dashed #007bff;
            border-radius: 10px;
            padding: 40px;
            text-align: center;
            margin-bottom: 30px;
            background-color: #f8f9fa;
        }
        .file-input {
            margin: 20px 0;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 10px;
        }
        button:hover {
            background-color: #0056b3;
        }
        button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
        .response {
            margin-top: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }
        .loading {
            text-align: center;
            color: #666;
            padding: 40px;
        }
        .error {
            border-color: #dc3545;
            color: #dc3545;
            background-color: #f8d7da;
        }
        .success {
            border-color: #28a745;
            background-color: #d4edda;
        }
        .file-info {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .analysis-result {
            background: white;
            padding: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .json-output {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            font-family: monospace;
            font-size: 14px;
            white-space: pre-wrap;
        }
        .extracted-text {
            background: #fff3cd;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            font-size: 14px;
            max-height: 200px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Job Advert Analyzer</h1>
        
        <div class="upload-section">
            <h3>Upload Job Advertisement File</h3>
            <p>Supported formats: PDF, Word, Images (JPG, PNG), Text</p>
            <input type="file" id="fileInput" class="file-input" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.txt" multiple>
            <br>
            <button onclick="analyzeFiles()" id="analyzeBtn">Analyze Job Advert</button>
        </div>
        
        <div id="fileList"></div>
        <div id="responseArea"></div>
    </div>

    <script>
        // File handling and text extraction functions
        const textExtractors = {
            // Extract text from PDF using PDF.js
            async extractFromPDF(file) {
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Simple text extraction from PDF (basic implementation)
                        // For production, you'd want to use a proper PDF.js implementation
                        const text = "PDF text extraction would require PDF.js library integration";
                        resolve(text);
                    };
                    reader.onerror = reject;
                    reader.readAsArrayBuffer(file);
                });
            },

            // Extract text from Word documents
            async extractFromWord(file) {
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Simple text extraction for Word docs
                        // For production, use mammoth.js or similar
                        const text = "Word document text extraction requires additional libraries";
                        resolve(text);
                    };
                    reader.onerror = reject;
                    reader.readAsArrayBuffer(file);
                });
            },

            // Extract text from images using OCR
            async extractFromImage(file) {
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Simple OCR simulation
                        // For production, use Tesseract.js or similar OCR library
                        const text = "Image OCR text extraction requires Tesseract.js integration";
                        resolve(text);
                    };
                    reader.onerror = reject;
                    reader.readAsDataURL(file);
                });
            },

            // Extract text from text files
            async extractFromText(file) {
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        resolve(e.target.result);
                    };
                    reader.onerror = reject;
                    reader.readAsText(file);
                });
            }
        };

        async function extractTextFromFile(file) {
            const ext = file.name.split('.').pop().toLowerCase();
            
            switch (ext) {
                case 'pdf':
                    return await textExtractors.extractFromPDF(file);
                case 'doc':
                case 'docx':
                    return await textExtractors.extractFromWord(file);
                case 'jpg':
                case 'jpeg':
                case 'png':
                    return await textExtractors.extractFromImage(file);
                case 'txt':
                    return await textExtractors.extractFromText(file);
                default:
                    throw new Error(`Unsupported file type: ${ext}`);
            }
        }

        async function analyzeWithCohere(text) {
            const response = await fetch("https://api.cohere.com/v2/chat", {
                method: "POST",
                headers: {
                    "Authorization": "Bearer qvZQtNisbEKkZrlpXlErgdlPxtd61ovyBFOuSGZl",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    "stream": false,
                    "model": "command-a-03-2025",
                    "messages": [
                        {
                            "role": "user",
                            "content": `Analyze this job advertisement and return ONLY a JSON object with the following structure:
                            {
                                "jobTitle": "string",
                                "company": "string",
                                "jobDescription": "string",
                                "requirements": ["string array"],
                                "responsibilities": ["string array"],
                                "salaryRange": "string",
                                "location": "string",
                                "employmentType": "string",
                                "applicationDeadline": "string",
                                "contactInfo": "string",
                                "skills": ["string array"],
                                "benefits": ["string array"]
                            }
                            
                            Job Advertisement Text: ${text.substring(0, 3000)}`
                        }
                    ]
                }),
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const body = await response.json();
            
            // Extract JSON from the response
            const responseText = body.message.content[0].text;
            
            // Try to parse JSON from the response
            try {
                // Extract JSON from markdown code blocks or plain text
                const jsonMatch = responseText.match(/\{[\s\S]*\}/);
                if (jsonMatch) {
                    return JSON.parse(jsonMatch[0]);
                } else {
                    // If no JSON found, return the text as description
                    return {
                        jobTitle: "Unable to parse",
                        company: "Unable to parse",
                        jobDescription: responseText,
                        requirements: [],
                        responsibilities: [],
                        salaryRange: "Unable to parse",
                        location: "Unable to parse",
                        employmentType: "Unable to parse",
                        applicationDeadline: "Unable to parse",
                        contactInfo: "Unable to parse",
                        skills: [],
                        benefits: []
                    };
                }
            } catch (e) {
                throw new Error('Failed to parse JSON response from AI');
            }
        }

        async function analyzeFiles() {
            const fileInput = document.getElementById('fileInput');
            const analyzeBtn = document.getElementById('analyzeBtn');
            const responseArea = document.getElementById('responseArea');
            const fileList = document.getElementById('fileList');
            
            const files = fileInput.files;
            
            if (files.length === 0) {
                alert('Please select at least one file');
                return;
            }
            
            // Disable button and show loading
            analyzeBtn.disabled = true;
            analyzeBtn.textContent = 'Analyzing...';
            responseArea.innerHTML = '<div class="loading">Processing files and analyzing job advertisements...</div>';
            
            fileList.innerHTML = '<h3>Selected Files:</h3>';
            
            try {
                const results = [];
                
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    
                    // Display file info
                    fileList.innerHTML += `
                        <div class="file-info">
                            <strong>File ${i + 1}:</strong> ${file.name} (${(file.size / 1024).toFixed(2)} KB)
                        </div>
                    `;
                    
                    // Extract text from file
                    const extractedText = await extractTextFromFile(file);
                    
                    // Analyze with Cohere
                    const analysis = await analyzeWithCohere(extractedText);
                    
                    results.push({
                        fileName: file.name,
                        fileSize: (file.size / 1024).toFixed(2) + ' KB',
                        fileType: file.type,
                        extractedText: extractedText.substring(0, 1000) + (extractedText.length > 1000 ? '...' : ''),
                        analysis: analysis
                    });
                }
                
                // Display results
                displayResults(results);
                
            } catch (error) {
                console.error('Error:', error);
                responseArea.innerHTML = `<div class="response error">
                    <strong>Error:</strong><br>${error.message}
                </div>`;
            } finally {
                // Re-enable button
                analyzeBtn.disabled = false;
                analyzeBtn.textContent = 'Analyze Job Advert';
            }
        }

        function displayResults(results) {
            const responseArea = document.getElementById('responseArea');
            
            let html = '<div class="response success">';
            html += `<h3>Analysis Results (${results.length} file(s) processed)</h3>`;
            
            results.forEach((result, index) => {
                html += `
                    <div class="analysis-result" style="margin-bottom: 30px;">
                        <h4>File: ${result.fileName}</h4>
                        <p><strong>Size:</strong> ${result.fileSize} | <strong>Type:</strong> ${result.fileType}</p>
                        
                        <div class="extracted-text">
                            <strong>Extracted Text (first 1000 chars):</strong><br>
                            ${result.extractedText}
                        </div>
                        
                        <h4>Analysis Result:</h4>
                        <div class="json-output">${JSON.stringify(result.analysis, null, 2)}</div>
                    </div>
                `;
            });
            
            html += '</div>';
            responseArea.innerHTML = html;
        }

        // File input change handler
        document.getElementById('fileInput').addEventListener('change', function(e) {
            const fileList = document.getElementById('fileList');
            const files = e.target.files;
            
            if (files.length > 0) {
                fileList.innerHTML = '<h3>Selected Files:</h3>';
                Array.from(files).forEach((file, index) => {
                    fileList.innerHTML += `
                        <div class="file-info">
                            <strong>File ${index + 1}:</strong> ${file.name} (${(file.size / 1024).toFixed(2)} KB)
                        </div>
                    `;
                });
            }
        });
    </script>
</body>
</html>