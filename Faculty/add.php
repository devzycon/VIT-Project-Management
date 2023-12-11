<?php

include('config.php');

if(isset($_POST['submit'])){
	$u_card = $_POST['card_no'];
	$u_f_name = $_POST['user_first_name'];
	$u_l_name = $_POST['user_last_name'];
	$u_email = $_POST['user_email'];
	$u_phone = $_POST['user_phone'];
	$u_project_type = isset($u_project_type) ? $u_project_type : ""; 
	$project_name = $POST['projectName'];
	$review_0 = $_POST['u_review_0'];

	  $insert_data = "INSERT INTO student_data(u_card, u_f_name, u_l_name,u_email, u_phone, project, review_0,project_name) VALUES ('$u_card','$u_f_name','$u_l_name','$u_email','$u_phone','$u_project_type','$project_name' )";
  	$run_data = mysqli_query($con,$insert_data);

  	if($run_data){
		  $added = true;
  	}else{
  		echo "Data not insert";
  	}

}

?>