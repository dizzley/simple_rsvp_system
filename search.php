<?php
require('auth/auth.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Simple RSVP System | Admin Mode</title>
<link rel="stylesheet" href="css/admin.css" type="text/css" media="screen" />
<script type="text/javascript" src="js/scrolltopcontrol.js"></script>

</head>
<body>

<div class="navbar">
<a href="index.php">Home</a> | <a href="admin.php">View All</a> | <a href="search.php">Search</a> | <a href="auth/logout.php">Logout</a>
</div>

<div class="list_search">
<form method="post" action="search.php?go" id="searchform">
<input class="search" type="text" name="keyword">
<input class="search_button" type="submit" name="submit" value="Search">
</form>
</div>

<?php

include('config.php');

$result = mysqli_query($connection, "SELECT * FROM simple_rsvp ORDER BY name") or die(mysqli_error());
$total_users = mysqli_num_rows($result);
$bystatus_yes = mysqli_query($connection, "SELECT status FROM simple_rsvp WHERE status='Yes'") or die(mysqli_error());
$total_yes = mysqli_num_rows($bystatus_yes);
$bystatus_no = mysqli_query($connection, "SELECT status FROM simple_rsvp WHERE status='No'") or die(mysqli_error());
$total_no = mysqli_num_rows($bystatus_no);

echo '<div class="namelist">';
echo '<div class="list_info"><span class="attending"><strong>' . $total_yes . '</strong> attending</span>, <span class="not_attending"><strong>' . $total_no . '</strong> not attending</span> and <span class="total">total: <strong>' . $total_users . '</strong></span>.</div>';

if(isset($_POST['submit'])){
if(isset($_GET['go'])){
if(preg_match("/[A-Z | a-z]+/", $_POST['keyword'])){
$keyword=$_POST['keyword'];

$resultx = mysqli_query($connection, "SELECT * FROM simple_rsvp WHERE name LIKE '%" . $keyword . "%' OR email LIKE '%" . $keyword ."%' OR phone LIKE '%" . $keyword ."%' OR status LIKE '%" . $keyword ."%'") or die(mysqli_error());

while($row = mysqli_fetch_array($resultx)) {
    echo '<div class="list_details">';
    echo '<span class="list_delete"><a href="do_delete.php?id=' . $row['id'] . '">Delete</a></span>';
    echo '<strong>Name:</strong> <span class="list_name">' . $row['name'] . '</span><br>';
    echo '<strong>Phone:</strong> <span class="list_phone">' . $row['phone'] . '</span><br>';
    echo '<strong>Email:</strong> <span class="list_email">' . $row['email'] . '</span><br>';
    if ($row['status'] == 'Yes') { $statusx = '<span class="attending">Yes</span>'; }
    else if ($row['status'] == 'No') { $statusx = '<span class="not_attending">No</span>'; }
    echo '<strong>Attending:</strong> <span class="list_status">' . $statusx . '</span>';
    echo '</div>';
}

echo '</div>';

} else {
echo '<div class="list_details">Please enter a search query!</div>';
}
}
}

?>

<div class="list_copy">&copy; Simple RSVP System by <a href="http://heiswayi.net">Heiswayi Nrird</a></div>

</body>
</html>