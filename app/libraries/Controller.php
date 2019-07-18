<?php

/* 
Base controller loads the model and view
*/

class Controller
{

  public function model($model)
  {
    require_once '../app/models/' . $model . '.php';

    //instantiate model
    return new $model;
  }

  public function view($view, $data = [])
  { 
    if(file_exists('../app/views/'.$view.'.php')){
      require_once '../app/views/'.$view.'.php';
    }
    else{
      echo "no view to display";
    }
  }
}
