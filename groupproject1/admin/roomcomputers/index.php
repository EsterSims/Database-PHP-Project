<?php
  require_once('../../util/main.php');
  require_once('../../model/dbinventory.php');
  require_once('../../model/database.php');

  include 'view/header.php'; 
  include 'view/sidebar.php'; 
  
  //Select all data from RoomComputers table
  try {
    $db = new PDO($dsn, $username, $password);
       
    $query = 'SELECT * FROM RoomComputers ;';
    $resultSet = $db->query($query);
    $result = $resultSet->rowCount();
   
  } catch (PDOException $e) {
    $error_message = $e->getMessage();
    echo "<p>An error occurred while connecting to the database: $error_message </p>";
  }  
?>
  
  <section>
    <?php
    //Display all data from RoomComputers table or "No records" message"
    if ($result == 0){
      echo '<br /><br /><h2>No records exist in the RoomComputers table!</h2>';
      echo '<h3>Please select the "Load Data" link to load or <br />the "Add a Vendor" link to add records.<h3/>';
      echo ' <a href="addroomcomputers.php">Add a RoomComputer</a>';
    } else{?> 
        <table class="center">
          <caption><h2>RoomComputers</h2></caption>
          <tr>
            <th>RoomID</th>
            <th>Building ID</th>
            <th>Computer ID</th>
            <th>Count</th>
            <th>Action</th>
          </tr>
          <?php foreach ($resultSet as $RoomComputers) { ?>
          <tr>
            <td><?php echo $RoomComputers['RoomID']; ?></td>
            <td><?php echo $RoomComputers['BuildingID']; ?></td>
            <td><?php echo $RoomComputers['ComputerID']; ?></td>
            <td><?php echo $RoomComputers['Count']; ?></td>
            <td><a href="updateroomcomputer.php?RoomID=<?php echo $RoomComputers['RoomID']?>&BuildingID=<?php echo $RoomComputers['BuildingID']?>&ComputerID=<?php echo $RoomComputers['ComputerID']; ?>">Update</a> | 
            <a href=  "deleteroomcomputer.php?RoomID=<?php echo $RoomComputers['RoomID']?>&BuildingID=<?php echo $RoomComputers['BuildingID']?>&ComputerID=<?php echo $RoomComputers['ComputerID']; ?>">Delete</a></td>
          </tr>
          <?php } ?>
          <tr>
            <td colspan="5"> <a href="selectbuilding.php ?>">Add a RoomComputer</a></td>
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