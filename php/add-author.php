
<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

	# Database Connection File
	include "../db_conn.php";


    /**   check if author  name is submitted**/
	if (isset($_POST['author_name'])) {
		// /** 
		// Get data from POST request  and store it in var
		$name = $_POST['author_name'];

		#simple form Validation
		if (empty($name)) {
			$em = "Tên tác giả chưa được nhập";
			header("Location: ../add-author.php?error=$em");
            exit;
		}else {
			# Insert Into Database
			$sql  = "INSERT INTO authors (name)
			         VALUES (?)";
			$stmt = $conn->prepare($sql);
			$res  = $stmt->execute([$name]);


		     if ($res) {
		     	# success message
		     	$sm = "Thêm thành công";
				header("Location: ../add-author.php?success=$sm");
	            exit;
		     }else{
		     	# Error message
		     	$em = "Thêm thất bại";
				header("Location: ../add-author.php?error=$em");
	            exit;
		     }
		}
	}else {
      header("Location: ../admin.php");
      exit;
	}

}else{
  header("Location: ../login.php");
  exit;
}