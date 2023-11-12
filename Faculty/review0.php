<?php
include('config.php');

$id = $_GET['id'];

if(isset($_POST['submit']))
{
	$u_card = $_POST['card_no'];
	$u_phone = $_POST['user_phone'];
	$u_project_type = $_POST['project_type'];
    $review_0 = $_POST['u_review_0'];
	

	$update = "UPDATE student_data SET review_0 = '$review_0' WHERE id=$id";
	$run_update = mysqli_query($con,$update);

	if ($run_update) {
		header('location:index.php');
	} else {
		echo "Data not updated. Error: " . mysqli_error($con);
	}
}

?>