<?php
  require_once('../../util/main.php');
  require_once('../../model/dbinventory.php');
  require_once('../../model/database.php');

  include '../../view/header.php'; 
  include '../../view/sidebar.php'; 
   
  // Check if POST method used and then insert the data. Also check for empty fields
  $Model = "";
  $ModelErr = "";
  $MemorySize = "";
  $MemorySizeErr = "";
  $StorageSize = "";
  $StorageSizeErr = "";
  $formok = TRUE;
  
  // getting current Vendors list
  try {
    $db = new PDO($dsn, $username, $password);
    $query = 'SELECT * FROM Vendors ORDER BY VendorID;';
    $resultSet = $db->query($query);
  } catch (PDOException $e) {
       $error_message = $e->getMessage();
       echo "<p>An error occurred while connecting to the database: $error_message </p>";
  }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $VendorID = $_POST['VendorID'];
      if (isset($_POST['Model'])) {
        $Model = $_POST['Model'];
        if (empty($Model)) {
          $ModelErr = 'Model is required!';
          $formok = FALSE;
        } 
      } else {
          $ModelErr = 'Model was not entered';
          $formok = FALSE;
      }     
      if (isset($_POST['MemorySize'])) {
        $MemorySize = $_POST['MemorySize'];
        if (empty($MemorySize)) {
          $MemorySizeErr = 'Memory Size is required!';
          $formok = FALSE;
        } 
      } else {
          $MemorySizeErr = 'Memory Size was not entered';
          $formok = FALSE;
      }
    
    if (isset($_POST['StorageSize'])) {
      $StorageSize = $_POST['StorageSize'];
      if (empty($StorageSize)) {
        $StorageSizeErr = 'Storage Size is required!';
        $formok = FALSE;
      } 
    } else {
      $StorageSizeErr = 'Storage Size was not entered';
      $formok = FALSE;
    }
    
    // Insert data into Computers table 
    if ($formok) {
    try {
      $db = new PDO($dsn, $username, $password);  
      $query = "INSERT INTO Computers
               (VendorID, Model, MemorySize, StorageSize)
             VALUES
               ('$VendorID', '$Model', '$MemorySize', '$StorageSize' )";
      $insert_count = $db->exec($query);
    } catch (PDOException $e) {
       $error_message = $e->getMessage();
       echo "<p>An error occurred while connecting to the database: $error_message </p>";
    }
      if ($insert_count < 1) {
        $errorMessage = 'Error inserting Computer.';
      } else {
        // Redirect to Computers listing page
        header('Location: index.php');
      }
    }  
  }  
  
?>
<section>
<br/>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="addcomputer" method="post">
  
   <input type="hidden" name="VendorID" value="<?php echo computers[$VendorID]; ?>" /> 
    <h3>Add Computer</h3>
    All Information Required * <br/><br/>
    Vendor ID / Name &nbsp;&nbsp;&nbsp;&nbsp;
    <select name="VendorID">
        <?php foreach ($resultSet as $vendors) :
                if ($vendors['VendorID'] == $computers['VendorID']) {
                  $selected = 'selected';
                } else {
                $selected = '';
                }
        ?>
            <option value="<?php echo $vendors['VendorID']; ?>" <?php
                      echo $selected ?>>
               <?php echo $vendors['VendorID'] . "/ " .$vendors['Name']; ?>
            </option>
        <?php endforeach; ?>
        </select><br><br>
     
    * Model &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="text" name="Model" id="Model" value = "<?php echo $Model; ?>"> <span class="error"><?php echo $ModelErr; ?></span><br/><br/>
    
    * Memory Size &nbsp;&nbsp;&nbsp;&nbsp;
    <input  type="text" name="MemorySize" id="MemorySize" value = "<?php echo $MemorySize; ?>"> <span class="error"><?php echo $MemorySizeErr; ?></span><br/><br/>
    
    * Storage Size &nbsp;&nbsp;&nbsp;&nbsp;
    <input  type="text" name="StorageSize" id="StorageSize" value = "<?php echo $StorageSize; ?>"> <span class="error"><?php echo $StorageSizeErr; ?></span><br/><br/>
    <input type="submit" value="Add Computer"><br/><br/>
  </form>
</section>
<?php

  // Close the database connections
  include '../../model/dbclose.php';
 
  // End the HTML code for the page
  include '../../view/footer.php'; ?>