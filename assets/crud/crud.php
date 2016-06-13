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
		
		//Absen	
		case "absen":
			
			$tanggal = date("D,d-m-Y");
			$jam = date("G:i:s");
			$absen = "Yth.Orantua/Wali dari ".$_POST['nama'].", hari ini tidak menghadiri sekolah dengan keterangan ".$_POST['kehadiran']."";
			$SQL = mysqli_query($con, 
									"INSERT INTO outbox SET  
										CreatorID='".$_POST['type']."', 
										InsertIntoDB=NOW(), 
										DestinationNumber='".$_POST['telepon']."',
										TextDecoded='".$absen."'
								");
			if($SQL){
				$laporan = mysqli_query($con, /*SQL untuk tabel laporan*/
									"INSERT INTO kehadiran SET  
										kehadiran='".$_POST['kehadiran']."', 
										tanggal='".$tanggal."',
										jam='".$jam."', 
										nis='".$_POST['nis']."'
								");
				echo json_encode($laporan);
			}
			break;
		//Pelanggaran	
		case "pelanggaran":
			
			$tanggal = date("D,d-m-Y");
			$jam = date("G:i:s");
			$pelanggaran = "Yth.Orantua/Wali dari ".$_POST['nama'].", hari ini melakukan pelanggaran disiplin sekolah dengan jenis pelanggaran ".$_POST['jenis']." dengan poin sebesar ".$_POST['poin']."";
			$SQL = mysqli_query($con, 
									"INSERT INTO outbox SET  
										CreatorID='".$_POST['type']."', 
										InsertIntoDB=NOW(), 
										DestinationNumber='".$_POST['telepon']."',
										TextDecoded='".$pelanggaran."'
								");
			if($SQL){
				$laporan = mysqli_query($con, /*SQL untuk tabel laporan*/
									"INSERT INTO pelanggaran SET  
										poin='".$_POST['poin']."', 
										jenis='".$_POST['jenis']."', 
										tanggal='".$tanggal."',
										nis='".$_POST['nis']."'
								");
				echo json_encode($laporan);
			}
			break;
		//Izin	
		case "izin":
			
			$jam = date("G:i:s");
			$tanggal = date("D,d-m-Y");
			$alasan = "Yth.Orantua/Wali dari ".$_POST['nama'].", hari ini meminta izin untuk ".$_POST['alasan']."";
			$SQL = mysqli_query($con, 
									"INSERT INTO outbox SET  
										CreatorID='".$_POST['type']."', 
										InsertIntoDB=NOW(), 
										DestinationNumber='".$_POST['telepon']."',
										TextDecoded='".$alasan."'
								");
			if($SQL){
				$laporan = mysqli_query($con, /*SQL untuk tabel laporan*/
									"INSERT INTO izin SET  
										alasan='".$_POST['alasan']."', 
										tanggal='".$tanggal."',
										nis='".$_POST['nis']."'
								");
				echo json_encode($laporan);
			}
			break;
		//informasi	
		case "informasi":
			
			$tanggal = date("d-m-y");
			$isipesan = "Yth.Orantua/Wali dari ".$_POST['nama'].",".$_POST['isipesan']."";
			$SQL = mysqli_query($con, 
									"INSERT INTO outbox SET  
										CreatorID='".$_POST['type']."', 
										InsertIntoDB=NOW(), 
										DestinationNumber='".$_POST['telepon']."',
										TextDecoded='".$isipesan."'
								");
			if($SQL){
				$laporan = mysqli_query($con, /*SQL untuk tabel laporan*/
									"INSERT INTO informasi SET  
										isipesan='".$isipesan."', 
										nis='".$_POST['nis']."'
								");
				echo json_encode($laporan);
			}
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