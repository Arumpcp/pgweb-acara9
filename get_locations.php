<?php 
// Sesuaikan dengan setting MySQL 
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "acara_9"; 

// Create connection 
$conn = new mysqli($servername, $username, $password, $dbname); 

// Check connection 
if ($conn->connect_error) { 
die("Connection failed: " . $conn->connect_error); 
} 
$sql = "SELECT * FROM locations"; 
$result = $conn->query($sql); 
if ($result->num_rows > 0) { 
echo "<table border='1px'><tr> 
<th>id</th> 
<th>name</th> 
<th>latitude</th> 
<th>longitude</th>"; 

// output data of each row 
while($row = $result->fetch_assoc()) { 
echo 
"<tr>
<td>".$row["id"]."</td>
<td>".$row["name"]."</td>
<td>".$row["latitude"]."</td>
<td>".$row["longitude"]."</td>
</tr>"; 
} 
echo "</table>"; 
} else { 
echo "0 results"; 
} 
$conn->close(); 
?>
