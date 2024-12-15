<?php

require_once __DIR__ . '/../database/connect.php';

class Books
{
    public $id = '';
    public $title = '';
    public $author = '';
    public $isbn = '';
    public $year = '';
    public $no_of_copies = '';

    public $student_id = '';
    public $book_id = '';
    public $borrow_date = '';
    public $return_date = '';
    public $status = '';
    public $subject_id = '';

    protected $db;

    function __construct()
    {
        $this->db = new Database(); // Instantiate the Database class.
    }


    function addBook()
    {
        $sql = "INSERT INTO books (title, isbn, year, no_of_copies, subject_id) VALUES (:title, :isbn, :year, :no_of_copies, :subject_id)";

        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':title', $this->title);
        $query->bindParam(':isbn', $this->isbn);
        $query->bindParam(':year', $this->year);
        $query->bindParam(':no_of_copies', $this->no_of_copies);
        $query->bindParam(':subject_id', $this->subject_id);

        return $query->execute();
    }

    function getSubjects(){
        $sql = "SELECT id, subject_name FROM subject";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function showBorrowed($student_id)
    {
        try {
            // SQL query to fetch borrowed books along with student and book details
            $sql = "SELECT bt.*, b.title, s.subject_name,
            COALESCE(GROUP_CONCAT(a.first_name, ' ', a.last_name ORDER BY a.first_name),'') AS authors,
            DATE_FORMAT(bt.borrow_date, '%M %e, %Y') AS formatted_borrow_date
            FROM borrowing_transaction bt
            LEFT JOIN books b ON bt.book_id = b.id
            LEFT JOIN Book_Authors ba ON b.id = ba.book_id
            LEFT JOIN Authors a ON ba.author_id = a.id
            LEFT JOIN subject s ON b.subject_id = s.id
            WHERE bt.status = 'Borrowed' AND bt.student_id = :student_id
            GROUP BY bt.id
            ORDER BY bt.borrow_date DESC;";


            // Prepare the query
            $query = $this->db->connect()->prepare($sql);

            // Bind the student ID
            $query->bindParam(':student_id', $student_id, PDO::PARAM_INT);

            // Execute the query and fetch all data
            $data = null;
            if ($query->execute()) {
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }

            // Return the fetched data
            return $data;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }



    function showAllBooks()
    {
        $sql = "SELECT b.*, s.subject_name, 
        COALESCE(GROUP_CONCAT(a.first_name, ' ', a.last_name ORDER BY a.first_name),'') AS authors, 
        COALESCE(GROUP_CONCAT(p.publisher_name ORDER BY p.publisher_name),'') AS publishers 
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

    function fetchAvailableBooks()
    {
        $sql = "SELECT  b.*, s.subject_name, 
        COALESCE(GROUP_CONCAT(a.first_name, ' ', a.last_name ORDER BY a.first_name),'') AS authors, 
        COALESCE(GROUP_CONCAT(p.publisher_name ORDER BY p.publisher_name),'') AS publishers 
        FROM books b
        LEFT JOIN Book_Authors ba ON b.id = ba.book_id
        LEFT JOIN Authors a ON ba.author_id = a.id
        LEFT JOIN Book_Publishers bp ON b.id = bp.book_id
        LEFT JOIN Publisher p ON bp.publisher_id = p.id
        LEFT JOIN subject s ON b.subject_id = s.id
        WHERE b.no_of_copies > 0 
        GROUP BY b.id
        ORDER BY b.title ASC;";

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

    function showRequestRecord($student_id)
    {
        $sql = "SELECT br.id, b.title, s.subject_name, br.status, 
                GROUP_CONCAT(a.first_name, ' ', a.last_name ORDER BY a.first_name SEPARATOR ', ') AS authors,
                DATE_FORMAT(br.date_requested, '%M %e, %Y') AS date_requested
                FROM book_request br
                LEFT JOIN books b ON br.book_id = b.id
                LEFT JOIN Book_Authors ba ON b.id = ba.book_id
                LEFT JOIN Authors a ON ba.author_id = a.id
                LEFT JOIN subject s ON b.subject_id = s.id
                WHERE br.student_id = :student_id
                GROUP BY br.id
                ORDER BY br.status DESC";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
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



    public function fetchOverdues($student_id)
    {
        try {
            $db = $this->db->connect();

            // Step 1: Update all overdue records to 'Overdue'
            $updateSql = "UPDATE borrowing_transaction 
                          SET status = 'Overdue' 
                          WHERE status = 'Borrowed' 
                            AND return_date < CURRENT_DATE";
            $updateQuery = $db->prepare($updateSql);
            $updateQuery->execute();

            // Step 2: Fetch the overdue records for the specific student
            $sql = "SELECT bt.*, b.id, b.title, s.subject_name,
                           DATEDIFF(CURRENT_DATE, bt.return_date) AS overdue_days
                    FROM borrowing_transaction bt
                    INNER JOIN books b ON bt.book_id = b.id
                    LEFT JOIN subject s ON b.subject_id = s.id
                    WHERE bt.status = 'Overdue'
                      AND bt.student_id = :student_id";

            $query = $db->prepare($sql);
            $query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
            $query->execute();
            $overdues = $query->fetchAll(PDO::FETCH_ASSOC);

            // Adding a fine calculation for each overdue book
            foreach ($overdues as &$overdue) {
                // Calculate fines 
                $overdue['fine'] = $overdue['overdue_days'] * 20; // 20 PESOS PER DAY
            }

            return $overdues;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }


    public function countOverdueBooksForStudent($student_id)
    {
        try {
            $db = $this->db->connect();

            // Query to count overdue books for a specific student
            $sql = "SELECT COUNT(*) AS overdue_count
                    FROM borrowing_transaction bt
                    WHERE bt.status = 'Overdue'
                    AND bt.student_id = :student_id";

            $query = $db->prepare($sql);
            $query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);

            return $result['overdue_count'];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return 0;
        }
    }
}
