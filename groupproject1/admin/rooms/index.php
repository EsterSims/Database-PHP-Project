<?php
  require_once('../../util/main.php');
  require_once('../../model/dbinventory.php');
  require_once('../../model/database.php');

  include 'view/header.php'; 
  include 'view/sidebar.php'; 
  
  //Select all data from Rooms table
  try {
    $db = new PDO($dsn, $username, $password);
       
    $query = 'SELECT * FROM rooms ORDER BY RoomId;';
    $resultSet = $db->query($query);
    $result = $resultSet->rowCount();
   
  } catch (PDOException $e) {
    $error_message = $e->getMessage();
    echo "<p>An error occurred while connecting to the database: $error_message </p>";
  }  
?>
  
  <section>
    <?php
    //Display all data from Rooms table or "No records" message"
    if ($result == 0){
      echo '<br /><br /><h2>No records exist in the Rooms table!</h2>';
      echo '<h3>Please select the "Load Data" link to load or <br />the "Add a Room" link to add records.<h3/>';
      echo ' <a href="addroom.php">Add a Room</a>';
    } else{?> 
        <table class="center">
          <caption><h2>Rooms</h2></caption>
          <tr>
            <th>Room ID</th>
            <th>Building ID</th>
            <th>Number</th>
            <th>Capacity</th>
            <th>Action</th>
          </tr>
          <?php foreach ($resultSet as $rooms) { ?>
          <tr>
            <td><?php echo $rooms['RoomID']; ?></td>
            <td><?php echo $rooms['BuildingID']; ?></td>
            <td><?php echo $rooms['RoomNumber']; ?></td>
            <td><?php echo $rooms['Capacity']; ?></td>
          <td><a href="updateroom.php?RoomID=<?php echo $rooms['RoomID']; ?>">Update</a> | <a href=  "deleteroom.php?RoomID=<?php echo $rooms['RoomID']; ?>">Delete</a></td>
          </tr>
          <?php } ?>
          <tr>
            <td colspan="5"> <a href="addroom.php?RoomID=<?php echo $rooms['RoomID']; ?>">Add a Room</a></td>
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