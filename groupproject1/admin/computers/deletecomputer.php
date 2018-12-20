<?php
  require_once('../../util/main.php');
  require_once('../../model/dbinventory.php');
  require_once('../../model/database.php');

  include '../../view/header.php'; 
  include '../../view/sidebar.php'; 

  try {
      $db = new PDO($dsn, $username, $password);
    // Get method used when selecting Computer to delete
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
      
      // Read the selected Computer from the database
      $query = 'SELECT * FROM Computers
              WHERE ComputerID='.$_GET['ComputerID'];
             
      if (empty($errorMessage)) {
        try {
          $statement = $db->prepare($query);
          $statement->execute();
          $result = $statement->fetchAll();
          $statement->closeCursor();
        } catch (PDOException $e) {
          $errorMessage = $e->getMessage();
        }
      }
      // Read vendor info from the database
     $VendorID = $result[0]['VendorID'];
     $query = 'SELECT * FROM Vendors
              WHERE VendorID='  .$VendorID;
             
      if (empty($errorMessage)) {
        try {
          $statement = $db->prepare($query);
          $statement->execute();
          $result1 = $statement->fetchAll();
          $statement->closeCursor();
        } catch (PDOException $e) {
          $errorMessage = $e->getMessage();
        }  
      }
    }
  
    // Delete is confirmed with POST method
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Delete the confirmed Computer from the database and checking for dependency
      $query = 'DELETE FROM Computers
             WHERE ComputerID='.$_POST['ComputerID'];
      $delete_count = $db->exec($query);
      if ($delete_count < 1) {
        $errorMessage = 'Error deleting Computer, other tables depend on this record.';
      } else {
        // Redirect to Computers listing page
        header('Location: index.php');
      }

      if (empty($errorMessage)) {
        try {
          $statement = $db->prepare($query);
          $statement->execute();
          $statement->closeCursor();
          // Redirect to Computers listing page
          header('Location: index.php');
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
        }
      }
    }
  } catch (PDOException $e) {
       $error_message = $e->getMessage();
       echo "<p>An error occurred while connecting to the database: $error_message </p>";
  }
  // Display if error occurred, else list the Computers
  if (!empty($errorMessage)) {
    display_db_error($errorMessage);
  } else {
?>
<section><br/>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="deletecomputer" method="post">
    <h3>Confirm Deletion from Computers table</h3>
    <input type="hidden" name="ComputerID" id="ComputerID" value="<?php echo $result[0]['ComputerID']; ?>" />
    Computer ID: <strong><?php echo $result[0]['ComputerID']; ?></strong><br/><br />
    Vendor ID / Name: <strong><?php echo $result[0]['VendorID'] . " / " .$result1[0]['Name']; ?></strong><br/><br />
    Model: <strong><?php echo $result[0]['Model']; ?></strong><br/><br />
    Memory Size: <strong><?php echo $result[0]['MemorySize']; ?></strong><br/><br />
    Storage Size: <strong><?php echo $result[0]['StorageSize']; ?></strong><br/><br />
    <input type="submit" value="Delete Computer"><br/><br />
    To cancel press the back button!<br />
  </form>
</section>
<?php }
 
  // Close the database connections
  include '../../model/dbclose.php';
 
  // End the HTML code for the page
  include '../../view/footer.php'; 
?>