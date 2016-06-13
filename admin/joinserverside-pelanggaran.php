<?php
		function mysqliConnection()
			{		
				// Database connection information
				$gaSql['user']     = 'sms';
				$gaSql['password'] = 'smsbase$555';   
				$gaSql['db']       = 'sms';  //Database
				$gaSql['server']   = 'localhost';   
				$gaSql['port']     = 3306; // 3306 is the default MySQL port
				$gaSql['charset']  = 'utf8';
				$db = new mysqli($gaSql['server'], $gaSql['user'], $gaSql['password'], $gaSql['db'], $gaSql['port']);
				if (mysqli_connect_error()) {
					die( 'Error connecting to MySQL server (' . mysqli_connect_errno() .') '. mysqli_connect_error() );
				}
				
				if (!$db->set_charset($gaSql['charset'])) {
					die( 'Error loading character set "'.$gaSql['charset'].'": '.$db->error );
				}
				return $db;
			}
			
		function Paging( $input )
			{
				$sLimit = "";
				if ( isset( $input['iDisplayStart'] ) && $input['iDisplayLength'] != '-1' ) {
					$sLimit = " LIMIT ".intval( $input['iDisplayStart'] ).", ".intval( $input['iDisplayLength'] );
				}
				
				return $sLimit;
			}
			
			
		function Ordering( $input, $aColumns )
			{
				$aOrderingRules = array();
				if ( isset( $input['iSortCol_0'] ) ) {
					$iSortingCols = intval( $input['iSortingCols'] );
					for ( $i=0 ; $i<$iSortingCols ; $i++ ) {
						if ( $input[ 'bSortable_'.intval($input['iSortCol_'.$i]) ] == 'true' ) {
							$aOrderingRules[] =
							$aColumns[ intval( $input['iSortCol_'.$i] ) ]." "
							.($input['sSortDir_'.$i]==='asc' ? 'asc' : 'desc');
						}
					}
				}
				
				if (!empty($aOrderingRules)) {
					$sOrder = " ORDER BY ".implode(", ", $aOrderingRules);
					} else {
					$sOrder = "";
				}
				return $sOrder;
			}
			
		function Filtering( $aColumns, $iColumnCount, $input, $db )
			{
				if ( isset($input['sSearch']) && $input['sSearch'] != "" ) {
					$aFilteringRules = array();
					for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
						if ( isset($input['bSearchable_'.$i]) && $input['bSearchable_'.$i] == 'true' ) {
							$aFilteringRules[] = $aColumns[$i]." LIKE '%".$db->real_escape_string( $input['sSearch'] )."%'";
						}
					}
					if (!empty($aFilteringRules)) {
						$aFilteringRules = array('('.implode(" OR ", $aFilteringRules).')');
					}
				}
				
				// Individual column filtering
				for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
					if ( isset($input['bSearchable_'.$i]) && $input['bSearchable_'.$i] == 'true' && $input['sSearch_'.$i] != '' ) {
						$aFilteringRules[] = $aColumns[$i]."  LIKE '%".$db->real_escape_string($input['sSearch_'.$i])."%'";
					}
				}
				
				if (!empty($aFilteringRules)) {
					$sWhere = "WHERE ".implode(" AND ", $aFilteringRules);
					} else {
					$sWhere = "WHERE 1=1 ";
				}
				return $sWhere;
			}
			

	mb_internal_encoding('UTF-8');
	$aColumns = array('k.id','a.nis','a.nama','a.kelas','k.poin','k.tanggal','k.jenis', 'k.nis'); //Kolom Pada Tabel
	
	// Indexed column (used for fast and accurate table cardinality)
	$sIndexColumn = 'id';
	
	// DB table to use
	$sTable = 'pelanggaran'; // Nama Tabel
	$sTable2 = 'siswa'; // Nama Tabel
	/*$sTable3 = 'all_provinsi';*/ // Nama Tabel
	
	
	// Input method (use $_GET, $_POST or $_REQUEST)
	$input =& $_POST;

	
	$iColumnCount = count($aColumns);
	
	$db = mysqliConnection();
	$sLimit = Paging( $input );
	$sOrder = Ordering( $input, $aColumns );
	$sWhere = Filtering( $aColumns, $iColumnCount, $input, $db );
	
	$aQueryColumns = array();
	foreach ($aColumns as $col) {
		if ($col != ' ') {
			$aQueryColumns[] = $col;
		}
	}
	
	$sQuery = "
    SELECT SQL_CALC_FOUND_ROWS k.id, a.nis ,a.nama, a.kelas, k.poin, k.tanggal,k.jenis, k.nis
    FROM ".$sTable." AS k 
	inner join ".$sTable2." AS a  on
	k.nis=a.nis
	".$sWhere.$sOrder.$sLimit;
	
	
	$rResult = $db->query( $sQuery ) or die($db->error);
	// Data set length after filtering
	$sQuery = "SELECT FOUND_ROWS()";
	$rResultFilterTotal = $db->query( $sQuery ) or die($db->error);
	list($iFilteredTotal) = $rResultFilterTotal->fetch_row();
	
	// Total data set length
	$sQuery = "SELECT COUNT(k.".$sIndexColumn.") FROM ".$sTable." AS k INNER JOIN ".$sTable2." AS a ON k.nis = a.nis";
	$rResultTotal = $db->query( $sQuery ) or die($db->error);
	list($iTotal) = $rResultTotal->fetch_row();
	
	/**
		* Output
	*/
	$output = array(
    "sEcho"                => intval($input['sEcho']),
    "iTotalRecords"        => $iTotal,
    "iTotalDisplayRecords" => $iFilteredTotal,
    "aaData"               => array(),
	);
	
	// Looping Data
	while ( $aRow = $rResult->fetch_assoc() ) {
		$row = array();
		$btn = '<a href="#" onClick="showModalsdata(\''.$aRow['id'].'\')">Edit</a> | <a href="#" onClick="deleteUser(\''.$aRow['id'].'\')">delete</a>';
		$row = array( $aRow['nis'],$aRow['nama'],$aRow['kelas'],$aRow['poin'],$aRow['tanggal'],$aRow['jenis']);
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );
?>