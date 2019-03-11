<?php

 // Full script URL begins with prefix (http://) ...end with slashing (/)
 $site_url = 'http://mpp.eng.usm.my/events/';
 
 // event information
 $event_name = 'Design Simple RSVP System';
 $event_date = '20 February 2012'; // Valid format example: 4 February 2012
 $event_time = '10:12 AM'; // Valid format example: 10:55 AM
 $event_location = 'Kampus Kejuruteraan';
 $event_link = 'http://google.com'; // begin with (http://) ...
 $event_details = 'Penat design setting sana sini test sana sini debug sana sini.';

 // Database Variables (edit with your own server information)
 $server = 'localhost';
 $user = 'root';
 $pass = '';
 $db = 'php';
 
 // Connect to Database
 $connection = mysqli_connect($server, $user, $pass, $db)
 or die ("Could not connect to server ... \n" . mysqli_error ());
 mysqli_select_db($connection, $db) 
 or die ("Could not connect to database ... \n" . mysqli_error ());

?>