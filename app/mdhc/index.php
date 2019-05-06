<?php    header("Content-type: text/html; charset=utf-8"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
   <head>
      <title>Maryland History and Culture Database</title>
      <link rel="stylesheet" type="text/css" href="includes/mdhc.css" media="all">
      <link rel="stylesheet" type="text/css" href="includes/mdhc_print.css" media="print">
      <!--[if lte IE 6]>
         <link rel="stylesheet" type="text/css" href="includes/mdhc_msie6.css">
      <![endif]-->
      <script type="text/javascript" src="includes/mdhc.js"></script>
   </head>
   <body onload="toggleAllCategories(document.getElementById('catAll').checked);">
      <?php include("includes/header.php"); ?>
      <h1>The Maryland History and Culture Bibliography</h1>
      <p><em>The Maryland History and Culture Bibliography</em> consists of citations to
      articles, books, and doctoral dissertations about various aspects of
      Maryland's history and culture, divided into a set of standard subject
      categories.  The citations are gathered from scholarly journals, local
      and state history-related newsletters and magazines, subject indexes to
      monographs and journals, publishers' catalogs, and electronic databases,
      among other sources.</p>
<p>Genealogy-related works are not included unless they are of a more
      general nature, for example, indexes to various types of vital records
      or Civil War muster rolls.</p>
<p>Please note: This bibliography does not contain links to electronic articles hosted by the University of Maryland Libraries, 
although some may be available online. Not all titles are available in print at the University of Maryland Libraries. 
Please <a href="http://www.lib.umd.edu/special/contact/home" target="_blank">contact</a> Special Collections and University Archives for assistance in obtaining copies of any of the articles cited 
in this bibliography.
</p>
      
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
                  require_once 'includes/setup.php';
                  $query = "select * from codes order by description";
                  $mysql = mysql_query($query,$conn);
                  while ($ary = mysql_fetch_assoc($mysql)) {
		    $ID = $ary['ID'];
                    $description = $ary['description'];
               ?>
               <label for="cat<?php echo $ID; ?>">
                  <input type="checkbox" id="cat<?php echo $ID; ?>" name="cat<?php echo $ID; ?>">
		     <?php echo $description; ?>
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
      <p><em>The Maryland History and Culture Bibliography</em> is based on the annual
      bibliography of Maryand history sources that appears in the <em>Maryland
      Historical Magazine</em>.  Citations in the bibliography largely date from
      the mid-1970s through 2008; works pre-dating this period were drawn from
      the first bibliography in the series, which was published in 1973.  Some
      of these articles were published in the late nineteenth and early twentieth
      centuries, but coverage is spotty for these earlier years until citations
      were gathered more systematically, beginning in 1974. Past compilers: Dorothy M. Brown and Richard R. Duncan (1973), Richard J. Cox (1974-1982), William LeFurgy and Peter H. Curtis (1983-1986), Anne S. K. Turkos and Peter H. Curtis (1987-1991), Anne S. K. Turkos and Jeff Korman (1992-2013), and Anne Turkos and Elizabeth Caringola (2013-present).
      Annotations were added as part of the original
      <a href="http://www.mdhc.org/">Maryland Humanities Council</a> project.
      Updates will be added in regular intervals.</p>
      <p><em>The Maryland History and Culture Bibliography</em> database was originally
      created by the Maryland Humanities Council in 2000. The University of
      Maryland Libraries assumed responsibility for the continued access and
      updating of the database in 2008.</p>

      <?php include("includes/footer.inc"); ?>
   </body>
</html>
