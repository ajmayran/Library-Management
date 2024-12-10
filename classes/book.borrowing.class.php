<?php

require_once '../database/connect.php';

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
    public $actual_return_date = '';
    public $publisher = '';
    public $authors = '';

    protected $db;

    function __construct()
    {
        $this->db = new Database(); // Instantiate the Database class.
    }

    function getTotalRequest()
    {
        $sql = "SELECT COUNT(*) AS total_requests FROM book_request";
        $query = $this->db->connect()->prepare($sql);
        $data = null;
        $data = null;

        if ($query->execute()) {
            // Use fetch() to get a single row, not fetchAll().
            $data = $query->fetch(PDO::FETCH_ASSOC); // This returns a single associative array
        }
        // Return the actual count value, not the entire array.
        return $data['total_requests'] ?? 0;
    }


    function showAllBooks()
    {
        $sql = "SELECT b.*, 
       s.subject_name, 
       GROUP_CONCAT(a.first_name, ' ', a.last_name ORDER BY a.first_name) AS authors, 
       GROUP_CONCAT(p.publisher_name ORDER BY p.publisher_name) AS publishers 
        FROM books b
        LEFT JOIN Book_Authors ba ON b.id = ba.book_id
        LEFT JOIN Authors a ON ba.author_id = a.id
        LEFT JOIN Book_Publishers bp ON b.id = bp.book_id
        LEFT JOIN Publisher p ON bp.publisher_id = p.id
        LEFT JOIN subject s ON b.subject_id = s.id
        GROUP BY b.id
        ORDER BY b.title ASC;";

        $query = $this->db->connect()->prepare($sql);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll();
        }

        return $data;
    }


    function ShowRequest()
    {
        $sql = "SELECT br.id,b.title, CONCAT(st.first_name, ' ', st.last_name) AS student_name, st.grade_lvl AS grade_lvl, sc.section_name AS section_name,
                br.status, DATE_FORMAT(br.date_requested, '%M %e, %Y') AS date_requested
        FROM book_request br
        LEFT JOIN books b ON br.book_id = b.id
        LEFT JOIN students st ON br.student_id = st.id
        LEFT JOIN section sc ON st.section_id = sc.id
        WHERE br.status = 'Pending';";

        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function approveRequest($request_id)
    {
        try {
            $db = $this->db->connect();

            // Fetch book_id and student_id from book_request
            $sql = "SELECT book_id, student_id FROM book_request WHERE id = :request_id";
            $query = $db->prepare($sql);
            $query->bindParam(':request_id', $request_id, PDO::PARAM_INT);
            $query->execute();
            $request = $query->fetch(PDO::FETCH_ASSOC);

            if (!$request) {
                return false; // Request not found
            }

            // Calculate the return_date (3 days after the borrow_date)
            $return_date = date('Y-m-d', strtotime('+3 days'));

            // Create a new borrowing transaction with the calculated return_date
            $sql = "INSERT INTO borrowing_transaction (book_id, student_id, status, borrow_date, return_date) 
                    VALUES (:book_id, :student_id, 'Borrowed', NOW(), :return_date)";
            $query = $db->prepare($sql);
            $query->bindParam(':book_id', $request['book_id'], PDO::PARAM_INT);
            $query->bindParam(':student_id', $request['student_id'], PDO::PARAM_INT);
            $query->bindParam(':return_date', $return_date, PDO::PARAM_STR);
            $query->execute();

            // Update the book_request status to Approved
            $sql = "UPDATE book_request SET status = 'Approved' WHERE id = :request_id";
            $query = $db->prepare($sql);
            $query->bindParam(':request_id', $request_id, PDO::PARAM_INT);
            $query->execute();

            // Update the book's no_of_copies
            $sql = "UPDATE books SET no_of_copies = no_of_copies - 1 WHERE id = :book_id";
            $query = $db->prepare($sql);
            $query->bindParam(':book_id', $request['book_id'], PDO::PARAM_INT);
            $query->execute();

            return true;
        } catch (Exception $e) {
            // Log the exception or handle errors appropriately
            error_log($e->getMessage());
            return false;
        }
    }


    public function declineRequest($request_id)
    {
        try {
            $db = $this->db->connect();

            // Update the book_request status to 'Denied'
            $sql = "UPDATE book_request SET status = 'Denied' WHERE id = :request_id";
            $query = $db->prepare($sql);
            $query->bindParam(':request_id', $request_id, PDO::PARAM_INT);

            return $query->execute();
        } catch (Exception $e) {
            // Log the exception or handle errors appropriately
            error_log($e->getMessage());
            return false;
        }
    }


    function showIssuedBooks()
    {
        // SQL query to fetch borrowed books along with student and book details
        $sql = "SELECT bt.*, b.title, CONCAT(st.first_name, ' ', st.last_name) AS student_name, st.grade_lvl AS grade_lvl,  sc.section_name,
                DATE_FORMAT(bt.borrow_date, '%M %e, %Y') AS borrow_date, DATE_FORMAT(bt.return_date, '%M %e, %Y') AS return_date
                FROM borrowing_transaction bt
                LEFT JOIN books b ON bt.book_id = b.id
                LEFT JOIN students st ON bt.student_id = st.id
                LEFT JOIN section sc ON st.section_id = sc.id
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

    public function returnBook($transaction_id)
    {
        try {
            $db = $this->db->connect();

            // Fetch book_id from borrowing_transaction
            $sql = "SELECT book_id FROM borrowing_transaction WHERE id = :transaction_id";
            $query = $db->prepare($sql);
            $query->bindParam(':transaction_id', $transaction_id, PDO::PARAM_INT);
            $query->execute();
            $transaction = $query->fetch(PDO::FETCH_ASSOC);

            if (!$transaction) {
                return false; // Transaction not found
            }

            // Update the borrowing transaction status to 'Returned'
            $sql = "UPDATE borrowing_transaction 
                    SET status = 'Returned' 
                    WHERE id = :transaction_id";
            $query = $db->prepare($sql);
            $query->bindParam(':transaction_id', $transaction_id, PDO::PARAM_INT);
            $query->execute();

            // Insert the actual return date into the new table
            $sql = "INSERT INTO book_return_log (transaction_id, actual_return_date) 
                    VALUES (:transaction_id, NOW())";
            $query = $db->prepare($sql);
            $query->bindParam(':transaction_id', $transaction_id, PDO::PARAM_INT);
            $query->execute();

            // Update the book's no_of_copies
            $sql = "UPDATE books SET no_of_copies = no_of_copies + 1 WHERE id = :book_id";
            $query = $db->prepare($sql);
            $query->bindParam(':book_id', $transaction['book_id'], PDO::PARAM_INT);
            $query->execute();

            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }


    function showReturnedRecords()
    {
        $sql = "SELECT brl.*, b.title, CONCAT(st.first_name, ' ', st.last_name) AS student_name, st.grade_lvl AS grade_lvl,  sc.section_name,
                    DATE_FORMAT(bt.borrow_date, '%M %e, %Y') AS borrow_date, DATE_FORMAT(bt.return_date, '%M %e, %Y') AS return_date,
                    DATE_FORMAT(brl.actual_return_date, '%M %e, %Y') AS actual_return_date
                    FROM book_return_log brl
                    LEFT JOIN borrowing_transaction bt ON brl.transaction_id = bt.id
                    LEFT JOIN books b ON bt.book_id = b.id
                    LEFT JOIN students st ON bt.student_id = st.id
                    LEFT JOIN section sc ON st.section_id = sc.id
                    ORDER BY brl.actual_return_date DESC;";

        $query = $this->db->connect()->prepare($sql);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll();
        }
        return $data;
    }


    public function deleteBook($book_id)
    {
        try {
            $db = $this->db->connect();
            $sql = "DELETE FROM books WHERE id = :book_id";
            $query = $db->prepare($sql);
            $query->bindParam(':book_id', $book_id, PDO::PARAM_INT);
            return $query->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function deleteStudent($student_id)
    {
        try {
            $db = $this->db->connect();
            $sql = "DELETE FROM students WHERE id = :student_id";
            $query = $db->prepare($sql);
            $query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
            return $query->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
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
