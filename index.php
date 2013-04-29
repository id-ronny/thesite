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
	     $x = intval($_GET['ID']);
	     $result = mysqli_query($con,"SELECT * FROM articles WHERE ID='$x'");
	     $row = mysqli_fetch_array($result);
	     echo "<h2>" . $row['ArtTitle'] . "</h2>";
	     echo "<p>" . $row['ArtCont'] . "</p><br>";
	     if(isset($_SESSION['admin'])) {echo "<a href=index.php?page=delete&ID=" . $row['ID'] . ">Delete</a>&nbsp;&nbsp;&nbsp;";
	     echo "<a href=index.php?page=edit&ID=" . $row['ID'] . ">Edit</a>";}
	     mysqli_close($con);
	break;
	case "edit":?>
	   <div class="ey"><?php
         $con=mysqli_connect("localhost","admin","qazwsx","my_db");
         if (mysqli_connect_errno())
         {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
         }
         $x = intval($_GET['ID']);
         $result = mysqli_query($con,"SELECT * FROM articles WHERE ID='$x'");
         $row = mysqli_fetch_array($result);
         mysqli_close($con);
         echo '<h1>Please Edit Article</h1><br><br>
            <form name="form_cr" action="index.php?page=edit-db" method="POST">
            <div align="left">
            <strong>Title:</strong><br><br>
            <input type="hidden" value="' . $row['ID'] . '" name="ID">
            <input type="text" size="35" value="' . $row['ArtTitle'] . '" name="ArtTitle">
            <br><br><strong>
            Body:</strong><br><br>
            <textarea cols="50" rows="6" name="ArtCont">' . $row['ArtCont'] . '
            </textarea>
            <br><br>
            <input type="submit" value="Apply">
            <br><br>
      </div>';
	break;
	case "delete":?>
	  <div class="ey"><?php
	     $con=mysqli_connect("localhost","admin","qazwsx","my_db");
        if (mysqli_connect_errno())
         {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
         }
         $x = intval($_GET['ID']);
         mysqli_query($con,"DELETE FROM articles WHERE ID='$x'");
         mysqli_close($con);
         echo "Article #" . $x . " has been deleted<br><a href=index.php>Home Page</a>";
	break;
	case "logout":?>
	   <div class="ey"><?php
	     session_destroy();
	     echo "Loged out<br><br><a href=index.php>Home Page<a>";
      ?></div><?php
	break;
	case "edit-db":?>
	   <div class="ey"><?php
	     $con=mysqli_connect("localhost","admin","qazwsx","my_db");
	     if (mysqli_connect_errno())
	     {
	        echo "Failed to connect to MySQL: " . mysqli_connect_error();
	     }
	     $x = intval($_POST['ID']);
	     $ArtTitle = $_POST['ArtTitle'];
	     $ArtCont = $_POST['ArtCont'];
	     mysqli_query($con,"UPDATE articles SET ArtTitle='$ArtTitle', ArtCont='$ArtCont' WHERE ID='$x'");
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
         $sql="INSERT INTO articles (ArtTitle, ArtCont) VALUES ('$_POST[ArtTitle]','$_POST[ArtCont]')";
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
         <h1>Please Add Article</h1><br><br>
         <form name="form_cr" action="index.php?page=create-db" method="POST">
         <div align="left">
            <strong>Title:</strong><br><br>
            <input type="text" size="35" name="ArtTitle">
            <br><br><strong>
            Body:</strong><br><br>
            <textarea cols="50" rows="6" name="ArtCont"></textarea><br><br>
            <input type="submit" value="Add"><br><br>
         </div>
         </form>
      ?></div><?php
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
