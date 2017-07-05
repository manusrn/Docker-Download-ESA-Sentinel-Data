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

        <h1> Result of the search</h1>
        <br />
        <a href="index.php"><strong>Not satisfied ? Go back to Homepage</strong></a>
        <br /><br />
        <a href="log_search.txt"><strong>Find the log here</strong></a>
        <br /><br />

        <?php


          //Check if the file is a geojson, and save it into /uploads
          if (isset($_FILES['area']) AND $_FILES['area']['error'] == 0)
          {

            //check if the format is geojson
            $infosfile = pathinfo($_FILES['area']['name']);
            $extension_upload = $infosfile['extension'];
            $extensions_allowed = array('geojson');
            if (in_array($extension_upload, $extensions_allowed))
            {
              $area = $_FILES['area']['name'] ;
              move_uploaded_file($_FILES['area']['tmp_name'],$_FILES['area']['name']);
              echo "Area saved ! <br />";//for testing
            }
          }
          $username = $_POST["username"];
          echo "username = $username <br />";
          $password = $_POST["password"];
          echo "password = hidden <br />";
          $startdate = $_POST["startdate"];
          if($startdate == NULL){
            $startdate = "" ;
            echo "startdate : last 24h <br />";
          }
          else{
            $startdate = "-s ".$startdate;//to respect sentinelsat command options syntax
            echo "startdate : $startdate <br />";
          }
          $enddate = $_POST["enddate"];
          if($enddate == NULL){
            $enddate = "" ;
            echo "enddate : last 24h <br />";
          }
          else{
            $enddate = "-e ".$enddate;//to respect sentinelsat command options syntax
            echo "enddate : $enddate <br />";
          }
          $producttype = $_POST["producttype"];
          if($producttype == "All"){
            $producttype = "" ;
            echo "producttype : All <br />";
          }
          else{
            $producttype = "--producttype  ".$producttype;//to respect sentinelsat command options syntax
            echo "product : $producttype <br />";
          }
          $cloud = $_POST["cloud"];
          if($cloud == NULL){
            $cloud = "";
            echo "cloud : unspecified <br />";
          }
          else{
            $cloud = "-c ".$cloud;//to respect sentinelsat command options syntax
            echo "cloud = $cloud <br />";
          }
          $sat = $_POST["sat"];
          if($sat == "unspecified"){
            $sat = "" ;
            echo "satellite : All satellites <br />";
          }
          else{
            $sat ="--".$sat; //to respect sentinelsat command options syntax
            echo "sat = $sat";
          }

          $cmd_search = "/opt/conda/bin/sentinel search "." ".$sat." ".$startdate." ".$enddate." ".$producttype." ".$cloud." ".$username." ".$password." ".$area ;
          $cmd_log = "/opt/conda/bin/sentinel search "." ".$sat." ".$startdate." ".$enddate." ".$producttype." ".$cloud." ".$username." password ".$area ;

          $output = shell_exec($cmd_search.' 2>&1');
          echo "<br /> <br />";

          //check if the search went well. Display the result if successful, display an error message if not

          //Unsuccessful search
          if ((strpos($output, 'Traceback') !== false )||(strpos($output, 'Missing argument') !== false)) {
            echo "An error appeared due to the parameters of the search. <a href='index.php'><strong>Go back to the Homepage</strong></a> and check your parameters.";
            echo "<br />Possible sources of error: <br />- username or password missing or incorrect <br />- date format incorrect <br />- Selection of cloud percentage is not possible with sentinel 1 <br />- product type format incorrect <br />- product type incompatible with chosen satellite";
            //write the cmd and the raw error in the log file
            $log = fopen("log_search.txt","a");
            $txt = $cmd_log.' '. $output ;
            fwrite($log , $txt) ;
            fclose($log);
          }
          //Successful search
          else{
            $old_char = array("Product", "---");
            $new_char = array("<br />Product", "<br /><br />---");
            $new_output = str_replace($old_char, $new_char, $output);// to adapt to php display
            echo $new_output ;
            //writing in the log file
            $log = fopen("log_search.txt","a");
            $txt = $cmd_log.' '. $output ;
            fwrite($log , $txt) ;
            fclose($log);

            //save the infos needed to launch download
            $cmd_download = $sat." ".$startdate." ".$enddate." ".$cloud." ".$username." ".$password." ".$area ;

            ?>
            <!-- Form directed to the download page. Appears only in search is successful -->
               <form method="post" action="download_folder.php" id="downloadfolders">
                   <p>
                     <input type="hidden" name="cmd" value="<?php echo $cmd_download ?>" >
                     <input type="hidden" name="username" value="<?php echo $username ?>" >
                   </p>
                 </form>
                 <button class='focus' type="submit" form="downloadfolders" value="Submit">Download in folders</button>

               <form method="post" action="download_zip.php" id="downloadzip">
                   <p>
                     <input type="hidden" name="cmd" value="<?php echo $cmd_download ?>" >
                     <input type="hidden" name="username" value="<?php echo $username ?>" >
                   </p>
                 </form>
                 <button class='focus' type="submit" form="downloadzip" value="Submit">Download in zip</button>
            <?php
          }
       ?>

     </div>

    </body>
</html>
