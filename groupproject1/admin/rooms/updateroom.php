<?php
  require_once('../../util/main.php');
  require_once('../../model/dbinventory.php');
  require_once('../../model/database.php');

  include '../../view/header.php'; 
  include '../../view/sidebar.php'; 
  
  // Get method used when selecting Room to update
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
  }
 
  // Check if POST method used and then update the data. Also check for empty fields
  $error = '';
  
  // getting current buildings list
  $query = 'SELECT * FROM Buildings ORDER BY BuildingId;';
    $resultSet = $db->query($query);
    
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $BuildingID =  $_POST['BuildingID'];
    $RoomNumber = $_POST['RoomNumber'];
    $Capacity = $_POST['Capacity'];
 
    if ( $RoomNumber === '' || $Capacity === '') {            
      $error = 'Input error, please check all fields and try again.<br />';
      $result[0]['RoomID'] = $_POST['RoomID'];
      $result[0]['BuildingID'] = $BuildingID;
      $result[0]['RoomNumber'] = $RoomNumber;
      $result[0]['Capacity'] = $Capacity;
    } else{ 
       
   // Update the confirmed Room changes to the database
      if (empty($errorMessage)) {
        try { 
          $query = 'UPDATE rooms
                SET BuildingID=\'' . $_POST['BuildingID'] . '\', ' .
               'RoomNumber=\'' . $_POST['RoomNumber'] . '\', ' .
               'Capacity=\'' . $_POST['Capacity'] . '\' ' .
               'WHERE RoomID=' . $_POST['RoomID'];
    
          $statement = $db->prepare($query);
          $statement->bindValue(':BuildingID',$BuildingID);
          $statement->bindValue(':RoomNumber',$RoomNumber);
          $statement->bindValue(':Capacity',$Capacity);
          $statement->execute();
          $statement->closeCursor();
        
          // Redirect to Rooms listing page
          header('Location: index.php');
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
        }
      }
    }  
  }
     
  //Display if error occurred, else list the Rooms
  if (!empty($errorMessage)) {
      display_db_error($errorMessage);
  } else {
?>
      <section><br/>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="updateroom" method="post"> 
        <h3>Update Room</h3>
        All Information required * <br/>
        <span class="error"><?php echo $error ;?></span>
        <input type="hidden" name="RoomID" id="RoomID" value="<?php echo $result[0]['RoomID']; ?>" /><br/>
        <input type="hidden" name="BuildingID" value="<?php echo $result[0]['BuildingID']; ?>" /> 
    
        Room ID &nbsp;-&nbsp;&nbsp;
        <strong><?php echo $result[0]['RoomID']; ?></strong><br/><br/>
  
        Building ID / Number - Name &nbsp;&nbsp;&nbsp;&nbsp;
        <select name="BuildingID">
        <?php foreach ($resultSet as $buildings) : 
            if ($buildings['BuildingID'] == $result[0]['BuildingID']) {
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
   
        *Room Number &nbsp;&nbsp;&nbsp;&nbsp;
        <input type ="text" name="RoomNumber" id="RoomNumber" value="<?php echo $result[0]['RoomNumber']; ?>"/><br/><br/>
        *Capacity &nbsp;&nbsp;&nbsp;&nbsp;
        <input type ="text" name="Capacity" id="Capacity" value="<?php echo $result[0]['Capacity']; ?>"/><br/><br/>
  
        <input type="submit" value="Update Room">
      </form>
    </section>
<?php
  }
 
  // Close the database connections
  include '../../model/dbclose.php';
 
  // End the HTML code for the page
  include '../../view/footer.php'; ?>