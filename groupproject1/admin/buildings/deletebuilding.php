<?php
  require_once('../../util/main.php');
  require_once('../../model/dbinventory.php');
  require_once('../../model/database.php');

  include '../../view/header.php'; 
  include '../../view/sidebar.php'; 

  // Get method used when selecting Building to delete
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Read the selected Building from the database
    try {
      $db = new PDO($dsn, $username, $password);
      $query = 'SELECT * FROM buildings
              WHERE BuildingID='.$_GET['BuildingID'];
             
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
    catch (PDOException $e) {
    $error_message = $e->getMessage();
    echo "<p>An error occurred while connecting to the database: $error_message </p>";
    }
  }
 
  // Delete is confirmed with POST method
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Delete the confirmed building from the database and checking for dependency
    $query = 'DELETE FROM buildings
             WHERE BuildingID='.$_POST['BuildingID'];
    $delete_count = $db->exec($query);
    if ($delete_count < 1) {
      $errorMessage = 'Error deleting building, other tables depend on this record.';
    } else {
      // Redirect to Buildings listing page
      header('Location: index.php');
    }

    if (empty($errorMessage)) {
      try {
        $statement = $db->prepare($query);
        $statement->execute();
        $statement->closeCursor();
        // Redirect to Buildings listing page
        header('Location: index.php');
      } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
      }
    }
  
  }
   
  // Display if error occurred, else list the buildings
  if (!empty($errorMessage)) {
    display_db_error($errorMessage);
  } else {
?>
<section><br/>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="deletebuilding" method="post">
    <h3>Confirm Deletion from Buildings table</h3>
    <input type="hidden" name="BuildingID" id="BuildingID" value="<?php echo $result[0]['BuildingID']; ?>" />
    Building ID: <strong><?php echo $result[0]['BuildingID']; ?></strong><br /><br />
    Building No: <strong><?php echo $result[0]['BuildingNo']; ?></strong><br /><br />
    Building Name: <strong><?php echo $result[0]['BuildingName']; ?></strong><br /><br />
    <input type="submit" value="Delete Building"><br/><br />
    To cancel press the back button!<br />
  </form>
</section>
<?php }
 
  // Close the database connections
  include '../../model/dbclose.php';
 
  // End the HTML code for the page
  include '../../view/footer.php'; 
?>