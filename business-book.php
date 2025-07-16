<?php require('app/db-config.php');?>
<?php require('app/DbClass.php');?>
<?php $db = new DbClass(); ?>

<?php
    if(isset($_GET['business'])){
      $ledger_books_id = filter_var($_GET['business'], FILTER_SANITIZE_NUMBER_INT);
    }else{
      $ledger_books_id = 0;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ledger-Book-App</title>
  <link rel="stylesheet" href="app/app.css">
</head>
<body>
  <?php
      $result = $db->showLedgerBooksName($ledger_books_id);
      foreach($result as $data): ?>
      <a href="ledger-book.php?ledger=<?= $data['id'] ?>"><?= $data['ledger_book_name'] ?></a>
      <br>
  <?php endforeach; ?>

  <script src="app/app.js"></script>
</body>
</html>