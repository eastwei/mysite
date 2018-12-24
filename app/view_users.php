<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$page_title = 'View the Current Users';
include('include/header.html');
//page header:
echo '<h1>Registered Users</h1>';
require('../mysqli_connect.php'); //Connect to the db.
//Make the query:
$q = "SELECT last_name,first_name,"
        . "DATE_FORMAT(registration_data,'%M %d,%Y') AS dr ,"
        . "user_id FROM users ORDER BY registration_data ASC";
$r = mysqli_query($dbc, $q); //Run the query.
$num = mysqli_num_rows($r);
if ($num > 0){
    //print how many users there are:
    echo "<p>There are currently $num registered users.</p>\n";
    //Table header.
    echo '<table align="center" cellspacing = "3" cellpadding="3" width="75%">
    <tr>
    <td align="left"><b>Edit</b></td>
    <td align="left"><b>Delete</b></td>
    <td align="left"><b>Last Name</b></td>
    <td align="left"><b>First Name</b></td>
    <td align="left"><b>Date Registered</b></td>
    </tr>';
    //Fetch and print all the records:
    while($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
        echo '<tr>'
           . '<td align="left"><a href="edit_user.php?id='.$row['user_id'].
                '">Edit</a></td>
              <td align="left"><a href="delete_user.php?id='.$row['user_id'].
                '">Delete</a></td>
              <td align="left">'.$row['last_name'].'</td>
              <td align="left">'.$row['first_name'].'</td>
              <td align="left">'.$row['dr'].'</td>
              </tr>';
    }
    echo '</table>'; //close the table.
    mysqli_free_result($r); //Free up the resources.
}else { //If it did not run OK.
    //Public message:
    echo '<p class="error">The current users could not be retrieved.</p>';
    //Debugging message:
    echo '<p>'.mysqli_error($dbc).'<br /><br />Query:'.$q.'</p>';
}//End of if ($r) IF.
mysqli_close($dbc);
include ('include/footer.html');
?>        

