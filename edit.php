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
	$u_project_type = $row['u_project_type'];
	
	$msg = "";
	//$image = $_FILES['image']['name'];
	//$target = "upload_images/".basename($image);

	//if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
  	//	$msg = "Image uploaded successfully";
  	//}else{
  	//	$msg = "Failed to upload image";
  	//}
	  $insert_data = "INSERT INTO student_data(u_card, u_f_name, u_l_name,u_email, u_phone, project_type) VALUES ('$u_card','$u_f_name','$u_l_name','$u_email','$u_phone','$u_project_type')";
  	$run_data = mysqli_query($con,$insert_data);

	if($run_update){
		header('location:index.php');
	}else{
		echo "Data not update";
	}
}

?>