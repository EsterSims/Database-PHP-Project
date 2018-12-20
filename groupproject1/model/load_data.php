<?php
  require_once('../util/main.php');
  require_once('../model/dbinventory.php');
  require_once('../model/database.php');

  try {
    $db = new PDO($dsn, $username, $password);
       
    //select the database to use            
    $SQLstatement = 'Use inventory;';
    $db->exec($SQLstatement);
    
     //insert data into Buildings table
    $buildingno = '13';
    $buildingname = 'Computer Science';
    $SQLstatement = 'INSERT INTO Buildings (BuildingNo, BuildingName) VALUES (:buildingno,:buildingname);';
    $statement = $db->prepare($SQLstatement);
    $statement->bindValue(':buildingno',$buildingno);
    $statement->bindValue(':buildingname',$buildingname);
    $statement->execute();
    $statement->closeCursor();
    
    $buildingno = '19';
    $buildingname = 'Admission';
    $SQLstatement = 'INSERT INTO Buildings (BuildingNo, BuildingName) VALUES (:buildingno,:buildingname);';
    $statement = $db->prepare($SQLstatement);
    $statement->bindValue(':buildingno',$buildingno);
    $statement->bindValue(':buildingname',$buildingname);
    $statement->execute();
    $statement->closeCursor();
    
    $buildingno = '17';
    $buildingname = 'Library';
    $SQLstatement = 'INSERT INTO Buildings (BuildingNo, BuildingName) VALUES (:buildingno,:buildingname);';
    $statement = $db->prepare($SQLstatement);
    $statement->bindValue(':buildingno',$buildingno);
    $statement->bindValue(':buildingname',$buildingname);
    $statement->execute();
    $statement->closeCursor();
    
    //insert data into Rooms table
    $buildingid = '1';
    $roomnumber = '105';
    $capacity = '25';
    $SQLstatement = 'INSERT INTO Rooms (buildingid, roomnumber, capacity) VALUES (:buildingid, :roomnumber, :capacity);';
    $statement = $db->prepare($SQLstatement);
    $statement->bindValue(':buildingid',$buildingid);
    $statement->bindValue(':roomnumber',$roomnumber);
    $statement->bindValue(':capacity',$capacity);
    $statement->execute();
    $statement->closeCursor();
    
    $buildingid = '3';
    $roomnumber = '245';
    $capacity = '50';
    $SQLstatement = 'INSERT INTO Rooms (buildingid, roomnumber, capacity) VALUES (:buildingid, :roomnumber, :capacity);';
    $statement = $db->prepare($SQLstatement);
    $statement->bindValue(':buildingid',$buildingid);
    $statement->bindValue(':roomnumber',$roomnumber);
    $statement->bindValue(':capacity',$capacity);
    $statement->execute();
    $statement->closeCursor();
    
    $buildingid = '1';
    $roomnumber = '125';
    $capacity = '20';
    $SQLstatement = 'INSERT INTO Rooms (buildingid, roomnumber, capacity) VALUES (:buildingid, :roomnumber, :capacity);';
    $statement = $db->prepare($SQLstatement);
    $statement->bindValue(':buildingid',$buildingid);
    $statement->bindValue(':roomnumber',$roomnumber);
    $statement->bindValue(':capacity',$capacity);
    $statement->execute();
    $statement->closeCursor();
    
    //insert data into Vendors table
    $name = 'Office Depot';
    $contact = 'Tom Smith';
    $phone = '954-555-5555';
    $SQLstatement = 'INSERT INTO Vendors (name, contact, phone ) VALUES (:name, :contact, :phone);';
    $statement = $db->prepare($SQLstatement);
    $statement->bindValue(':name',$name);
    $statement->bindValue(':contact',$contact);
    $statement->bindValue(':phone',$phone);
    $statement->execute();
    $statement->closeCursor();
    
    $name = 'Apple';
    $contact = 'Sue Gomez';
    $phone = '954-222-2222';
    $SQLstatement = 'INSERT INTO Vendors (name, contact, phone ) VALUES (:name, :contact, :phone);';
    $statement = $db->prepare($SQLstatement);
    $statement->bindValue(':name',$name);
    $statement->bindValue(':contact',$contact);
    $statement->bindValue(':phone',$phone);
    $statement->execute();
    $statement->closeCursor(); 
    
    $name = 'Computers R Us';
    $contact = 'Bob Jones';
    $phone = '305-123-4567';
    $SQLstatement = 'INSERT INTO Vendors (name, contact, phone ) VALUES (:name, :contact, :phone);';
    $statement = $db->prepare($SQLstatement);
    $statement->bindValue(':name',$name);
    $statement->bindValue(':contact',$contact);
    $statement->bindValue(':phone',$phone);
    $statement->execute();
    $statement->closeCursor();
    
    //insert data into Computers table
    $vendorid = '1';
    $model = 'HP Pavilion x';
    $memorysize = '8GB';
    $storagesize = '256GB';
    $SQLstatement = 'INSERT INTO Computers (vendorid, model, memorysize, storagesize) VALUES (:vendorid, :model, :memorysize, :storagesize);';
    $statement = $db->prepare($SQLstatement);
    $statement->bindValue(':vendorid',$vendorid);
    $statement->bindValue(':model',$model);
    $statement->bindValue(':memorysize',$memorysize);
    $statement->bindValue(':storagesize',$storagesize);
    $statement->execute();
    $statement->closeCursor();
    
    $vendorid = '2';
    $model = 'Apple -21.5 iMac';
    $memorysize = '8GB';
    $storagesize = '1TB';
    $SQLstatement = 'INSERT INTO Computers (vendorid, model, memorysize, storagesize) VALUES (:vendorid, :model, :memorysize, :storagesize);';
    $statement = $db->prepare($SQLstatement);
    $statement->bindValue(':vendorid',$vendorid);
    $statement->bindValue(':model',$model);
    $statement->bindValue(':memorysize',$memorysize);
    $statement->bindValue(':storagesize',$storagesize);
    $statement->execute();
    $statement->closeCursor();
    
    $vendorid = '1';
    $model = 'Apple -21.5 iMac';
    $memorysize = '8GB';
    $storagesize = '1TB';
    $SQLstatement = 'INSERT INTO Computers (vendorid, model, memorysize, storagesize) VALUES (:vendorid, :model, :memorysize, :storagesize);';
    $statement = $db->prepare($SQLstatement);
    $statement->bindValue(':vendorid',$vendorid);
    $statement->bindValue(':model',$model);
    $statement->bindValue(':memorysize',$memorysize);
    $statement->bindValue(':storagesize',$storagesize);
    $statement->execute();
    $statement->closeCursor();
    
    //insert data into RoomComputers table
    $roomid = '1';
    $buildingid = '1';
    $computerid = '1';
    $count = '10';
    $SQLstatement = 'INSERT INTO RoomComputers (roomid, buildingid, computerid, count) VALUES (:roomid, :buildingid, :computerid, :count);';
    $statement = $db->prepare($SQLstatement);
    $statement->bindValue(':roomid',$roomid);
    $statement->bindValue(':buildingid',$buildingid);
    $statement->bindValue(':computerid',$computerid);
    $statement->bindValue(':count',$count);
    $statement->execute();
    $statement->closeCursor();
    
    //insert data into RoomComputers table
    $roomid = '1';
    $buildingid = '1';
    $computerid = '2';
    $count = '15';
    $SQLstatement = 'INSERT INTO RoomComputers (roomid, buildingid, computerid, count) VALUES (:roomid, :buildingid, :computerid, :count);';
    $statement = $db->prepare($SQLstatement);
    $statement->bindValue(':roomid',$roomid);
    $statement->bindValue(':buildingid',$buildingid);
    $statement->bindValue(':computerid',$computerid);
    $statement->bindValue(':count',$count);
    $statement->execute();
    $statement->closeCursor();
    
    //insert data into RoomComputers table
    $roomid = '2';
    $buildingid = '3';
    $computerid = '2';
    $count = '50';
    $SQLstatement = 'INSERT INTO RoomComputers (roomid, buildingid, computerid, count) VALUES (:roomid, :buildingid, :computerid, :count);';
    $statement = $db->prepare($SQLstatement);
    $statement->bindValue(':roomid',$roomid);
    $statement->bindValue(':buildingid',$buildingid);
    $statement->bindValue(':computerid',$computerid);
    $statement->bindValue(':count',$count);
    $statement->execute();
    $statement->closeCursor();
        
    header('Location: ../index.php');
    
   } catch (PDOException $e) {
      $error_message = $e->getMessage();
      echo "<p>An error occurred while connecting to
           the database: $error_message </p>";  
   }
  ?>