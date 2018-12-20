<?php
  require_once('../../util/main.php');
  require_once('../../model/dbinventory.php');
  require_once('../../model/database.php');

  include 'view/header.php'; 
  include 'view/sidebar.php'; 
  
  //Select all data from Computers table
  try {
    $db = new PDO($dsn, $username, $password);
       
    $query = 'SELECT * FROM Computers ORDER BY ComputerID;';
    $resultSet = $db->query($query);
    $result = $resultSet->rowCount();
   
  } catch (PDOException $e) {
      $error_message = $e->getMessage();
      echo "<p>An error occurred while connecting to the database: $error_message </p>";
  }  
?>
  
  <section>
    <?php
    //Display all data from Computers table or "No records" message"
    if ($result == 0){
      echo '<br /><br /><h2>No records exist in the Computers table!</h2>';
      echo '<h3>Please select the "Load Data" link to load or <br />the "Add a Computer" link to add records.<h3/>';
      echo ' <a href="addcomputer.php">Add a Computer</a>';
    } else{?> 
        <table class="center">
          <caption><h2>Computers</h2></caption>
          <tr>
            <th>Computer ID</th>
            <th>Vendor ID</th>
            <th>Model</th>
            <th>Memory size</th>
            <th>Storage Size</th>
            <th>Action</th>
          </tr>
          <?php foreach ($resultSet as $Computers) { ?>
          <tr>
            <td><?php echo $Computers['ComputerID']; ?></td>
            <td><?php echo $Computers['VendorID']; ?></td>
            <td><?php echo $Computers['Model']; ?></td>
            <td><?php echo $Computers['MemorySize']; ?></td>
            <td><?php echo $Computers['StorageSize']; ?></td>
            <td><a href="updatecomputer.php?ComputerID=<?php echo $Computers['ComputerID']; ?>">Update</a> | <a href=  "deletecomputer.php?ComputerID=<?php echo $Computers['ComputerID']; ?>">Delete</a></td>
          </tr>
          <?php } ?>
          <tr>
            <td colspan="6"> <a href="addcomputer.php?ComputerID=<?php echo $Computers['ComputerID']; ?>">Add a Computer</a></td>
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