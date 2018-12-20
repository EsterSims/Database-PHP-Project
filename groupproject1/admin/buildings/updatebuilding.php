<?php
  require_once('../../util/main.php');
  require_once('../../model/dbinventory.php');
  require_once('../../model/database.php');

  include '../../view/header.php'; 
  include '../../view/sidebar.php'; 
  
  // Get method used when selecting Building to update
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Read the selected Building from the database
    $query = 'SELECT * FROM Buildings
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
 
  // Check if POST method used and then update the data. Also check for empty fields
  $error = '';
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $BuildingNo =  $_POST['BuildingNo'];
    $BuildingName = $_POST['BuildingName'];
 
    if ( $BuildingNo === '' ||  $BuildingName === '') {            
      $error = 'Input error, please check all fields and try again.<br />';
      $result[0]['BuildingID'] = $_POST['BuildingID'];
      $result[0]['BuildingNo'] = $BuildingNo;
      $result[0]['BuildingName'] = $BuildingName;
    } else{ 
        
    // Update the confirmed Building changes to the database
      if (empty($errorMessage)) {
        try { 
          $query = 'UPDATE Buildings
                SET BuildingNo=\'' . $_POST['BuildingNo'] . '\', ' .
               'BuildingName=\'' . $_POST['BuildingName'] . '\' ' .
               'WHERE BuildingID=' . $_POST['BuildingID'];
    
          $statement = $db->prepare($query);
          $statement->bindValue(':BuildingNo',$BuildingNo);
          $statement->bindValue(':BuildingName',$BuildingName);
          $statement->execute();
          $statement->closeCursor();
        
          // Redirect to Building listing page
          header('Location: index.php');
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
        }
      }
    }  
  }
     
  //Display if error occurred, else list the Buildings
  if (!empty($errorMessage)) {
      display_db_error($errorMessage);
  } else {
?>
      <section><br/>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="updatebuilding" method="post">
        <h3>Update  Building</h3>
        All Information Required * <br/>
        <span class="error"><?php echo $error ;?></span>
        <input type="hidden" name="BuildingID" id="BuildingID" value="<?php echo $result[0]['BuildingID']; ?>" /><br/>
        Building ID &nbsp;-&nbsp;&nbsp;
        <strong><?php echo $result[0]['BuildingID']; ?></strong><br/><br/>
  
        *Building No &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" name="BuildingNo" id="BuildingNo" value="<?php echo $result[0]['BuildingNo'];  ?>"/><br/><br/>
        *Building Name &nbsp;&nbsp;&nbsp;&nbsp;
        <input type ="text" name="BuildingName" id="BuildingName" value="<?php echo $result[0]['BuildingName']; ?>"/><br/><br/>
  
        <input type="submit" value="Update Building">
      </form>
    </section>
<?php
  }
 
  // Close the database connections
  include '../../model/dbclose.php';
 
  // End the HTML code for the page
  include '../../view/footer.php'; ?>