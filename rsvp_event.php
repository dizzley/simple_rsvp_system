<script type="text/javascript">
window.onload=function(){
  GetCount(dateFuture1, 'countbox1');
};
</script>

<?php

include('config.php');

if ($event_name == '') { $event_name = 'Not set'; }
if ($event_date == '') { $event_date = '4 February 2012'; }
if ($event_time == '') { $event_time = '10:55 AM'; }
if ($event_location == '') { $event_location = 'Not set'; }
if ($event_link == '') { $event_link = 'Not set'; }
if ($event_details == '') { $event_details = 'Not set'; }
if ($site_url == '') { $site_url = 'Not set'; }

$byname = mysqli_query($connection, "SELECT name FROM simple_rsvp ORDER BY id") or die(mysqli_error());
$total_users = mysqli_num_rows($byname);
$bystatus_yes = mysqli_query($connection, "SELECT status FROM simple_rsvp WHERE status='Yes'") or die(mysqli_error());
$total_yes = mysqli_num_rows($bystatus_yes);
$bystatus_no = mysqli_query($connection, "SELECT status FROM simple_rsvp WHERE status='No'") or die(mysqli_error());
$total_no = mysqli_num_rows($bystatus_no);

if ($total_yes == '0' || $total_yes == '1') { $english1 = 'person'; }
else if ($total_yes > '1') { $english1 = 'persons'; }
if ($total_no == '0' || $total_no == '1') { $english2 = 'person'; }
else if ($total_no > '1') { $english2 = 'persons'; }
if ($total_users == '0' || $total_users == '1') { $english3 = 'person'; }
else if ($total_users > '1') { $english3 = 'persons'; } 

echo '<div class="event">';
echo '<span class="edit_event"><a href="admin.php">Admin Mode</a></span><br>';
echo '<h2 class="title"><strong>' . $event_name . '</a></strong></h2>';
echo '<strong><span class="date_label">Date: </span></strong><span class="view_date"> ' . $event_date . '</span> ';
echo ' <strong><span class="time_label">Time: </span></strong><span class="view_time"> ' . $event_time . '</span><br>';
echo '<strong><span class="location_label">Location: </span></strong><span class="view_location"> ' . $event_location . '</span><br>';
echo '<strong><span class="detail_label">Details:</span></strong>' . $event_details . '<br>';
echo '<strong><span class="link_label">Link: </span></strong><span class="view_link"><a class="view_link" href="' . $event_link . '" target="_blank"> ' . $event_link . '</a></span><br>';
echo '<div class="stat">';
echo '<strong><span class="yes_label">Attending: </span></strong><span class="view_yes">' . $total_yes . ' ' . $english1 . '</span> ';
echo '<strong><span class="no_label">Not Attending: </span></strong><span class="view_no">' . $total_no . ' ' . $english2 . '</span> ';
echo ' <strong><span class="total_label">Total: </span></strong><span class="view_total"> ' . $total_users . ' ' . $english3 . '</span><br>';
echo '</div>';
echo '<div id="fb-like" class="fb-like" data-href="' . $site_url . '" data-send="true" data-layout="button_count" data-width="100" data-show-faces="false"></div>';
                
$date_from_mysql = $event_date;
$time_from_mysql = $event_time;
   
$datetime_mysql = $date_from_mysql . " " . $time_from_mysql;
$split_datetime_mysql = explode(" ", $datetime_mysql);
$mysql_day = $split_datetime_mysql[0];
$mysql_month = $split_datetime_mysql[1];
$mysql_year = $split_datetime_mysql[2];
$mysql_time = $split_datetime_mysql[3];
$mysql_A = $split_datetime_mysql[4];
list($m_hour, $m_minute) = explode(":", $mysql_time);

switch($mysql_month) {
case "January":$m_month = "1";break;
case "February":$m_month = "2";break;
case "March":$m_month = "3";break;
case "April":$m_month = "4";break;
case "May":$m_month = "5";break;
case "June":$m_month = "6";break;
case "July":$m_month = "7";break;
case "August":$m_month = "8";break;
case "September":$m_month = "9";break;
case "October":$m_month = "10";break;
case "November":$m_month = "11";break;
case "Disember":$m_month = "12";break;
}

switch($mysql_A) {
case "AM":$m_hour2 = $m_hour;break;
case "PM":$m_hour2 = $m_hour + 12;break;
}

if ($m_hour2 == "24") {
$m_hour2 = "0"; // return zero
} else {
$m_hour2 = $m_hour2;
}

$m_sec = "0";$m_month = $m_month - 1;
$target_datetime = $mysql_year . "," . $m_month . "," . $mysql_day . "," . $m_hour2 . "," . $m_minute . "," . $m_sec;
                
echo '<script type="text/javascript">';
echo 'dateFuture1 = new Date(' . $target_datetime . ');';
echo '</script>';
                
echo '<div class="countbox" id="countbox1"></div>';
echo '<strong><span class="permalink">Permalink: </span></strong><span class="view_permalink"><a href="' . $site_url . '">' . $site_url . '</a><span>';
                
echo '</div>'; 

?>