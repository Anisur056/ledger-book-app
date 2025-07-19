<?php require('app/db-config.php');?>
<?php require('app/DbClass.php');?>
<?php $db = new DbClass(); ?>

<?php
    if(isset($_GET['business'])){
      $ledger_books_id = filter_var($_GET['business'], FILTER_SANITIZE_NUMBER_INT);
    }else{
      $ledger_books_id = 1;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no">
  <title>Ledger-Book-App</title>
  <link rel="stylesheet" href="app/css/app.css">
  <link rel="stylesheet" href="app/css/bootstrap.min.css">
</head>
<body class="body-mobile bg-app-gray">

  <!-- Mobile Navbar -->
  <nav class="border-bottom">
    <div class="d-flex flex-row justify-content-between align-items-center">
      <div class="left-side">
        <div class="d-flex flex-row justify-content-between align-items-center">
          <div class="1 px-3">
            <!-- Logo -->
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-buildings" viewBox="0 0 16 16">
              <path d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022M6 8.694 1 10.36V15h5zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5z"/>
              <path d="M2 11h1v1H2zm2 0h1v1H4zm-2 2h1v1H2zm2 0h1v1H4zm4-4h1v1H8zm2 0h1v1h-1zm-2 2h1v1H8zm2 0h1v1h-1zm2-2h1v1h-1zm0 2h1v1h-1zM8 7h1v1H8zm2 0h1v1h-1zm2 0h1v1h-1zM8 5h1v1H8zm2 0h1v1h-1zm2 0h1v1h-1zm0-2h1v1h-1z"/>
            </svg>
          </div>
          <div class="2">
            <div class="d-flex flex-column">
              <span class="fsize-title">SALARY-OF-JUNE-25</span>
              <span class="fsize-sub">Tap to switch business</span>
            </div>
          </div>
          <div class="3 px-3">
            <!-- Down Logo -->
            <button class="btn btn-outline-none p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
              </svg>
            </button>
          </div>
        </div>
      </div>
      <div class="right-side">
        <!-- Prfile Logo -->
        <img src="app/img/profile.jpg" alt="" class="image rounded-circle m-3">
      </div>
    </div>
  </nav>




<!-- Ledger Book List -->
<?php
  $result = $db->showLedgerBooksName($ledger_books_id);
  foreach($result as $data): ?>

  <a class="text-decoration-none text-black border-bottom d-block py-4" href="ledger-book.php?ledger=<?= $data['id'] ?>">
    <?= $data['ledger_book_name'] ?>
  </a>

<?php endforeach; ?>








<!-- Right side Offcanvas Navigation -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasBottomLabel">Business Book List</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <?php
        $result = $db->showBusinessBookName();
        foreach($result as $data): ?>

          <a class="text-decoration-none text-black border-bottom d-block py-4" href="?business=<?= $data['id'] ?>">
            <?= $data['business_book_name'] ?>
          </a>

        <?php endforeach; ?>
    </div>
  </div>




  <script src="app/js/app.js"></script>
  <script src="app/js/bootstrap.bundle.min.js"></script>
</body>
</html>