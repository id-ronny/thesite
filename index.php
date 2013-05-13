<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php session_start(); if(!isset($_SESSION['lang'])){$_SESSION['lang']='eng';}?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>The Site | by ronny</title>
<style type="text/css">
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
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $stext = "t" . $row["PID"];
            if ($_SESSION['lang']=='eng') {
                $array[$stext]=$row["eng"];
            } else {
                $array[$stext]=$row["ukr"];
            }
        }
        extract($array);
        // print_r($array);
        $dbh = null;
    }
    catch(PDOException $e){
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
                    <a href="index.php"><img src="img/images.jpeg" width="115" height="115" alt="image"/></a>      
                    <div style="text-align:right;position:relative;float:right;top:25px;margin-right:30px">
                        <strong><?php echo $t1; ?></strong><br />
                        <a href="index.php?page=viewprfl&amp;PID=<?php echo $_SESSION["PID"];?>"><?php echo $t2; ?></a>
                        <a href="index.php?page=editprfl&amp;PID=<?php echo $_SESSION["PID"];?>"><?php echo $t3; ?></a><br />
                        <a href="index.php?page=create"><?php echo $t4; ?></a>
                        <a href="index.php?page=adminlang"><?php echo $t32 ;?></a><br />
                        <a href="index.php?page=adminpg"><?php echo $t13 ;?></a>
                        <a href="index.php?page=logout"><?php echo $t5 ;?></a><br />
                    </div>
                    <div style="position:relative;top:-20px;margin-left:115px">
                        <a href="index.php?page=langselect"><img src="img/ukraine-flag.png" width="20" height="15" alt="image"/></a>
                        <a href="index.php?page=langselect"><img src="img/english-flag.png" width="20" height="15" alt="image"/></a>
                    </div>
                </div><?php
                break;
            case 'mod':?>
                <div class="ex">
                    <a href="index.php"><img src="img/images.jpeg" width="115" height="115" alt="image"/></a>      
                    <div style="text-align:right;position:relative;float:right;top:25px;margin-right:30px">
                        <strong><?php echo $t7; ?></strong><br />
                        <a href="index.php?page=viewprfl&amp;PID=<?php echo $_SESSION["PID"];?>"><?php echo $t2; ?></a>
                        <a href="index.php?page=editprfl&amp;PID=<?php echo $_SESSION["PID"];?>"><?php echo $t3; ?></a><br />
                        <a href="index.php?page=create"><?php echo $t4;?></a><br />
                        <a href="index.php?page=logout"><?php echo $t5;?></a><br />
                    </div>
                    <div style="position:relative;top:-20px;margin-left:115px">
                        <a href="index.php?page=langselect"><img src="img/ukraine-flag.png" width="20" height="15" alt="image"/></a>
                        <a href="index.php?page=langselect"><img src="img/english-flag.png" width="20" height="15" alt="image"/></a>
                    </div>
                </div><?php
                break;
            default:?>
                <div class="ex">
                    <a href="index.php"><img src="img/images.jpeg" width="115" height="115" alt="image"/></a>      
                    <div style="text-align:right;position:relative;float:right;top:25px;margin-right:30px">
                        <strong>Welcome User!</strong><br />
                        <a href="index.php?page=viewprfl&amp;PID=<?php echo $_SESSION["PID"];?>"><?php echo $t2; ?></a>
                        <a href="index.php?page=editprfl&amp;PID=<?php echo $_SESSION["PID"];?>"><?php echo $t3; ?></a><br />
                        <a href="index.php?page=logout"><?php echo $t5; ?></a><br />
                    </div>
                    <div style="position:relative;top:-20px;margin-left:115px">
                        <a href="index.php?page=langselect"><img src="img/ukraine-flag.png" width="20" height="15" alt="image"/></a>
                        <a href="index.php?page=langselect"><img src="img/english-flag.png" width="20" height="15" alt="image"/></a>
                    </div>
                </div><?php
                break;
        }
    } else if (isset($_GET["falsepass"])){?>
        <div class="ex">
            <a href="index.php"><img src="img/images.jpeg" width="115" height="115" alt="image"/></a>               
            <div style="text-align:right;position:relative;float:right;top:15px;margin-right:30px"><?php
                if(isset($_GET['ID'])){echo '<form action="index.php" method="get"><div>';
                    echo '<div><input type="hidden" value="' . $_GET['ID'] . '" name="ID"/>';
                    echo '<input type="hidden" value="view" name="page"/>';}      
                else { echo '<form action="index.php" method="get"><div>';}?>
                    <?php echo $t8;?>:<input type="text" name="usr"/><br />
                    <?php echo $t9;?>:<input type="password" name="passwd"/><br /><?php
                if ($_GET["falsepass"]=='1') {
                    echo '<span style="color:red;font-size:12px">Incorrect username or password!</span><br />';
                } else {
                    echo '<span style="color:red;font-size:12px">' . $t36 . '</span><br />';
                }?>
                <div style="position:relative;float:right;top:-1px;right:0px;">    
                    <input type="submit" value="<?php echo $t11; ?>"/>
                </div>    
                </div></form>            
                <div style="position:relative;float:right;top:-1px;right:15px;">    
                    <form action="index.php" method="get">
                    <div>
                        <input type="hidden" size="30" name="page" value="createprfl"/>
                        <input type="submit" value="<?php echo $t10; ?>"/>
                    </div>
                    </form>
                </div>
                </div>
                <div style="position:relative;top:-20px;margin-left:115px">
                    <a href="index.php?page=langselect"><img src="img/ukraine-flag.png" width="20" height="15" alt="image"/></a>
                    <a href="index.php?page=langselect"><img src="img/english-flag.png" width="20" height="15" alt="image"/></a>
                </div>
        </div><?php
    } else {?>
        <div class="ex">
            <a href="index.php"><img src="img/images.jpeg" width="115" height="115" alt="image"/></a>      
            <div style="text-align:right;position:relative;float:right;top:15px;margin-right:30px"><?php
                if(isset($_GET['ID'])){echo '<form action="index.php" method="get"><div>';
                echo '<input type="hidden" value="' . $_GET['ID'] . '" name="ID"/>';
                echo '<input type="hidden" value="view" name="page"/>';}     
                else { echo '<form action="index.php" method="get"><div>';}?>
                <?php echo $t8; ?>: <input type="text" name="usr"/><br />
                <?php echo $t9; ?>: <input type="password" name="passwd"/><br /><br />
                <div style="position:relative;float:right;top:-1px;right:0px;">    
                    <input type="submit" value="<?php echo $t11; ?>"/>
                </div>    
                </div></form>            
                <div style="position:relative;float:right;top:-1px;right:15px;">    
                    <form action="index.php" method="get"><div>
                    <input type="hidden" size="30" name="page" value="createprfl"/>
                    <input type="submit" value="<?php echo $t10; ?>"/>
                </div></form>
                </div>
                </div>
            <div style="position:relative;top:-20px;margin-left:115px">
                        <a href="index.php?page=langselect"><img src="img/ukraine-flag.png" width="20" height="15" alt="image"/></a>
                        <a href="index.php?page=langselect"><img src="img/english-flag.png" width="20" height="15" alt="image"/></a>
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
	     echo "<img src=\"" . $row["Image"] . "\" alt=\"image\"/><br />";
         echo "<h3>" . $row["FirstName"] . "&nbsp;" . $row["LastName"] ."</h3>";
	     echo "<p> e-mail:" . "&nbsp;" . $row["Email"] . "</p>";
         echo "<p>" . $t14 . ":&nbsp;" . $row["REG_DATE"] . "</p>";
	     echo "<p>" . $t15 . ":&nbsp;" . $row["LVIS_DATE"] . "</p>";
	     echo "<a href=\"index.php?page=deleteprfl&amp;PID=" . $x . "\">" . $t16 . "</a></div>";
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
            echo '<h1>' . $t17 . '</h1>
            <span style="color:red;font-size:12px"><img src="' . $row["Image"] . '" alt="' . $t29 . '"/></span><br /><br />';
            if($row["Image"]>'0'){
                echo '<a href="index.php?page=deletepic&amp;PID=' . $row["PID"] . '">' . $t18 . '</a><br /><br />';
            }
            echo   '<form name="form_cr" action="index.php?page=edit-dbprfl" method="post" enctype="multipart/form-data">
            <fieldset>
            <input type="hidden" size="30" name="Image" value="' . $row["Image"] . '"/>
            <input type="hidden" size="30" name="PID" value="' . $row["PID"] . '"/>
            <input type="hidden" size="30" name="login" value="' . $row["Login"] . '"/>
            <label>' . $t19 . ':</label><br />
            <input type="text" size="30" name="firstname" value="' . $row["FirstName"] . '"/><br /><br />
            <label>' . $t20 . ':</label><br />
            <input type="text" size="30" name="lastname" value="' . $row["LastName"] . '"/><br /><br />
            <label>Email:</label><br />
            <input type="text" size="30" name="email" value="' . $row["Email"] . '"/><br /><br />
            <label>' . $t21 . ':</label><br />
            <input type="file" name="photo" id="photo"/><br /><br />
            <input type="submit" value="' . $t22 . '"/><br />
        </fieldset></form>
        <p>
    <a href="http://validator.w3.org/check?uri=referer"><img
      src="http://www.w3.org/Icons/valid-xhtml11" alt="Valid XHTML 1.1" height="31" width="88" /></a>
  </p>
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
        //echo "Article #" . $x . " has been deleted<br /><a href="index.php">Home Page</a>";
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
         //echo "Personal record #" . $x . " has been deleted<br /><a href="index.php">Home Page</a>";
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
        //echo "Your photo has been deleted<br /><a href="index.php">Home Page</a>";
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
                $allowedExts = array("jpeg", "jpg");
                $file = explode(".", $_FILES["photo"]["name"]);
                $extension = end($file);
                if ((($_FILES["photo"]["type"] == "image/jpeg")
                || ($_FILES["photo"]["type"] == "image/jpg")
                || ($_FILES["photo"]["type"] == "image/pjpeg"))
                && ($_FILES["photo"]["size"] < 30000)
                && in_array($extension, $allowedExts))
                {
                    if ($_FILES["photo"]["error"] > 0)
                    {
                        echo "Return Code: " . $_FILES["photo"]["error"] . "<br />";
                    }
                    else
                    {
                        echo "Upload: " . $_FILES["photo"]["name"] . "<br />";
                        echo "Type: " . $_FILES["photo"]["type"] . "<br />";
                        echo "Size: " . ($_FILES["photo"]["size"] / 1024) . " kB<br />";
                        echo "Temp file: " . $_FILES["photo"]["tmp_name"] . "<br />";

                        move_uploaded_file($_FILES["photo"]["tmp_name"],
                        "img/" . $_POST["login"] . "." . $extension);
                        $original_image = imagecreatefromjpeg("img/" . $_POST["login"] . "." . $extension);
                        $cropped_image = imagecreatetruecolor(150, 150);
                        imagecopy($cropped_image, $original_image, 0, 0, 50, 50, 150, 150);
                        imagejpeg($cropped_image, "img/" . $_POST["login"] . "." . $extension, 100);
                        imagedestroy($cropped_image);
                        imagedestroy($original_image);
                        $filepath = "img/" . $_POST["login"] . "." . $extension;
                        echo "Stored in: " . $filepath . "<br />";
                    }
                    
                }
                else
                {
                    echo "Invalid Image<br />";

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
            mysqli_close($con);
        ?></div><?php
	break;
	case "create-dbprfl":?>
        <div class="ey"><?php
            if(!empty($_POST["passwd"]) && !empty($_POST["passwdcnf"]) && !empty($_POST["email"]) && !empty($_POST["login"])){
                if($_POST["passwd"] == $_POST["passwdcnf"]){
                    $con=mysqli_connect("localhost","admin","qazwsx","my_db");
                    if (mysqli_connect_errno())
                    {
                        echo "Failed to connect to MySQL: " . mysqli_connect_error();
                    }
                    $result = mysqli_query($con,"SELECT * FROM persons
                    WHERE login='$_POST[login]' AND email='$_POST[email]'");
                    $row = mysqli_fetch_array($result);
                    if ($row["PID"]>'0') {
                        echo $t39 . "<br /><br /><a href=\"index.php?page=createprfl\">" . $t40 . "<a>";
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
                    echo $t38 . "<br /><br /><a href=\"index.php?page=createprfl\">" . $t40 . "<a>";
                }
            }else{
                echo $t41 . "<br /><br /><a href=\"index.php?page=createprfl\">" . $t40 . "<a>";
            }
            
               ?></div><?php
	break;
	case "createprfl":?>
        <div class="ey">
            <h1><?php echo $t17; ?></h1><br /><br />
            <form name="form_cr" action="index.php?page=create-dbprfl" method="post">
            <fieldset>
                <label><?php echo $t19; ?>:</label><br />
                <input type="text" size="30" name="firstname"/><br /><br />
                <label><?php echo $t20; ?>:</label><br />
                <input type="text" size="30" name="lastname"/><br /><br />
                <label>Email:</label><br />
                <input type="text" size="30" name="email"/><br /><br />
                <label><?php echo $t9; ?>:</label><br />
                <input type="password" size="30" name="passwd"/><br /><br />
                <label><?php echo $t37; ?>:</label><br />
                <input type="password" size="30" name="passwdcnf"/><br /><br />
                <label><?php echo $t8 ;?>:</label><br />
                <input type="text" name="login" size="30"/><br /><br />
                <input type="submit" value="<?php echo $t22; ?>"/><br />
            </fieldset>
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
            <?php 
            while($row = mysqli_fetch_array($result))
            echo "<tr><td>" . $row["PID"] . "</td>
            <td>" . $row["Login"] . "</td>
            <td>"  . $row["Role"] . "</td>
            <td>"  . $row["Active"] . "</td>
            <td><a href=\"index.php?page=updstat&amp;role=usr&amp;PID="  . $row["PID"] . "\">USR</a></td>
            <td><a href=\"index.php?page=updstat&amp;role=mod&amp;PID="  . $row["PID"] . "\">MOD</a></td>
            <td><a href=\"index.php?page=updstat&amp;role=adm&amp;PID="  . $row["PID"] . "\">ADM</a></td>
            <td><a href=\"index.php?page=updstat&amp;active=1&amp;PID="  . $row["PID"] . "\">ACTV</a></td>
            <td><a href=\"index.php?page=updstat&amp;active=0&amp;PID="  . $row["PID"] . "\">INAC</a></td>
            <td><a href=\"index.php?page=updstat&amp;active=2&amp;PID="  . $row["PID"] . "\">x</a></td></tr>";
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
                    echo "<a href=\"index.php?page=delallcom&amp;ID=" . $_GET['ID'] . "\">"; 
                    if ($_SESSION['lang']=='eng') {print("Reset voting");} else {print("Обнулити голосування");}
                    echo "</a><br /><br />";
                }
                }
            echo '<h1>' . $t17 . '</h1><br /><br />
            <form name="form_cr" action="index.php?page=edit-db" method="post">
            <fieldset>
                <input type="hidden" value="' . $row['ID'] . '" name="ID"/>
                <strong>' . $t24 . ':</strong><br />
                <input type="text" size="35" value="' . $row['ArtTitle'] . '" name="ArtTitle"/>
                <br /><br /><strong>
                ' . $t25 . ':</strong><br />
                <textarea cols="50" rows="6" name="ArtCont">' . $row['ArtCont'] . '</textarea><br /><br /><br />
                <strong>' . $t26 . ':</strong><br />
                <input type="text" size="35" value="' . $row['ArtTitleUA'] . '" name="ArtTitleUA"/>
                <br /><br /><strong>
                ' . $t27 . ':</strong><br />
                <textarea cols="50" rows="6" name="ArtContUA">' . $row['ArtContUA'] . '</textarea><br /><br />
                <input type="submit" value="' . $t22 . '"/><br />
            </fieldset></form>';
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
            mysqli_close($con);
      ?></div><?php
    break;
    case "create":?>
        <div class="ey">
            <h1><?php echo $t4; ?></h1><br /><br />
            <form name="form_cr" action="index.php?page=create-db" method="post">
            <fieldset>
                <strong><?php echo $t24; ?>:</strong><br />
                <input type="text" size="35" name="ArtTitle"/>
                <br /><br /><strong>
                <?php echo $t25; ?>:</strong><br />
                <textarea cols="50" rows="6" name="ArtCont"></textarea><br /><br /><br />
                <strong><?php echo $t26; ?>:</strong><br />
                <input type="text" size="35" name="ArtTitleUA"/>
                <br /><br /><strong>
                <?php echo $t27; ?>:</strong><br />
                <textarea cols="50" rows="6" name="ArtContUA"></textarea><br /><br />
                <input type="submit" value="<?php echo $t22; ?>"/><br /><br />
            </fieldset>
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
            if (array_key_exists('login', $_SESSION)) {
            $result = mysqli_query($con,"SELECT * FROM votes WHERE ID='$_GET[ID]' AND login='$_SESSION[login]'");
            $row = mysqli_fetch_array($result);
            if ($row['score']>'0') {
                print($t33); echo "&nbsp;&nbsp;-&nbsp;&nbsp;" . $row['score'];?>
                <form name="form_a" action="index.php?page=deletemark" method="post">
                <div>
                <input type="hidden" value="<?php echo $row['VID']; ?>" name="VID"/>
                <input type="submit"  value="<?php echo $t18; ?>"/></div></form><?php
            } else {
                if ($_SESSION['lang']=='eng') {print("<script type=\"text/javascript\">function myFunction(){alert(\"Thanks for voting!\");}</script>Vote:");
                } else {print("<script type=\"text/javascript\">function myFunction(){alert(\"Дякуємо за вашу оцінку!\");}</script>Голосувати:");}
            ?><form name="form_cr" action="index.php?page=vote" method="post">
            <div>
            <input type="hidden" value="<?php print($_GET['ID']) ?>" name="ID"/>
            <input type="hidden" value="<?php print($_SESSION['login']) ?>" name="login"/>
            <select name="score">
                <option value="5">5</option>
                <option value="4">4</option>
                <option value="3">3</option>
                <option value="2">2</option>
                <option value="1">1</option>
            </select>
            <input type="submit" onclick="myFunction()" value="<?php echo $t22; ?>"/></div></form><?php
            }
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
                    echo "<i>Total votes - ". $i ."<br />Average mark - " . $score/$i . "</i><br />";
                    echo "<p>" . $row['ArtCont'] . "</p><br />";
                } else {
                    echo "<h2>" . $row['ArtTitleUA'] . "</h2>";
                    echo "<i>Всього голосів - ". $i ."<br />Середня оцінка - " . $score/$i . "</i><br />";
                    echo "<p>" . $row['ArtContUA'] . "</p>";
                }
            } else {
                if ($_SESSION['lang']=='eng') {
                    echo "<h2>" . $row['ArtTitle'] . "</h2>";
                    echo "<i>Nobody voted for this yet</i><br />";
                    echo "<p>" . $row['ArtCont'] . "</p><br />";
                } else {
                    echo "<h2>" . $row['ArtTitleUA'] . "</h2>";
                    echo "<i>За цей метріал ще ніхто не голосував</i><br />";
                    echo "<p>" . $row['ArtContUA'] . "</p>";
                }
            }
            if (array_key_exists('login', $_SESSION)) {
            if ($_SESSION['lang']=='eng') {print("<h3>Leave comment:</h3>");} else {print("<h3>Коментувати:</h3>");}?>
                <form name="form_cr" action="index.php?page=comcre" method="post"><fieldset>
                <input type="hidden" value="<?php print($_GET['ID']); ?>" name="ID"/>
                <input type="hidden" value="<?php print($_SESSION['login']); ?>" name="login"/>
                <input type="hidden" value="<?php print($_SESSION['PID']); ?>" name="PID"/>
                <strong><?php echo $t34; ?>:</strong><br />
                <input type="text" size="35" name="ComTitle"/>
                <br /><br /><strong>
                <?php echo $t35; ?>:</strong><br />
                <textarea cols="50" rows="4" name="ComCont"></textarea><br />
                <input type="submit" value="<?php echo $t22; ?>"/>
                </fieldset>
                </form><br /><?php
            }
            $result = mysqli_query($con,"SELECT * FROM coments WHERE ID='$_GET[ID]'");
            while($row = mysqli_fetch_array($result)){
                echo "<b><a href=\"index.php?page=viewprfl&amp;PID=" . $row['PID'] . "\">" . $row['login'] . "</a></b>  " . $row['ComDate'] . "<br />";
                echo "<b>" . $row['ComTitle'] . "</b><br />";
                echo $row['ComCont'] . "<br /><br />";
                if(isset($_SESSION['admin'])){
                if($_SESSION['admin']=='adm') {
                    echo "<a href=\"index.php?page=deletecom&amp;CID=" . $row['CID'] . "\">"; 
                    if ($_SESSION['lang']=='eng') {print("Delete comment");} else {print("Видалити коментар");}
                    echo "</a><br /><br />";
                }
                }
            }    
            if(isset($_SESSION['admin'])){
            if($_SESSION['admin']=='mod'
            || $_SESSION['admin']=='adm') {echo "<a href=\"index.php?page=delete&amp;ID=" . $_GET['ID'] . "\">" . $t18 . "</a>&nbsp;&nbsp;&nbsp;";
            echo "<a href=\"index.php?page=edit&amp;ID=" . $_GET['ID'] . "\">" . $t23 . "</a>";}}
            if (!mysqli_query($con,$sql))
            {
                die('Error: ' . mysqli_error());
            }
            mysqli_close($con);
        echo "</div>";
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
            <th><?php echo $t30;?></th>
            <th><?php echo $t31;?></th>
            <th><?php echo $t28;?></th>
            </tr>
            <?php
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
        echo "<tr><td>" . $row["PID"] . "</td>
            <td>" . $row["ukr"] . "</td>
            <td>"  . $row["eng"] . "</td>
            <td><a href=\"index.php?page=txtedit&amp;PID="  . $row["PID"] . "\"> " . $t28 . " </a></td></tr>";
        }
        echo "</table></div>";
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
            echo '<h1>' . $t17 . '</h1><br /><br />
            <form name="form_cr" action="index.php?page=txtedit-db" method="post">
            <fieldset>
                <input type="hidden" value="' . $row['PID'] . '" name="PID"/>
                <strong>' . $t30 . ':</strong><br />
                <input type="text" size="48" value="' . $row['ukr'] . '" name="ukr"/><br />
                <strong>' . $t31 . ':</strong><br />
                <input type="text" size="48" value="' . $row['eng'] . '" name="eng"/><br />
                <input type="submit" value="' . $t22 . '"/><br />
            </fieldset></form>';
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
                $count = $dbh->exec("UPDATE std_texts SET ukr='$_POST[ukr]', eng='$_POST[eng]' WHERE PID='$_POST[PID]'");
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
	        echo "<a href=\"index.php?page=view&amp;ID=" . $row['ID'] . "\">" . $t12 . "</a><br /><br />";
            }
      ?></div><?php
	}?>
</body>
</html>
