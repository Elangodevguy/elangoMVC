<?php

class Users extends Controller
{
  public function __construct()
  {
    $this->userModel = $this->model('User');
  }

  public function register()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      //sanitize input
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      // save input
      $data = [
        'name' => trim($_POST['name']),
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'confirm_password' => trim($_POST['confirm_password']),
        'name_err' => '',
        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => ''
      ];
      // email empty
      if (empty($data['email'])) {
        $data['email_err'] = 'Please Enter Email';
      } else {
        if ($this->userModel->findUserByEmail($data['email'])) {
          $data['email_err'] = 'Email already Taken';
        }
      }
      // name empty
      if (empty($data['name'])) {
        $data['name_err'] = 'Please Enter Name';
      }
      // password empty
      if (empty($data['password'])) {
        $data['password_err'] = 'Please Enter Password';
      } else if (strlen($data['password']) < 6) {
        $data['password_err'] = 'Password must be atleast 6';
      }
      if (empty($data['confirm_password'])) {
        $data['confirm_password_err'] = 'Please Confirm Password';
      } else {
        if ($data['password'] != $data['confirm_password']) {
          $data['confirm_password_err'] = 'Password doesnot Match';
        }
      }
      //validated
      if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
        // hash ur password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        if ($this->userModel->register($data)) {
          flash('register_success', 'you are registered and can log in');
          redirect('users/login');
        } else {
          die('something went wrong');
        }
      } else {
        $this->view('users/register', $data);
      }
    } else {
      $data = [
        'name' => '',
        'email' => '',
        'password' => '',
        'confirm_password' => '',
        'name_err' => '',
        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => ''
      ];

      $this->view('/users/register', $data);
    }
  }

  public function login()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      //sanitize input
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      // save input
      $data = [
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'email_err' => '',
        'password_err' => ''
      ];
      // email empty
      if (empty($data['email'])) {
        $data['email_err'] = 'Please Enter Email';
      } else {
        if ($this->userModel->findUserByEmail($data['email'])) {
          // user found
        } else {
          $data['email_err'] = 'NO User found';
        }
      }

      // password empty
      if (empty($data['password'])) {
        $data['password_err'] = 'Please Enter Password';
      }
      //validated
      if (empty($data['email_err']) && empty($data['password_err'])) {
        $loggedInUser = $this->userModel->login($data['email'], $data['password']);

        if ($loggedInUser) {
          $this->createUserSession($loggedInUser);
        } else {
          $data['password_err'] = 'Password Incorrect';
          $this->view('users/login', $data);
        }
      } else {
        $this->view('users/login', $data);
      }
    } else {
      $data = [
        'email' => '',
        'password' => '',
        'email_err' => '',
        'password_err' => ''
      ];

      $this->view('/users/login', $data);
    }
  }

  public function createUserSession($user){
    $_SESSION['user_id'] = $user->id;
    $_SESSION['user_name'] = $user->name;
    $_SESSION['user_email'] = $user->email;

    redirect('pages/index');
  }

  public function logout(){
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_email']);

    session_destroy();
    redirect('users/login');
  }
}
