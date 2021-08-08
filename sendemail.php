<!DOCTYPE html>
<html>
  <head>
      <title>Make me Elvis - Send Email</title>
      <link rel="stylesheet" type="text/css" href="css/styles.css">
  </head>
<?php
  // Checks to see if the submit button has already been submitted
  if (isset($_POST['submit']))
  {
    // Get inputs from form
    $from = "jimmyboxing93@yahoo.com";
    $subject = $_POST['subject'];
    $text = $_POST['elvismail'];
    // Flag varibale for form
    $output_form = false;

    // If Subject and body text is empty
    if (empty($subject) && (empty($text)))
    {
      // Output, error message
      echo "You forgot the email and body text.<br />";
      // Set flag to true to show form
      $output_form = true;

    }
    // If only the subject is empty
    if (empty($subject) && (!empty($text)))
    {
      // Output error message for only the subject
      echo "You forgot the email subject.<br />";
      // Set flag to true to show form
      $output_form = true;
    }
    // If only the body text is missing
    if (!empty($subject) && (empty($text)))
    {
      // Output error message for only the body text
      echo "You forgot the email body text.<br />";
      // Set flag to true to show form
      $output_form = true;
    }
  }
    else
    {
      // Set flag to true to show form
      $output_form = true;
    }
    if (!empty($subject) && (!empty($text)))
    {
      // Connection to the database
      $dbc = mysqli_connect('localhost', 'root', '***', 'elvis_store')
      or die('error connecting to MySQL server.');


      // Creates query to get to send email who is on the mailing list.
      $query = "SELECT * FROM email_list";
      // Queries the results
      $result = mysqli_query($dbc, $query);

      // Loops through all the rows in the table
      while ($row = mysqli_fetch_array($result))
      {
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];

        $msg = "Dear $first_name $last_name, \n $text";

        $to = $row['email'];
        // Mails out email to eveyone on the mailing list
        mail($to, $subject, $msg, 'From: ' . $from);
        // Confirms that email was sent
        echo 'Email sent to: ' . $to . '<br />';
      }
      // Close connection
      mysqli_close($dbc);
    }

  // if flag is true, show form
  if ($output_form)
  {
  ?>
  <body>
  <img src="images/blankface.jpg" width=161 height="350" alt="" style="float:right" />
  <img name="elvislogo" src="images/elvislogo.gif" width="299" height="32" border="0" alt="Make Me Elvis" />
  <p><strong>Private:</strong> For Eler's use ONLY<br />
      Write and send an email to mailing list members</p>
      <!-- Form is used to save data user previously entered. embedded with php -->
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="subject">Subject of email:</label><br />
    <input type="text" id="subject" name="subject" size="30" value="<?php echo $subject; ?>"/><br />
    <label for="elvismail">Body of email:</label><br />
    <textarea id="elvismail" name="elvismail" rows="8" col="60">
    <?php echo "$text"; ?></textarea><br />
    <input type="submit" name="submit" value="Submit">
  </form>
  <?php
  }
?>
</body>
</html>
