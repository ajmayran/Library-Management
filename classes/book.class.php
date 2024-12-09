<?php

require_once __DIR__ . '/../database/connect.php';

class Books
{
    public $id = '';
    public $title = '';
    public $author = '';
    public $no_of_copies = '';
    public $student_id = '';
    public $book_id = '';
    public $borrow_date = '';
    public $return_date = '';
    public $status = '';

    protected $db;

    function __construct()
    {
        $this->db = new Database(); // Instantiate the Database class.
    }

    function showBorrowed()
    {
        // SQL query to fetch borrowed books along with student and book details
        $sql = "SELECT bt.*, b.title, b.author, s.subject_name, DATE_FORMAT(bt.borrow_date, '%M %e, %Y') AS borrow_date
                FROM borrowing_transaction bt
                LEFT JOIN books b ON bt.book_id = b.id
                LEFT JOIN subject s ON b.subject_id = s.id
                WHERE bt.status = 'Borrowed'
                ORDER BY borrow_date DESC;";

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

    function fetchAvailableBooks()
    {
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

    function book_request($student_id, $book_id)
    {
        $sql = "INSERT INTO book_request (student_id, book_id, date_requested, status)
                VALUES (:student_id, :book_id, NOW(), 'Pending')";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':student_id', $student_id);
        $query->bindParam(':book_id', $book_id);

        return $query->execute();
    }

    function showRequestRecord()
    {
        $sql = "SELECT br.id,b.title,b.author, s.subject_name,br.status, DATE_FORMAT(br.date_requested, '%M %e, %Y') AS date_requested
        FROM book_request br
        LEFT JOIN books b ON br.book_id = b.id
        LEFT JOIN subject s ON b.subject_id = s.id;";

        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    // Add this function in the Books class
    public function removeRequest($id)
    {
        $sql = "DELETE FROM book_request WHERE id = :id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);

        return $query->execute(); // Return true if deletion is successful
    }

    // In your Books class, add a fetchOverdues function like this:

    public function fetchOverdues()
    {
        try {
            $db = $this->db->connect();

            // Query to get books where the return date is past the expected date and not yet returned
            $sql = "SELECT b.id, b.title, s.subject_name, bt.borrow_date, bt.return_date,
                       DATEDIFF(CURRENT_DATE, bt.return_date) AS overdue_days
                FROM borrowing_transaction bt
                INNER JOIN books b ON bt.book_id = b.id
                LEFT JOIN subject s ON b.subject_id = s.id
                WHERE bt.status = 'Borrowed' AND bt.return_date < CURRENT_DATE";

            $query = $db->prepare($sql);
            $query->execute();
            $overdues = $query->fetchAll(PDO::FETCH_ASSOC);

            // Adding a fine calculation for each overdue book
            foreach ($overdues as &$overdue) {
                // Calculate fines 
                $overdue['fine'] = $overdue['overdue_days'] * 20; // 20 PESO PER DAY
            }

            return $overdues;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function countOverdueBooks() {
        try {
            $db = $this->db->connect();
    
            // Query to count overdue books
            $sql = "SELECT COUNT(*) AS overdue_count
                    FROM borrowing_transaction bt
                    WHERE bt.status = 'Borrowed' AND bt.return_date < CURRENT_DATE";
    
            $query = $db->prepare($sql);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
    
            return $result['overdue_count'];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return 0;
        }
    }
    
}
