<?php 
 
// Load the database file 
include('connect.php');
 
// Fetch records from database 
$query = $connection->query("SELECT * 
                             FROM user
                             INNER JOIN department ON department.DepartmentID=user.DepartmentID
                             INNER JOIN role ON role.RoleID=user.RoleID ORDER BY user.UserID ASC"); 
 
if($query->num_rows > 0){ 
    $delimiter = ","; 
    $filename = "users-data_" . date('Y-m-d') . ".csv"; 
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 
     
    // Set column headers 
    $fields = array('UserID', 'Name', 'Email', 'Department Name', 'Role'); 
    fputcsv($f, $fields, $delimiter); 
     
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = $query->fetch_assoc()){ 
        // $status = ($row['status'] == 1)?'Active':'Inactive'; 
        $lineData = array($row['UserID'], $row['Name'], $row['Email'], $row['DepartmentName'], $row['RoleName']); 
        fputcsv($f, $lineData, $delimiter); 
    } 
     
    // Move back to beginning of file 
    fseek($f, 0); 
     
    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
     
    //output all remaining data on a file pointer 
    fpassthru($f); 
} 
exit; 
 
?>