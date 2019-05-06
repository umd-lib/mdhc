<?php header("Content-type: text/html; charset=utf-8"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
   <head>
      <title>Administrative Tools &ndash; Maryland History and Culture Bibliography</title>
      <link rel="stylesheet" type="text/css" href="includes/admin.css" media="all">
   </head>
   <body>
      <?php include ("includes/header.php"); ?>
      <h1>Create / Modify a Citation Record</h1>
      <?php
         include("includes/setup.php");
         $author = rawurldecode($_POST['author']);
         $citation = rawurldecode($_POST['citation']);
         $annotation = rawurldecode($_POST['annotation']);
         $rowID = rawurldecode($_POST['rowID']);
         $existing = $_POST['existing'];
         if ($_POST['submit'] and $citation) {
            $rowQuery = "SELECT MAX(id) AS LASTROW FROM citation";
            if ($rowID == "") {
               $rowMySQL = mysql_query("$rowQuery",$conn);
               $rowID = mysql_fetch_row($rowMySQL);
               $rowID = $rowID[0] + 1;
            }
            $newCitationQuery = "REPLACE INTO citation (id, author, citation";
            if ($annotation != "") {
               $newCitationQuery .= ", annotation";
            }
            $newCitationQuery .= ") VALUES ('$rowID', '$author', '$citation'";
            if ($annotation != "") {
               $newCitationQuery .= ", '$annotation'";
            }
            $newCitationQuery .= ")";$newCitationMySQL = mysql_query("$newCitationQuery",$conn);
            if (!$newCitationMySQL) {
               die("Invalid query A: " . mysql_error());
            }
            $codeQuery = "SELECT * FROM codes";
            $codeMySQL = mysql_query("$codeQuery",$conn);
            $codeIDs = array();
            while ($codeArray = mysql_fetch_assoc($codeMySQL)) {
               while (list($codeKey,$codeVal) = each($codeArray)) {
                  $$codeKey = $codeVal;
               }
               if ($_POST['cat' . $ID]) {
                  $assignCategoryQuery = "REPLACE INTO codelookup (CitID, CodeID) VALUES ('$rowID', '$ID')";
                  $assignCategoryMySQL = mysql_query("$assignCategoryQuery",$conn);
                  if (!$assignCategoryMySQL) {
                     die("Invalid query B: " . mysql_error());
                  }
               } else {
                  $removeCategoryQuery = "DELETE FROM codelookup WHERE CitID = '$rowID' AND CodeID = '$ID'";
                  $removeCategoryMySQL = mysql_query("$removeCategoryQuery",$conn);
                  if (!$removeCategoryMySQL) {
                     die("Invalid query C: " . mysql_error());
                  }
               }
            }
            if ($existing == "true") {
      ?>
      <p>The following record has been modified:</p>
      <?php
               $existing = "false";
            } else {
      ?>
      <p>The following record has been created:</p>
      <?php
         }
      ?>
      <div class="result">
         <strong><?php print "$author"; ?></strong> <?php print "$citation"; ?>
         <?php 
            if ($annotation != "") {
         ?>
         <div class="annotation">
            <strong>Annotations / Notes:</strong> <?php print "$annotation"; ?>
         </div>
         <?php
            }
            $codesQuery = "select * from codelookup,codes where codelookup.CitID='$rowID' AND codelookup.CodeID = codes.ID";
            $codesMySQL = mysql_query("$codesQuery",$conn);
            if (!$codesMySQL) {
               die("Invalid Query E: " . mysql_error());
            }
            $codesCount = mysql_num_rows($codesMySQL);
            $i = 1;
            while ($codesArray = mysql_fetch_assoc($codesMySQL)) {
               while (list($codesKey,$codesVal) = each($codesArray)) {
                  $$codesKey = $codesVal;
               }
               $description_display .="<a href=\"results.php?cat$ID=on&amp;start=0&amp;limit=20\">$description</a>";
               if ($i < $codesCount) {
                  $description_display .= " | ";
               }
               $i++;
            }
         ?>
         <div class="description">
            <strong>Category:</strong> <?php print "$description_display"; ?>
         </div>
         <br class="clear">
      </div>
      <hr>
      <?php
            $author = "";
            $citation = "";
            $annotation = "";
            $rowID = "";
         } else if ($_POST['submit'] and $citation == "") {
      ?>
         <p>You <strong>must</strong> enter a citation when submitting a new record!</p>
      <?php 
         } else if ($_POST['delete']) {
            $deleteCiteQuery = "DELETE FROM citation WHERE ID = '$rowID'";
            $deleteCiteMySQL = mysql_query("$deleteCiteQuery",$conn);
            if (!$deleteCiteMySQL) {
               die("Invalid Query D: " . mysql_error());
            }
            $deleteCodeQuery = "DELETE FROM codelookup WHERE CitID = '$rowID'";
            $deleteCodeMySQL = mysql_query("$deleteCodeQuery",$conn);
            if (!$deleteCodeMySQL) {
               die("Invalid Query E: " . mysql_error());
            }
            $author = "";
            $citation = "";
            $annotation = "";
            $rowID = "";
            $existing = "false";
      ?>
         <p>The citation record has been deleted.</p>
      <?php
         }
      ?>
      <form id="editCitation" action="editcitation.php" method="post">
         <fieldset>
            <?php
               if ($existing == "true") {
            ?>
            <legend>Edit an Existing Citation Record</legend>
            <input type="hidden" name="existing" value="true">
            <?php
                  $clearcats = false;
               } else {
            ?>
            <legend>Create a New Citation Record</legend>
            <?php
                  $clearcats = true;
               }
            ?>
            <input type="hidden" name="rowID" value="<?php echo $rowID ?>">
            <label for="author">Author / Editor:</label>
            <input type="text" id="author" name="author" alt="Enter attribution" value="<?php echo $author ?>">
            <br>
            <label for="citation">Work Citation:</label>
            <textarea id="citation" name="citation"><?php echo $citation ?></textarea>
            <br>
            <label for="annotation">Annotations / Notes:</label>
            <textarea id="annotation" name="annotation"><?php echo $annotation ?></textarea>
            <hr>
            <div class="label">Assign Categories:</div>
            <div id="categoryList">
               <?php
                  $count = 0;
                  $categoryQuery = "SELECT * FROM codes ORDER BY description";
                  $categoryMySQL = mysql_query("$categoryQuery",$conn);
                  while ($categoryArray = mysql_fetch_assoc($categoryMySQL)) {
                     while (list($categoryKey,$categoryVal) = each($categoryArray)) {
                        $$categoryKey = $categoryVal;
                     }
                     if ($_POST['cat' . $ID] and $existing == 'true') {
               ?>
               <label for="cat<?php echo $ID ?>">
                  <input type="checkbox" id="cat<?php echo $ID ?>" name="cat<?php echo $ID ?>" checked="checked">
                  <?php echo $description ?>
               </label>
               <?php
                        $count++;
                     }
                  }
                  if ($count > 0) {
               ?>
               <hr />
               <?php
                  }
                  $categoryQuery2 = "SELECT * FROM codes ORDER BY description";
                  $categoryMySQL2 = mysql_query("$categoryQuery2",$conn);
                  while ($categoryArray2 = mysql_fetch_assoc($categoryMySQL2)) {
                     while (list($categoryKey2,$categoryVal2) = each($categoryArray2)) {
                        $$categoryKey2 = $categoryVal2;
                     }
                     if (!$_POST['cat' . $ID] or $existing != 'true') {
               ?>
               <label for="cat<?php echo $ID ?>">
                  <input type="checkbox" id="cat<?php echo $ID ?>" name="cat<?php echo $ID ?>">
                  <?php echo $description ?>
               </label>
               <?php
                     }
                  }
               ?>
            </div>
            <br>
            <input type="submit" class="formbutton" value="Create / Revise Citation" alt="Submit Citation" name="submit">
            <input type="submit" class="formbutton" value="Delete Citation Record" alt="Delete Citation" name="delete"<?php
               if ($existing != "true") {
            ?> disabled="disabled"<?php
               }
            ?>>
         </fieldset>
      </form>
      <?php include("includes/footer.inc"); ?>
   </body>
</html>
