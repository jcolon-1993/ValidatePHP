<!DOCTYPE html>
<html>
  <head>
      <title>Make me Elvis - Remove Email</title>
      <link rel="stylesheet" type="text/css" href="css/styles.css">
  </head>
  <body>
    <img src="images/blankface.jpg" width=161 height="350" alt="" style="float:right" />
    <img name="elvislogo" src="images/elvislogo.gif" width="299" height="32" border="0" alt="Make Me Elvis" />
    <p>Please select the email addresses to delete from the email list and click Remove.</p>
    <form method="post" action="removeemail.php">
    <?php
      $dbc = mysqli_connect('localhost', 'root', '****', 'elvis_store')
      or die('error connecting to MySQL server.');

      // Delete the customer rows only if the form has been submitted
      if (isset($_POST['submit']))
      {
        // Use for each to loop through check boxes
        foreach ($_POST['todelete'] as $delete_id)
        {
          // If box is checked, delete customer
          $query = "DELETE FROM email_list WHERE id = '$delete_id'";
          mysqli_query($dbc, $query)
          or die("Error querying database");
        }
        echo 'Customer(s) removed.<br />';
      }

      // Display the customer rows with checkboxes for deleting
      $query = "SELECT * FROM email_list";
      $result = mysqli_query($dbc, $query);
      while ($row = mysqli_fetch_array($result))
      {
        echo '<input type="checkbox" value="' .$row['id'] . '" name="todelete[]" />';
        echo $row['first_name'];
        echo ' ' . $row['last_name'];
        echo ' ' . $row['email'];
        echo '<br />';
      }

      mysqli_close($dbc);
     ?>
     <input type="submit" name="submit" value="Remove" />
   </form>
</body>
</html>
