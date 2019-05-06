<?php    header("Content-type: text/html; charset=utf-8"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
   <head>
      <title>Administrative Tools &ndash; Maryland History and Culture Database</title>
      <link rel="stylesheet" type="text/css" href="includes/admin.css" media="all">
      <script type="text/javascript" src="http://www.lib.umd.edu/dcr/collections/mdhc/includes/mdhc.js"></script>
   </head>
   <body onload="toggleAllCategories(document.getElementById('catAll').checked);">
      <?php include("includes/header.php"); ?>
      <h1>The Maryland History and Culture Bibliography</h1>
      <h2>Administrative Tools</h2>
      <form id="search" action="results.php" method="get">
         <fieldset>
            <legend>Search the bibliography</legend>
            <label for="query1">Search Terms:</label>
            <div class="query">
               <input type="text" name="query1" id="query1" alt="Search query">
            </div>
            <div class="type">
               <select name="type1" id="type1" alt="Search type">
                  <option selected="selected" value="all">All fields</option>
                  <option value="citation">Title</option>
                  <option value="author">Author</option>
               </select>
            </div>
            <br>
            <div class="boolean">
               <select name="boolean2" id="boolean2" alt="Search boolean">
                  <option selected="selected">AND</option>
                  <option>OR</option>
                  <option>NOT</option>
               </select>
            </div>
            <div class="query">
               <input type="text" name="query2" id="query2" alt="Search query">
            </div>
            <div class="type">
               <select name="type2" id="type2" alt="Search type">
                  <option selected="selected" value="all">All fields</option>
                  <option value="citation">Title</option>
                  <option value="author">Author</option>
               </select>
            </div>
            <br>
            <div class="boolean">
               <select name="boolean3" id="boolean3" alt="Search boolean">
                  <option selected="selected">AND</option>
                  <option>OR</option>
                  <option>NOT</option>
               </select>
            </div>
            <div class="query">
               <input type="text" name="query3" id="query3" alt="Search query">
            </div>
            <div class="type">
               <select name="type3" id="type3" alt="Search type">
                  <option selected="selected" value="all">All fields</option>
                  <option value="citation">Title</option>
                  <option value="author">Author</option>
               </select>
            </div>
            <br>
            <hr>
            <div class="categoryHeader">Category Search:</div>
            <div id="allCategories">
               <label for="catAll">
                  <input type="checkbox" checked="checked" id="catAll" name="catAll" onclick="toggleAllCategories(this.checked);">
                  Search all categories
               </label>
            </div>
            <div id="categoryList">
               <?php
                  include("../includes/setup.php");
                  $query = "select * from codes order by ID";
                  $mysql = mysql_query("$query",$conn);
                  while ($ary = mysql_fetch_assoc($mysql)) {
                     while (list($key,$val) = each($ary)) {
                        $$key = $val;
                     }
               ?>
               <label for="cat<?php echo $ID ?>">
                  <input type="checkbox" id="cat<?php echo $ID ?>" name="cat<?php echo $ID ?>">
                  <?php echo $description ?>
               </label>
               <?php
                  }
               ?>
            </div>
            <br>
            <input type="submit" class="formbutton" value="Search" alt="Perform search" onclick="return verifySearchForm();">
            <input type="reset" class="formbutton" value="Reset form" alt="Clear the search form" onclick="toggleAllCategories(true);">
         </fieldset>
      </form>
      <?php include("includes/footer.inc"); ?>
   </body>
</html>
