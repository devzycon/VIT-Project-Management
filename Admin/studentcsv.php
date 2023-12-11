<?php
require_once 'lib/Database.php';

$database = new Database();
$query = "SELECT * FROM admission.student_data";
$result = $database->pdo->query($query);

$csvContent = "id,std_id,std_fname,std_lname,std_email,std_phone,project_type,review_0,f_id\n";

while($row = $result->fetch(PDO::FETCH_ASSOC)){
    $csvContent .= $row['id'] . ',' . $row['u_card'] . ',' . $row['u_f_name'] . ',' . $row['u_l_name'] . ',' . $row['u_email'] . ',' . $row['u_phone'] . ',' . $row['u_project_type'] . ',' . $row['review_0'] . ',' . $row['faculty_id'] . "\n";
}

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="students.csv" ');


echo $csvContent;