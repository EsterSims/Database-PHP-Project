<?php
  require_once('../../util/main.php');
  require_once('../../model/dbinventory.php');
  require_once('../../model/database.php');

  include '../../view/header.php'; 
  include '../../view/sidebar.php'; 
   
  // Check if POST method used and then insert the data. Also check for empty fields
  $BuildingNo ="";
  $BuildingNoErr = ""; 
  $BuildingName = "";
  $BuildingNameErr = "";
  $formok = TRUE;
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['BuildingNo'])) {
      $BuildingNo = $_POST['BuildingNo'];
      if (empty($BuildingNo)) {
        $BuildingNoErr = 'Building No is required!';
        $formok = FALSE;
      } 
    } else {
      $BuildingNoErr = 'Building No was not entered';
      $formok = FALSE;
    }
    
    if (isset($_POST['BuildingName'])) {
      $BuildingName = $_POST['BuildingName'];
      if (empty($BuildingName)) {
        $BuildingNameErr = 'Building Name is required!';
        $formok = FALSE;
      } 
    } else {
      $BuildingNameErr = 'Building Name was not entered';
      $formok = FALSE;
    }
    // Insert data into buildings table 
    if ($formok) {
      try {
    $db = new PDO($dsn, $username, $password);
      $query = "INSERT INTO buildings
               (BuildingNo, BuildingName)
             VALUES
               ('$BuildingNo', '$BuildingName')";
      $insert_count = $db->exec($query);
      if ($insert_count < 1) {
        $errorMessage = 'Error inserting Building.';
      } else {
        // Redirect to Building listing page
        header('Location: index.php');
      }
    } catch (PDOException $e) {
       $error_message = $e->getMessage();
       echo "<p>An error occurred while connecting to the database: $error_message </p>";
    }
   }    
  }  
  
?>
<section><br/>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="addbuilding" method="post">
    <h3>Add Building</h3>
    All Information Required * <br/><br/>
    * Building Number &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="text" name="BuildingNo" id="BuildingNo" value = "<?php echo $BuildingNo; ?>"> <span class="error"><?php echo $BuildingNoErr; ?></span><br/><br/>
    
    * Building Name &nbsp;&nbsp;&nbsp;&nbsp;
    <input  type="text" name="BuildingName" id="BuildingName" value = "<?php echo $BuildingName; ?>"> <span class="error"><?php echo $BuildingNameErr; ?></span><br/><br/>
    <input type="submit" value="Add Building"><br/><br/>
  </form>
</section>
<?php

  // Close the database connections
  include '../../model/dbclose.php';
 
  // End the HTML code for the page
  include '../../view/footer.php'; ?>