      <?php
               if ($numpages > 1) {
      ?>
      <div class="pagelinks">
         <?php
                  if ($numpages > 10) {
                     $displaypages = 10;
                  } else {
                     $displaypages = $numpages;
                  }
                  $currentpage = intval($start / $limit) + 1;
                  $lastpage = $currentpage + intval($displaypages / 2);
                  if ($lastpage > $numpages) {
                     $lastpage = $numpages;
                  }
                  $firstpage = $lastpage - ($displaypages - 1);
                  if ($firstpage < 1) {
                     $firstpage = 1;
                     $lastpage = $firstpage + ($displaypages - 1);
                  }
         ?>
         <span class="pagelink">
            <?php
                  if ($currentpage == 1) {
                     echo "Previous page";
                  } else {
                     $newstart = $start - $limit;
                     $url = "results.php?start=$newstart&amp;limit=$limit&amp;$urlQuery";
                     echo "<a href=\"$url\">Previous page</a>";
                  }
            ?>
            &middot;
         </span>
         <?php
                  $i = $firstpage - 1;
                  while ($i < $lastpage) {
         ?>
         <span class="pagelink">
            <?php
                     $newstart = $i * $limit;
                     $url = "results.php?start=$newstart&amp;limit=$limit&amp;$urlQuery";
                     $i++;
                     if ($start == $newstart) {
                        /* Do not display a link to the current page */
                        echo "Page $i";
                     } else {
                        echo "<a href=\"$url\">$i</a>";
                     }
            ?>
         </span>
         <?php
                     /* Print a dot to seperate invidivual links */
                     echo "&middot;";
                  }
         ?><span class="pagelink">
            <?php
                  if ($currentpage == $lastpage) {
                     echo "Next page";
                  } else {
                     $newstart = $start + $limit;
                     $url = "results.php?start=$newstart&amp;limit=$limit&amp;$urlQuery";
                     echo "<a href=\"$url\">Next page</a>";
                  }
            ?>
         </span>
      </div>
      <?php
               }
      ?>
