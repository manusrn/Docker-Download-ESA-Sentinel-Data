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
        <section>
          <article>
            <h2>How does this page work?</h2>
            <p>
              This webpage allows you to download products from ESA's <a target="_blank" href="https://scihub.copernicus.eu/">Sentinel satellites</a>.<br />
              To use this tool, you have to create an account <a target="_blank" href="https://scihub.copernicus.eu/dhus/#/home">here</a>.<br />
              All the fields with * have to be filled.<br />
              You can create your geojson file on <a target="_blank" href="http://geojson.io/">geojson.io</a>.<br />
              Once the form is completed, press <strong>submit</strong> to launch the search and display the results. If there is an issue, check your parameters. You can also look at the log to see the complete error message.<br />
              If you are satisfied with the results of the search, press the download button that will be displayed, choosing the format you want your data to be in (single zip, multiple zips or  folders). if you want to download the complete products, you should choose the zip format ( Single zip is all products in one zip file, multiple zip is each product in one zipe file). If you are just interested in specific bands images, you should use the folders format.<br /><br />
              <strong>Usefull tips :</strong><br />
              <ul>
                <li>If you don't choose start and end date, the search will show all the products for the area for the last 24h.</li>
                <li>Choosing a type of product will overwrite the selection of satellites.</li>
                <li>Choosing a percentage of cloud will only work with sentinel 2.</li>
              </ul>
            </p>
          </article>
          <div id="interactive_part">
            <?php include("form.php") ?>
          </div>
        </section>

        <a target="_blank" href="downloads"><strong>General depository</strong></a>

      </div>

    </body>
</html>
