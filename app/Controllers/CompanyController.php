<?php

namespace App\Controllers;

use App\Models\CompanyModel;

class CompanyController extends BaseController
{
    protected $companyModel;

    public function __construct()
    {
        $this->companyModel = new CompanyModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Companies - LaFab AI Posting',
            'companies' => $this->companyModel->findAll()
        ];

        return view('companies/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Add New Company - LaFab AI Posting'
        ];

        return view('companies/create', $data);
    }

    public function edit($id)
    {
        $company = $this->companyModel->find($id);
        
        if (!$company) {
            return redirect()->to('/companies')->with('error', 'Company not found.');
        }

        $data = [
            'title' => 'Edit Company - LaFab AI Posting',
            'company' => $company
        ];

        return view('companies/edit', $data);
    }

    public function store()
    {
        $rules = [
            'company_name' => 'required|min_length[3]|max_length[255]',
            'contact_name' => 'required|min_length[3]|max_length[255]',
            'contact_email' => 'permit_empty|valid_email',
            'url' => 'permit_empty|valid_url'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'company_name' => $this->request->getPost('company_name'),
            'contact_name' => $this->request->getPost('contact_name'),
            'contact_email' => $this->request->getPost('contact_email'),
            'contact_phone' => $this->request->getPost('contact_phone'),
            'url' => $this->request->getPost('url'),
            'contact_fax' => $this->request->getPost('contact_fax'),
            'since' => $this->request->getPost('since'),
            'company_size' => $this->request->getPost('company_size'),
            'logo' => $this->request->getPost('logo'),
            'address1' => $this->request->getPost('address1'),
            'address2' => $this->request->getPost('address2')
        ];

        if ($this->companyModel->save($data)) {
            return redirect()->to('/companies')->with('success', 'Company added successfully.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add company.');
        }
    }

    public function update($id)
    {
        $company = $this->companyModel->find($id);
        
        if (!$company) {
            return redirect()->to('/companies')->with('error', 'Company not found.');
        }

        $rules = [
            'company_name' => 'required|min_length[3]|max_length[255]',
            'contact_name' => 'required|min_length[3]|max_length[255]',
            'contact_email' => 'permit_empty|valid_email',
            'url' => 'permit_empty|valid_url'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'company_name' => $this->request->getPost('company_name'),
            'contact_name' => $this->request->getPost('contact_name'),
            'contact_email' => $this->request->getPost('contact_email'),
            'contact_phone' => $this->request->getPost('contact_phone'),
            'url' => $this->request->getPost('url'),
            'contact_fax' => $this->request->getPost('contact_fax'),
            'since' => $this->request->getPost('since'),
            'company_size' => $this->request->getPost('company_size'),
            'address1' => $this->request->getPost('address1'),
            'address2' => $this->request->getPost('address2')
        ];

        if ($this->companyModel->update($id, $data)) {
            return redirect()->to('/companies')->with('success', 'Company updated successfully.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update company.');
        }
    }

    public function delete($id)
    {
        $company = $this->companyModel->find($id);
        
        if (!$company) {
            return redirect()->to('/companies')->with('error', 'Company not found.');
        }

        if ($this->companyModel->delete($id)) {
            return redirect()->to('/companies')->with('success', 'Company deleted successfully.');
        } else {
            return redirect()->to('/companies')->with('error', 'Failed to delete company.');
        }
    }

    
    
    public function ajaxList()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(405)->setJSON([
                'success' => false,
                'message' => 'Method not allowed'
            ]);
        }

        try {
            $companies = $this->companyModel->select('id, company_name')->orderBy('company_name', 'ASC')->findAll();
            $companiesList = [];
            
            foreach ($companies as $company) {
                $companiesList[$company['id']] = $company['company_name'];
            }
            
            return $this->response->setJSON([
                'success' => true,
                'companies' => $companiesList
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error fetching companies'
            ]);
        }
    }

    // Add this method to your CompanyController
    public function ajaxStore()
    {
        // Validate AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(405)->setJSON([
                'success' => false,
                'message' => 'Method not allowed'
            ]);
        }

        $rules = [
            'company_name' => 'required|min_length[2]|max_length[255]',
            'contact_name' => 'required|min_length[2]|max_length[255]',
            'contact_email' => 'permit_empty|valid_email',
        ];

        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();

            // Log to CodeIgniter logs (writable/logs/)
            // log_message('error', 'Validation failed: ' . json_encode($errors));

            return $this->response->setJSON([
                'success' => false,
                'errors'  => $errors
            ]);
        }


        try {
            $data = [
                'company_name' => $this->request->getPost('company_name'),
                'contact_name' => $this->request->getPost('contact_name'),
                'contact_email' => $this->request->getPost('contact_email'),
                'contact_phone' => $this->request->getPost('contact_phone'),
                'company_size' => $this->request->getPost('company_size'),
                'address1' => $this->request->getPost('address1'),
                'logo' => $this->request->getPost('logo'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            // Save to database
            $companyId = $this->companyModel->insert($data);
            
            if ($companyId) {
                $company = $this->companyModel->find($companyId);
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Company added successfully',
                    'company' => [
                        'id' => $companyId,
                        'company_name' => $company['company_name']
                    ]
                ]);
            } else {
                throw new \Exception('Failed to save company');
            }
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error saving company: ' . $e->getMessage()
            ]);
        }
    }
}