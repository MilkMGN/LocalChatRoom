<?php session_start();
// Standard grabbing of info (Username and location of the currently viewed file).
$userName = $_SESSION['userName'];
// Directory in which this is stored.
$currentdir = str_replace("C:/xampp/htdocs", "", getcwd());
// Change the permission level of a user
if(isset($_POST['user'])) {
  if(isset($_POST['permLevel'])) {
    $userToChange = $_POST['user'];
    $permToChange = $_POST['permLevel'];
    $link = mysqli_connect("localhost", "root", "milkmgn", "LCR");
    $sql = "UPDATE UserAccounts SET Perms = $permToChange WHERE UserName = '$userToChange'";
    $results = mysqli_query($link, $sql);
  }

  // Spencer's attempt at name changes
  if(isset($_POST['userNameChange'])) {
  $userToChange = $_POST['user'];
  $newName = $_POST['userNameChange'];
  $link = mysqli_connect("localhost", "root", "milkmgn", "LCR");
  $sql = "SELECT UserID From LCR.userAccounts WHERE UserName = '$userToChange'";
  $results = mysqli_query($link, $sql);
  $data = mysqli_fetch_assoc($results);

  $userID = $data['UserID'];
  $sql = "UPDATE UserAccounts SET UserName = '$newName' WHERE USERID = $userID";
  $results = mysqli_query($link, $sql);
  }
}
// If the owner wants to see a user's perms, grab it from a text file.
if(isset($_POST['userQuery'])) {
  $link = mysqli_connect("localhost", "root", "milkmgn", "LCR");
  $sql = "SELECT Perms FROM LCR.UserAccounts WHERE UserName = '".$_POST['userQuery']."';";
  $results = mysqli_query($link, $sql);
  $data = mysqli_fetch_assoc($results);
  $userQuery = $data['Perms'];
}
?>
<!DOCTYPE HTML>
<html>
  <head lang="en-AU">
    <link rel="stylesheet" href="style.php">
    <meta charset="UTF-8">
    <title>Local Chat Room</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
  </head>
  <?php include 'headerbar.php'; include 'sidebar.php'; ?>
  <?php
  if($userPerm == 5) {
    echo "<body>
    <div style='text-align:center;'>
      <h2>Change User's Permissions -</h2>
      <form action='owner.php' method='post'>
        User:<input type='text' name='user'><br>
        Permission level:<input type='text' name='permLevel'><br>
        <input type='submit' value='Change Permissions'>
      </form>
      <h2>View a user's permissions -</h2>
      <form action='owner.php' method='post'>
        User:<input type='text' name='userQuery'><br>
        Permission level: ";
     if(isset($userQuery)) { 
        echo $userQuery;
     }
     echo "
        <input type='submit' value='View Permissions'>
      </form>
      <h2>Change User's name -</h2>
      <form action='owner.php' method='post'>
        User:<input type='text' name='user'><br>
        New Name:<input type='text' name='userNameChange'><br>
        <input type='submit' value='Change Name'>
      </form>
    </div>
  </body>";
  } else {
    echo '';
  }
  ?>
</html>
