<?php
include('config.php');

$id = $_GET['id'];

if(isset($_POST['submit']))
{
	$u_card = $_POST['card_no'];
	$u_f_name = $_POST['user_first_name'];
	$u_l_name = $_POST['user_last_name'];
	$u_email = $_POST['user_email'];
	$u_phone = $_POST['user_phone'];
	$u_project_type = $_POST['project_type'];
	

	$update = "UPDATE student_data SET u_card='$u_card', u_f_name = '$u_f_name', u_l_name = '$u_l_name', u_email = '$u_email', u_phone = '$u_phone',u_project_type= '$u_project_type' WHERE id=$id";
	$run_update = mysqli_query($connection,$update);

	if($run_update){
		header('location:index.php');
	}else{
		echo "Data not update";
	}
}

?>