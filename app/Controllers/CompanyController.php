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
}