<?php
    if(isset($_GET['action'])){
        if($_GET['action'] === 'db-backup'){

            require ('../app/db-config.php');

            $tables = '*';
            $link = mysqli_connect($host,$user,$pass, $db);
        
            // Check connection
            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
                exit;
            }
        
            mysqli_query($link, "SET NAMES 'utf8'");
        
            //get all of the tables
            if($tables == '*')
            {
                $tables = array();
                $result = mysqli_query($link, 'SHOW TABLES');
                while($row = mysqli_fetch_row($result))
                {
                    $tables[] = $row[0];
                }
            }
            else
            {
                $tables = is_array($tables) ? $tables : explode(',',$tables);
            }
        
            $return = '';
            //cycle through
            foreach($tables as $table)
            {
                $result = mysqli_query($link, 'SELECT * FROM '.$table);
                $num_fields = mysqli_num_fields($result);
                $num_rows = mysqli_num_rows($result);
        
                $return.= 'DROP TABLE IF EXISTS `'.$table.'`;';
                $row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE '.$table));
                $return.= "\n\n".$row2[1].";\n\n";
                $counter = 1;
        
                //Over tables
                for ($i = 0; $i < $num_fields; $i++) 
                {   //Over rows
                    while($row = mysqli_fetch_row($result))
                    {   
                        if($counter == 1){
                            $return.= 'INSERT INTO `'.$table.'` VALUES(';
                        } else{
                            $return.= '(';
                        }
        
                        //Over fields
                        for($j=0; $j<$num_fields; $j++) 
                        {
                            $row[$j] = addslashes($row[$j]);
                            $row[$j] = str_replace("\n","\\n",$row[$j]);
                            if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                            if ($j<($num_fields-1)) { $return.= ','; }
                        }
        
                        if($num_rows == $counter){
                            $return.= ");\n";
                        } else{
                            $return.= "),\n";
                        }
                        ++$counter;
                    }
                }
                $return.="\n\n\n";
            }
        
            //save file
            $fileName = 'db.sql';
            $handle = fopen($fileName,'w+');
            fwrite($handle,$return);
            if(fclose($handle)){
                if (file_exists($fileName)) {
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename='.basename($fileName));
                    header('Content-Transfer-Encoding: binary');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($fileName));
                    ob_clean();
                    flush();
                    readfile($fileName);
                    exit;
                }
            }
            
        }
    }

    if(isset($_POST['dbBtn'])){

        require ('../app/db-config.php');

        $sql_data = file_get_contents($_FILES['dbFile']['tmp_name']);

        $connection = mysqli_connect($host,$user,$pass,$db);

        mysqli_character_set_name($connection);

        mysqli_set_charset($connection,"utf8");

        $data = explode(';',$sql_data);

        foreach($data as $query){
            if(!empty($query)){
                mysqli_query($connection,$query);
                //echo $query.' <b>SUCCESS</b></br>';
            }
            echo "<script> window.location.href = '?';</script>";
        }
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Database- Backup & Restore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  </head>
  <body class="p-3">
      <!--begin::App Content Header-->
      <div class="app-content-header pb-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6"><h3 class="mb-0">Database- Backup & Restore</h3></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page"><a href="?">Database- Backup & Restore</a></li>
            </ol>
          </div>
        </div>
      </div>
      </div>
      
      <!-- Main Body Content -->
      
      <div class="card p-4">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#backup-section" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Backup</button>
              </li>
              <li class="nav-item" role="presentation">
                  <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#restore-section" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Restore</button>
              </li>
          </ul>
      
          <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="backup-section" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                <div class="m-3">
                    <h4>Backup Database</h4>
                    <p>Click the button below to Download Database .sql file</p>
                    <a class="btn btn-primary" href="?action=db-backup">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-download-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 0a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 4.095 0 5.555 0 7.318 0 9.366 1.708 11 3.781 11H7.5V5.5a.5.5 0 0 1 1 0V11h4.188C14.502 11 16 9.57 16 7.773c0-1.636-1.242-2.969-2.834-3.194C12.923 1.999 10.69 0 8 0m-.354 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V11h-1v3.293l-2.146-2.147a.5.5 0 0 0-.708.708z"/>
                        </svg>
                        Download
                    </a>
                </div>
              </div>

              <div class="tab-pane fade" id="restore-section" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                <div class="m-3">
                    <h4 class="mb-3">Restore Database</h4>
                    <form
                        method="POST"
                        enctype="multipart/form-data">
                        
                        <input required name="dbFile" type="file" class="form-control mb-3" />

                        <button name="dbBtn" type="submit" class="btn btn-primary">Upload</button>

                    </form>
                </div>
              </div>
          </div>
      </div>

    <div class="d-block text-end m-3">
        <div class="small">
            by
            <a
            href="mailto:anis14109@gmail.com"
            class="text-dark text-decoration-none"
            target="_blank"
            >Anisur Rahman</a>
        </div>
    </div>


    <!-- Js Start -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  </body>
</html>