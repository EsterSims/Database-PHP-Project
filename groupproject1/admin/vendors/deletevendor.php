<?php
  require_once('../../util/main.php');
  require_once('../../model/dbinventory.php');
  require_once('../../model/database.php');

  include '../../view/header.php'; 
  include '../../view/sidebar.php'; 

  // Get method used when selecting Vendor to delete
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Read the selected Vendor from the database
    $query = 'SELECT * FROM Vendors
              WHERE VendorID='.$_GET['VendorID'];
             
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
  }
 
  // Delete is confirmed with POST method
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Delete the confirmed Vendor from the database and checking for dependency
    $query = 'DELETE FROM Vendors
             WHERE VendorID='.$_POST['VendorID'];
    $delete_count = $db->exec($query);
    if ($delete_count < 1) {
      $errorMessage = 'Error deleting Vendor, other tables depend on this record.';
    } else {
      // Redirect to Vendors listing page
      header('Location: index.php');
    }

    if (empty($errorMessage)) {
      try {
        $statement = $db->prepare($query);
        $statement->execute();
        $statement->closeCursor();
        // Redirect to Vendors listing page
        header('Location: index.php');
      } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
      }
    }
  }
   
  // Display if error occurred, else list the Vendors
  if (!empty($errorMessage)) {
    display_db_error($errorMessage);
  } else {
?>
<section><br/>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="deletevendor" method="post">
    <h3>Confirm Deletion from Vendors table</h3>
    <input type="hidden" name="VendorID" id="VendorID" value="<?php echo $result[0]['VendorID']; ?>" />
    Vendor ID: <strong><?php echo $result[0]['VendorID']; ?></strong><br/><br />
    Vendor Name: <strong><?php echo $result[0]['Name']; ?></strong><br/><br />
    Vendor Contact: <strong><?php echo $result[0]['Contact']; ?></strong><br/><br />
    Vendor Phone: <strong><?php echo $result[0]['Phone']; ?></strong><br/><br />
    <input type="submit" value="Delete Vendor"><br/><br />
    To cancel press the back button!<br />
  </form>
</section>
<?php }
 
  // Close the database connections
  include '../../model/dbclose.php';
 
  // End the HTML code for the page
  include '../../view/footer.php'; 
?>