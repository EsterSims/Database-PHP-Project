<?php
  require_once('../../util/main.php');
  require_once('../../model/dbinventory.php');
  require_once('../../model/database.php');

  include '../../view/header.php'; 
  include '../../view/sidebar.php'; 
  
  // Get method used when selecting Vendor to update
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Read the selected Vendor from the database
    $query = 'SELECT * FROM Vendors
              WHERE VendorID='.$_GET['VendorID'];
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
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Name =  $_POST['Name'];
    $Contact = $_POST['Contact'];
    $Phone = $_POST['Phone'];
 
    if ( $Name === '' ||  $Contact === '' ||  $Phone === '' || preg_match('/^\d{3}-\d{3}-\d{4}$/', $Phone)!= 1 ) {            
      $error = 'Input error, please check all fields and try again.<br />';
      $result[0]['VendorID'] = $_POST['VendorID'];
      $result[0]['Name'] = $Name;
      $result[0]['Contact'] = $Contact;
      $result[0]['Phone'] = $Phone;
    } else{ 
        
    // Update the confirmed Vendor changes to the database
      if (empty($errorMessage)) {
        try { 
          $query = 'UPDATE Vendors
                SET Name=\'' . $_POST['Name'] . '\', ' .
               'Contact=\'' . $_POST['Contact'] . '\', ' .
               'Phone=\'' . $_POST['Phone'] . '\' ' .   
               'WHERE VendorID=' . $_POST['VendorID'];
    
          $statement = $db->prepare($query);
          $statement->bindValue(':Name',$Name);
          $statement->bindValue(':Contact',$Contact);
          $statement->bindValue(':Phone',$Phone);
          $statement->execute();
          $statement->closeCursor();
        
          // Redirect to Vendors listing page
          header('Location: index.php');
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
        }
      }
    }  
  }
     
  //Display if error occurred, else list the Vendors
  if (!empty($errorMessage)) {
      display_db_error($errorMessage);
  } else {
?>
      <section><br/>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="updatevendor" method="post">
        <h3>Update  Vendor</h3>
        All Information Required * <br/>
        <span class="error"><?php echo $error ;?></span>
        <input type="hidden" name="VendorID" id="VendorID" value="<?php echo $result[0]['VendorID']; ?>" /><br/>
        Vendor ID &nbsp;-&nbsp;&nbsp;
        <strong><?php echo $result[0]['VendorID']; ?></strong><br/><br/>
  
        *Vendor Name &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" name="Name" id="Name" value="<?php echo $result[0]['Name'];  ?>"/><br/><br/>
        *Vendor Contact &nbsp;&nbsp;&nbsp;&nbsp;
        <input type ="text" name="Contact" id="Contact" value="<?php echo $result[0]['Contact']; ?>"/><br/><br/>
        *Vendor Phone &nbsp;&nbsp;&nbsp;&nbsp;
        <input type ="text" name="Phone" id="Phone" placeholder="xxx-xxx-xxxx" value="<?php echo $result[0]['Phone']; ?>"/><br/><br/>
  
        <input type="submit" value="Update Vendor">
      </form>
    </section>
<?php
  }
 
  // Close the database connections
  include '../../model/dbclose.php';
 
  // End the HTML code for the page
  include '../../view/footer.php'; ?>