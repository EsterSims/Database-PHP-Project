<?php
  require_once('../../util/main.php');
  require_once('../../model/dbinventory.php');
  require_once('../../model/database.php');

  include 'view/header.php'; 
  include 'view/sidebar.php'; 
  
  //Select all data from buildings table
  try {
    $db = new PDO($dsn, $username, $password);
       
    $query = 'SELECT * FROM buildings ORDER BY BuildingID;';
    $resultSet = $db->query($query);
    $result = $resultSet->rowCount();
   
  } catch (PDOException $e) {
    $error_message = $e->getMessage();
    echo "<p>An error occurred while connecting to the database: $error_message </p>";
  }  
?>
  
  <section>
    <?php
    //Display all data from buildings table or "No records" message"
    if ($result == 0){
      echo '<br /><br /><h2>No records exist in the Building table!</h2>';
      echo '<h3>Please select the "Load Data" link to load or <br />the "Add a Building" link to add records.<h3/>';
      echo ' <a href="addbuilding.php">Add a Building</a>';
    } else{?> 
    
        <table class="center">
          <caption><h2>Buildings</h2></caption>
          <tr>
            <th>ID</th>
            <th>Number</th>
            <th>Name</th>
            <th>Action</th>
          </tr>
          <?php foreach ($resultSet as $buildings) { ?>
          <tr>
            <td><?php echo $buildings['BuildingID']; ?></td>
            <td><?php echo $buildings['BuildingNo']; ?></td>
            <td><?php echo $buildings['BuildingName']; ?></td>
            <td><a href="updatebuilding.php?BuildingID=<?php echo $buildings['BuildingID']; ?>">Update</a> | <a href=  "deletebuilding.php?BuildingID=<?php echo $buildings['BuildingID']; ?>">Delete</a></td>
          </tr>
          <?php } ?>
          <tr>
            <td colspan="4"> <a href="addbuilding.php?BuildingID=<?php echo $buildings['BuildingID']; ?>">Add a Building</a></td>
          </tr>
        </table>
        <br/><br/>
    <?php } ?> 
   </section>
<?php  
  // Close the database connections
  include '../../model/dbclose.php';
  
  // End the HTML code for the page
  include 'view/footer.php'; ?>