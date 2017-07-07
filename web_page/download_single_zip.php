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

        <h1> Downloaded folders</h1>
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
          $cmd = "/opt/conda/bin/sentinel search -d -p ".$depository." ".$cmd ;
          shell_exec("$cmd  2>&1");
          echo "<br /> <br />";

          //unzipping of the files in downloads
          $files_list = scandir($depository);
          $nb_files = count($files_list);
          for ($x = 0; $x <= $nb_files ; $x++){ // check for every file or depository in the folder $depository
            // check if the file is a zip file
            if (strpos($files_list[$x], 'zip') !== false ){
              shell_exec("/usr/bin/unzip $depository/$files_list[$x]  -d $depository  2>&1");
              shell_exec("rm -r $depository/$files_list[$x]");// rm the zip file
            }

          }
          //Comment from here to "end comment" if Sen2cor doesn't work

          // sen2cor Processing of L1C products
          $files_list = scandir($depository);// scan the depository again to see all the unziped files
          $nb_files = count($files_list);
          for ($x = 0; $x <= $nb_files ; $x++){// check for every file or depository in the folder $depository
            // check if the file is a L1C product and is NOT a zip file
            if ((strpos($files_list[$x], 'MSIL1C') !== false )&&(strpos($files_list[$x], 'zip') === false)){
              shell_exec("/opt/conda/bin/L2A_Process $depository/$files_list[$x]  2>&1");
              shell_exec("rm -r $depository/$files_list[$x]");// rm the L1C depository
            }
          }
          //end comment (if sen2cor doesn't work)


          // Zip the content of the parent folder
          shell_exec("cd $depository/ && /usr/bin/zip -r /var/www/html/downloads/$userfolder.zip ./* && cd -   2>&1");
          shell_exec("rm -r $depository  2>&1"); // rm the L2A product parent depository


          echo "<br /> <br />All the files have been donwloaded and processed. <br /> <br />";
        ?>

        <a target="_blank" href="downloads/<?php echo $userfolder.zip ?>"><strong>Click here to download the zip file</strong></a>

     </div>

    </body>
</html>
