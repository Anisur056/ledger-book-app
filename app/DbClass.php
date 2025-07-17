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

        public function showLedgerBookTranscetion($ledger_book_id){
        $statement = $this->pub_pdo->prepare('SELECT * FROM `tbl_ledger_book_transections` WHERE `tbl_ledger_books_id` = ?  ORDER BY `id` DESC LIMIT 10');
        $statement->execute([$ledger_book_id]);
        return $statement->fetchAll();
    }

    // ========================= VOUCHER RELATED DB SCRIPT ================================= //
    public function showVoucherByStudentId($student_id){
        $statement = $this->pub_pdo->prepare('SELECT * FROM `shnmm_tbl_vouchers` WHERE `INKED_TO`=? AND `TRANSECTION_STATUS`=? AND `ACCOUNTS_HEAD`=?');
        $statement->execute([$student_id,'cash_in','FEES_COLLECTION']);
        return $statement->fetchAll();
    }

    public function addVoucher($ENTRY_DATE, $STUDENT_NAME,$STUDENT_CLASS,
            $STUDENT_SECTION, $STUDENT_ROLL,
            $TRANSECTION_STATUS, $ACCOUNTS_HEAD, 
            $DESCRIPTION, $AMOUNT, $RECEIVED, 
            $DUE, $REMARK, $RECEIVED_BY, $INKED_TO){
            $addStudent = $this->pub_pdo->prepare('INSERT INTO `shnmm_tbl_vouchers`
            (`ENTRY_DATE`,`STUDENT_NAME`,`STUDENT_CLASS`,
            `STUDENT_SECTION`, `STUDENT_ROLL`,`TRANSECTION_STATUS`, 
            `ACCOUNTS_HEAD`, `DESCRIPTION`, `AMOUNT`, 
            `RECEIVED`, `DUE`, `REMARK`, `RECEIVED_BY`, `INKED_TO`) 
            VALUES (?,?,?,
            ?,?,?,
            ?,?,?,?,
            ?,?,?,?)');
      
        $addStudent->execute([$ENTRY_DATE, $STUDENT_NAME,$STUDENT_CLASS,
            $STUDENT_SECTION, $STUDENT_ROLL,
            $TRANSECTION_STATUS, $ACCOUNTS_HEAD, 
            $DESCRIPTION, $AMOUNT, $RECEIVED, 
            $DUE, $REMARK, $RECEIVED_BY, $INKED_TO]);
    }

    public function updateVoucher($ENTRY_DATE,$DESCRIPTION, $AMOUNT, 
        $RECEIVED,$DUE, $REMARK, $VOUCHER_NO){
        $update = $this->pub_pdo->prepare('UPDATE `shnmm_tbl_vouchers` SET 
        `ENTRY_DATE`= ?,`DESCRIPTION`= ?,`AMOUNT`= ?,`RECEIVED`= ?,
        `DUE`= ?,`REMARK`= ? WHERE `VOUCHER_NO` = ?');
  
        $update->execute([
          $ENTRY_DATE,$DESCRIPTION,
          $AMOUNT,$RECEIVED,$DUE,
          $REMARK,$VOUCHER_NO,]);
    }
    
    public function showVoucherById($voucher_id){
        $statement = $this->pub_pdo->prepare('SELECT * FROM `shnmm_tbl_vouchers` WHERE `VOUCHER_NO`=?');
        $statement->execute([$voucher_id]);
        return $statement->fetchAll();
    }

}