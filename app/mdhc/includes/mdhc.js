function verifySearchForm() {
   var keyword = document.getElementById("keyword").value;
   var author = document.getElementById("author").value;
   var category = document.getElementById("category").value;
   if (keyword == "" && author == "" && category == "") {
      alert("You must enter at least one search term!");
      return false;
   } else {
      return true;
   }
}
function resetContactForm() {
   var name = document.getElementById("name");
   var email = document.getElementById("email");
   var comment = document.getElementById("comment");
   name.value = "";
   email.value = "";
   comment.value = "";
}
function resetSearchForm() {
   var keyword = document.getElementById("keyword").value;
   var author = document.getElementById("author").value;
   var category = document.getElementById("category").value;
   if (keyword != "" || author != "" || category != "") {
      window.location = "index.php";
      return true;
   } else {
      return false;
   }
}

function toggleAllCategories(status) {
   var catList = document.getElementById("categoryList");
   var checkboxes = catList.getElementsByTagName("input");
   for (i = 0; i < checkboxes.length; i++) {
      checkboxes[i].checked = status;
      checkboxes[i].disabled = status;
   }
   /* if (status) {
      catList.style.display = "none";
   } else {
      catList.style.display = "block";
   } */
}