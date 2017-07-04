<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <style>.focus:focus {color: #14ff00;}</style>
        <link rel="stylesheet" href="style.css" />
        <title>Download Sentinel Data</title>
    </head>

    <body>
      <p>
        <form method="post" action="search.php" enctype="multipart/form-data" id="form1">
          <p>
            <label for="area">Area in geojson format, name without spaces *</label> :<input type="file" name="area" /><br />
            <label for="username">Your username *</label> : <input type="text" name="username" id="username" />
          </br>
            <label for="password">Your password *</label> : <input type="text" name="password" id="password" />
          </br>
            <label for="startdate">Start date ( yyyymmdd )</label> : <input type="text" name="startdate" id="startdate" placeholder="ex : 20171225"/>
          </br>
            <label for="enddate">End  date ( yyyymmdd )</label> : <input type="text" name="enddate" id="enddate" placeholder="ex : 20171231"/>
          </br>
            <!--<label for="producttype">Product type (choose from SLC, GRD, OCN, RAW, S2MSI1C, S2MSI2Ap) </label> : <input type="text" name="producttype" id="producttype"/>    -->
            <label for="producttype">Product type</label>
              <select name="producttype" id="producttype">
                  <option value="All" selected>All</option>
                  <optgroup label="Sentinel 1 products">
                    <option value="SLC">SLC</option>
                    <option value="GRD">GRD</option>
                    <option value="OCN">OCN</option>
                    <option value="RAW">RAW</option>
                  </optgroup>
                  <optgroup label="Sentinel 2 products">
                    <option value="S2MSI1C">S2MSI1C</option>
                    <option value="S2MSI2Ap">S2MSI2Ap</option>
                  </optgroup>


              </select>
          </br>
            <label for="cloud">Cloud coverage(0 to 100)</label> : <input type="text" name="cloud" id="cloud"/>
          </br>
             Satellite :<br />
             <input type="radio" name="sat" value="sentinel 1" id="sentinel 1" /> <label for="sentinel 1">sentinel 1</label><br />
             <input type="radio" name="sat" value="sentinel 2" id="sentinel 2" /> <label for="sentinel 2">sentinel 2</label><br />
             <input type="radio" name="sat" value="unspecified" id="All satellites" checked="checked"/> <label for="none">All satellites</label><br />
           </br>
             <!--input type="submit" value="Send" /-->
          </p>
        </form>
        <button class='focus' type="submit" form="form1" value="Submit">Submit</button>
      </p>

    </body>
</html>

<!--
<p>
  <form method="post" action="search.php" enctype="multipart/form-data" id="form1">
    <p>
      <label for="area">Area in geojson format, name without spaces</label> :<input type="file" name="area" /><br />
      <label for="username">Your username</label> : <input type="text" name="username" id="username" />
    </br>
      <label for="password">Your password</label> : <input type="text" name="password" id="password" />
    </br>
      <label for="startdate">Start date ( yyyymmdd )</label> : <input type="text" name="startdate" id="startdate" placeholder="ex : 20171225"/>
    </br>
      <label for="enddate">End  date ( yyyymmdd )</label> : <input type="text" name="enddate" id="enddate" placeholder="ex : 20171231"/>
    </br>
      <label for="producttype">Product type (choose from SLC, GRD, OCN, RAW, S2MSI1C, S2MSI2Ap) </label> : <input type="text" name="producttype" id="producttype"/>
    </br>
      <label for="cloud">Cloud coverage(0 to 100)</label> : <input type="text" name="cloud" id="cloud"/>
    </br>
       Satellite :<br />
       <input type="radio" name="sat" value="sentinel 1" id="sentinel 1" /> <label for="sentinel 1">sentinel 1</label><br />
       <input type="radio" name="sat" value="sentinel 2" id="sentinel 2" /> <label for="sentinel 2">sentinel 2</label><br />
       <input type="radio" name="sat" value="unspecified" id="All satellites" checked="checked"/> <label for="none">All satellites</label><br />
     </br>
    </p>
  </form>
  <button class='focus' type="submit" form="form1" value="Submit">Submit</button>
</p>    -->
