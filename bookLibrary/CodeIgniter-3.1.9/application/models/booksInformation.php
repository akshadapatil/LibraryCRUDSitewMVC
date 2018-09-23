<?php

class booksInformation extends CI_Model{
    
    function __construct()
    {
        parent::__construct();
        $this->load->database("librarydatabase");
    }
    
    /*
     * Get the list of books.
     */
    function getBooks()
    {
        $query = $this->db->get('books');
        return $query->result();
    }
    
    /*
     * Insert a record of book.
     */
    function insertBook($data)
    {
        $this->db->insert('books', $data);
        return true;
    }
    
    /*
     * Insert a user.
     */
    function insertUser($data)
    {
        $this->db->select('*'); 
        $this->db->from('users');
        $this->db->where('username', $data['username']);
        $query = $this->db->get();
        $result = $query->result_array();
        
        $count = count($result);
        if (empty($count))
        {
            $this->db->insert('users', $data);
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * To check if user already exists.
     */
    function checkUserExists($data)
    {
        $data = array(
            'username' => $data['username'],
            'password' => $data['password']
        );
        $this->db->select('*'); 
        $this->db->from('users');
        $this->db->where($data);
        $query = $this->db->get();
        $result = $query->result_array();
        
        $count = count($result);
        return $count;
    }
    
    /**
     * To get the user id based on the username. 
     */
    function getUserId($data)
    {
        $query1 = $this->db->query("SELECT userid FROM users WHERE username LIKE " . '"' . $data['username'] . '"')->row();
        return $query1->userid;
    }
    
    /**
     * To check if user has been issued any book to return
     */
    public function checkBookIssued($data)
    {
        $query = "SELECT * FROM user_book WHERE userid = " . $data['userid']. " AND return_date IS NULL";
        return $this->db->query($query)->result_array();
    }
    
    /**
     * To borrow a book.
     */ 
    function borrowBook($data)
    {
        $currentDate      = $this->db->query("SELECT CURRENT_DATE")->row();
        $dataToBeInserted = array(
            "idbooks"    => $data['idbooks'],
            "userid"     => $data['userid'],
            "issue_date" => $currentDate->CURRENT_DATE
        );

        $insertRecord = $this->db->insert("user_book", $dataToBeInserted);
    }
    
    /**
     * To return an issued book.
     */ 
    function returnBook($data)
    {
        $currentDate = $this->db->query("SELECT CURRENT_DATE")->row();
        $record      = array(
            'idbooks' => $data['idbooks'],
            'userid'  => $data['userid']
        );
        
        $this->db->where($record);
        $this->db->update('user_book', array('return_date' => $currentDate->CURRENT_DATE));
        return true;
    }
    
    /**
     * To check whether a book is available or not.
     */
    function checkBookAvailabilty($data)
    {
        $query = "SELECT 
                    (SELECT totalNoOfBooks FROM books WHERE idbooks = " . $data['idbooks'] . ")
                    -
                    (SELECT count(ubid) FROM user_book WHERE idbooks = " . $data['idbooks']. " AND issue_date IS NOT NULL and return_date IS NULL)
                    AS DIFFERENCE";
        
        $count = $this->db->query($query)->row();
        return $count->DIFFERENCE;
    }
}