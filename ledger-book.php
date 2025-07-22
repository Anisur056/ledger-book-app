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

<?php

  // verify if request method is post & submited via html form.
  if ($_SERVER['REQUEST_METHOD']==='POST') 
	{
        // Only works if addContactBtn button clicked.
		if(isset($_POST['add_submit_button']))
        {
            // Takes values of submited html form.
            // in html {name="..."} attribute in required.
            $tnx_status = $_POST['tnx_status'];
            $date_add_input = $_POST['date_add_input'];
            $time_add_input = $_POST['time_add_input'];
            $amount_add_input = $_POST['amount_add_input'];
            $decription_add_input = $_POST['decription_add_input'];
            $catagory = $_POST['catagory'];

            // Sql command to insert data.
            if($tnx_status === 'cash_in'){
              $insert = $pdo->prepare('INSERT INTO `tbl_ledger_book_transections` (`date`,`time`,`description`,`accounts_head`,`cash_in`,`tbl_ledger_books_id`) VALUES(?,?,?,?,?,?)');
              $insert->execute([$date_add_input, $time_add_input, $decription_add_input, $catagory, $amount_add_input, $ledger_books_id]);
            }else{
              $insert = $pdo->prepare('INSERT INTO `tbl_ledger_book_transections` (`date`,`time`,`description`,`accounts_head`,`cash_out`,`tbl_ledger_books_id`) VALUES(?,?,?,?,?,?)');
              $insert->execute([$date_add_input, $time_add_input, $decription_add_input, $catagory, $amount_add_input, $ledger_books_id]);
            }
        }

        // Only works if updateContentBtn button clicked.
		if(isset($_POST['updateContentBtn']))
        {
            // Takes values of submited html form.
            // in html {name="..."} attribute in required.
            $update_tnx_id = $_POST['update_tnx_id'];
            $update_tnx_status = $_POST['update_tnx_status'];
            $update_date_add_input = $_POST['update_date_add_input'];
            $update_time_add_input = $_POST['update_time_add_input'];
            $update_amount_add_input = $_POST['update_amount_add_input'];
            $update_decription_add_input = $_POST['update_decription_add_input'];
            $update_catagory = $_POST['update_catagory'];

            // Sql command to update data.
            if($update_tnx_status === 'cash_in'){
              $update = $pdo->prepare('UPDATE `tbl_ledger_book_transections` SET `date`=?, `time`=?, `description`=?, `accounts_head`=?, `cash_in`=?, `cash_out`=0 WHERE `id`=?');
              $update->execute([$update_date_add_input, $update_time_add_input, $update_decription_add_input, $update_catagory, $update_amount_add_input, $update_tnx_id]);
            }else{
              $update = $pdo->prepare('UPDATE `tbl_ledger_book_transections` SET `date`=?, `time`=?, `description`=?, `accounts_head`=?, `cash_out`=?, `cash_in`=0 WHERE `id`=?');
              $update->execute([$update_date_add_input, $update_time_add_input, $update_decription_add_input, $update_catagory, $update_amount_add_input, $update_tnx_id]);
            }

        }

        // Only works if deleteContentBtn button clicked.
		if(isset($_POST['delete_submit_button']))
        {
            // Takes table data id from hidden field.
            echo $deleteIdInput = $_POST['deleteIdInput'];

            // delete table record from database.
            $delete = $pdo->prepare('DELETE FROM `tbl_ledger_book_transections` WHERE id=?');
            $delete->execute([$deleteIdInput]);

        }
	}

  // Script to show data with pagination features.
  // Limit for data show per page.
  $limit_to_show = 10;

  // Get the curret page number.
  if(isset($_GET['page'])){
      $url_page_number = $_GET['page'];
  }else{
      $url_page_number = 1;
  }

  // Offset to show data from.
  $offset = ($url_page_number-1)*$limit_to_show;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no">
  <title>Ledger-Book-App</title>
  <link rel="stylesheet" href="app/css/app.css">
  <link rel="stylesheet" href="app/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.2.2/font/bootstrap-icons.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Akshar:wght@300..700&family=Tiro+Bangla:ital@0;1&display=swap" rel="stylesheet">
    
</head>
<body class="body-mobile bg-app-gray">

  <!-- Mobile Navbar -->
  <nav class="border-bottom bg-app-light">
    <div class="d-flex flex-row justify-content-between align-items-center">
      <div class="left-side">
        <div class="d-flex flex-row justify-content-between align-items-center">
          <div class="px-3">
            <!-- Back Button -->
             <a href="index.php" class="text-decoration-none text-black">
               <i class="bi bi-arrow-left fs-3"></i>
             </a>
          </div>
          <div class="">
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
          <i class="bi bi-plus-square fs-3"></i>
        </a>
        <!-- Prfile Logo -->
        <img src="app/img/profile.jpg" alt="" class="image rounded-circle m-3">
      </div>
    </div>
  </nav>

  <!-- Net Balance Summary  -->
  <div class="card m-3">

    <div class="d-flex flex-row justify-content-between align-items-center p-2">
      <div class="">
        Total In (+)
      </div>
      <div class="text-success">
        <?php
            $total_in_amount = 0;
            $result = $db->cashCalculation($ledger_books_id);
            foreach($result as $data){
                $total_in_amount+= $data['cash_in'];
            }
            echo "<b>$total_in_amount</b>";
        ?>    
      </div>
    </div>

    <div class="d-flex flex-row justify-content-between align-items-center p-2">
      <div class="">
        Total Out (-)
      </div>
      <div class="text-danger">
        <?php
            $total_out_amount = 0;
            $result = $db->cashCalculation($ledger_books_id);
            foreach($result as $data){
                $total_out_amount+= $data['cash_out'];
            }
            echo "<b>$total_out_amount</b>";
        ?>  
      </div>
    </div>

    <div class="d-flex flex-row justify-content-between align-items-center border-top p-2">
      <div class="">
        <strong>
          Net Balance
        </strong>
      </div>
      <div class="">
        <strong>
        <?php
          echo ($total_in_amount-$total_out_amount);
        ?> 
        </strong>
      </div>
    </div>

    <div class="text-center border-top p-3">
      <a href="" class="text-decoration-none text-primary">VIEW REPORTS ></a>
    </div>
  </div>

  <!-- Entry Counter -->
  <p class="text-center">
    --- Total 
        <?php
          $count = 0;
          $result = $db->cashCalculation($ledger_books_id);
          foreach($result as $data){
              $count++;
          }
          echo "<b>$count</b>";
        ?>
    Transection ---
  </p>

  <!-- all ledger entry list -->
  <main>
    <?php
      $result = $db->showLedgerBookTranscetion($ledger_books_id, $offset, $limit_to_show);
      foreach($result as $data): ?>
        <div class="p-2 mb-2 bg-app-light">
          <!-- left side `accounts_head/catagory`, Right side `cash_in/out` -->
          <div class="d-flex flex-row justify-content-between align-items-center py-2">
            <!-- left side -->
            <div class="left-side">
              <span class="bg-app-catagory p-1 rounded-2 tiro-bangla"><?= $data['accounts_head'] ?></span>  
            </div>
            <!-- right side -->
            <div class="right-side">
                <?php
                  if($data['cash_in']>0){ echo "<span class='text-success'>".$data['cash_in']."</span>";
                  }elseif($data['cash_out']>0){ echo "<span class='text-danger'>".$data['cash_out']."</span>";} ?>
            </div>
          </div>
          <!-- left side `description`, Right side `balance` -->
          <div class="d-flex flex-row justify-content-between align-items-center border-bottom">
            <!-- left side -->
            <div class="left-side">
              <span class="tiro-bangla"><?= $data['description'] ?></span>  
            </div>
            <!-- right side -->
            <div class="right-side">
              <!-- <span>Balance: 0000</span> -->
            </div>
          </div>
          <!-- Entry By -->
          <div class="mt-2"><span class="text-primary">Entry by : Anisur Rahman </span> at <?= $data['time'] ?></div>
          <div class="mt-1"><?= $data['date'] ?></div>
          <div class="d-flex flex-row justify-content-end">
            <button class="btn btn-success m-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#updateEntryForm<?= $data['id'] ?>" aria-controls="offcanvasRight"><i class="bi bi-pencil-square"></i></button>
            <button class="btn btn-danger m-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#deleteEntryForm<?= $data['id'] ?>" aria-controls="offcanvasRight"><i class="bi bi-trash"></i></button>
            <a class="btn btn-primary m-1" href="voucher_print.php"><i class="bi bi-printer"></i></a>
          </div>
        </div>


        <!-- Update Entry Form -->
        <form action="" method="post">
          <div class="offcanvas offcanvas-end" tabindex="-1" id="updateEntryForm<?= $data['id'] ?>" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header bg-light">
              <h5 class="offcanvas-title" id="offcanvasRightLabel">Update Entry</h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              <!-- Cash in/out -->
              <div class="py-2">
                <label  class="form-label">Transection Type: </label><br>
                <input type="radio" class="btn-check" name="update_tnx_status" id="update_cash_in_button<?= $data['id'] ?>" value="cash_in" <?= ($data['cash_in'] > 0) ? 'checked' : '' ; ?> >
                <label class="btn text-success" for="update_cash_in_button<?= $data['id'] ?>">Cash In (+)</label>

                <input type="radio" class="btn-check" name="update_tnx_status" id="update_cash_out_button<?= $data['id'] ?>" value="cash_out" <?= ($data['cash_out'] > 0) ? 'checked' : '' ; ?> >
                <label class="btn text-danger" for="update_cash_out_button<?= $data['id'] ?>">Cash Out (-)</label>
              </div>
              <!-- date & time -->
              <div class="row">
                <div class="col-6">
                  <div class="mb-3">
                    <label  class="form-label">Date :</label>
                    <input type="text" class="form-control" name="update_date_add_input" value="<?= $data['date'] ?>">
                  </div>
                </div>
                <div class="col-6">
                  <div class="mb-3">
                    <label  class="form-label">Time :</label>
                    <input type="text" class="form-control" name="update_time_add_input" value="<?= $data['time'] ?>">
                  </div>
                </div>
              </div>
              <!-- amout input -->
              <div class="mb-3">
                <label  class="form-label">Amount :</label>
                <input type="text" class="form-control" name="update_amount_add_input" value="<?= ($data['cash_in'] > 0) ? $data['cash_in'] : $data['cash_out'] ; ?>">
              </div>
              <!-- Description input -->
              <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                <textarea class="form-control" name="update_decription_add_input" rows="3"><?= $data['description'] ?></textarea>
              </div>
              <!-- catagory -->
              <div class="mb-3">
                <label  class="form-label">Catagory :</label>
                <select name="update_catagory" class="form-select mb-3">
                  <option value="">নির্বাচন করুন</option>
                  <?php
                    $result = $db->read_tbl_transection_accounts_head();
                    foreach($result as $data_for_select): ?>
                      
                      <option <?= ($data['accounts_head'] === $data_for_select['accounts_head_name']) ? 'selected' : '' ; ?> value="<?= $data_for_select['accounts_head_name'] ?>"><?= $data_for_select['accounts_head_name'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="offcanvas-footer bg-light p-3">
              <!-- submit button -->
              <input type="hidden" name="update_tnx_id" value="<?= $data['id'] ?>">
              <button type="submit" name="updateContentBtn" class="btn btn-success float-end">Save</button>
            </div>
          </div>
        </form>

        <!-- Delete Entry Form -->
        <form action="" method="post">
          <div class="offcanvas offcanvas-end" tabindex="-1" id="deleteEntryForm<?= $data['id'] ?>" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header bg-light">
              <h5 class="offcanvas-title text-danger" id="offcanvasRightLabel">Delete Entry</h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              <h6 class="text-danger">Are You Want to Delete this Transection?  </h6>                           
              <div class="modal-footer">
                  <input name="deleteIdInput" type="hidden" value="<?= $data['id'] ?>">
              </div>
            </div>
            <div class="offcanvas-footer bg-light p-3">
              <!-- submit button -->
              <button type="submit" name="delete_submit_button" class="btn btn-danger float-end">Yes</button>
            </div>
          </div>
        </form>


    <?php endforeach; ?>
  </main>

  <!-- Pagination Script -->
  <nav>
    <ul class="pagination m-3 d-flex flex-wrap justify-content-center">
        <?php
            // Script to show page number
            $select_users = $pdo->prepare('SELECT * FROM `tbl_ledger_book_transections`');
            $select_users->execute();
            $total_records = $select_users->rowCount();
            if($total_records > 0){
                $total_pages = ceil($total_records/$limit_to_show);
                for($page_number = 1; $page_number<=$total_pages; $page_number++){ ?>
                    <li class="page-item"> 
                        <a class="page-link <?php if($page_number == $url_page_number){echo('active');} ?>" href="?ledger=<?= $ledger_books_id ?>&page=<?= $page_number ?>">
                            <?= $page_number ?>
                        </a>
                    </li><?php
                }
            }
        ?>
    </ul>
  </nav>

  <!-- Add Entry Form -->
  <form action="" method="post">
    <div class="offcanvas offcanvas-end" tabindex="-1" id="addEntryForm" aria-labelledby="offcanvasRightLabel">
      <div class="offcanvas-header bg-light">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Add Entry</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <!-- Cash in/out -->
        <div class="py-2">
          <label  class="form-label">Transection Type: </label><br>
          <input type="radio" class="btn-check" name="tnx_status" id="cash_in_button" value="cash_in" checked>
          <label class="btn text-success" for="cash_in_button">Cash In (+)</label>

          <input type="radio" class="btn-check" name="tnx_status" id="cash_out_button" value="cash_out">
          <label class="btn text-danger" for="cash_out_button">Cash Out (-)</label>
        </div>
        <!-- date & time -->
        <div class="row">
          <div class="col-6">
            <div class="mb-3">
              <label  class="form-label">Date :</label>
              <input type="text" class="form-control" name="date_add_input" value="<?php echo date('d-M-Y');?>">
            </div>
          </div>
          <div class="col-6">
            <div class="mb-3">
              <label  class="form-label">Time :</label>
              <input type="text" class="form-control" name="time_add_input" value="<?php echo date('h:i A');?>">
            </div>
          </div>
        </div>
        <!-- amout input -->
        <div class="mb-3">
          <label  class="form-label">Amount :</label>
          <input type="text" class="form-control" name="amount_add_input">
        </div>
        <!-- Description input -->
        <div class="mb-3">
          <label for="exampleFormControlTextarea1" class="form-label">Description</label>
          <textarea class="form-control" name="decription_add_input" rows="3"></textarea>
        </div>
        <!-- catagory -->
        <div class="mb-3">
          <label  class="form-label">Catagory :</label>
          <select name="catagory" class="form-select mb-3">
            <option value="">নির্বাচন করুন</option>
            <?php
              $result = $db->read_tbl_transection_accounts_head();
              foreach($result as $data): ?>
                
                <option value="<?= $data['accounts_head_name'] ?>"><?= $data['accounts_head_name'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="offcanvas-footer bg-light p-3">
        <!-- submit button -->
        <button type="submit" name="add_submit_button" class="btn btn-success float-end">Save</button>
      </div>
    </div>
  </form>



  <script src="app/js/app.js"></script>
  <script src="app/js/bootstrap.bundle.min.js"></script>
</body>
</html>