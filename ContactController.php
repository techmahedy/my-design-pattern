<?php
namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Repository\Repository;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{   
    public $repository;
    public $model = Contact::class;

    public function __construct(Repository $repository)
    {  
       if(property_exists($this,'repository')){
           $this->repository = $repository;
       }
    }

    public function index(Contact $contact)
    {   
        $contact = $contact->latest()->get();
        if(method_exists(Repository::class,'loadView')){
            return $this->repository->loadView('welcome',$contact);
        }
    }

    public function store(ContactRequest $request)
    {
        $data = $request->validated();
        if(property_exists($this,'model')){
            $this->repository->storeData($this->model,$data);
        }
        return redirect()->back();
    }

    public function edit($id)
    {
        $contact = Contact::find($id);
        if(method_exists(Repository::class,'loadView')){
            return $this->repository->loadView('edit',$contact);
        }
    }

    public function update(ContactRequest $request, $id)
    {
        $data = $request->validated();
        if(method_exists(Repository::class,'updateData')){
            $this->repository->updateData($this->model,$data, $id);
        }
        return redirect()->route('contact.index');
    }

    public function delete($id)
    {
        if(method_exists(Repository::class,'deleteData')){
            $this->repository->deleteData($this->model, $id);
        }
        return redirect()->back();
    }
}