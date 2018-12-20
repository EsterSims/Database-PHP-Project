<?php
  require_once('../../util/main.php');
  require_once('../../model/dbinventory.php');
  require_once('../../model/database.php');
  
  include '../../view/header.php'; 
  include '../../view/sidebar.php'; 
   
  // Check if POST method used and then insert the data. Also check for empty fields
  $RoomNumber = "";
  $RoomNumberErr = "";
  $Capacity = "";
  $CapacityErr = "";
  $formok = TRUE;
 
  // getting current buildings list
  $query = 'SELECT * FROM Buildings ORDER BY BuildingId;';
    $resultSet = $db->query($query);
    
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $BuildingID = $_POST['BuildingID'];
    if (isset($_POST['RoomNumber'])) {
      $RoomNumber = $_POST['RoomNumber'];
      if (empty($RoomNumber)) {
        $RoomNumberErr = 'Room Number is required!';
        $formok = FALSE;
      } 
    } else {
      $RoomNumberErr = 'Room Number was not entered';
      $formok = FALSE;
    }
    
    if (isset($_POST['Capacity'])) {
      $Capacity = $_POST['Capacity'];
      if (empty($Capacity)) {
        $CapacityErr = 'Capacity is required!';
        $formok = FALSE;
      } 
    } else {
      $CapacityErr = 'Capacity was not entered';
      $formok = FALSE;
    }
    // Insert data into Rooms table 
    if ($formok) {
      $query = "INSERT INTO Rooms
               (BuildingID, RoomNumber, Capacity)
             VALUES
               ('$BuildingID', '$RoomNumber', '$Capacity')";
      $insert_count = $db->exec($query);
      if ($insert_count < 1) {
        $errorMessage = 'Error inserting Room.';
      } else {
        // Redirect to Room listing page
        header('Location: index.php');
      }
    }  
  }  
  
?>
 
<section><br/>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="addroom" method="post">
  <input type="hidden" name="BuildingID" value="<?php echo rooms[$BuildingID]; ?>" /> 
    <h3>Add Room</h3>
    All Information Required * <br/><br/>
    Building ID / Number - Name &nbsp;&nbsp;&nbsp;&nbsp;
    <select name="BuildingID">
        <?php foreach ($resultSet as $buildings) : 
            if ($buildings['BuildingID'] == $rooms['BuildingID']) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
        ?>
            <option value="<?php echo $buildings['BuildingID']; ?>" <?php
                      echo $selected ?>>
               <?php echo $buildings['BuildingID'] . "/ " .$buildings['BuildingNo']. "- " .$buildings['BuildingName']; ?>
            </option>
        <?php endforeach; ?>
        </select><br><br>
  
    * Room Number &nbsp;&nbsp;&nbsp;&nbsp;
    <input  type="text" name="RoomNumber" id="RoomNumber" value = "<?php echo $RoomNumber; ?>"> <span class="error"><?php echo $RoomNumberErr; ?></span><br/><br/>
    
    * Capacity &nbsp;&nbsp;&nbsp;&nbsp;
    <input  type="text" name="Capacity" id="Capacity" value = "<?php echo $Capacity; ?>"> <span class="error"><?php echo $CapacityErr; ?></span><br/><br/>
    <input type="submit" value="Add Room"><br/><br/>
  </form>
</section>
<?php

  // Close the database connections
  include '../../model/dbclose.php';
 
  // End the HTML code for the page
  include '../../view/footer.php'; ?>