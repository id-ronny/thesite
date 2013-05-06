<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php session_start(); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>The Site | by ronny</title>
<style>
div.ex
{
width:520px;
height:120px;
padding:10px;
border:5px solid gray;
margin:auto;
font-family:courier;
}
div.ey
{
width:520px;
padding:10px;
border:5px solid orange;
margin:auto;
font-family:courier;
}
</style>
</head>

<body>
<?php	if(isset($_SESSION['admin']))
	{?>
	  <div class="ex">
         <a href="index.php"><img src="img/images.jpeg" width="115" height="115"/></a>		
         <div style="text-align:right;position:relative;float:right;top:25px;margin-right:30px">
            <strong>Welcome Administrator!</strong><br>
            <a href=index.php?page=create>Create new article</a><br>
            <a href=index.php?page=logout>Logout</a><br>
         </div>
      </div><?php
	}
   else if(isset($_GET['usr']) || isset($_GET['admin']))
	{
		if($_GET['usr']=="admin" && $_GET['passwd']=="qazwsx")
		{
         $_SESSION['admin']=TRUE; ?>
         <div class="ex">
            <a href="index.php"><img src="img/images.jpeg" width="115" height="115"/></a>				
            <div style="text-align:right;position:relative;float:right;top:25px;margin-right:30px">
               <strong>Welcome Administrator!</strong><br>
               <a href=index.php?page=create>Create new article</a><br>
               <a href=index.php?page=logout>Logout</a><br>
            </div>
         </div><?php
		}
		else
		{?>
         <div class="ex">
            <a href="index.php"><img src="img/images.jpeg" width="115" height="115"/></a>				
            <div style="text-align:right;position:relative;float:right;top:25px;margin-right:30px"><?php
            	if(isset($_GET['ID'])){echo '<form action="index.php" method="get">';
               echo '<input type="hidden" value="' . $_GET['ID'] . '" name="ID">';
               echo '<input type="hidden" value="view" name="page">';}		
		         else { echo '<form action="index.php" method="get">';}?>
               Username: <input type="text" name="usr"><br>
               Password: <input type="password" name="passwd"><br>
		         <span style="color:red;font-size:12px">Incorrect username or password!</span><br>
		         <input type="submit" value="Sign In">
		         </form>
		      </div>
		   </div><?php
		}
	}
	else
	{?>
      <div class="ex">
         <a href="index.php"><img src="img/images.jpeg" width="115" height="115"/></a>		
		   <div style="text-align:right;position:relative;float:right;top:25px;margin-right:30px"><?php
            if(isset($_GET['ID'])){echo '<form action="index.php" method="get">';
            echo '<input type="hidden" value="' . $_GET['ID'] . '" name="ID">';
            echo '<input type="hidden" value="view" name="page">';}		
		      else { echo '<form action="index.php" method="get">';}?>
		      Username: <input type="text" name="usr"><br>
		      Password: <input type="password" name="passwd"><br><br>
		      <input type="submit" value="Sign In">
		      </form>
		   </div>
	   </div><?php
	}
	if(isset($_GET['page'])){$page=$_GET['page'];}else{$page="";}
	switch ($page)
	{
	case "view":?>
	  <div class="ey"><?php
	     $con=mysqli_connect("localhost","admin","qazwsx","my_db");
	     if (mysqli_connect_errno())
	     {
	        echo "Failed to connect to MySQL: " . mysqli_connect_error();
	     }
	     $x = intval($_GET["PID"]);
	     $result = mysqli_query($con,"SELECT * FROM persons WHERE PID='$x'");
	     $row = mysqli_fetch_array($result);
	     echo "<img src=\"" . $row["Image"] . "\"><br>";
         echo "<h2>" . $row["FirstName"] . "&nbsp" . $row["LastName"] ."</h2><br>";
	     echo "<p> Registred:" . "&nbsp" . $row["REG_DATE"] . "</p><br>";
	     
	     mysqli_close($con);
	break;
	case "edit":?>
	   <div class="ey"><?php
         $con=mysqli_connect("localhost","admin","qazwsx","my_db");
         if (mysqli_connect_errno())
         {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
         }
         $x = intval($_GET["PID"]);
         $result = mysqli_query($con,"SELECT * FROM persons WHERE PID='$x'");
         $row = mysqli_fetch_array($result);
         mysqli_close($con);
         echo '<h1>Please Edit Your Info</h1>
            <img src="' . $row["Image"] . '" alt="Photo Not Added"><br>
            <a href=test_index.php?page=deletepic&PID=' . $row["PID"] . '>Delete</a><br><br>
            <form name="form_cr" action="test_index.php?page=edit-db" method="POST">
            <div align="left">
            <input type="hidden" size="30" name="PID" value="' . $row["PID"] . '">
            <label for="firstname">First Name:</label><br>
            <input type="text" size="30" name="firstname" value="' . $row["FirstName"] . '"><br><br>
            <label for="lastname">Last Name:</label><br>
            <input type="text" size="30" name="lastname" value="' . $row["LastName"] . '"><br><br>
            <label for="email">Email:</label><br>
            <input type="text" size="30" name="email" value="' . $row["Email"] . '"><br><br>
            <label for="photo">Add/Change Photo:</label><br>
            <input type="file" name="photo" id="photo"><br><br>
            <input type="submit" value="Susmit"><br>
      </div>';
	break;
	case "delete":?>
	  <div class="ey"><?php
	     $con=mysqli_connect("localhost","admin","qazwsx","my_db");
        if (mysqli_connect_errno())
         {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
         }
         $x = intval($_GET['PID']);
         mysqli_query($con,"DELETE FROM articles WHERE ID='$x'");
         mysqli_close($con);
         echo "Article #" . $x . " has been deleted<br><a href=index.php>Home Page</a>";
	break;
	case "deletepic":?>
     <div class="ey"><?php
        $con=mysqli_connect("localhost","admin","qazwsx","my_db");
        if (mysqli_connect_errno())
         {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
         }
         $x = intval($_GET["PID"]);
         mysqli_query($con,"UPDATE persons SET Image='' WHERE PID='$x'");
         mysqli_close($con);
         echo "Your photo has been deleted<br><a href=index.php>Home Page</a>";
   break;
   case "logout":?>
	   <div class="ey"><?php
	     session_destroy();
	     echo "Loged out<br><br><a href=index.php>Home Page<a>";
      ?></div><?php
	break;
	case "edit-db":?>
	   <div class="ey"><?php
      if(isset($_FILES["photo"])){
         $allowedExts = array("gif", "jpeg", "jpg", "png");
         $file = explode(".", $_FILES["photo"]["name"]);
         $extension = end($file);
         if ((($_FILES["photo"]["type"] == "image/gif")
         || ($_FILES["photo"]["type"] == "image/jpeg")
         || ($_FILES["photo"]["type"] == "image/jpg")
         || ($_FILES["photo"]["type"] == "image/pjpeg")
         || ($_FILES["photo"]["type"] == "image/x-png")
         || ($_FILES["photo"]["type"] == "image/png"))
         && ($_FILES["photo"]["size"] < 20000)
         && in_array($extension, $allowedExts))
         {
            if ($_FILES["photo"]["error"] > 0)
            {
               echo "Return Code: " . $_FILES["photo"]["error"] . "<br>";
            }
            else
            {
               echo "Upload: " . $_FILES["photo"]["name"] . "<br>";
               echo "Type: " . $_FILES["photo"]["type"] . "<br>";
               echo "Size: " . ($_FILES["photo"]["size"] / 1024) . " kB<br>";
               echo "Temp file: " . $_FILES["photo"]["tmp_name"] . "<br>";

            if (file_exists("img/" . $_POST["login"] . "." . $extension))
            {
               echo $_POST["login"] . "." . $extension . " already exists. ";
            }
            else
            {
               move_uploaded_file($_FILES["photo"]["tmp_name"],
               "img/" . $_POST["login"] . "." . $extension);
               $original_image = imagecreatefromjpeg("img/" . $_POST["login"] . "." . $extension);
         $cropped_image = imagecreatetruecolor(150, 150);
         imagecopy($cropped_image, $original_image, 0, 0, 50, 50, 150, 150);
         imagejpeg($cropped_image, "img/" . $_POST["login"] . "." . $extension, 100);
         imagedestroy($cropped_image);
         imagedestroy($original_image);
               $filepath = "img/" . $_POST["login"] . "." . $extension;
               echo "Stored in: " . $filepath . "<br>";
            }
         }
      }
      else
      {
         echo "Invalid file";
      }
     }    // $fp = fopen($tmpName, 'r');
         // $content = $fp;
         // $content = fread($fp, filesize($tmpName));
         // $content = addslashes($content);
         // fclose($fp);
         $con=mysqli_connect("localhost","admin","qazwsx","my_db");
	     if (mysqli_connect_errno())
	     {
	        echo "Failed to connect to MySQL: " . mysqli_connect_error();
	     }
	     $x = intval($_POST["PID"]);
	     //$FirstName = $_POST["firstname"];
	     //$LastName = $_POST["lastname"];
	     //$Email = $_POST["email"];
        if (isset($filepath)) {
           mysqli_query($con,"UPDATE persons SET FirstName='$_POST[firstname]', LastName='$_POST[lastname]', Email='$_POST[email]', Image='$filepath' WHERE PID='$x'");
        } else {
           mysqli_query($con,"UPDATE persons SET FirstName='$_POST[firstname]', LastName='$_POST[lastname]', Email='$_POST[email]' WHERE PID='$x'");
        }
        
        
	     
        echo "1 record updated<br><br><a href=index.php>Home Page</a>";
	     mysqli_close($con);
      ?></div><?php
	break;
	case "create-db":?>
	   <div class="ey"><?php
         
         $con=mysqli_connect("localhost","admin","qazwsx","my_db");
         if (mysqli_connect_errno())
         {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
         }
         
         $sql="INSERT INTO persons (Login, Password, Email, FirstName, LastName, Active, Role) VALUES (
            '$_POST[login]','$_POST[passwd]','$_POST[email]',
            '$_POST[firstname]','$_POST[lastname]','1','usr')";
        if (!mysqli_query($con,$sql))
         {
            die('Error: ' . mysqli_error());
         }
         echo "1 record added<br><br><a href=index.php>Home Page<a>";
         mysqli_close($con);
               ?></div><?php
	break;
	case "create":?>
      <div class="ey">
         <h1>Please Fill Out Your Info</h1><br><br>
         <form name="form_cr" action="test_index.php?page=create-db" method="POST" enctype="multipart/form-data">
         <div align="left">
            <label for="firstname">First Name:</label><br>
            <input type="text" size="30" name="firstname"><br><br>
            <label for="lastname">Last Name:</label><br>
            <input type="text" size="30" name="lastname"><br><br>
            <label for="email">Email:</label><br>
            <input type="text" size="30" name="email"><br><br>
            <label for="passwd">Password:</label><br>
            <input type="password" size="30" name="passwd"><br><br>
            <label for="passwdcnf">Repeat password:</label><br>
            <input type="password" size="30" name="passwdcnf"><br><br>
            <label for="login">Login:</label><br>
            <input type="text" name="login" size="30"><br><br>
            <input type="submit" value="Sign Up"><br>
         </div>
         </form>
      </div><?php
   break;
	case "adminpg":?>
      <div class="ey"><?php
         $con=mysqli_connect("localhost","admin","qazwsx","my_db");
        if (mysqli_connect_errno())
        {
           echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        //$x = intval($_GET["PID"]);
        $result = mysqli_query($con,"SELECT * FROM persons");
        ?><table border="1">
         <tr>
         <th>Person ID</th>
         <th>Login</th>
         <th>Role</th>
         <th>Status</th>
         <th>Set</th>
         <th>Set</th>
         <th>Set</th>
         <th>Set</th>
         <th>Set</th>
         <th>Del</th>
         </tr>
         <tr>
<?php 
        while($row = mysqli_fetch_array($result))
        echo "<td>" . $row["PID"] . "</td>
            <td>" . $row["Login"] . "</td>
            <td>"  . $row["Role"] . "</td>
            <td>"  . $row["Active"] . "</td>
            <td><a href=test_index.php?page=updstat&role=usr&PID="  . $row["PID"] . ">USR</a></td>
            <td><a href=test_index.php?page=updstat&role=mod&PID="  . $row["PID"] . ">MOD</a></td>
            <td><a href=test_index.php?page=updstat&role=adm&PID="  . $row["PID"] . ">ADM</a></td>
            <td><a href=test_index.php?page=updstat&active=1&PID="  . $row["PID"] . ">ACTV</a></td>
            <td><a href=test_index.php?page=updstat&active=0&PID="  . $row["PID"] . ">INAC</a></td>
            <td><a href=test_index.php?page=updstat&active=2&PID="  . $row["PID"] . ">x</a></td></tr>";
              
        mysqli_close($con);
         ?>
         
         </table>
         </div>
         </form>
      </div><?php
   break;
   case "updstat":?>
     <div class="ey"><?php
        $con=mysqli_connect("localhost","admin","qazwsx","my_db");
        if (mysqli_connect_errno())
         {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
         }
         $x = intval($_GET["PID"]);
         if (isset($_GET["role"])) {
            mysqli_query($con,"UPDATE persons SET Role='$_GET[role]' WHERE PID='$x'");
         } else {
            if($_GET["active"]=='2')
            {
               mysqli_query($con,"DELETE FROM persons WHERE PID='$x'");
            }
            else
            {
               mysqli_query($con,"UPDATE persons SET Active='$_GET[active]' WHERE PID='$x'");
            }
         }
         mysqli_close($con);
         echo "Role has been updated<br><a href=index.php>Home Page</a>";
   break;
   default: ?>
	   <div class="ey"><?php
         $con=mysqli_connect("localhost","admin","qazwsx","my_db");
    	   if (mysqli_connect_errno())
    	   {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
    	   }
	      $result = mysqli_query($con,"SELECT * FROM articles");
	      while($row = mysqli_fetch_array($result))
	      {
	        echo "<h3>" . $row['ArtTitle'] . "</h3>";
	        $rest = substr($row['ArtCont'], 0, 150);
	        echo "<p> $rest...</p>";
	        echo "<a href=index.php?page=view&ID=" . $row['ID'] . ">Read more</a><br><br>";
	      }
      ?></div><?php
	}?>
</body>
</html>
