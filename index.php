<?php require('settings.php');?>
<?php require('DbClass.php');?>
<?php $db = new DbClass(); ?>

<?php

    if(isset($_GET['ledger-books'])){
      $ledger_books_id = filter_var($_GET['ledger-books'], FILTER_SANITIZE_NUMBER_INT);
    }else{
      $ledger_books_id = 0;
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ledger-Book-v0.1</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="theme/css/adminlte.min.css">

  <link rel="stylesheet" href="theme/css/dataTables.dataTables.css" />

  <link rel="stylesheet" href="theme/css/buttons.dataTables.css" />
</head>
<body>
  <div class="wrapper">

    <!-- Top Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form class="form-inline">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>
      </ul>
    </nav>
    <!-- /. Top navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="?" class="brand-link">
        <img src="theme/img/128x128.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Ledger-Book-v0.1</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="theme/img/128x128.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">Anisur Rahman</a>
          </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->

            <?php
                $result = $db->showBusinessBookName();
                foreach($result as $data): ?>

                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fa-solid fa-book"></i>
                    <p>
                      <?= $data['business_book_name'] ?>
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>

                  <ul class="nav nav-treeview">

                    <?php
                    $result2 = $db->showLedgerBooksName($data['id']);
                    foreach($result2 as $data): ?>
                    
                      <li class="nav-item ml-3">
                        <a href="?ledger-books=<?= $data['id'] ?>" class="nav-link">
                          <i class="fa-solid fa-receipt nav-icon"></i>
                          <p><?= $data['ledger_book_name'] ?></p>
                        </a>
                      </li>
                    
                    <?php endforeach; ?>
                      
                  </ul>

                </li>

            <?php endforeach; ?>
            

          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">
                <?php
                  $result3 = $db->showLedgerBookById($ledger_books_id);
                  foreach($result3 as $data){
                    echo $data['ledger_book_name'];
                  }
                ?>
              </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="?">Home</a></li>
                <li class="breadcrumb-item active">
                <?php
                  $result3 = $db->showLedgerBookById($ledger_books_id);
                  foreach($result3 as $data){
                    echo $data['ledger_book_name'];
                  }
                ?>
                </li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="card p-3 table-responsive">
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
          </div>
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="float-right d-none d-sm-inline">
        Anything you want
      </div>
      <!-- Default to the left -->
      <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>
  </div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="theme/js/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="theme/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="theme/js/adminlte.min.js"></script>

<script src="theme/js/datatable/dataTables.js"></script>
<script src="theme/js/datatable/dataTables.buttons.js"></script>
<script src="theme/js/datatable/buttons.dataTables.js"></script>
<script src="theme/js/datatable/buttons.colVis.min.js"></script>
<script src="theme/js/datatable/jszip.min.js"></script>
<script src="theme/js/datatable/pdfmake.min.js"></script>
<script src="theme/js/datatable/vfs_fonts.js"></script>
<script src="theme/js/datatable/buttons.html5.min.js"></script>
<script src="theme/js/datatable/buttons.print.min.js"></script>

<script>
  const table = new DataTable('#transectionTable', {
      lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, 'All']
      ],
      order: [[0, 'dsc']],
      scrollX: true,
      layout: {
        topStart: 'pageLength',
        topEnd: 'search',
        bottomStart: {
            buttons: ['copy', 'csv', 'excel', 'pdf', 
            {
                text: 'JSON',
                action: function (e, dt, button, config) {
                    var data = dt.buttons.exportData();

                    DataTable.fileSave(new Blob([JSON.stringify(data)]), 'Export.json');
                }
            },
            {
              extend: 'print',
              exportOptions: {
                columns: ':visible'
              },
              autoPrint: false
            },
            {
                extend: 'colvis',
                collectionLayout: 'fixed columns',
                popoverTitle: 'Column visibility control',
                postfixButtons: ['colvisRestore']
            },
            ]
        },
        bottomEnd: 'info'
      }
  });
</script>

</body>
</html>
