<?php
  require_once('../../util/main.php');
  require_once('../../model/dbinventory.php');
  require_once('../../model/database.php');

  include '../../view/header.php'; 
  include '../../view/sidebar.php'; 
   
  // Check if POST method used and then insert the data. Also check for empty fields
  $Name ="";
  $NameErr = ""; 
  $Contact = "";
  $ContactErr = "";
  $Phone = "";
  $PhoneErr = "";
  $formok = TRUE;
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['Name'])) {
      $Name = $_POST['Name'];
      if (empty($Name)) {
        $NameErr = 'Vendor Name is required!';
        $formok = FALSE;
      } 
    } else {
      $NameErr = 'Vendor Name was not entered';
      $formok = FALSE;
    }
    
    if (isset($_POST['Contact'])) {
      $Contact = $_POST['Contact'];
      if (empty($Contact)) {
        $ContactErr = 'Vendor Contact is required!';
        $formok = FALSE;
      } 
    } else {
      $ContactErr = 'Vendor Contact was not entered';
      $formok = FALSE;
    }
    
    // Checking for Phone number errors
    if (isset($_POST['Phone'])) {  
      $Phone = $_POST['Phone'];
      if (empty($Phone)) {
        $PhoneErr = 'Vendor phone number is required!';
        $formok = FALSE;
      } 
      else if(preg_match('/^\d{3}-\d{3}-\d{4}$/', $Phone)!= 1){
        $PhoneErr = 'Phone number format must be xxx-xxx-xxxx!';
        $formok = FALSE;
      }
      
    }else{
      $phoneerror = 'Phone number was not entered';
      $formok = FALSE;   
    }
    
    // Insert data into Vendor table 
    if ($formok) {
      $query = "INSERT INTO Vendors
               (Name, Contact, Phone)
             VALUES
               ('$Name', '$Contact', '$Phone')";
      $insert_count = $db->exec($query);
      if ($insert_count < 1) {
        $errorMessage = 'Error inserting Vendor.';
      } else {
        // Redirect to Vendor listing page
        header('Location: index.php');
      }
    }  
  }  
  
?>
<section><br/>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="addvendor" method="post">
    <h3>Add Vendor</h3>
    All Information Required * <br/><br/>
    * Vendor Name &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="text" name="Name" id="Name" value = "<?php echo $Name; ?>"> <span class="error"><?php echo $NameErr; ?></span><br/><br/>
    
    * Vendor Contact &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="text" name="Contact" id="Contact" value = "<?php echo $Contact; ?>"> <span class="error"><?php echo $ContactErr; ?></span><br/><br/>
    
    * Vendor Phone &nbsp;&nbsp;&nbsp;&nbsp;
    <input  type="text" name="Phone"  id="Phone" placeholder="xxx-xxx-xxxx" value = "<?php echo $Phone; ?>"> <span class="error"><?php echo $PhoneErr; ?></span><br/><br/>
    <input type="submit" value="Add Vendor"><br/><br/>
  </form>
</section>
<?php

  // Close the database connections
  include '../../model/dbclose.php';
 
  // End the HTML code for the page
  include '../../view/footer.php'; ?>