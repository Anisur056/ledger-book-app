<?php

class DbClass{

    Public $pub_pdo;

    public function __construct(){
        require "db-config.php";
        $this->pub_pdo = $pdo;
    }

    // ========================= DB SCRIPT ================================= //
    public function showBusinessBookName(){
        $select = $this->pub_pdo->prepare('SELECT * FROM `tbl_business_book`');
        $select->execute();
        return $select->fetchAll();
    }

    public function showLedgerBooksName($business_book_id){
        $statement = $this->pub_pdo->prepare('SELECT * FROM `tbl_ledger_books` WHERE `tbl_business_book_id` = ? ORDER BY `id` DESC');
        $statement->execute([$business_book_id]);
        return $statement->fetchAll();
    }

    public function showLedgerBooksid($id){
        $statement = $this->pub_pdo->prepare('SELECT * FROM `tbl_ledger_books` WHERE `id` = ? ');
        $statement->execute([$id]);
        return $statement->fetchAll();
    }

    public function showLedgerBookTranscetion($ledger_book_id, $offset, $limit_to_show){
        $statement = $this->pub_pdo->prepare("SELECT * FROM `tbl_ledger_book_transections` WHERE `tbl_ledger_books_id` = ?  ORDER BY `id` DESC LIMIT $offset, $limit_to_show");
        $statement->execute([$ledger_book_id]);
        return $statement->fetchAll();
    }

    public function cashCalculation($ledger_book_id){
        $statement = $this->pub_pdo->prepare('SELECT * FROM `tbl_ledger_book_transections` WHERE `tbl_ledger_books_id` = ?');
        $statement->execute([$ledger_book_id]);
        return $statement->fetchAll();
    }

    public function read_tbl_transection_accounts_head(){
        $statement = $this->pub_pdo->prepare('SELECT * FROM `tbl_transection_accounts_head`');
        $statement->execute();
        return $statement->fetchAll();
    }

    

  

}