<?php
    class Users extends Controller{
        public function __construct(){
            $this->userModel = $this->model('User');
            $this->postModel = $this->model('Post');
          
        }
      
        public function register()
        {      
            if($this->isloggedIn())
                redirect('pages/index');
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $token = substr(md5(openssl_random_pseudo_bytes(20)), 10);
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data =['username' => trim($_POST['username']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'email' => trim($_POST['email']),
                    'token' => $token,
                    'username_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];

                if(empty($data['username'])){
                    $data['username_err'] = 'Please enter Username';
                }elseif(!ctype_alnum($data['username']) && !empty($data['username'])){
                    $data['username_err'] = 'Please Username Should be AlphaNumeric';
                }
                elseif($this->userModel->findUser($data['username'])){
                    $data['username_err'] = 'Username Already Exist';
                }

                if(empty($data['password'])){
                    $data['password_err'] = 'Please enter Password';
                }elseif(strlen($_POST['password']) < 6 || ctype_lower($_POST['password'])){
                    $data['password_err'] = 'Password must be at least 6 characters AND number / upper char';
                }

                if(empty($data['confirm_password'])){
                    $data['confirm_password_err'] = 'Please confirm Password';
                }elseif($_POST['password'] != $_POST['confirm_password']){
                    $data['confirm_password_err'] = 'Passwords not match';
                }

                if(empty($data['email'])){
                    $data['email_err'] = 'Please enter email';
                }elseif($this->userModel->findUserByEmail($data['email'])){
                    $data['email_err'] = 'Email Already Exist';
                }

                if(empty($data['username_err']) && empty($data['password_err']) && empty($data['confirm_password_err']) && empty($data['email_err'])){
                    $data['password'] = hash('whirlpool', $data['password']);
                    
                    $to  = $data['email'];
                    $subject = 'Confirm account';
                    $message = '
                        <html>
                        <head>
                        </head>
                        <body>
                            <p>To active your account click <a href="localhost/Camagru/users/confirm/?token='. $token .'">Here</a></p>
                        </body>
                        </html>
                    ';
                    $headers = 'MIME-Version: 1.0'. "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
                    $headers .= 'To: ' . $to."\r\n";
                    mail($to, $subject, $message , $headers);
                    if($this->userModel->register($data)){
                        flash('register_success', 'Check Your Email Please To Confirm Your Account!');
                        redirect('users/login');
                      } else {
                        die('Something went wrong');
                      }
                }else{
                    $this->view('users/register', $data);
                }
            }else{
                $data =['username' => '',
                    'password' => '',
                    'email' => '',
                    'confirm_password' => '',
                    'username_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];
                $this->view('users/register', $data);
            }
        }  

        public function login()
        {    
            if($this->isloggedIn())
                redirect('pages/index');
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data =['username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'username_err' => '',
                'password_err' => '',
                 ];
                if(empty($data['username'])){
                    $data['username_err'] = 'Please enter Username';
                }
            
                if(empty($data['password'])){
                    $data['password_err'] = 'Please enter Password';
                }elseif(strlen($_POST['password']) < 6|| ctype_lower($_POST['password'])) {
                   $data['password_err'] = 'Password must be at least 6 characters AND number / upper char';
                }
                if($this->userModel->findUser($data['username']) == false)
                {
                    $data['username_err'] = 'No User Found';
                    
                }elseif($this->userModel->checkuserconfirmed($data['username'])){
                    
                }
                else{
                   $data['username_err'] = 'Please Check Your Email to confirm your Account';
                    
                }
              
                

                if(empty($data['username_err']) && empty($data['password_err'])){
                   $loggedInUser = $this->userModel->login($data['username'], $data['password']);
                  
                   if($loggedInUser)
                   {
                    $this->createUserSession($loggedInUser);
                   }else{
                       $data['password_err'] = "Password incorrect";
                       $this->view('users/login', $data);
                   }
                }else{
                    $this->view('users/login', $data);
                }

            }else{
                $data =['username' => '',
                    'password' => '',
                    'username_err' => '',
                    'password_err' => '',
                   
                ];
                $this->view('users/login', $data);
            }
        }  
        public function createUserSession($user)
        {
            $_SESSION['id'] = $user->id;
            $_SESSION['username'] = $user->username;
            $_SESSION['email'] = $user->email;
            $_SESSION['notification'] = $user->notification;
            redirect('pages/index');
        }

        public function logout()
        {
            unset($_SESSION['id']);
            unset($_SESSION['username']);
            unset($_SESSION['email']);
            unset($_SESSION['notification']);
            session_destroy();
            redirect('users/login');
        }
       
        public function isloggedIn(){
            if(isset($_SESSION['id']))
            {
                return true ;
            }
            else{
                return false;
            }
        }

        public function fgpass()
        {
              if($this->isloggedIn())
                redirect('pages/index');
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data =[
                    'email' => trim($_POST['email']),
                    'email_err' => '' 
                ];
                if(empty($data['email'])){
                    $data['email_err'] = 'Please enter email';
                }
                elseif($this->userModel->findUserByEmail($data['email']) == false){
                    $data['email_err'] = 'Email Not Found';
                }
                    
                if(empty($data['email_err']))
                {
                        $row = $this->userModel->getUserByEmail($data['email']);
                        $token = $row->token;
                        $to  = $data['email'];
                        $subject = 'Recover account';
                        $message = '
                            <html>
                            <head>
                            </head>
                            <body>
                                <p>To recover your account click here <a href="localhost/Camagru/users/changepass/?token='. $token .'"><button 
                                type="button" class="btn btn-primary">Change Password</button></a></p>
                            </body>
                            </html>
                        ';
                        $headers = 'MIME-Version: 1.0'. "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
                        $headers .= 'To: ' . $to."\r\n";
                        if(mail($to, $subject, $message , $headers))
                            redirect('users/emailsend');
                    }
                
                else{
                     $this->view('users/fgpass', $data);
                }

            }
            else{
                $data =['email' => '',
                    'email_err' => ''];
                $this->view('users/fgpass', $data);
            
                }
                
        }
        
        public function changepass()
        {
           
            if(isset($_GET['token'])){
                 $token = $_GET['token'];
             if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
                   
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data =[
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'token' => $token,
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];
                  if(empty($data['password'])){
                    $data['password_err'] = 'Please enter Password';
                }elseif(strlen($_POST['password']) < 6 || ctype_lower($_POST['password'])){
                    $data['password_err'] = 'Password must be at least 6 characters AND number / upper char';
                }

                if(empty($data['confirm_password'])){
                    $data['confirm_password_err'] = 'Please confirm Password';
                }elseif($_POST['password'] != $_POST['confirm_password']){
                    $data['confirm_password_err'] = 'Passwords not match';
                }
                  if(empty($data['password_err']) && empty($data['confirm_password_err'])){
                    $data['password'] = hash('whirlpool', $data['password']);
                   
                    if($this->userModel->changepass($data)){
                       
                        flash('changepass_success', 'You Password Changed');
                        redirect('users/login');
                      } else {
                        die('Something went wrong');
                      }
                }else{
                     
                    $this->view('users/changepass', $data);
                }
            }
                else{
                $data =[
                    'password' => '',
                    'confirm_password' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];
                $this->view('users/changepass', $data);
             }
            }

            
            
        }
        
        public function confirm(){
            $page = ['title' => "Thank You"];
            
            $this->view("users/confirm", $page);
            if(isset($_GET['token']))
            {
                $data = ['token' => $_GET['token']];
                $this->userModel->confirm($data);
            }
        }
        
         public function emailsend(){
            $page = ['title' => "Thank You"];
            
            $this->view("users/emailsend", $page);
        }
        
        
        public function profile()
        {
            $posts = $this->postModel->getImagesbyUsr($_SESSION['id']);
            $data = ['title' => $_SESSION['username'],
                     'posts' => $posts
                
            ];
            $this->view("users/profile", $data);
        }
        
        public function modify()
        {
       // Check for POST
       if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          
           $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

           $data = [
               'id' => $_SESSION['id'],
               'username' => trim($_POST['username']),
               'email' => trim($_POST['email']),
               'password' => trim($_POST['password']),
               'confirm_password' => trim($_POST['confirm_password']),
               'username_err' => '',
               'email_err' => '',
               'password_err' => '',
               'confirm_password_err' => '',
               'notif' =>  $_POST['notif']
           ];
            if(!empty($data['notif']))
            {
                $data['notif'] = 1;
                $_SESSION['notification'] = 1;
               
            }
            else{
                $data['notif'] = 0;
                 $_SESSION['notification'] = 0;
                
            }
           if($this->userModel->findUser($data['username'])) {
               $data['username_err'] = 'Name  is already taken';
           }elseif(!ctype_alnum($data['username']) && !empty($data['username'])){
                    $data['username_err'] = 'Please Username Should be AlphaNumeric';
           }
           if($this->userModel->findUserByEmail($data['email'])) {
               $data['email_err'] = 'Email is already taken';
           }

           if ($data['password'] && $data['confirm_password']) {
               if (strlen($data['password']) < 6 || ctype_lower($_POST['password'])) {
                   $data['password_err'] = 'Password must be at least 6 characters AND number / upper char';
               } elseif (empty($data['confirm_password'])) {
                   $data['confirm_password_err'] = 'Please confirm password';
               } elseif ($data['password'] != $data['confirm_password']) {
                   $data['confirm_password_err'] = 'Passwords do not match';
               }
           }

           if (empty($data['email_err']) && empty($data['username_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
              
               if (!(empty($data['password']))) {
                  $data['password'] = hash('whirlpool', $data['password']);
               }
               if ($this->userModel->modify($data)) {
                   flash('modify_success', 'Your account is modified');
                   redirect('users/modify');
               } else {
                   die('Something went wrong');
               }
           } else {
               if(isset($_SESSION['id']))
                    $this->view('users/modify', $data);
               else
                    $this->view('pages/index');
           }
       } else {
           $data = [
               'username' => '',
               'email' => '',
               'password' => '',
               'confirm_password' => '',
               'username_err' => '',
               'email_err' => '',
               'password_err' => '',
               'confirm_password_err' => '',
           ];
           if(isset($_SESSION['id']))
               $this->view('users/modify', $data);
           else
               $this->view('pages/index');
       }
   }
    }
   
