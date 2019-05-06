<?php

$keyword = (array_key_exists('keyword',$_GET) ? $_GET['keyword'] : '');
$author = (array_key_exists('author',$_GET) ? $_GET['author'] : '');
$category = (array_key_exists('category',$_GET) ? $_GET['category'] : '');

?>
     <div id="container">
         <div id="header">
            <div class="masthead">
               <a href="http://www.lib.umd.edu/"><img alt="University of Maryland Libraries" src="images/libraries.png" class="libraries"></a>
               <a href="http://digital.lib.umd.edu/"><img alt="Digital Collections" src="images/dc.png" class="digital"></a>
               <!-- <img alt="A collage of images from the collections" src="images/banner.jpg" class="banner"> -->
            </div>
            <div class="topborder">
					<img alt="" src="images/edge_tl_red.gif" class="leftcorner">
					<div class="navlinks">
						<a href="http://digital.lib.umd.edu/">Home</a> |
						<a href="http://digital.lib.umd.edu/collections.jsp">Collections A-Z</a> |
						<a href="http://digital.lib.umd.edu/tools.jsp">Gateways + Tools</a> |
						<a href="http://digital.lib.umd.edu/about.jsp">About the Collections</a>
					</div>
					<img alt="" src="images/edge_tr_red.gif" class="rightcorner">
            </div>
            <div class="subheader">
               <form action="results.php" class="quicksearch">
                  <div>
                     <input type="hidden" alt="Search type" name="type1" value="all">
                     <input type="text" alt="Search query" name="query1" class="query">
                     <input type="submit" alt="Submit search" value="Search" class="submit">
                  </div>
               </form>
               <div class="navlinks">
                  <a href="index.php<?php
                     if ($keyword != "" || $author != "" || $category != "") {
                        print "?";
                        if ($keyword != "") {
                           print "keyword=$keyword";
                           if ($author != "" || $category != "") {
                              print "&amp;";
                           }
                        }
                        if ($author != "") {
                           print "author=$author";
                           if ($category != "") {
                              print "&amp;";
                           }
                        }
                        if ($category != "") {
                           print "category=$category";
                        }
                     }
                  ?>">Maryland History and Culture Bibliography</a> |
                  <a href="results.php">Browse All Entries</a> |
                  <a href="http://www.lib.umd.edu/special/contact/home" target="_blank">Contact Form</a>
               </div>
            </div>
         </div>
         <div id="body">
