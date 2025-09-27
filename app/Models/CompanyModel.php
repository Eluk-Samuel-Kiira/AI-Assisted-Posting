<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyModel extends Model
{
    protected $table            = 'companies';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    
    protected $allowedFields = [
        'company_name',
        'contact_name',
        'contact_email',
        'contact_phone',
        'url',
        'contact_fax',
        'since',
        'company_size',
        'address1',
        'address2',
        'logo'
    ];
    
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    
    protected $validationRules = [
        'company_name' => 'required|min_length[3]|max_length[255]',
        'contact_name' => 'required|min_length[3]|max_length[255]',
        'contact_email' => 'permit_empty|valid_email',
        'url' => 'permit_empty|valid_url',
    ];
    
    protected $validationMessages = [
        'company_name' => [
            'required' => 'Company name is required.',
            'min_length' => 'Company name must be at least 3 characters long.',
        ],
        'contact_name' => [
            'required' => 'Contact name is required.',
            'min_length' => 'Contact name must be at least 3 characters long.',
        ],
    ];
    
    protected $skipValidation = false;
}