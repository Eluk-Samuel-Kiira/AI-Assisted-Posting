<?php

namespace App\Models;

use CodeIgniter\Model;

class JobModel extends Model
{
    protected $table            = 'jobs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'job_title',
        'company',
        'job_description',
        'location',
        'employment_type',
        'experience_level',
        'salary_range',
        'work_arrangement',
        'contact_info',
        'application_deadline',
        'education_requirements',
        'skills',
        'requirements',
        'responsibilities',
        'benefits',
        'preferred_qualifications',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'job_title' => 'required|max_length[255]',
        'company' => 'required|max_length[255]',
        'job_description' => 'required',
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;

    /**
     * Prepare data for insertion - handle array fields
     */
    public function prepareData(array $data): array
    {
        $jsonFields = ['skills', 'requirements', 'responsibilities', 'benefits', 'preferred_qualifications'];
        
        foreach ($jsonFields as $field) {
            if (isset($data[$field]) && is_array($data[$field])) {
                $data[$field] = json_encode($data[$field]);
            } elseif (!isset($data[$field])) {
                $data[$field] = json_encode([]);
            }
        }
        
        return $data;
    }

    /**
     * Insert job data with proper array handling
     */
    public function insertJob(array $data)
    {
        $preparedData = $this->prepareData($data);
        return $this->insert($preparedData);
    }
}