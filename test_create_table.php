<?php
$con=mysqli_connect("localhost","admin","qazwsx","my_db");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

// Create table
$sql="CREATE TABLE persons(PID INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(PID),
Login CHAR(30),
Password CHAR(30),
Email CHAR(60),
FirstName CHAR(15),
LastName CHAR(15),
Role CHAR(15),
Active TINYINT(1),
Image MEDIUMBLOB,
REG_DATE TIMESTAMP,
LVIS_DATE TIMESTAMP
)";

// Execute query
if (mysqli_query($con,$sql))
  {
  echo "Table persons created successfully";
  }
else
  {
  echo "Error creating table: " . mysqli_error($con);
  }
?> 