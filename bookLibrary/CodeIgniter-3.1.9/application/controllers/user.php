<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class user extends CI_Controller{

    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION)) {session_start(); }
        $this->load->helper('url');
        
        //To load the model file which contains database queries.
        $this->load->model("booksInformation");
    }
    
    public function index() {
        $this->load->view("signUpForm");
    }
    
    /*
     * Sign up Form Functionality.
     */
    public function signup() {
        $data = array(
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password')
        );
        $response = $this->booksInformation->insertUser($data);

        if ($response == true)
        {
            $_SESSION['username'] = $this->input->post('username');
            header("Location:" . base_url());
            exit();
        }
        else
        {
            $data['error'] = "Username already exists";
            $this->load->view("signUpForm", $data);
        }
    }
    
    public function login()
    {
        $this->load->view("loginForm");
    }
    
    /*
     * Check if user exists during log in.
     */
    public function checkUserExits() {
        $data = array(
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password')
        );
        
        $response = $this->booksInformation->checkUserExists($data);

        if ($response == true)
        {
            $_SESSION['username'] = $this->input->post('username');
            header("Location:" . base_url());
            exit();
        }
        else
        {
            $data['error'] = "Credentials doesn't match.";
            $this->load->view("loginForm", $data);
        }
    }
}