<?php
  require_once('../../util/main.php');
  require_once('../../model/dbinventory.php');
  require_once('../../model/database.php');

  include '../../view/header.php'; 
  include '../../view/sidebar.php'; 
  try {
    $db = new PDO($dsn, $username, $password);
    // Get method used when selecting Computer to update
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
    }
 
    // Check if POST method used and then update the data. Also check for empty fields
    $error = '';
    // getting current Vendors list
    $query = 'SELECT * FROM Vendors ORDER BY VendorID;';
    $resultSet = $db->query($query);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $VendorID =  $_POST['VendorID'];
      $Model = $_POST['Model'];
      $MemorySize = $_POST['MemorySize'];
      $StorageSize = $_POST['StorageSize'];
 
      if ($Model === '' ||  $MemorySize === '' ||  $StorageSize === '') {            
        $error = 'Input error, please check all fields and try again.<br />';
        $result[0]['ComputerID'] = $_POST['ComputerID'];
        $result[0]['VendorID'] = $VendorID;
        $result[0]['Model'] = $Model;
        $result[0]['MemorySize'] = $MemorySize;
        $result[0]['StorageSize'] = $StorageSize;
      } else{ 
        
      // Update the confirmed Computer changes to the database
        if (empty($errorMessage)) {
          try { 
            $query = 'UPDATE Computers
                  SET VendorID=\'' . $_POST['VendorID'] . '\', ' .
                 'Model=\'' . $_POST['Model'] . '\', ' .
                 'MemorySize=\'' . $_POST['MemorySize'] . '\', ' .
                 'StorageSize=\'' . $_POST['StorageSize'] . '\' ' .         
                 'WHERE ComputerID=' . $_POST['ComputerID'];
    
            $statement = $db->prepare($query);
            $statement->bindValue(':VendorID',$VendorID);
            $statement->bindValue(':Model',$Model);
            $statement->bindValue(':MemorySize',$MemorySize);
            $statement->bindValue(':StorageSize',$StorageSize);
            $statement->execute();
            $statement->closeCursor();
          
            // Redirect to Computers listing page
            header('Location: index.php');
          } catch (PDOException $e) {
              $errorMessage = $e->getMessage();
          }
        }
      }  
    }
  } catch (PDOException $e) {
      $error_message = $e->getMessage();
      echo "<p>An error occurred while connecting to the database: $error_message </p>";
  }  
  //Display if error occurred, else list the Buildings
  if (!empty($errorMessage)) {
      display_db_error($errorMessage);
  } else {
?>
  <section><br/>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="updatecomputer" method="post">
      <h3>Update  Computer</h3>
      All Information Required * <br/>
      <span class="error"><?php echo $error ;?></span>
      <input type="hidden" name="ComputerID" id="ComputerID" value="<?php echo $result[0]['ComputerID']; ?>" /><br/>
      <input type="hidden" name="VendorID" value="<?php echo $result[0]['VendorID']; ?>" /> 
       
      Computer ID &nbsp;-&nbsp;&nbsp;
      <strong><?php echo $result[0]['ComputerID']; ?></strong><br/><br/>

      Vendor ID / Name &nbsp;&nbsp;&nbsp;&nbsp;
      <select name="VendorID">
      <?php foreach ($resultSet as $vendors) :
              if ($vendors['VendorID'] == $result[0]['VendorID']) {
                $selected = 'selected';
              } else {
                 $selected = '';
              } ?>
              <option value="<?php echo $vendors['VendorID']; ?>" <?php echo $selected ?>>
                <?php echo $vendors['VendorID'] . "/ " .$vendors['Name']; ?>
               </option>
      <?php endforeach; ?>
      </select><br><br>
      *Model &nbsp;&nbsp;&nbsp;&nbsp;
      <input type ="text" name="Model" id="Model" value="<?php echo $result[0]['Model']; ?>"/><br/><br/>
      *Memory Size &nbsp;&nbsp;&nbsp;&nbsp;
      <input type ="text" name="MemorySize" id="MemorySize" value="<?php echo $result[0]['MemorySize']; ?>"/><br/><br/>
      *Storage Size &nbsp;&nbsp;&nbsp;&nbsp;
      <input type ="text" name="StorageSize" id="StorageSize" value="<?php echo $result[0]['StorageSize']; ?>"/><br/><br/>

      <input type="submit" value="Update Computer">
    </form>
  </section>
<?php
  }
 
  // Close the database connections
  include '../../model/dbclose.php';
 
  // End the HTML code for the page
  include '../../view/footer.php'; ?>