<?php
namespace App\Controller;

use App\Controller\AppController;

class CompaniesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }


    // function for get all companies
    //API Method GET: http://localhost/cakeApi/companies/index
    public function index()
    {
        $companies = $this->Companies->find()->select([
            'Companies.id',
            'Companies.company_name',
            'Companies.address'
        ])->limit(10);
        $this->set([
            'companies' => $companies,
            '_serialize' => ['companies']
        ]);
    }

    
    // function for get single company details
    //API Method GET: http://localhost/cakeApi/companies/view/2
    public function view($id)
    {
        $company = $this->Companies->get($id);
        $this->set([
            'contact' => $company,
            '_serialize' => ['contact']
        ]);
    }


    // function for add new company
    //API Method POST: http://localhost/cakeApi/companies/add
    public function add()
    {
        $this->request->allowMethod(['post', 'put']);
        $company = $this->Companies->newEntity($this->request->getData());
        if ($this->Companies->save($company)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $this->set([
            'message' => $message,
            'contact' => $company,
            '_serialize' => ['message', 'contact']
        ]);
    }


    // function for edit company
    //API Method POST: http://localhost/cakeApi/companies/edit/2
    public function edit($id)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
        $company = $this->Companies->get($id);
        $company = $this->Companies->patchEntity($company, $this->request->getData());
        if ($this->Companies->save($company)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
    }


    // function for delete company
    //API Method DELETE: http://localhost/cakeApi/companies/delete/2
    public function delete($id)
    {
        $this->request->allowMethod(['delete']);
        $company = $this->Companies->get($id);
        $message = 'Deleted';
        if (!$this->Companies->delete($company)) {
            $message = 'Error';
        }
        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
    }
}