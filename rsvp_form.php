<?php
 function renderForm($name, $email, $phone, $yes_status, $no_status, $error)
 {
?>

<div id="make_box">

<div class="form_title"><h3>Répondez S'il Vous Plaît (RSVP) <span class="pls_respond"><em>Please Respond.</em></span></h3></div>
<?php 
// if there are any errors, display them
if ($error != '')
{
echo '<div class="err">'.$error.'</div>';
}
?>
 
            <form action="" method="post">
            <div>
            <table class="add_event">
            <tr><td class="label"><strong>Name:</strong></td><td><input maxlength="140" class="name" type="text" name="name" value="<?php echo $name; ?>" /></td></tr>
            <tr><td class="label"><strong>Email:</strong></td><td><input maxlength="140" class="email" type="text" name="email" value="<?php echo $email; ?>" /></td></tr>
            <tr><td class="label"><strong>Phone:</strong></td><td><input id="phone" maxlength="20" class="phone" type="text" name="phone" value="<?php echo $phone; ?>" /></td></tr>
            <tr><td class="label"><strong>Status:</strong></td><td class="status">
            <label class="status_yes"><input class="status" type="radio" name="status" value="Yes" <?php echo $yes_status; ?> /> Attending</label>             <label class="status_no"><input class="status" type="radio" name="status" value="No" <?php echo $no_status; ?> /> Not attending</label>
            </td></tr>
           
            <input type="hidden" name="antispam" value="" />
            
            
            <tr><td></td><td><input class="ui-button ui-button-green ui-icon-checkmark" type="submit" name="submit" value="Submit"></td></tr>
            </table>
            </div>
            </form>
            
</div>

<script>
jQuery(function($){
   $("#phone").mask("999-9999999");
});
</script>
            
<?php 
 }
 
 // connect to the database
 include('config.php');
 
 $yes_status = 'unchecked';
 $no_status = 'unchecked';
 
 // email validation
 function check_email_address($email) {
        // First, we check that there's one @ symbol, and that the lengths are right
        if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
            // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
            return false;
        }
        // Split it into sections to make life easier
        $email_array = explode("@", $email);
        $local_array = explode(".", $email_array[0]);
        for ($i = 0; $i < sizeof($local_array); $i++) {
            if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
                return false;
            }
        }
        if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
            $domain_array = explode(".", $email_array[1]);
            if (sizeof($domain_array) < 2) {
                return false; // Not enough parts to domain
            }
            for ($i = 0; $i < sizeof($domain_array); $i++) {
                if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
                    return false;
                }
            }
        }

        return true;
  }
 
 // check if the form has been submitted. If it has, start to process the form and save it to the database
 if (isset($_POST['submit']))
 { 
 // get form data, making sure it is valid
 $name = mysql_real_escape_string(htmlspecialchars($_POST['name']));
 $email = mysql_real_escape_string(htmlspecialchars($_POST['email']));
 $phone = mysql_real_escape_string(htmlspecialchars($_POST['phone']));
 $antispam = $_POST['antispam'];
 
 // set status when option is made
 if (isset($_POST['status'])) {
  $status = $_POST['status'];
 if ($status == 'Yes') {
  $yes_status = 'checked';
  $mystatus = 'Yes';
 }
 else if ($status == 'No') {
  $no_status = 'checked';
  $mystatus = 'No';
 } 
 }
 
 // required all fields
 if ($name == '' || $email == '' || $phone == '')
 {
 $error = 'ERROR: All fields are required!';
 renderForm($name, $email, $phone, $yes_status, $no_status, $error);
 }
 else if (check_email_address($email) == FALSE) {
 $error = 'ERROR: Invalid email address!';
 renderForm($name, $email, $phone, $yes_status, $no_status, $error);
 }
 // if status is undefined
 else if (!isset($_POST['status'])) {
 $error = 'ERROR: Please make your option to attend or not!';
 renderForm($name, $email, $phone, $yes_status, $no_status, $error);
 }
 else if ($antispam !== '')
 {
 // prevent spambot from submitting form
 $error = 'So, you are not human!';
 renderForm($name, $email, $phone, $yes_status, $no_status, $error);
 }
 else
 {
 // save the data to the database
 mysql_query("INSERT simple_rsvp SET name='$name', email='$email', phone='$phone', status='$mystatus'")
 or die(mysql_error()); 
 
 // once saved, redirect back to the view page
 header("Location: index.php"); 
 }
 }
 else
 // if the form hasn't been submitted, display the form
 {
 renderForm('','','','','','');
 }
?> 