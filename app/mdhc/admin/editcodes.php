<?php    header("Content-type: text/html; charset=utf-8"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
   <head>
      <title>Create / Modify Bibliographic Categories &ndash; Maryland History and Culture Database</title>
      <link rel="stylesheet" type="text/css" href="includes/admin.css" media="all">
   </head>
   <body>
      <?php include("includes/header.php"); ?>
      <h1>Create / Modify Bibliographic Categories</h1>
      <?php
         include("includes/setup.php");
         if ($_POST['delete']) {
            $codeID = $_POST['codeID'];
            $description = rawurldecode($_POST['description']);
            $deleteQuery = "DELETE FROM codes WHERE ID = '$codeID'";
            $deleteMySQL = mysql_query("$deleteQuery",$conn);
            if (!$deleteMySQL) {
               die("Invalid Query B: " . mysql_error());
            }
            $deleteLookupQuery = "DELETE FROM codelookup WHERE CodeID = '$codeID'";
            $deleteLookupMySQL = mysql_query("$deleteLookupQuery",$conn);
            if (!$deleteLookupMySQL) {
               die("Invalid Query C: " . mysql_error());
            }
      ?>
      <p>The category "<span class="searchterm"><?php print "$description"; ?></span>"
      has been disassociated with all citation records and removed from the database.</p>
      <?php
         } else if ($_POST['rename']) {
            $codeID = $_POST['codeID'];
            $description = rawurldecode($_POST['description']);
            $replaceQuery = "REPLACE INTO codes (ID, description) VALUES ('$codeID', '$description')";
            $replaceMySQL = mysql_query("$replaceQuery",$conn);
            if (!$replaceMySQL) {
               die("Invalid Query D: " . mysql_error());
            }
      ?>
      <p>The category "<span class="searchterm"><?php print "$description"; ?></span>"
      has been successfully <?php
         if ($_POST['new']) {
            echo "created";
         } else {
            echo "modified";
         }
         
      ?>.
      </p>
      <?php
         }
         if ($_POST['modify']) {
            $codeID = $_POST['codeID'];
            $description = rawurldecode($_POST['description']);
         } else {
            $codeIDQuery = "SELECT MAX(id) AS LASTROW FROM codes";
            $codeIDMySQL = mysql_query("$codeIDQuery",$conn);
            $codeID = mysql_fetch_row($codeIDMySQL);
            $codeID = $codeID[0] + 1;
            $description = "";
         }
      ?>
      <form id="renameCategory" action="editcodes.php" method="post">
         <fieldset>
            <legend>
               <?php
                  if ($_POST['modify']) {
                     echo "Rename bibliographic category";
                  } else {
                     echo "Create new bibliographic category";
                  }
               ?>
            </legend>
            <input type="hidden" name="codeID" value="<?php echo $codeID ?>" alt="The row ID">
            <?php   
               if (!$_POST['modify']) {
            ?>
            <input type="hidden" name="new" value="true" alt="This is a new category">
            <?php
               }
            ?>
            <label for="description">Description:</label>
            <input type="text" id="description" name="description" value="<?php echo $description ?>">
            <input type="submit" id="rename" name="rename" value="Submit Changes">
         </fieldset>
      </form>
      <table id="categories">
         <thead>
            <tr>
               <th class="name">Category description</th>
               <th class="modify">Rename / Delete</th>
            </tr>
         </thead>
         <tbody>
            <?php
               $codesQuery = "SELECT * FROM codes ORDER BY description";
               $codesMySQL = mysql_query("$codesQuery",$conn);
               if (!$codesMySQL) {
                  die("Invalid Query A: " . mysql_error());
               }
               while ($codesArray = mysql_fetch_assoc($codesMySQL)) {
                  while (list($codesKey,$codesVal) = each($codesArray)) {
                     $$codesKey = $codesVal;
                  }
            ?>
            <tr>
               <td class="name">
                  <?php print "$description"; ?>
               </td>
               <td class="modify">
                  <form action="editcodes.php" method="post">
                     <div>
                        <input type="hidden" name="codeID" value="<?php echo $ID ?>">
                        <input type="hidden" name="description" value="<?php echo rawurlencode($description) ?>">
                        <input type="submit" name="modify" value="Rename">
                        <input type="submit" name="delete" value="Delete">
                     </div>
                  </form>
               </td>
            </tr>
            <?php
               }
            ?>
         </tbody>
         <tfoot></tfoot>
      </table>
      <?php include("includes/footer.inc"); ?>
   </body>
</html>
