 <?PHP
  require_once('../util/main.php');
  require_once('../model/dbinventory.php');
  require_once('../model/database.php');
  
  include '../view/header.php'; 
  include '../view/sidebar.php'; 
  // Get method used when selecting Room to update
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // getting current info in selected building
    try {
       $db = new PDO($dsn, $username, $password);
       $query = 'SELECT * FROM Buildings 
           WHERE BuildingID='.$_GET['BuildingID'] .'
            ORDER BY BuildingID ';
        $resultSet = $db->query($query);     
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
        $query = 'SELECT Rooms.RoomID, Rooms.RoomNumber, rooms.Capacity, vendors.Name,
                   computers.Model, computers.MemorySize, computers.StorageSize, roomcomputers.Count
                   FROM rooms
                   LEFT JOIN roomcomputers 
                   ON Rooms.roomID = roomcomputers.RoomID 
                   LEFT JOIN computers 
                   ON RoomComputers.ComputerID = Computers.computerID 
                   LEFT JOIN vendors 
                   ON Computers.VendorID = Vendors.VendorID 
                   WHERE RoomComputers.BuildingID ='.$_GET['BuildingID'] .' 
                   ORDER BY RoomID';
        $resultSet = $db->query($query);       
     } catch (PDOException $e) {
        $error_message = $e->getMessage();
        echo "<p>An error occurred while connecting to the database: $error_message </p>";
    }   
  }
?>
  <section><br/>
    <h2>Welcome to the Delta Team Computer Inventory Database Report</h2>
    <p>This is the complete inventory of all computers in the selected building</p>
 
     Building ID &nbsp;-&nbsp;&nbsp;
        <strong><?php echo $result[0]['BuildingID'] ?></strong><br /> 
     Building Number &nbsp;-&nbsp;&nbsp;
        <strong><?php echo $result[0]['BuildingNo'] ?></strong> &nbsp;&nbsp;
     Building Name &nbsp;-&nbsp;&nbsp;
        <strong><?php echo $result[0]['BuildingName'] ?></strong><br/><br/>
     
    <table class="center">
      <caption>Inventory by Rooms in the building</caption>
      <tr>
        <th>Room ID</th>  
        <th>Room Number</th>
        <th>Room Capacity</th>  
        <th>Vendor Name</th>
        <th>Computer Model</th>            
        <th>Memory Size</th>
        <th>Storage Size</th>
        <th>Computer Count</th>
      </tr>
     <?php foreach ($resultSet as $result2) { ?>
      <tr>
        <td><?php echo $result2['RoomID']; ?></td> 
        <td><?php echo $result2['RoomNumber']; ?></td> 
        <td><?php echo $result2['Capacity']; ?></td> 
        <td><?php echo $result2['Name']; ?></td> 
        <td><?php echo $result2['Model']; ?></td> 
        <td><?php echo $result2['MemorySize']; ?></td> 
        <td><?php echo $result2['StorageSize']; ?></td> 
        <td><?php echo $result2['Count']; ?></td>       
      </tr>
      <?php } ?>
      
    </table>  
    <br/><br/>
  </section>
<?php include '../view/footer.php'; ?>