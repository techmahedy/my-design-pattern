<?php

namespace App\Repository;

use Illuminate\Support\Facades\View;

class Repository {
   
   public function loadView(string $view = null, $collection = [])
   {   
       return View::make($view,compact('collection'));
   }
   
   public function storeData(string $model = null, $data = [])
   {
      $model::create($data);
      if(method_exists($this, 'responseSuccess')){
        $this->responseSuccess('message','Contact added successfully');
      }
   }
   
   public function updateData(string $model = null, $data = [], $id)
   {
      $model::where('id',$id)->update($data);
      if(method_exists($this, 'responseSuccess')){
        $this->responseSuccess('message','Contact updated successfully');
      }
   }

   public function deleteData(string $model = null, int $id = null)
   {
       $model::where('id',$id)->delete();
       if(method_exists($this, 'responseSuccess')){
        $this->responseSuccess('message','Contact deleted successfully');
       }
   }

   public function responseSuccess(string $key = null, string $value = null)
   {
      echo session()->flash($key,$value);
   }

   
}