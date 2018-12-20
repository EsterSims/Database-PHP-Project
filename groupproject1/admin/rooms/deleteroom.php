<?php
  require_once('../../util/main.php');
  require_once('../../model/dbinventory.php');
  require_once('../../model/database.php');

  include '../../view/header.php'; 
  include '../../view/sidebar.php'; 

  // Get method used when selecting Room to delete
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Read the selected Room from the database
    $query = 'SELECT * FROM rooms
              WHERE RoomID='.$_GET['RoomID'];
             
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
  // Read Building info from the database
 $BuildingID = $result[0]['BuildingID'];
 $query = 'SELECT * FROM Buildings
              WHERE BuildingID='  .$BuildingID;
             
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
    // Delete the confirmed Room from the database and checking for dependency
    $query = 'DELETE FROM rooms
             WHERE RoomID='.$_POST['RoomID'];
    $delete_count = $db->exec($query);
    if ($delete_count < 1) {
      $errorMessage = 'Error deleting Room, other tables depend on this record.';
    } else {
      // Redirect to Rooms listing page
      header('Location: index.php');
    }

    if (empty($errorMessage)) {
      try {
        $statement = $db->prepare($query);
        $statement->execute();
        $statement->closeCursor();
        // Redirect to Rooms listing page
        header('Location: index.php');
      } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
      }
    }
  }
   
  // Display if error occurred, else list the Rooms
  if (!empty($errorMessage)) {
    display_db_error($errorMessage);
  } else {
?>
<section><br/>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="deleteroom" method="post">
    <h3>Confirm Deletion from Rooms table</h3>
    <input type="hidden" name="RoomID" id="RoomID" value="<?php echo $result[0]['RoomID']; ?>" />
    Building ID / Number - Name: <strong><?php echo $result[0]['BuildingID'] . " / " .$result1[0]['BuildingNo'] . " - " .$result1[0]['BuildingName']; ?></strong><br/><br />
    Room ID: <strong><?php echo $result[0]['RoomID']; ?></strong><br/><br />
    Room Number: <strong><?php echo $result[0]['RoomNumber']; ?></strong><br/><br />
    Capacity: <strong><?php echo $result[0]['Capacity']; ?></strong><br/><br />
    <input type="submit" value="Delete Room"><br/><br />
    To cancel press the back button!<br />
  </form>
</section>
<?php }
 
  // Close the database connections
  include '../../model/dbclose.php';
 
  // End the HTML code for the page
  include '../../view/footer.php'; 
?>