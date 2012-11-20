<?php

$mypassword = "hn2012";
$password = sha1($mypassword);

session_start();
if (!isset($_SESSION['loggedIn'])) {
    $_SESSION['loggedIn'] = false;
}

$error_msg = "";
if (isset($_POST['password'])) {
    if (sha1($_POST['password']) == $password) {
        $_SESSION['loggedIn'] = true;
    } else {
        $error_msg = "<div class='error_msg'>Access Denied!</div>";
    }
} 

if (!$_SESSION['loggedIn']): ?>

<html>
<head>
<title>Event Lister | Administration</title>
<link rel="stylesheet" href="auth/style.css" type="text/css" media="screen" />
</head>
  <body>
  <div class="login_box">
    <p>This is a restricted page, Access Code is required to proceed.</p>
    <form method="post">
      <table class="login_table">
      <tr>
      <td class="label"></td><td class="input_label"><?php echo $error_msg; ?></td>
      </tr><tr>
      <td class="label">Access Code:</td><td class="input_label"><input class="password" type="password" name="password"></td>
      </tr><tr>
      <td class="label"></td><td class="input_label"><input class="submit_button" type="submit" name="submit" value="Submit"></td>
      </tr>
      </table>
    </form>
  
  <p style="margin-top:10px;font-size:11px;">Having a problem? Contact me via <a href="mailto:wayi@heiswayi.net">email</a>.</p>
  
  <div class="login_copy">&copy; Coded by <a href="http://heiswayi.net">Heiswayi Nrird</a></div>
  </div>

  </body>
</html>

<?php
exit();
endif;
?>