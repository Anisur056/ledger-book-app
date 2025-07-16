<?php require('app/db-config.php');?>
<?php require('app/DbClass.php');?>
<?php $db = new DbClass(); ?>

<?php
    if(isset($_GET['ledger'])){
      $ledger_books_id = filter_var($_GET['ledger'], FILTER_SANITIZE_NUMBER_INT);
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

<a href="business-book.php?business=<?= $ledger_books_id ?>">< back</a>

    <table id="transectionTable" class="table responsiveTable" style="font-size:10pt;">
        <thead>
            <tr>
            <td style="width:3%"></td>
            <td style="width:10%">Date & Time</td>
            <td style="width:10%">Details</td>
            <td style="width:10%">party_name</td>
            <td style="width:10%">accounts_head</td>
            <td style="width:10%">entry_by</td>
            <td style="width:5%">cash_in</td>
            <td style="width:5%">Cash Out</td>
            <td style="width:5%">Balance</td>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php
                $result = $db->showLedgerBookTranscetion($ledger_books_id);
                foreach($result as $data): ?>
                
                <tr 
                <?php if($data['cash_in'] > 0){ echo 'class="table-success"';
                }else{ echo 'class="table-danger"'; }
                ?> >
                    <td><?= $data['id'] ?></td>
                    <td data-label="Date & Time: "><?= $data['date'] ?><br><?= $data['time'] ?></td>
                    <td data-label="Details: "><?= $data['description'] ?></td>
                    <td data-label="Party Name: "><?= $data['party_name'] ?></td>
                    <td data-label="Accounts Head: "><?= $data['accounts_head'] ?></td>
                    <td data-label="Entry By: "><?= $data['entry_by'] ?></td>
                    <td data-label="Cash In: "><?= $data['cash_in'] ?></td>
                    <td data-label="Cash Out: "><?= $data['cash_out'] ?></td>
                    <td data-label="Balance: ">0</td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>

  <script src="app/app.js"></script>
</body>
</html>