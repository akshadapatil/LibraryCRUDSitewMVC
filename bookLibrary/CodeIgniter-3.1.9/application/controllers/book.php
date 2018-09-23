<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Book extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION)) { session_start(); }
        
        //To load the model file which contains database queries.
        $this->load->model("booksInformation");
    }
    
    public function index()
    {
        $data['loggedIn'] = 'false';
        
        //To show list of all books available.
        $data['listOfBooks'] = $this->booksInformation->getBooks();

        //To load the base_url.
        $this->load->helper('url');

        if (isset($_SESSION['username']))
        {
            $data['loggedIn']   = 'true';
             $data['isAdmin']   = 'false';
            $data['username']   = $_SESSION['username'];
            $_SESSION['userid'] = $data['userid'] = $this->booksInformation->getUserId($data);
            $data['bookIssued'] = $this->booksInformation->checkBookIssued($data);
            
            if ($_SESSION['username'] == "admin")
            {
                $data['isAdmin'] = 'true';
            }
        }

        //To load the view.
        $this->load->view("homePage", $data);
    }
    
    /**
     * This function is used to insert a book into the database.
     */
    public function addBook()
    {
        $data = array(
            'name'           => $this->input->post('name'),
            'type'           => $this->input->post('type'),
            'totalNoOfBooks' => $this->input->post('totalBooks')
        );
        $this->booksInformation->insertBook($data);
        echo "Form Submitted Sucessfully";       
    }
    
    /**
     * This function is used to borrow a book from the library.
     */
    public function borrowBook()
    {
        $data = array(
            'userid'   => $_SESSION['userid'],
            'idbooks'  => $this->input->post('idbooks')
        );

        $this->booksInformation->borrowBook($data);
        echo "Record inserted successfully";
    }

    /**
     * This function is used to return a book from the library.
     */
    public function returnBook()
    {
        $data = array(
            'userid'   => $_SESSION['userid'],
            'idbooks'  => $this->input->post('idbooks')
        );

        $this->booksInformation->returnBook($data);
        echo "Record inserted successfully";
    }
    
    /**
     * Check whether a book is available or not
     */
    public function checkBookAvailability()
    {
        $book = array(
            'idbooks'  => $this->input->post('idbooks')
        );
        
        echo $this->booksInformation->checkBookAvailabilty($book);
    }
    
    public function logout()
    {
        // Unset all of the session variables.
        $_SESSION = array();

        // Finally, destroy the session.
        session_destroy();
        $data['loggedIn'] = 'false';
        
        //To show list of all books available.
        $data['listOfBooks'] = $this->booksInformation->getBooks();

        $this->load->helper('url');
        //To load the view.
        $this->load->view("homePage", $data);
    }
}