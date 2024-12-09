<?php

require_once './database/connect.php';

class Books
{
    public $id = '';
    public $title = '';
    public $author = '';
    public $o_of_copies = '';
    public $borrower_name = '';
    public $book_id = '';
    public $borrow_date = '';
    public $return_date = '';
    public $status = '';

    protected $db;

    function __construct()
    {
        $this->db = new Database(); // Instantiate the Database class.
    }

    function bookRequest()
    {
        $sql = "INSERT INTO borrowing_transactions (borrower_name, book_id, borrow_date, remarks) VALUES (:borrower_name, :book_id, :borrow_date, :remarks);";
        $sql = $sql . "UPDATE books SET number_of_copies = (SELECT number_of_copies FROM books WHERE id = :book_id) - 1 WHERE id = :book_id";

        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':borrower_name', $this->borrower_name);
        $query->bindParam(':book_id', $this->book_id);
        $query->bindParam(':borrow_date', $this->borrow_date);

        return $query->execute();
    }

    // function return()
    // {
    //     $sql = "UPDATE borrowing_transactions SET return_date = :return_date, status = 'Returned', remarks = :remarks WHERE id = :id;";
    //     $sql = $sql . "UPDATE books SET number_of_copies = (SELECT number_of_copies FROM books WHERE id = :book_id) + 1 WHERE id = :book_id";

    //     $query = $this->db->connect()->prepare($sql);

    //     $query->bindParam(':return_date', $this->return_date);
    //     $query->bindParam(':book_id', $this->book_id);
    //     $query->bindParam(':remarks', $this->remarks);
    //     $query->bindParam(':id', $this->id);

    //     return $query->execute();
    // }

    // function fetchRecord($recordID)
    // {
    //     $sql = "SELECT * FROM borrowing_transactions WHERE id = :recordID;";
    //     $query = $this->db->connect()->prepare($sql);
    //     $query->bindParam(':recordID', $recordID);
    //     $data = null;
    //     if ($query->execute()) {
    //         $data = $query->fetch();
    //     }
    //     return $data;
    // }

    function showBorrowed()
    {
        // SQL query to fetch borrowed books along with student and book details
        $sql = "SELECT bt.*, b.title, b.author, s.subject_name
                FROM borrowing_transaction bt
                LEFT JOIN books b ON bt.book_id = b.id
                LEFT JOIN subject s ON b.subject_id = s.id
                WHERE bt.status = 'Borrowed'
                ORDER BY bt.borrow_date DESC;";

        // Prepare and execute the query
        $query = $this->db->connect()->prepare($sql);
        $data = null;
        
        // If the query executes successfully, fetch all the data
        if ($query->execute()) {
            $data = $query->fetchAll();
        }
    
        // Return the fetched data
        return $data;
    }
    

    function showAllBooks()
    {
        $sql = "SELECT b.*, s.subject_name, p.publisher_name
        FROM books b
        LEFT JOIN subject s ON b.subject_id = s.id
        LEFT JOIN publisher p ON b.publisher_id = p.id
        ORDER BY b.title ASC;";

        $query = $this->db->connect()->prepare($sql);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll();
        }

        return $data;
    }

    function fetchAvailableBooks() {
        $sql = "SELECT  b.*, s.subject_name, p.publisher_name
        
        FROM books b
        LEFT JOIN subject s ON b.subject_id = s.id
        LEFT JOIN publisher p ON b.publisher_id = p.id
        WHERE no_of_copies > 0 ORDER BY b.title ASC;";

        $query = $this->db->connect()->prepare($sql);

        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll(); 
        }

        return $data;
    }

    function hasAlreadyBorrowed($student_id, $book_id)
    {
        $sql = "SELECT COUNT(*) FROM borrowing_transaction 
                WHERE student_id = :student_id 
                AND book_id = :book_id 
                AND status = 'Borrowed'";
        
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $query->bindParam(':book_id', $book_id, PDO::PARAM_INT);

        $query->execute();
        return $query->fetchColumn() > 0; // Return true if the count is greater than 0
    }
}

