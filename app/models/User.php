<?php
    class User 
    {
        private $db;

        public function __construct()
        {
            $this->db = new Database;
        }

        // Register User
        public function register($data)
        {
            $this->db->query('INSERT INTO users (name, email, password, token, active) VALUES(:name, :email, :password, :token, :active)');
            // Bind values
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password', $data['password']);
            //* 後加token,active
            $this->db->bind(':token', $data['token']);
            $this->db->bind(':active', 0);

            // Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

         //* 後加 Active User by Token
        public function activeUserByEmail($data)
        {            
            $this->db->query('SELECT email, token FROM users WHERE active = :active AND token = :token AND email = :email');
            // Bind values
            $this->db->bind(':active', 0);
            $this->db->bind(':token', $data['token']);
            $this->db->bind(':email', $data['email']);
            $row = $this->db->single();
            if ($this->db->rowCount() > 0) // 表示有找到
            {
                $this->db->query('UPDATE users SET active = :active WHERE token=:token AND email=:email');
                // Bind values
                $this->db->bind(':active', 1);
                $this->db->bind(':token', $data['token']);
                $this->db->bind(':email', $data['email']);
            }
            // Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }

        }

        // Login User
        public function login($email, $password) 
        {
            $this->db->query('SELECT * FROM users WHERE email = :email');
            $this->db->bind(':email', $email);

            $row = $this->db->single();

            $hashed_password = $row->password;
            if(password_verify($password, $hashed_password)) {
                return $row;
            } else {
                return false;
            }
        }

        // Find user by email
        public function findUserByEmail($email)
        {
            $this->db->query('SELECT * FROM users WHERE email = :email');
            $this->db->bind(':email', $email);
            // Bind values
            $row = $this->db->single();
        
            // Check row
            if ($this->db->rowCount() > 0) // 表示有找到
            {
                return true;
            } else {
                return false;
            }
        }
    }