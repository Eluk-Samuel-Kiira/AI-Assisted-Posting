<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\JobModel;
use App\Models\CompanyModel;

class JobParser extends Controller
{
    protected $jobModel;
    protected $companyModel;

    public function __construct()
    {
        $this->jobModel = new JobModel();
        $this->companyModel = new CompanyModel();
    }


    public function index()
    {
        return view('job_parser_form'); // simple file + text form for testing
    }

    
    public function processJobDescription()
    {
        $rawInput = file_get_contents('php://input');
        log_message('info', 'Raw input received: ' . $rawInput);

        $data = $this->request->getJSON(true);

        if (!$data || !isset($data['job_data'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid JSON data'
            ]);
        }

        $jobData = $data['job_data'];
        $companyId = $data['companyId'] ?? null;
        $userId = session()->get('user_id');
        $companyName = $data['companyName'] ?? null;

        if (!$companyId || !$userId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Missing company_id or user_id'
            ]);
        }

        // Validate company exists and matches the name
        $company = $this->companyModel->find($companyId);

        if (!$company) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid company_id: company not found'
            ]);
        }

        if (strtolower($company['company_name']) !== strtolower($companyName)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Company name does not match the selected company_id'
            ]);
        }

        // Validate uniqueness of job title for this company
        $jobTitle = $jobData['jobTitle'] ?? null;
        if (!$jobTitle) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Job title is required'
            ]);
        }

        if (!$this->jobModel->isJobTitleUnique($companyId, $jobTitle)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => "Job title '{$jobTitle}' already exists for this company"
            ]);
        }

        try {
            $dbData = [
                'job_title' => $jobTitle,
                'company' => $jobData['company'] ?? null,
                'company_id' => $companyId,
                'user_id' => $userId,
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
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $jobId = $this->jobModel->insertJob($dbData);

            if ($jobId) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Job data saved successfully',
                    'job_id' => $jobId,
                    'timestamp' => date('Y-m-d H:i:s')
                ]);
            } else {
                $errors = $this->jobModel->errors();
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
