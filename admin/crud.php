<?php
	//Connection Database
	$con = mysqli_connect("localhost","sms","smsbase$555","sms");
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	switch ($_POST['type']) {
		
		//Tampilkan Data 
		case "get":
			
			$SQL = mysqli_query($con, "SELECT * FROM siswa WHERE nis='".$_POST['nis']."'");
			$return = mysqli_fetch_array($SQL,MYSQLI_ASSOC);
			echo json_encode($return);
			break;
		
		// Tambah data siswa baru	
		case "new":
			
			$SQL = mysqli_query($con, 
									"INSERT INTO siswa SET  
										nis='".$_POST['nis']."', 
										nama='".$_POST['nama']."', 
										kelas='".$_POST['kelas']."',
										telepon='".$_POST['telepon']."'
								");
			if($SQL){
				echo json_encode("OK");
			}
			break;
			
		//Edit Data	siswa
		case "edit":
			
			$SQL = mysqli_query($con, 
									"UPDATE siswa SET 
										nama='".$_POST['nama']."', 
										kelas='".$_POST['kelas']."',
										telepon='".$_POST['telepon']."'
									WHERE nis='".$_POST['nis']."'
								");
			if($SQL){
				echo json_encode("OK");
			}			
			break;
			
		//Hapus Data siswa	
		case "delete":
			
			$SQL = mysqli_query($con, "DELETE FROM siswa WHERE nis='".$_POST['nis']."'");
			if($SQL){
				echo json_encode("OK");
			}			
			break;

	} 
	
?>