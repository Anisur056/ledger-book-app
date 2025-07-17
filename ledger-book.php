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
  <meta name="viewport" content="width=device-width, user-scalable=no">
  <title>Ledger-Book-App</title>
  <link rel="stylesheet" href="app/css/app.css">
  <link rel="stylesheet" href="app/css/bootstrap.min.css">
</head>
<body style="width:393px; margin: 0 auto;">

  <!-- Mobile Navbar -->
  <nav class="border-bottom">
    <div class="d-flex flex-row justify-content-between align-items-center">
      <div class="left-side">
        <div class="d-flex flex-row justify-content-between align-items-center">
          <div class="1 px-3">
            <!-- Back Button -->
             <a href="index.php" class="text-decoration-none text-black">
               <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                 <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
               </svg>
             </a>
          </div>
          <div class="2">
            <!-- Ledger book Title -->
            <span class="fs-6">
              <?php $result = $db->showLedgerBooksid($ledger_books_id);
                  foreach($result as $data): ?>
                  <?= $data['ledger_book_name'] ?>
              <?php endforeach; ?>
            </span>
          </div>
        </div>
      </div>
      <div class="right-side">
        <!-- Add Entry Button -->
        <a href="" class="me-3 text-decoration-none text-black" data-bs-toggle="offcanvas" data-bs-target="#addEntryForm" aria-controls="offcanvasRight">
          <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-folder-plus" viewBox="0 0 16 16">
            <path d="m.5 3 .04.87a2 2 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2m5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19q-.362.002-.683.12L1.5 2.98a1 1 0 0 1 1-.98z"/>
            <path d="M13.5 9a.5.5 0 0 1 .5.5V11h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V12h-1.5a.5.5 0 0 1 0-1H13V9.5a.5.5 0 0 1 .5-.5"/>
          </svg>
        </a>
        <!-- Prfile Logo -->
        <img src="app/img/profile.jpg" alt="" class="image rounded-circle m-3">
      </div>
    </div>
  </nav>

  <!-- Main Summary  -->
  <div class="card m-3">

    <div class="d-flex flex-row justify-content-between align-items-center border-bottom p-2">
      <div class="">
        <strong>
          Net Balance
        </strong>
      </div>
      <div class="">
        <strong>
          2,075
        </strong>
      </div>
    </div>

    <div class="d-flex flex-row justify-content-between align-items-center p-2">
      <div class="">
        Total In (+)
      </div>
      <div class="text-success">
        22860
      </div>
    </div>

    <div class="d-flex flex-row justify-content-between align-items-center p-2">
      <div class="">
        Total Out (-)
      </div>
      <div class="text-danger">
        20785
      </div>
    </div>

    <div class="text-center border-top p-3">
      <a href="" class="text-decoration-none text-primary">VIEW REPORTS ></a>
    </div>

  </div>

  <p class="text-center">--- Showing 111 entries ---</p>


  <!-- all ledger entry list -->
  <main>
    <?php
        $result = $db->showLedgerBookTranscetion($ledger_books_id);
        foreach($result as $data): ?>
          <div class="card m-2 p-2 
            <?php 
            if($data['cash_in'] > 0){ echo 'border-success';
            }else{ echo 'border-danger'; }
            ?>">
            <div class="d-flex flex-row justify-content-between align-items-center">
              <div class="left-side">
                <span><?= $data['accounts_head'] ?></span>  
              </div>
              <div class="right-side">
                
                  <?php
                    if($data['cash_in']>0){
                      echo "<span class='text-success'>".$data['cash_in']."</span>";
                    }elseif($data['cash_out']>0){
                      echo "<span class='text-danger'>".$data['cash_out']."</span>";
                    }
                  ?>
              </div>
            </div>
            <div class="d-flex flex-row justify-content-between align-items-center">
              <div class="left-side">
                <span><?= $data['description'] ?></span>  
              </div>
              <div class="right-side">
                <span>Balance: 0000</span>
              </div>
            </div>
            <span class="border-top">Entry by : Anisur Rahman at <?= $data['time'] ?> <?= $data['date'] ?></span>
          </div>
    <?php endforeach; ?>
  </main>



<div class="offcanvas offcanvas-end" tabindex="-1" id="addEntryForm" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header bg-light">
    <h5 class="offcanvas-title" id="offcanvasRightLabel">Add Entry</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">

    <div class="mb-3">
      <label  class="form-label">Date :</label>
      <input type="text" class="form-control" placeholder="name@example.com" value="<?php echo date('d-M-Y');?>">
    </div>
    <div class="mb-3">
      <label  class="form-label">Time :</label>
      <input type="text" class="form-control" placeholder="name@example.com" value="<?php echo date('h:i A');?>">
    </div>
    <div class="mb-3">
      <label  class="form-label">Catagory :</label>
      <input type="text" class="form-control" value="">
    </div>
    <div class="mb-3">
      <label  class="form-label">Amount :</label>
      <input type="text" class="form-control" value="">
    </div>
    <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Description</label>
      <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
    </div>
    

  </div>
  
  <div class="offcanvas-footer bg-light p-3">
    <button type="button" class="btn btn-success float-end">Save</button>
  </div>
</div>



  <script src="app/js/app.js"></script>
  <script src="app/js/bootstrap.bundle.min.js"></script>
</body>
</html>