<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style.css" />
        <title>Download Sentinel Data</title>
    </head>

    <body>
      <div id="full_page">
        <?php include("header.php") ?>

        <h1> Downloaded zip files</h1>
        <br />
        <a href="index.php"><strong>Homepage</strong></a>
        <br /><br />

        <?php

          //Creating the user depository, with the format date_username
          $user = $_POST["username"];
          $date = date("Y-m-d-h-i-s");
          //$date = "0000-00-00-00-00-00" ;  // usefull for testing
          $userfolder = $date."_".$user ;
          $depository = "/var/www/html/downloads/$userfolder";
          mkdir($depository);

          // Running sentinelsat download, downloaded products in /downloads/ date_username
          $cmd = $_POST["cmd"];
          $cmd = "/opt/conda/bin/sentinel search -d -p $depository  $cmd" ;
          shell_exec($cmd.' 2>&1');
          echo "<br /> <br />";

          //Comment from here to "end comment" if Sen2cor doesn't work

          //unzipping of the L1C files in downloads
          $files_list = scandir($depository);
          $nb_files = count($files_list);
          for ($x = 0; $x <= $nb_files ; $x++){ // check for every file or depository in the folder $depository
            // check if the file is a zip file of a L1C product
            if ((strpos($files_list[$x], 'MSIL1C') !== false )&&(strpos($files_list[$x], 'zip') !== false)){
              shell_exec("/usr/bin/unzip $depository/$files_list[$x]  -d $depository  2>&1");
              shell_exec("rm $depository/$files_list[$x]"); // rm the zip file
            }

          }
          // Sen2cor processing of L1C Products
          $files_list = scandir($depository);// scan the depository again to see all the unziped files
          $nb_files = count($files_list);
          for ($x = 0; $x <= $nb_files ; $x++){// check for every file or depository in the folder $depository
            // check if the file is a L1C product and is NOT a zip file
            if ((strpos($files_list[$x], 'MSIL1C') !== false )&&(strpos($files_list[$x], 'zip') === false)){
              // Run sen2cor processing of L1C products
              shell_exec("/opt/conda/bin/L2A_Process $depository/$files_list[$x] 2>&1");
              shell_exec("rm -r $depository/$files_list[$x] 2>&1"); // rm the L1C product
            }
          }
          // zipping of L2A depositories
          $files_list = scandir($depository);// scan the depository again to see all the unziped files
          $nb_files = count($files_list);
          for ($x = 0; $x <= $nb_files ; $x++){// check for every file or depository in the folder $depository
            // check if the file is a L1C product and is NOT a zip file
            if ((strpos($files_list[$x], 'MSIL2A') !== false )&&(strpos($files_list[$x], 'zip') === false)){
              //create parent folder to have the product folder in the zip file
              $parentfold = str_replace(".SAFE","",$files_list[$x]);
              mkdir("$depository/$parentfold");
              //Move the product folder in the parent folder
              shell_exec("mv $depository/$files_list[$x]  $depository/$parentfold/ ");
              // Zip the content of the parent folder
              shell_exec("cd $depository/$parentfold/ && /usr/bin/zip -r $depository/$parentfold.zip ./* && cd -   2>&1");
              shell_exec("rm -r $depository/$parentfold 2>&1"); // rm the L2A product parent depository
            }
          }

          //end comment if Sen2cor doesn't work

        echo "<br /> <br />All the files have been donwloaded and processed. You can find them in Downloaded Products <br /><br />";

        ?>

        <a target="_blank" href="downloads/<?php echo $userfolder ?>"><strong>Downloaded Products</strong></a>

     </div>

    </body>
</html>
