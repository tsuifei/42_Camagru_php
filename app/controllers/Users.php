<?php

class Users extends Controller // 繼承Controller類別
{
    public function __construct() 
    {
        $this->userModel = $this->model('User'); //model/User的數據資料

    }

    public function register()
    {
        // Check for POST /確認POST為存入資訊方式
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            // Process form /註冊表單過程/載入表單

            // Sanitize POST data 過濾資料
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init data 填入表單資料初始化/過濾
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
            ];

            // Validate Name
            if(empty($data['name'])) //如果沒填入name就顯示錯誤訊息
            {
                $data['name_err'] = 'Pleae enter name';
            }
            // Validate email
            if(empty($data['email'])) 
            {
                $data['email_err'] = 'Pleae enter email';
            } else {
                // Check email
                if($this->userModel->findUserByEmail($data['email']))
                {
                    $data['email_err'] = 'Email is already taken'; // 電子郵件已被使用
                }
            }
            // Validate password
            if(empty($data['password'])) 
            {
                $data['password_err'] = 'Pleae enter password';
            } elseif(strlen($data['password']) < 6) {
                    $data['password_err'] = 'Password must be at least 6 characters';
                }

            // Validate confirm_password
            if(empty($data['confirm_password'])) 
            {
                $data['confirm_password_err'] = 'Pleae confirm password';
            } elseif($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Password do not match';
                }
            
            // make sure errors are empty 確認沒有錯誤
            if(empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err']) )
            {
                // Validated                
                // Hash Password 密碼哈希加密
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                //* 後加 Token
                $token = bin2hex(random_bytes(4)); 
                $data['token'] = $token;              

                // Register User
                if($this->userModel->register($data))
                {
                    //* 後加 Send confirmation email
                    $this->sendMail($_POST['email'],  $token);

                    flash('register_success', 'You are registered and we have sent your an email, 
                    kindly activate your account. You can copy and paste the code in above field 
                    or just use the link to activate.');
                    redirect('users/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Loas view with errors /把錯誤訊息的view對應到這裡
                $this->view('users/register', $data);
            }

        } else {
            // Init data 填入表單資料初始化
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
            ];
            // Load view 載入視圖
            $this->view('users/register', $data);
        }
    }

    //* 後加 Send email pour confirmer
    public function sendMail($email, $token) {
        $subject = "Account Activation Code";

        $headers = "From: Camagru Paris app \r\n";
        $headers .= "Reply-To: pommier@gmail.com \r\n";
        $headers .= "CC: pommier@gmail.com \r\n";
        $headers .= "MIME-Version: 1.0 \r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1 \r\n";
        $message = '<html><body>';
        $message .= '<h3>Activation Your account</h3>';
        $message .= '<h3>please click on the link below </h3>';
        $message .= '<h3>or copy / paste in your internet browser</h3>';
        $message .= '<a href="'. URLROOT . 'users/activate?token='.urlencode($token).'&email='.urlencode($email).'" >Click here</a>';
        $message .= '</body></html>';
        // echo $message;
        // die();

        mail($email, $subject, $message, $headers);

    }

    //* 後加 Activate user
    public function activate() {
        // Check for GET
        if($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            // Sanitize POST data 過濾資料
            $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
            $data = [
                'token' => trim($_GET['token']),
                'email' => trim($_GET['email']),
            ];
            $this->userModel->activeUserByEmail($data);
            flash('activation_success', 'Your account is already activated');
            $this->view('users/activate', $data);
        }else {
                
                // Loas view with login /把login的view對應到這裡
                $this->view('users/activate', $data);
                flash('activation_success', 'Your account NOT activated');
            }
    }

    public function login()
    {
        // Check for POST /確認POST為存入資訊方式
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            //Process form /註冊表單過程 ／載入表單
            // Sanitize POST data 過濾資料
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init data 填入表單資料初始化/過濾
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',
            ];

            // Validate email
            if(empty($data['email'])) 
            {
                $data['email_err'] = 'Pleae enter email';
            }
            // Validate password
            if(empty($data['password'])) 
            {
                $data['password_err'] = 'Pleae enter password';
            }

            // Check for user/email
            if($this->userModel->findUserByEmail($data['email'])) {
                // User found
            } else {
                // User not found
                $data['email_err'] = 'No user found';
            }

            // make sure errors are empty 確認沒有錯誤
            if(empty($data['email_err']) && empty($data['password_err']))
            {
                // Validated
                // Check and set logged in user
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if($loggedInUser) {
                    //Create Session
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Password incorrect';
                    $this->view('users/login', $data);
                }
            } else {
                // Loas view with login /把login的view對應到這裡
                $this->view('users/login', $data);
            }

        } else {
            // Init data 填入表單資料初始化
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
            ];
            // Load view 載入視圖
            $this->view('users/login', $data);
        }
    }

    // Change password
    public function changePw($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize POST array
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data = [
            'id' => $id,
            'password' => trim($_POST['password']),
            'confirm_password' => trim($_POST['confirm_password']),
            'password_err' => '',
            'confirm_password_err' => ''
        ];
        // Validate password
        if(empty($data['password'])) 
        {
            $data['password_err'] = 'Pleae enter password';
        } elseif(strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }

        // Validate confirm_password
        if(empty($data['confirm_password'])) 
        {
            $data['confirm_password_err'] = 'Pleae confirm password';
        } elseif($data['password'] != $data['confirm_password']) {
                $data['confirm_password_err'] = 'Password do not match';
            }

        // Make sure no errors
        if(empty($data['password_err']) && empty($data['confirm_password_err'])) {
            // Validated
            // Hash Password 密碼哈希加密
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            //echo $data;
            if($this->postModel->changePassword($data)) {
            flash('change_success', 'Password changed');
            redirect('users/login');
            } else {
            die('Somethis went wrong 出了些問題');
            }
        } else {
            //Loas view with errors
            $this->view('users/register', $data);
        }
        } else {
            // Loas view with login /把login的view對應到這裡
            $this->view('users/login', $data);
        }
        $data = [
            'id' => $id,
            'password' => '',
            'confirm_password' => ''
            ];
            // Load view 載入視圖
            $this->view('users/login', $data);
        }
    }

    public function createUserSession($user) 
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        redirect('pages/index');
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        session_destroy();
        redirect('users/login');
    }


    public function isLoggedIn()
    {
        if(isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }
}