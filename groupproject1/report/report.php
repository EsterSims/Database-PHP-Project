<?php
  require_once('../util/main.php');
  require_once('../model/dbinventory.php');
  require_once('../model/database.php');
  
  include '../view/header.php'; 
  include '../view/sidebar.php'; 
  try {
    $db = new PDO($dsn, $username, $password);
    // getting current buildings list
    $query = 'SELECT * FROM Buildings ORDER BY BuildingId;';
    $resultSet = $db->query($query);
  } catch (PDOException $e) {
     $error_message = $e->getMessage();
     echo "<p>An error occurred while connecting to the database: $error_message </p>";
  } 
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $BuildingID = $_POST['BuildingID'];
        // Redirect to viewreport page
        header('Location: viewreport.php');
    }  
?>
 
<section><br/>
  <form action="<?php echo $app_path ?>report/viewreport.php" name="report" method="GET">
  <input type="hidden" name="BuildingID" value="<?php echo $result[0]['BuildingID']; ?>" /> 
  <input type="hidden" name="BuildingNo" value="<?php echo $result[0]['BuildingNo']; ?>" /> 
  <input type="hidden" name="BuildingName" value="<?php echo $result[0]['BuildingName']; ?>" /> 
    <h3>Select a Building to view a report of all computers in that building</h3>
    
        Building ID / Number - Name&nbsp;&nbsp;&nbsp;&nbsp;
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
    
    <input type="submit" value="Select Building"><br/><br/>
  </form>
</section>
<?php

  // Close the database connections
  include '../model/dbclose.php';
 
  // End the HTML code for the page
  include '../view/footer.php'; ?>