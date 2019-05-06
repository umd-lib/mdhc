<?php    header("Content-type: text/html; charset=utf-8"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
   <head>
      <title>Search Results &ndash; Maryland History and Culture Bibliography</title>
      <link rel="stylesheet" type="text/css" href="includes/admin.css" media="all">
   </head>
   <body>
      <?php include("includes/header.php"); ?>
      <h1>Search Results</h1>
      <?php
         include("includes/setup.php");
         $searchQuery = "SELECT * FROM citation";  // Begin constructing the MySQL query
         $displayQuery = "Your search "; // Begin constructing a sentence summarizing the search
         
         /* Populate an array with the contents of all three search box fields */
         $search = array(); // declare the array
         $i = 0; // set up and zero-out a counter to keep track of our entries into the array
         if ($_GET['query1'] != "") { // ignore if no search string was entered into this field
            $search[$i] = array (
               "boolean"   => $_GET['boolean1'],
               "query"     => trim($_GET['query1']), // Trim excess whitespace from the beginning and end of the text
               "type"      => $_GET['type1']
            );
            if ($i == 0) { // if this is the first (non-ignored) string, append a "for" to the search summary sentence
               $displayQuery .= "for ";
            }
            $displayQuery .= $search[$i]["boolean"] . " \"<span class=\"searchterm\">" . $search[$i]["query"] . "</span>\" ";
            $urlQuery .= "query1=" . $search[$i]["query"] . "&amp;type1=" . $search[$i]["type"] . "&amp;";
            $i++; // increment the counter
         }
         if ($_GET['query2'] != "") { // ignore if no search string was entered into this field 
            $search[$i] = array (
               "boolean"   => $_GET['boolean2'],
               "query"     => trim($_GET['query2']), // Trim excess whitespace from the beginning and end of the text
               "type"      => $_GET['type2']
            );
            if ($i == 0) { // if this is the first (non-ignored) string, append a "for" to the search summary sentence
               $displayQuery .= "for ";
            }
            $displayQuery .= $search[$i]["boolean"] . " \"<span class=\"searchterm\">" . $search[$i]["query"] . "</span>\" ";
            $urlQuery .= "boolean2=" . $search[$i]["boolean"] . "&amp;query2=" . $search[$i]["query"] . "&amp;type2=" . $search[$i]["type"] . "&amp;";
            $i++; // increment the counter
         }
         if ($_GET['query3'] != "") { // ignore if no search string was entered into this field
            $search[$i] = array (
               "boolean"   => $_GET['boolean3'],
               "query"     => trim($_GET['query3']), // Trim excess whitespace from the beginning and end of the text
               "type"      => $_GET['type3']
            );
            if ($i == 0) { // if this is the first (non-ignored) string, append a "for" to the search summary sentence
               $displayQuery .= "for ";
            }
            $displayQuery .= $search[$i]["boolean"] . " \"<span class=\"searchterm\">" . $search[$i]["query"] . "</span>\" ";
            $urlQuery .= "boolean3=" . $search[$i]["boolean"] . "&amp;query3=" . $search[$i]["query"] . "&amp;type3=" . $search[$i]["type"] . "&amp;";
            $i++; // increment the counter
         }
         
         /* Format and perform the category search */
         $codeCount = 0; // set up and zero-out a counter for the category search
         if ($_GET["catAll"] == "on") {
            $urlQuery .= "catAll=on&amp;";
         } else {
            // only proceed if the "Search all categories" box WAS NOT checked
            $codeQuery = "SELECT * FROM codes"; // a simple MySQL query to retrieve all the rows from the category table
            $codeMySQL = mysql_query("$codeQuery",$conn);
            while ($codeArray = mysql_fetch_assoc($codeMySQL)) {
               while (list($codeKey,$codeVal) = each($codeArray)) {
                  $$codeKey = $codeVal;
               }
               if ($_GET['cat' . $ID]) { // if the relevant checkbox was checked, include the matching results
                  $urlQuery .= "cat" . $ID . "=on&amp;";
                  if ($codeCount == 0) {
                     // create an array to store category descriptions for use in the search summary
                     $codeDescriptions = array();
                     // group all categories together within the MySQL query
                     $searchQuery .= ",codelookup WHERE (";
                  } else {
                     $searchQuery .= " OR ";
                  }
                  $searchQuery .= "(codelookup.CodeID = '$ID' AND citation.ID = codelookup.CitID)";
                  // store category description for later use
                  $codeDescriptions[$codeCount] = $description;
                  $codeCount++; // increment the counter
               }
            }
            
            if ($codeCount > 0) {
               $searchQuery .= ") ";
               $displayQuery .= "in the categor";
               if (count($codeDescriptions) > 1) {
                  $displayQuery .= "ies ";
               } else {
                  $displayQuery .= "y ";
               }
               $i = 0;
               while ($i < count($codeDescriptions)) {
                  // loop through the category description array and add each description to the
                  // search summary sentence.
                  $displayQuery .= "\"<span class=\"searchterm\">" . $codeDescriptions[$i] . "</span>";
                  if ($i + 1 < count($codeDescriptions)) {
                     $displayQuery .= ",";
                  }
                  $displayQuery .= "\" ";
                  if ($i + 2 == count($codeDescriptions)) {
                     $displayQuery .= "and ";
                  }
                  $i++;
               }
            }
         }
         
         $inputCount = 0;
         while ($inputCount < count($search)) {
            if ($inputCount == 0) {
               if ($codeCount == 0) {
                  $searchQuery .= " WHERE ";
               } else {
                  $searchQuery .= " AND (";
               }
            }
            $boolean = $search[$inputCount]["boolean"];
            $query = split(" ",$search[$inputCount]["query"]);
            $type = $search[$inputCount]["type"];
            if ($boolean == "NOT") {
               if ($inputCount > 0) $searchQuery .= "AND";
               $operator = "NOT LIKE";
               $booleanTypeAll = "AND";
            } else {
               if ($inputCount > 0) $searchQuery .= $boolean;
               $operator = "LIKE";
               $booleanTypeAll = "OR";
            }
            if (count($query) > 1) {
               $searchQuery .= " (";
            }
            $i = 0;
            while ($i < count($query)) {
               if ($i > 0) {
                  $searchQuery .= " AND ";
               }
               if ($type == "all") {
                  $searchQuery .= " (citation.author $operator '%$query[$i]%' $booleanTypeAll citation.citation $operator '%$query[$i]%') ";
               } else {
                  $searchQuery .= " citation.$type $operator '%$query[$i]%' ";
               }
               $i++;
            }
            if (count($query) > 1) {
               $searchQuery .= ") ";
            }
            $inputCount++;
         }
         if ($inputCount > 0 and $codeCount > 0) {
            $searchQuery .= ")";
         }
         $searchQuery .= " ORDER BY citation.author,citation.citation";
         $displayQuery .= " returned";
         /*  echo "<p>$searchQuery</p>"; */
         $searchMySQL = mysql_query("$searchQuery",$conn);
         $searchCount = mysql_num_rows($searchMySQL);
         if ($searchCount == 0) {
            $displayQuery .= " no results!";
            /* echo "<p>$searchQuery</p>"; */
            echo "<p>$displayQuery</p>";
         } else {
            $displayQuery .= " $searchCount result";
            if ($searchCount > 1) {
               $displayQuery .= "s";
            }
            if (!$_GET['start']) {
               $start = 0;
            } else {
               $start = $_GET['start'];
            }
            if (!$_GET['limit']) {
               $limit = 20;
            } else {
               $limit = $_GET['limit'];
            }
            $searchQuery .= " LIMIT $start,$limit";
            /* echo "<p>$searchQuery</p>"; */
            $searchMySQL = mysql_query("$searchQuery",$conn);
            $displayfirst = $start + 1;
            $displaylast = $start + $limit;
            if ($displaylast > $searchCount) {
               $displaylast = $searchCount;
            }
            $currentdisplay = "Showing results $displayfirst through $displaylast.";
            $numpages = intval($searchCount / $limit);
            if ($searchCount % $limit != 0) {
               $numpages++;
            }
            $displayQuery .= " in $numpages page";
            if ($numpages > 1) {
               $displayQuery .= "s";
            }
            $displayQuery .= ".";
            echo "<p>$displayQuery</p>";
            echo "<p>$currentdisplay</p>";
            include("../includes/pagenav.php");
            $position = $start + 1;
            while ($ary = mysql_fetch_assoc($searchMySQL)) {
               while (list($key,$val) = each($ary)) {
                  $$key = $val;
               }
               $query2 = "select * from codelookup,codes where codelookup.CitID='$ID' AND codelookup.CodeID = codes.ID";
               $mysql2 = mysql_query("$query2",$conn);
               $count2 = mysql_num_rows($mysql2);
      ?>
      <form action="editcitation.php" method="post">
         <div class="result">
            <input type="hidden" name="existing" value="true">
            <input type="hidden" name="rowID" value="<?php echo rawurlencode($ID) ?>">
            <input type="hidden" name="author" value="<?php echo rawurlencode($author) ?>">
            <input type="hidden" name="citation" value="<?php echo rawurlencode($citation) ?>">
            <?php
               if ($annotation != "") {
            ?>
            <input type="hidden" name="annotation" value="<?php echo rawurlencode($annotation) ?>">
            <?php
               }
               $i = 1;
               while ($ary2 = mysql_fetch_assoc($mysql2)) {
                  while (list($key2,$val2) = each($ary2)) {
                     $$key2 = $val2;
                  }
                  $description_display .="<a href=\"results.php?cat$ID=on&amp;start=0&amp;limit=20\">$description</a>";
                  if ($i < $count2) {
                     $description_display .= " | ";
                  }
            ?>
            <input type="hidden" name="cat<?php echo $ID ?>" value="on">
            <?php
                  $i++;
               }
            ?>
            <div class="position">
               <?php echo "$position"; ?>)
            </div>
            <div class="content">
               <input type="submit" class="edit" value="Edit">
               <strong><?php print "$author"; ?></strong> <?php print "$citation"; ?>
               <?php
                  if ($annotation != "") {
               ?>
               <div class="annotation">
                  <strong>Annotations / Notes:</strong> <?php print "$annotation"; ?>
               </div>
               <?php
                  }
               ?>
               <div class="description">
                  <strong>Category:</strong> <?php print "$description_display"; ?>
               </div>
            </div>
            <br class="clear">
         </div>
      </form>
      <?php
            $description_display="";
            $position++;
         }
      ?>
      <?php
            include("includes/pagenav.php");
         }
         include("includes/footer.inc");
      ?>
   </body>
</html>
