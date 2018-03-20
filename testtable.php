<!DOCTYPE html>
<html lang="en">

<head>
	

</head>

<body>

	<div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Node ID</th>
                  <th>Location</th>
                  <th>Distance from Location (ft)</th>
                </tr>
              </thead>
              <!-- <tfoot>
                <tr>
                  <th>Name</th>
                  <th>Position</th>
                  <th>Office</th>
                  <th>Age</th>
                  <th>Start date</th>
                  <th>Salary</th>
                </tr>
               </tfoot>-->
              <tbody>
<?php
$servername = "testehealth2.cnm1zt3zgdr0.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "adminpass";
$dbname = "E_Health_Fall_2017_2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";


$sql = "SELECT tbl2.ID, tbl2.distance, accessPoints_test.location FROM
  (
  SELECT tbl.ID, tbl.MAC, tbl.distance, tbl.time_2 FROM test3 tbl
  INNER JOIN
  (
    SELECT ID, MIN(distance) minDistance FROM test3 
        WHERE time_2 >= (SELECT max(time_2) - interval 1 minute FROM test3)
        GROUP BY ID
  )tbl1
  ON tbl1.ID=tbl.ID
  WHERE tbl1.minDistance=tbl.distance
                  )tbl2
JOIN accessPoints_test ON tbl2.MAC = accessPoints_test.mac
GROUP BY ID";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo'<tr>
                  <td scope="row">' . $row["ID"]. '</td>
                  <td>' . $row["location"] .'</td>
                  <td> '.$row["distance"] .'</td>
              </tr>';
    }
} else {
    echo "0 results";
}




$conn->close();
?>
			</tbody>
        </table>
    </div>
</body>
</html>