<?php

require_once './includes/functions.php';
require_once './classes/book.class.php';

$id = $borrower_name = $book_id = $borrow_date = $return_date = $remarks = '';
$borrower_nameErr = $book_idErr = $borrow_dateErr = $return_dateErr = $remarksErr = '';

$bookObj = new Books();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $record = $bookObj->fetchRecord($id);
        if (!empty($record)) {
            $borrower_name = $record['borrower_name'];
            $book_id = $record['book_id'];
            $borrow_date = date('Y-m-d', strtotime($record['borrow_date']));
            $remarks = $record['remarks'];
        } else {
            echo 'No rental found';
            exit;
        }
    } else {
        echo 'No rental found';
        exit;
    }
} else if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_GET['id'];
    $record = $rentalObj->fetchRecord($id);
    if (!empty($record)) {
        $borrower_name = $record['borrower_name'];
        $book_id = $record['book_id'];
        $borrow_date = date('Y-m-d', strtotime($record['borrow_date']));
        $remarks = $record['remarks'];
    }
    $return_date = !empty($_POST['return_date'])? clean_input(date('Y-m-d', strtotime($_POST['return_date']))): '';
    $remarks = clean_input($_POST['remarks']);

    if(empty($return_date)){
        $return_dateErr = 'Return Date is required';
    }else if($return_date < $borrow_date){
        $return_dateErr = 'Return Date cant be prior to borrow date';
    }

    if(empty($return_dateErr)){
        $rentalObj->id = $id;
        $rentalObj->book_id = $book_id;
        $rentalObj->return_date = $return_date;
        $rentalObj->remarks = $remarks;

        if($rentalObj->return()){
            header('Location: view-books.php');
        } else {
            echo 'Something went wrong when returning a book.';
        }
    }
}
?>
