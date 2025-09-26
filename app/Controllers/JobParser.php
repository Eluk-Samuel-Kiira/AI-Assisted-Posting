<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\JobModel;

class JobParser extends Controller
{
    protected $jobModel;

    public function __construct()
    {
        $this->jobModel = new JobModel();
    }


    public function index()
    {
        return view('job_parser_form'); // simple file + text form for testing
    }

    
    public function processJobDescription()
    {
        // Log raw input for debugging
        $rawInput = file_get_contents('php://input');
        log_message('info', 'Raw input received: ' . $rawInput);

        $data = $this->request->getJSON(true);

        if (!$data) {
            log_message('error', 'No JSON data received or invalid JSON');
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid JSON data'
            ]);
        }

        if (!isset($data['job_data'])) {
            log_message('error', 'Missing job_data field. Received: ' . json_encode($data));
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Missing job_data field'
            ]);
        }

        $jobData = $data['job_data'];
        log_message('info', 'Processing job data: ' . json_encode($jobData));

        try {
            // Prepare data for database insertion
            $dbData = [
                'job_title' => $jobData['jobTitle'] ?? null,
                'company' => $jobData['company'] ?? null,
                'job_description' => $jobData['jobDescription'] ?? null,
                'location' => $jobData['location'] ?? null,
                'employment_type' => $jobData['employmentType'] ?? null,
                'experience_level' => $jobData['experienceLevel'] ?? null,
                'salary_range' => $jobData['salaryRange'] ?? null,
                'work_arrangement' => $jobData['workArrangement'] ?? null,
                'contact_info' => $jobData['contactInfo'] ?? null,
                'application_deadline' => $this->parseDate($jobData['applicationDeadline'] ?? null),
                'education_requirements' => $jobData['educationRequirements'] ?? null,
                'skills' => $jobData['skills'] ?? [],
                'requirements' => $jobData['requirements'] ?? [],
                'responsibilities' => $jobData['responsibilities'] ?? [],
                'benefits' => $jobData['benefits'] ?? [],
                'preferred_qualifications' => $jobData['preferredQualifications'] ?? [],
            ];

            // Save to database using the custom method
            $jobId = $this->jobModel->insertJob($dbData);

            if ($jobId) {
                log_message('info', "Job saved successfully with ID: {$jobId}");
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Job data saved successfully',
                    'job_id' => $jobId,
                    'timestamp' => date('Y-m-d H:i:s')
                ]);
            } else {
                $errors = $this->jobModel->errors();
                log_message('error', 'Failed to save job: ' . print_r($errors, true));
                
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to save job data',
                    'errors' => $errors
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Error saving job: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }

    private function parseDate($dateString)
    {
        if (empty($dateString)) {
            return null;
        }

        try {
            $date = new \DateTime($dateString);
            return $date->format('Y-m-d');
        } catch (\Exception $e) {
            log_message('warning', "Could not parse date: {$dateString}");
            return null;
        }
    }
    

    
    /**
     * Get all saved jobs (reload page)
     */
    public function getJobs()
    {
        try {
            $jobs = $this->jobModel
                        ->orderBy('created_at', 'DESC')
                        ->findAll();
            
            // Process the jobs data
            $processedJobs = [];
            foreach ($jobs as $job) {
                // Decode JSON array fields
                $jsonFields = ['skills', 'requirements', 'responsibilities', 'benefits', 'preferred_qualifications'];
                
                foreach ($jsonFields as $field) {
                    if (isset($job[$field]) && is_string($job[$field]) && !empty($job[$field])) {
                        $decoded = json_decode($job[$field], true);
                        $job[$field] = (json_last_error() === JSON_ERROR_NONE) ? $decoded : [];
                    } else {
                        $job[$field] = [];
                    }
                }
                
                $processedJobs[] = $job;
            }

            $data = [
                'title' => 'Job Postings - LaFab AI Posting',
                'jobs' => $processedJobs
            ];

            return view('job_postings/index', $data);
            
        } catch (\Exception $e) {
            return redirect()->to('/job-postings')->with('error', 'Error loading jobs: ' . $e->getMessage());
        }
    }

     /**
     * View single job details
     */
    public function view($id)
    {
        try {
            $job = $this->jobModel->find($id);
            
            if (!$job) {
                return redirect()->to('/job-postings')->with('error', 'Job not found');
            }
            
            // Decode JSON array fields for the single job
            $jsonFields = ['skills', 'requirements', 'responsibilities', 'benefits', 'preferred_qualifications'];
            
            foreach ($jsonFields as $field) {
                if (isset($job[$field]) && is_string($job[$field]) && !empty($job[$field])) {
                    $decoded = json_decode($job[$field], true);
                    $job[$field] = (json_last_error() === JSON_ERROR_NONE) ? $decoded : [];
                } else {
                    $job[$field] = [];
                }
            }

            $data = [
                'title' => ($job['job_title'] ?? 'Job Details') . ' - LaFab AI Posting',
                'job' => $job
            ];

            return view('job_postings/view', $data);
            
        } catch (\Exception $e) {
            return redirect()->to('/job-postings')->with('error', 'Error loading job: ' . $e->getMessage());
        }
    }
    

    /**
     * Delete a job
     */
    public function delete($id)
    {
        try {
            $job = $this->jobModel->find($id);
            
            if (!$job) {
                return redirect()->to('/job-postings')->with('error', 'Job not found');
            }
            
            // Delete the job
            $this->jobModel->delete($id);
            
            return redirect()->to('/job-postings')->with('success', 'Job deleted successfully');
            
        } catch (\Exception $e) {
            return redirect()->to('/job-postings')->with('error', 'Error deleting job: ' . $e->getMessage());
        }
    }
}
