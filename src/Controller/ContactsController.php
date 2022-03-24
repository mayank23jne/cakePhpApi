<?php
namespace App\Controller;

use App\Controller\AppController;

class ContactsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    // function for get all contacts
    //API Method GET: http://localhost/cakeApi/contacts/index
    public function index()
    {
        $contacts = $this->Contacts->find()->select([
            'Contacts.id',
            'Contacts.first_name',
            'Contacts.last_name',
            'Contacts.phone_number'
        ])->limit(10);
        $this->set([
            'contacts' => $contacts,
            '_serialize' => ['contacts']
        ]);
    }

    // function for get all contacts with company data
    //API Method GET: http://localhost/cakeApi/contacts/index_ext
    public function index_ext()
    {
        $contacts = $this->Contacts->find()->select([
            'Contacts.id',
            'Contacts.first_name',
            'Contacts.last_name',
            'Contacts.phone_number',
            'Companies.id',
            'Companies.company_name',
            'Companies.address'
        ])->limit(10)->join([
            'Companies' => [
                'table' => 'Companies',
                'type' => 'LEFT',
                'conditions' => 'Contacts.company_id = Companies.id'
            ]
        ]);


        $this->set([
            'contacts' => $contacts,
            '_serialize' => ['contacts']
        ]);
    }


    // function for get single contact details
    //API Method GET: http://localhost/cakeApi/contacts/view/2
    public function view($id)
    {
        $contact = $this->Contacts->get($id);
        $this->set([
            'contact' => $contact,
            '_serialize' => ['contact']
        ]);
    }

    // function for add new contact
    //API Method POST: http://localhost/cakeApi/contacts/add
    public function add()
    {
        $this->request->allowMethod(['post', 'put']);
        $contact = $this->Contacts->newEntity($this->request->getData());
        if ($this->Contacts->save($contact)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $this->set([
            'message' => $message,
            'contact' => $contact,
            '_serialize' => ['message', 'contact']
        ]);
    }

    // function for edit contact
    //API Method POST: http://localhost/cakeApi/contacts/edit/2
    public function edit($id)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
        $contact = $this->Contacts->get($id);
        $contact = $this->Contacts->patchEntity($contact, $this->request->getData());
        if ($this->Contacts->save($contact)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
    }


    // function for delete contact
    //API Method DELETE: http://localhost/cakeApi/contacts/delete/2
    public function delete($id)
    {
        $this->request->allowMethod(['delete']);
        $contact = $this->Contacts->get($id);
        $message = 'Deleted';
        if (!$this->Contacts->delete($contact)) {
            $message = 'Error';
        }
        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
    }
}