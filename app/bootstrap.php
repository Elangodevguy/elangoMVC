<?php
  // Load config
  require_once 'config/config.php';
  // load Helper function
  require_once 'helpers/url_helper.php';
  require_once 'helpers/session_helper.php';

  // Load Libraries
  // require_once 'libraries/core.php';
  // require_once 'libraries/controller.php';
  // require_once 'libraries/database.php';

  //AutoLoad Core LIbraries

  spl_autoload_register(function($classname){
    require_once 'libraries/'.$classname.'.php'; 
  });