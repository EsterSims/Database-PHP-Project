<?php
  require_once('../../util/main.php');
  require_once('../../model/dbinventory.php');
  require_once('../../model/database.php');

  include 'view/header.php'; 
  include 'view/sidebar.php'; 
  
  //Select all data from Vendors table
  try {
    $db = new PDO($dsn, $username, $password);
       
    $query = 'SELECT * FROM Vendors ORDER BY VendorID;';
    $resultSet = $db->query($query);
    $result = $resultSet->rowCount();
   
  } catch (PDOException $e) {
    $error_message = $e->getMessage();
    echo "<p>An error occurred while connecting to the database: $error_message </p>";
  }  
?>
  
  <section>
    <?php
    //Display all data from Vendors table or "No records" message"
    if ($result == 0){
      echo '<br /><br /><h2>No records exist in the Vendors table!</h2>';
      echo '<h3>Please select the "Load Data" link to load or <br />the "Add a Vendor" link to add records.<h3/>';
      echo ' <a href="addvendor.php">Add a Vendor</a>';
    } else{?> 
        <table class="center">
          <caption><h2>Vendors</h2></caption>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Contact</th>
            <th>Phone</th>
            <th>Action</th>
          </tr>
          <?php foreach ($resultSet as $Vendors) { ?>
          <tr>
            <td><?php echo $Vendors['VendorID']; ?></td>
            <td><?php echo $Vendors['Name']; ?></td>
            <td><?php echo $Vendors['Contact']; ?></td>
            <td><?php echo $Vendors['Phone']; ?></td>
            <td><a href="updatevendor.php?VendorID=<?php echo $Vendors['VendorID']; ?>">Update</a> | <a href=  "deletevendor.php?VendorID=<?php echo $Vendors['VendorID']; ?>">Delete</a></td>
          </tr>
          <?php } ?>
          <tr>
            <td colspan="5"> <a href="addvendor.php?VendorID=<?php echo $Vendor['VendorID']; ?>">Add a Vendor</a></td>
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