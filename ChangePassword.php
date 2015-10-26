<?PHP
	session_start();
	// Create connection to Oracle
	$conn = oci_connect("system", "131137", "//localhost/XE");
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	} 
?>
Change Password form
<hr>

<?PHP
	if(isset($_POST['ChangeSubmit'])){
		$username = trim($_POST['username']);
		$oldpassword = trim($_POST['oldpassword']);
		$newpassword = trim($_POST['newpassword']);
		$confirm = trim($_POST['confirmpassword']);
		if($confirm == $newpassword){
			$query = "SELECT * FROM EMPLOYEES WHERE username='$username' and password='$oldpassword'";
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
			echo "Login fail.";
			// Fetch each row in an associative array
			$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
			if($row){
				$query1 = "UPDATE EMPLOYEES SET password='$newpassword' WHERE password='$oldpassword'";
				$parseRequest = oci_parse($conn, $query);
				oci_execute($parseRequest);
				echo '<script>window.location = "MemberPage.php";</script>';
			}
			else
			{
				echo "Change Password Fail.";
			}
		}
		else
		{
			echo "Change Password Fail.";
		}
	};
	oci_close($conn);
?>

<form action='ChangePassword.php' method='post'>
	Username <br>
	<input name='username' type='input'><br>
	OldPassword<br>
	<input name='oldpassword' type='password'><br><br>
	NewPassword<br>
	<input name='newpassword' type='password'><br><br>
	ConfirmPassword<br>
	<input name='confirmpassword' type='password'><br><br>
	<input name='ChangeSubmit' type='submit' value='Login'>
</form>