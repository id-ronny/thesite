<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php session_start(); if(!isset($_SESSION['lang'])){$_SESSION['lang']='eng';}?>
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

<body><?php	
    try {
    $dbh = new PDO("mysql:host=localhost;dbname=my_db", 'admin', 'qazwsx');
    $sql = "SELECT * FROM std_texts";
    $dbh->query($sql);        
    $stmt = $dbh->query($sql);
    //$row = $stmt->fetch(PDO::FETCH_ASSOC);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
    $array[]=$row;
    
    }
    //print_r($array);
    $dbh = null;
    }
        catch(PDOException $e)
    {
    echo $e->getMessage();
    }

    if(isset($_GET["usr"]) || isset($_GET["passwd"])){
        $con=mysqli_connect("localhost","admin","qazwsx","my_db");
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        $result = mysqli_query($con,"SELECT * FROM persons
        WHERE login='$_GET[usr]' AND password='$_GET[passwd]'");
        $row = mysqli_fetch_array($result);
        if ($row["Active"]=='0') {
            header( 'Location: index.php?falsepass=2' ) ;
        }
        else if(isset($row["Role"])){
            $_SESSION['admin']=$row["Role"];
            $_SESSION['PID']=$row["PID"];
            $_SESSION['login']=$row["Login"];
            mysqli_query($con,"UPDATE persons SET LVIS_DATE=NOW() WHERE PID='$row[PID]'");
            mysqli_close($con);   
        }
        else{
            header( 'Location: index.php?falsepass=1' ) ;
        }
    }
    if (isset($_SESSION["admin"])) {
        switch ($_SESSION["admin"]) {
            case 'adm':?>
                <div class="ex">
                    <a href="index.php"><img src="img/images.jpeg" width="115" height="115"/></a>      
                    <div style="text-align:right;position:relative;float:right;top:25px;margin-right:30px">
                        <strong><?echo $array['18'][$_SESSION['lang']];?></strong><br>
                        <a href=index.php?page=viewprfl&PID=<?php echo $_SESSION["PID"];?>><?echo $array['19'][$_SESSION['lang']];?></a>
                        <a href=index.php?page=editprfl&PID=<?php echo $_SESSION["PID"];?>><?echo $array['20'][$_SESSION['lang']];?></a><br>
                        <a href=index.php?page=create><?echo $array['17'][$_SESSION['lang']];?></a>
                        <a href=index.php?page=adminlang>Ukr/Eng</a><br>
                        <a href=index.php?page=adminpg><?echo $array['10'][$_SESSION['lang']];?></a>
                        <a href=index.php?page=logout><?echo $array['16'][$_SESSION['lang']];?></a><br>
                    </div>
                    <div style="position:relative;top:-20px;margin-left:115px">
                        <a href="index.php?page=langselect"><img src="img/ukraine-flag.png" width="20" height="15"/></a>
                        <a href="index.php?page=langselect"><img src="img/english-flag.png" width="20" height="15"/></a>
                    </div>
                </div><?php
                break;
            case 'mod':?>
                <div class="ex">
                    <a href="index.php"><img src="img/images.jpeg" width="115" height="115"/></a>      
                    <div style="text-align:right;position:relative;float:right;top:25px;margin-right:30px">
                        <strong><?echo $array['15'][$_SESSION['lang']];?></strong><br>
                        <a href=index.php?page=viewprfl&PID=<?php echo $_SESSION["PID"];?>><?echo $array['19'][$_SESSION['lang']];?></a>
                        <a href=index.php?page=editprfl&PID=<?php echo $_SESSION["PID"];?>><?echo $array['20'][$_SESSION['lang']];?></a><br>
                        <a href=index.php?page=create><?echo $array['17'][$_SESSION['lang']];?></a><br>
                        <a href=index.php?page=logout><?echo $array['16'][$_SESSION['lang']];?></a><br>
                    </div>
                    <div style="position:relative;top:-20px;margin-left:115px">
                        <a href="index.php?page=langselect"><img src="img/ukraine-flag.png" width="20" height="15"/></a>
                        <a href="index.php?page=langselect"><img src="img/english-flag.png" width="20" height="15"/></a>
                    </div>
                </div><?php
                break;
            default:?>
                <div class="ex">
                    <a href="index.php"><img src="img/images.jpeg" width="115" height="115"/></a>      
                    <div style="text-align:right;position:relative;float:right;top:25px;margin-right:30px">
                        <strong>Welcome User!</strong><br>
                        <a href=index.php?page=viewprfl&PID=<?php echo $_SESSION["PID"];?>><?echo $array['20'][$_SESSION['lang']];?></a>
                        <a href=index.php?page=editprfl&PID=<?php echo $_SESSION["PID"];?>><?echo $array['20'][$_SESSION['lang']];?></a><br>
                        <a href=index.php?page=logout>Logout</a><br>
                    </div>
                    <div style="position:relative;top:-20px;margin-left:115px">
                        <a href="index.php?page=langselect"><img src="img/ukraine-flag.png" width="20" height="15"/></a>
                        <a href="index.php?page=langselect"><img src="img/english-flag.png" width="20" height="15"/></a>
                    </div>
                </div><?php
                break;
        }
    } else if (isset($_GET["falsepass"])){?>
        <div class="ex">
            <a href="index.php"><img src="img/images.jpeg" width="115" height="115"/></a>               
            <div style="text-align:right;position:relative;float:right;top:15px;margin-right:30px"><?php
                if(isset($_GET['ID'])){echo '<form action="index.php" method="get">';
                echo '<input type="hidden" value="' . $_GET['ID'] . '" name="ID">';
                echo '<input type="hidden" value="view" name="page">';}      
                else { echo '<form action="index.php" method="get">';}?>
                <?echo $array['13'][$_SESSION['lang']];?>:<input type="text" name="usr"><br>
                <?echo $array['12'][$_SESSION['lang']];?>:<input type="password" name="passwd"><br><?php
                if ($_GET["falsepass"]=='1') {
                    echo '<span style="color:red;font-size:12px">Incorrect username or password!</span><br>';
                } else {
                    echo '<span style="color:red;font-size:12px">Your account is inactive! Pealse contact admin</span><br>';
                }?>
                <div style="position:relative;float:right;top:-1px;right:0px;">    
                    <input type="submit" value="<?echo $array['8'][$_SESSION['lang']];?>">
                </div>    
                </form>            
                <div style="position:relative;float:right;top:-1px;right:15px;">    
                    <form action="index.php" method="get">
                    <input type="hidden" size="30" name="page" value="createprfl">
                    <input type="submit" value="<?echo $array['11'][$_SESSION['lang']];?>">
                </form>
                </div>
                </div>
                <div style="position:relative;top:-20px;margin-left:115px">
                    <a href="index.php?page=langselect"><img src="img/ukraine-flag.png" width="20" height="15"/></a>
                    <a href="index.php?page=langselect"><img src="img/english-flag.png" width="20" height="15"/></a>
                </div>
        </div><?php
    } else {?>
        <div class="ex">
            <a href="index.php"><img src="img/images.jpeg" width="115" height="115"/></a>      
            <div style="text-align:right;position:relative;float:right;top:15px;margin-right:30px"><?php
                if(isset($_GET['ID'])){echo '<form action="index.php" method="get">';
                echo '<input type="hidden" value="' . $_GET['ID'] . '" name="ID">';
                echo '<input type="hidden" value="view" name="page">';}     
                else { echo '<form action="index.php" method="get">';}?>
                <?echo $array['13'][$_SESSION['lang']];?>: <input type="text" name="usr"><br>
                <?echo $array['12'][$_SESSION['lang']];?>: <input type="password" name="passwd"><br><br>
                <div style="position:relative;float:right;top:-1px;right:0px;">    
                    <input type="submit" value="<?echo $array['8'][$_SESSION['lang']];?>">
                </div>    
                </form>            
                <div style="position:relative;float:right;top:-1px;right:15px;">    
                    <form action="index.php" method="get">
                    <input type="hidden" size="30" name="page" value="createprfl">
                    <input type="submit" value="<?echo $array['11'][$_SESSION['lang']];?>">
                </form>
                </div>
                </div>
            <div style="position:relative;top:-20px;margin-left:115px">
                        <a href="index.php?page=langselect"><img src="img/ukraine-flag.png" width="20" height="15"/></a>
                        <a href="index.php?page=langselect"><img src="img/english-flag.png" width="20" height="15"/></a>
                </div>
        </div><?php
    }
    if(isset($_GET['page'])){$page=$_GET['page'];}else{$page="";}
	switch ($page)
	{
	case "viewprfl":?>
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
         echo "<h3>" . $row["FirstName"] . "&nbsp" . $row["LastName"] ."</h3>";
	     echo "<p> e-mail:" . "&nbsp" . $row["Email"] . "</p>";
         echo "<p>" . $array['7'][$_SESSION['lang']] . ":&nbsp" . $row["REG_DATE"] . "</p>";
	     echo "<p>" . $array['6'][$_SESSION['lang']] . ":&nbsp" . $row["LVIS_DATE"] . "</p>";
	     echo "<a href=index.php?page=deleteprfl&PID=" . $x . ">" . $array['5'][$_SESSION['lang']] . "</a>";
         mysqli_close($con);
	break;
	case "editprfl":?>
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
            echo '<h1>' . $array['4'][$_SESSION['lang']] . '</h1>
            <span style="color:red;font-size:12px"><img src="' . $row["Image"] . '" alt="Photo Not Added! Reqirements: JPEG 200x200 to 300x300"></span><br><br>';
            if($row["Image"]>'0'){
                echo '<a href=index.php?page=deletepic&PID=' . $row["PID"] . '>' . $array['3'][$_SESSION['lang']] . '</a><br><br>';
            }
            echo   '<form name="form_cr" action="index.php?page=edit-dbprfl" method="POST" enctype="multipart/form-data">
            <div align="left">
            <input type="hidden" size="30" name="Image" value="' . $row["Image"] . '">
            <input type="hidden" size="30" name="PID" value="' . $row["PID"] . '">
            <input type="hidden" size="30" name="login" value="' . $row["Login"] . '">
            <label for="firstname">' . $array['1'][$_SESSION['lang']] . ':</label><br>
            <input type="text" size="30" name="firstname" value="' . $row["FirstName"] . '"><br><br>
            <label for="lastname">' . $array['2'][$_SESSION['lang']] . ':</label><br>
            <input type="text" size="30" name="lastname" value="' . $row["LastName"] . '"><br><br>
            <label for="email">Email:</label><br>
            <input type="text" size="30" name="email" value="' . $row["Email"] . '"><br><br>
            <label for="photo">' . $array['0'][$_SESSION['lang']] . ':</label><br>
            <input type="file" name="photo" id="photo"><br><br>
            <input type="submit" value="' . $array['21'][$_SESSION['lang']] . '"><br>
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
        header( 'Location: index.php' ) ;
        //echo "Article #" . $x . " has been deleted<br><a href=index.php>Home Page</a>";
	break;
	case "deleteprfl":?>
      <div class="ey"><?php
         $con=mysqli_connect("localhost","admin","qazwsx","my_db");
        if (mysqli_connect_errno())
         {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
         }
         $x = intval($_GET['PID']);
         mysqli_query($con,"DELETE FROM persons WHERE PID='$x'");
         mysqli_close($con);
         //echo "Personal record #" . $x . " has been deleted<br><a href=index.php>Home Page</a>";
         session_destroy();
         header( 'Location: index.php' ) ;
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
        header( 'Location: index.php' ) ;
        //echo "Your photo has been deleted<br><a href=index.php>Home Page</a>";
   break;
   case "logout":?>
        <div class="ey"><?php
	       session_destroy();
	       header( 'Location: index.php' ) ;
      ?></div><?php
	break;
	case "edit-dbprfl":?>
	   <div class="ey"><?php
            if(isset($_FILES["photo"]["name"])){
                $allowedExts = array("gif", "jpeg", "jpg", "png");
                $file = explode(".", $_FILES["photo"]["name"]);
                $extension = end($file);
                if ((($_FILES["photo"]["type"] == "image/gif")
                || ($_FILES["photo"]["type"] == "image/jpeg")
                || ($_FILES["photo"]["type"] == "image/jpg")
                || ($_FILES["photo"]["type"] == "image/pjpeg")
                || ($_FILES["photo"]["type"] == "image/x-png")
                | ($_FILES["photo"]["type"] == "image/png"))
                && ($_FILES["photo"]["size"] < 30000)
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
                else
                {
                    echo "Invalid Image<br>";

                }
            }    
            $con=mysqli_connect("localhost","admin","qazwsx","my_db");
	        if (mysqli_connect_errno())
            {
	           echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
            $x = intval($_POST["PID"]);
            if (isset($filepath)) {
            mysqli_query($con,"UPDATE persons SET FirstName='$_POST[firstname]', LastName='$_POST[lastname]', Email='$_POST[email]', Image='$filepath' WHERE PID='$x'");
            } else {
                mysqli_query($con,"UPDATE persons SET FirstName='$_POST[firstname]', LastName='$_POST[lastname]', Email='$_POST[email]' WHERE PID='$x'");
            }
            header( 'Location: index.php' ) ;
            //echo "Info updated<br><br><a href=index.php>Home Page</a>";
            mysqli_close($con);
        ?></div><?php
	break;
	case "create-dbprfl":?>
        <div class="ey"><?php
            if($_POST["passwd"] == $_POST["passwdcnf"]){
                $con=mysqli_connect("localhost","admin","qazwsx","my_db");
                if (mysqli_connect_errno())
                {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }
                $result = mysqli_query($con,"SELECT * FROM persons
                WHERE login='$_POST[login]' AND password='$_POST[email]'");
                $row = mysqli_fetch_array($result);
                if ($row["PID"]>'0') {
                    echo "User with such email OR password exists<br><br><a href=index.php?page=createprfl>Try Again<a>";
                }
                else{
                    $sql="INSERT INTO persons (Login, Password, Email, FirstName, LastName, Active, Role) VALUES (
                    '$_POST[login]','$_POST[passwd]','$_POST[email]',
                    '$_POST[firstname]','$_POST[lastname]','1','usr')";
                    if (!mysqli_query($con,$sql)){
                        die('Error: ' . mysqli_error());
                    }
                    mysqli_close($con);
                    $con=mysqli_connect("localhost","admin","qazwsx","my_db");
                    if (mysqli_connect_errno()){
                        echo "Failed to connect to MySQL: " . mysqli_connect_error();
                    }
                    $result = mysqli_query($con,"SELECT * FROM persons
                    WHERE login='$_POST[login]'");
                    $row = mysqli_fetch_array($result);
                    $_SESSION['admin']=$row["Role"];
                    $_SESSION['PID']=$row["PID"];
                    mysqli_query($con,"UPDATE persons SET LVIS_DATE=NOW() WHERE PID='$row[PID]'");
                    mysqli_close($con);
                    header( 'Location: index.php?falsepass=2' ) ;                
                }
            }
            else{
                echo "Password confirmation doesn't match!<br><br><a href=index.php?page=createprfl>Try Again<a>";
            }
            
               ?></div><?php
	break;
	case "createprfl":?>
        <div class="ey">
            <h1><?echo $array['4'][$_SESSION['lang']];?></h1><br><br>
            <form name="form_cr" action="index.php?page=create-dbprfl" method="POST">
            <div align="left">
                <label for="firstname"><?echo $array['1'][$_SESSION['lang']];?>:</label><br>
                <input type="text" size="30" name="firstname"><br><br>
                <label for="lastname"><?echo $array['2'][$_SESSION['lang']];?>:</label><br>
                <input type="text" size="30" name="lastname"><br><br>
                <label for="email">Email:</label><br>
                <input type="text" size="30" name="email"><br><br>
                <label for="passwd"><?echo $array['12'][$_SESSION['lang']];?>:</label><br>
                <input type="password" size="30" name="passwd"><br><br>
                <label for="passwdcnf"><?echo $array['12'][$_SESSION['lang']];?>-2:</label><br>
                <input type="password" size="30" name="passwdcnf"><br><br>
                <label for="login"><?echo $array['13'][$_SESSION['lang']];?>:</label><br>
                <input type="text" name="login" size="30"><br><br>
                <input type="submit" value="<?echo $array['11'][$_SESSION['lang']];?>"><br>
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
            <tr><?php 
            while($row = mysqli_fetch_array($result))
            echo "<td>" . $row["PID"] . "</td>
            <td>" . $row["Login"] . "</td>
            <td>"  . $row["Role"] . "</td>
            <td>"  . $row["Active"] . "</td>
            <td><a href=index.php?page=updstat&role=usr&PID="  . $row["PID"] . ">USR</a></td>
            <td><a href=index.php?page=updstat&role=mod&PID="  . $row["PID"] . ">MOD</a></td>
            <td><a href=index.php?page=updstat&role=adm&PID="  . $row["PID"] . ">ADM</a></td>
            <td><a href=index.php?page=updstat&active=1&PID="  . $row["PID"] . ">ACTV</a></td>
            <td><a href=index.php?page=updstat&active=0&PID="  . $row["PID"] . ">INAC</a></td>
            <td><a href=index.php?page=updstat&active=2&PID="  . $row["PID"] . ">x</a></td></tr>";
            mysqli_close($con);?>
            </table>
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
            header( 'Location: index.php?page=adminpg' ) ;
        ?></div><?php
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
            if(isset($_SESSION['admin'])){
                if($_SESSION['admin']=='adm') {
                    echo "<a href=index.php?page=delallcom&ID=" . $_GET['ID'] . ">"; 
                    if ($_SESSION['lang']=='eng') {print("Reset voting");} else {print("Обнулити голосування");}
                    echo "</a><br><br>";
                }
                }
            echo '<h1>' . $array['4'][$_SESSION['lang']] . '</h1><br><br>
            <form name="form_cr" action="index.php?page=edit-db" method="POST">
            <div align="left">
                <input type="hidden" value="' . $row['ID'] . '" name="ID">
                <strong>' . $array['23'][$_SESSION['lang']] . ':</strong><br>
                <input type="text" size="35" value="' . $row['ArtTitle'] . '"name="ArtTitle">
                <br><br><strong>
                ' . $array['24'][$_SESSION['lang']] . ':</strong><br>
                <textarea cols="50" rows="6" name="ArtCont">' . $row['ArtCont'] . '</textarea><br><br><br>
                <strong>' . $array['25'][$_SESSION['lang']] . ':</strong><br>
                <input type="text" size="35" value="' . $row['ArtTitleUA'] . '"name="ArtTitleUA">
                <br><br><strong>
                ' . $array['26'][$_SESSION['lang']] . ':</strong><br>
                <textarea cols="50" rows="6" name="ArtContUA">' . $row['ArtContUA'] . '</textarea><br><br>
                <input type="submit" value="' . $array['21'][$_SESSION['lang']] . '"><br><br>
            </div>';
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
            mysqli_query($con,"UPDATE articles SET ArtTitle='$_POST[ArtTitle]', ArtCont='$_POST[ArtCont]', ArtTitleUA='$_POST[ArtTitleUA]', ArtContUA='$_POST[ArtContUA]' WHERE ID='$x'");
            
            header('Location: index.php');
            //echo "1 record updated<br><br><a href=index.php>Home Page</a>";
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
            $sql="INSERT INTO articles (ArtTitle, ArtCont, ArtTitleUA, ArtContUA) VALUES ('$_POST[ArtTitle]','$_POST[ArtCont]','$_POST[ArtTitleUA]','$_POST[ArtContUA]')";
            if (!mysqli_query($con,$sql))
            {
                die('Error: ' . mysqli_error());
            }
            header('Location: index.php');
            //echo "1 record added<br><br><a href=index.php>Home Page<a>";
            mysqli_close($con);
      ?></div><?php
    break;
    case "create":?>
        <div class="ey">
            <h1><?echo $array['17'][$_SESSION['lang']];?></h1><br><br>
            <form name="form_cr" action="index.php?page=create-db" method="POST">
            <div align="left">
                <strong><?echo $array['23'][$_SESSION['lang']];?>:</strong><br>
                <input type="text" size="35" name="ArtTitle">
                <br><br><strong>
                <?echo $array['24'][$_SESSION['lang']];?>:</strong><br>
                <textarea cols="50" rows="6" name="ArtCont"></textarea><br><br><br>
                <strong><?echo $array['25'][$_SESSION['lang']];?>:</strong><br>
                <input type="text" size="35" name="ArtTitleUA">
                <br><br><strong>
                <?echo $array['26'][$_SESSION['lang']];?>:</strong><br>
                <textarea cols="50" rows="6" name="ArtContUA"></textarea><br><br>
                <input type="submit" value="<?echo $array['21'][$_SESSION['lang']];?>"><br><br>
            </div>
                </form>
        </div><?php
    break;
    case "view":?>
        <div class="ey"><?php
             $con=mysqli_connect("localhost","admin","qazwsx","my_db");
            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
            $result = mysqli_query($con,"SELECT * FROM votes WHERE ID='$_GET[ID]' AND login='$_SESSION[login]'");
            $row = mysqli_fetch_array($result);
            if ($row['score']>'0') {
                if ($_SESSION['lang']=='eng') {print("Your mark:");} else {print("Ваша оцінка:");}echo "&nbsp;&nbsp;-&nbsp;&nbsp;" . $row['score'];?>
                <form name="form_a" action="index.php?page=deletemark" method="POST">
                <input type="hidden" value="<?php echo $row['VID']; ?>" name="VID">
                <input type="submit"  value="<?echo $array['3'][$_SESSION['lang']];?>"></form><?php
            } else {
                if ($_SESSION['lang']=='eng') {print("<SCRIPT>function myFunction(){alert(\"Thanks for voting!\");}</SCRIPT>Vote:");} else {print("<SCRIPT>function myFunction(){alert(\"Дякуємо за вашу оцінку!\");}</SCRIPT>Голосувати:");}
            ?><form name="form_cr" action="index.php?page=vote" method="POST">
            <input type="hidden" value="<?php print($_GET['ID']) ?>" name="ID">
            <input type="hidden" value="<?php print($_SESSION['login']) ?>" name="login">
            <select name="score">
                <option value="5">5</option>
                <option value="4">4</option>
                <option value="3">3</option>
                <option value="2">2</option>
                <option value="1">1</option>
            </select>
            <input type="submit" onclick="myFunction()" value="<?echo $array['21'][$_SESSION['lang']];?>"></form><?php
            }
            $result = mysqli_query($con,"SELECT score FROM votes WHERE ID='$_GET[ID]'");
            $i='0'; $score='0';
            while($row = mysqli_fetch_array($result))
            {
                $score = $score + $row['score'];
                $i++;
            }
            $x = intval($_GET['ID']);
            $result = mysqli_query($con,"SELECT * FROM articles WHERE ID='$x'");
            $row = mysqli_fetch_array($result);
            if ($i>'0') {
                if ($_SESSION['lang']=='eng') {
                    echo "<h2>" . $row['ArtTitle'] . "</h2>";
                    echo "<i>Total votes - ". $i ."<br>Average mark - " . $score/$i . "</i><br>";
                    echo "<p>" . $row['ArtCont'] . "</p><br>";
                } else {
                    echo "<h2>" . $row['ArtTitleUA'] . "</h2>";
                    echo "<i>Всього голосів - ". $i ."<br>Середня оцінка - " . $score/$i . "</i><br>";
                    echo "<p>" . $row['ArtContUA'] . "</p>";
                }
            } else {
                if ($_SESSION['lang']=='eng') {
                    echo "<h2>" . $row['ArtTitle'] . "</h2>";
                    echo "<i>Nobody voted for this yet</i><br>";
                    echo "<p>" . $row['ArtCont'] . "</p><br>";
                } else {
                    echo "<h2>" . $row['ArtTitleUA'] . "</h2>";
                    echo "<i>За цей метріал ще ніхто не голосував</i><br>";
                    echo "<p>" . $row['ArtContUA'] . "</p>";
                }
            }
            

            
            if ($_SESSION['lang']=='eng') {print("<h3>Leave comment:</h3>");} else {print("<h3>Коментувати:</h3>");}?><strong>
                <form name="form_cr" action="index.php?page=comcre" method="POST">
                <input type="hidden" value="<?php print($_GET['ID']) ?>" name="ID">
                <input type="hidden" value="<?php print($_SESSION['login']) ?>" name="login">
                <input type="hidden" value="<?php print($_SESSION['PID']) ?>" name="PID">
                <?echo $array['25'][$_SESSION['lang']];?>:</strong><br>
                <input type="text" size="35" name="ComTitle">
                <br><br><strong>
                <?echo $array['26'][$_SESSION['lang']];?>:</strong><br>
                <textarea cols="50" rows="4" name="ComCont"></textarea><br>
                <input type="submit" value="<?echo $array['21'][$_SESSION['lang']];?>"><br><br>
                </form>
            <?php
            $result = mysqli_query($con,"SELECT * FROM coments WHERE ID='$_GET[ID]'");
            while($row = mysqli_fetch_array($result)){
                echo "<b><a href=index.php?page=viewprfl&PID=" . $row['PID'] . ">" . $row['login'] . "</a></b>  " . $row['ComDate'] . "<br>";
                echo "<b>" . $row['ComTitle'] . "</b><br>";
                echo $row['ComCont'] . "<br><br>";
                if(isset($_SESSION['admin'])){
                if($_SESSION['admin']=='adm') {
                    echo "<a href=index.php?page=deletecom&CID=" . $row['CID'] . ">"; 
                    if ($_SESSION['lang']=='eng') {print("Delete comment");} else {print("Видалити коментар");}
                    echo "</a><br><br>";
                }
                }
            }    

            if(isset($_SESSION['admin'])){
            if($_SESSION['admin']=='mod'
            || $_SESSION['admin']=='adm') {echo "<a href=index.php?page=delete&ID=" . $_GET['ID'] . ">" . $array['3'][$_SESSION['lang']] . "</a>&nbsp;&nbsp;&nbsp;";
            echo "<a href=index.php?page=edit&ID=" . $_GET['ID'] . ">" . $array['22'][$_SESSION['lang']] . "</a>";}}
            if (!mysqli_query($con,$sql))
            {
                die('Error: ' . mysqli_error());
            }
            mysqli_close($con);
    break;
    case "langselect":
        if ($_SESSION['lang']=='ukr') {
            $_SESSION['lang']='eng';
        } else {
            $_SESSION['lang']='ukr';
        }
        $temp = $_SESSION['lang'];
        echo $temp;
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        //header('Location: index.php');
    break;
    case "comcre":
        $con=mysqli_connect("localhost","admin","qazwsx","my_db");
                if (mysqli_connect_errno())
                {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }
                if (array_key_exists('ComTitle', $_POST)) {
                    $string = $_POST["ComCont"];
                    $string = substr($string,0,16);
                    $string = substr($string,0,strrpos($string," "));
                }
                else{
                    $string = $_POST["ComTitle"];
                }
                $sql="INSERT INTO coments (ID, ComTitle, ComCont, login, ComDate, PID) VALUES (
                    '$_POST[ID]', '$string', '$_POST[ComCont]', '$_POST[login]', NOW(), '$_POST[PID]')";
                    if (!mysqli_query($con,$sql)){
                        die('Error: ' . mysqli_error());
                    }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    break;
    case "vote":
        $con=mysqli_connect("localhost","admin","qazwsx","my_db");
                if (mysqli_connect_errno())
                {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }
                $sql="INSERT INTO votes (ID, score, login) VALUES (
                    '$_POST[ID]', '$_POST[score]', '$_POST[login]')";
                    if (!mysqli_query($con,$sql)){
                        die('Error: ' . mysqli_error());
                    }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    break;
    case "deletecom":
        $con=mysqli_connect("localhost","admin","qazwsx","my_db");
            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
        mysqli_query($con,"DELETE FROM coments WHERE CID='$_GET[CID]'");
        mysqli_close($con);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        ?><SCRIPT>alert("DONE")</SCRIPT><?php
        //header('Location: index.php');
    break;
    case "deletemark":
        $con=mysqli_connect("localhost","admin","qazwsx","my_db");
            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
        mysqli_query($con,"DELETE FROM votes WHERE VID='$_POST[VID]'");
        mysqli_close($con);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        //header('Location: index.php');
    break;
    case "delallcom":
        $con=mysqli_connect("localhost","admin","qazwsx","my_db");
            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
        mysqli_query($con,"DELETE FROM votes WHERE ID='$_GET[ID]'");
        mysqli_close($con);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        ?><SCRIPT>alert("DONE")</SCRIPT><?php
        //header('Location: index.php');
    break;
    case "adminlang":?>
        <div class="ey"><?php
    try {
        $dbh = new PDO("mysql:host=localhost;dbname=my_db", 'admin', 'qazwsx');
        $sql = "SELECT * FROM std_texts";
        $dbh->query($sql);        
        $stmt = $dbh->query($sql);
        ?><table border="1">
            <tr>
            <th>Text ID</th>
            <th>Text Ukr</th>
            <th>Text Eng</th>
            <th>Text ID</th>
            </tr>
            <?php
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
        echo "<td>" . $row["PID"] . "</td>
            <td>" . $row["ukr"] . "</td>
            <td>"  . $row["eng"] . "</td>
            <td><a href=index.php?page=txtedit&PID="  . $row["PID"] . ">EDIT</a></td></tr>";
        }
        $dbh = null;
        }
        catch(PDOException $e)
        {
        echo $e->getMessage();
        }
    break;
    case "txtedit":?>
        <div class="ey"><?php
            try {
            $dbh = new PDO("mysql:host=localhost;dbname=my_db", 'admin', 'qazwsx');
            $sql = "SELECT * FROM std_texts WHERE PID='$_GET[PID]'";
            $dbh->query($sql);        
            $stmt = $dbh->query($sql);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            echo '<h1>' . $array['4'][$_SESSION['lang']] . '</h1><br><br>
            <form name="form_cr" action="index.php?page=txtedit-db" method="POST">
            <div align="left">
                <input type="hidden" value="' . $row['PID'] . '" name="PID">
                <strong>' . $array['25'][$_SESSION['lang']] . ':</strong><br>
                <input type="text" size="50" value="' . $row['ukr'] . '"name="ukr"><br>
                
                <strong>' . $array['23'][$_SESSION['lang']] . ':</strong><br>
                <input type="text" size="50" value="' . $row['eng'] . '"name="eng"><br>
                <input type="submit" value="' . $array['21'][$_SESSION['lang']] . '"><br><br>
            </div>';
        ?></div><?php
            $dbh = null;
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
    break;
    case "txtedit-db":?>
        <div class="ey"><?php
            try {
                $dbh = new PDO("mysql:host=localhost;dbname=my_db", 'admin', 'qazwsx');
                $count = $dbh->exec("UPDATE std_texts SET ukr='$_POST[ukr]' WHERE PID='$_POST[PID]'");
                header( 'Location: index.php' ) ;
                $dbh = null;
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
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
	           if ($_SESSION['lang']=='eng') {
                    echo "<h3>" . $row['ArtTitle'] . "</h3>";
                    $rest = substr($row['ArtCont'], 0, 150);
                } else {
                    echo "<h3>" . $row['ArtTitleUA'] . "</h3>";
                    $rest = substr($row['ArtContUA'], 0, 150);
                }
               
            echo "<p> $rest...</p>";
	        echo "<a href=index.php?page=view&ID=" . $row['ID'] . ">" . $array['9'][$_SESSION['lang']] . "</a><br><br>";
            }
      ?></div><?php
	}?>
</body>
</html>
