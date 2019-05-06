<?php
   header("Content-type: text/html; charset=utf-8");
   require 'includes/captcha.php';
   $captchas = new CaptchasDotNet ('seancdaug', '8X5ID9Om1Ukd5xgNaErviYW9aYGPeIfOXKkW4InL',
                                 '/tmp/captchasnet-random-strings','3600',
											'abcdefghkmnopqrstuvwxyz','6',
											'240','80');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
   <head>
      <title>Contact Us &ndash; Maryland History and Culture Bibliography</title>
      <link rel="stylesheet" type="text/css" href="includes/mdhc.css" media="all">
      <link rel="stylesheet" type="text/css" href="includes/mdhc_print.css" media="print">
      <!--[if lte IE 6]>
         <link rel="stylesheet" type="text/css" href="includes/mdhc_msie6.css">
      <![endif]-->
      <script type="text/javascript" src="includes/mdhc.js"></script>
   </head>
   <body>
      <?php
         include("includes/header.php");
         if ($_REQUEST['submit']) {
            $name          = $_REQUEST['name'];
            $email         = $_REQUEST['email'];
            $comment       = $_REQUEST['comment'];
            $password      = $_REQUEST['password'];
            $random_string = $_REQUEST['random'];
         }
         if ($captchas->validate($random_string) and $captchas->verify($password) and $name != "" and $email != "" and $comment != "") {
            $to = "libdcr@umd.edu,aturkos@umd.edu,askhornbake@umd.edu";
				$subject = "MDHC Bibliography Public Comment";
				$body = "The following comment was submitted on " . date("m-d-y") . " by " . $name . " <" . $email . ">:\n\n" . $comment;
            if (mail($to, $subject, $body)) {
      ?>
      <h1>Message Successfully Sent</h1>
      <p>Your message has been distributed to the bibliographers. If applicable, we will respond as soon as possible. Thank you for
      using the bibliography, and for taking the time to let us know what you think.</p>
      <?php
            } else {
      ?>
      <h1>Message Send Failure &ndash; An Error Has Occurred</h1>
      <p>Oops! An error has prevented us from sending your message. Please try again later. We apologize for the inconvenience.</p>
      <?php
            }
         } else {
      ?>
      <h1>Questions or Comments?</h1>
      <?php
            if ($_REQUEST['submit']) {
               if ($name == "" or $email == "" or $comment == "") {
      ?>
      <div class="contactError">One or more of the fields below have not been completed. Please completely fill in all fields and try again.</div>
      <?php
               } else if (!$captchas->validate($random_string) or !$captchas->verify($password)) {
      ?>
      <div class="contactError">The text you entered into the confirmation box does not match the text displayed in the image. Please try again.</p>
      <?php
            }
         }
      ?>
      <p>Please let us know what you think about the Maryland History and Culture Bibliography, ask a question, or let us know what isn't working. All information will be kept in strict confidence.</p>
		<form action="contact.php" name="mailform" id="mailform" method="post">
         <fieldset>
            <legend>Please complete all fields</legend>
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $name ?>">
            <br>
            <label for="email">E-Mail Address:</label>
            <input type="text" id="email" name="email" value="<?php echo $email ?>">
            <br>
            <label for="comment">Question / Comment:</label>
            <textarea name="comment" id="comment"><?php echo $comment ?></textarea>
            <br>
            <div class="captcha">
               <input type="hidden" name="random" value="<?php echo $captchas->random () ?>" />
               <label for="password">To confirm you're not a script, please type the word displayed in the image below in the adjoining text box.</label>
               <div class="captchaImage">
                  <?php echo $captchas->image () ?>
               </div>
               <div class="captchaInput">
      				<a href="<?php echo $captchas->audio_url () ?>">Phonetic spelling (mp3)</a>
                  <input name="password" id="password" maxlength="6" />
               </div>
               <br>
            </div>
            <input type="submit" class="formbutton" value="Send Comment" alt="Send Comment" name="submit">
            <input type="button" class="formbutton" value="Reset Form" alt="Clear the comment form" onclick="resetContactForm();">
         </fieldset>
      </form>
      <?php
         }
         include("includes/footer.inc");
      ?>
   </body>
</html>
