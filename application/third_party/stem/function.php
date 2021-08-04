<?php
require_once APPPATH . 'third_party/stem/ClassNazief.php';
function create_alert($type, $pesan, $header=null){
	$_SESSION['adm-type'] = $type;
	$_SESSION['adm-message'] = $pesan;

	if($header!==null){
		header("location:".$header);
		exit();
	}
}

function stem($string){
	global $naz;
	$naz = new Nazief();
	$input = filter_var(strtolower($string), FILTER_SANITIZE_STRING);
	$result = preg_replace("/[^a-zA-Z ]/", "", $input);
	$pecah = explode(" ",$result);
	$out = array();
	foreach($pecah as $item){
		if(strlen($item) > 0){
			$out[] = $naz->nazief($item);
		}
	}
	$host = "localhost";
	$port = "3306";
	$dbname = "skp";
	$dbuser = "root";
	$dbpass = "";
	$db = new PDO('mysql:host='.$host.';port='.$port.';dbname='.$dbname.';charset=utf8', $dbuser, $dbpass);
		$sql = $db->query("SELECT stopword FROM stopword_list");
		foreach($sql as $row){
			$stopword[] = $row['stopword'];
		}
	
		foreach($out as $inp){
			if(!in_array($inp, $stopword)){
				$saved[] = $inp;
			}
		}
		return $saved;
}

function show_alert(){
	if(isset($_SESSION['adm-type'])){
		$type = ucfirst($_SESSION['adm-type']);
		unset($_SESSION['adm-type']);
		$message = $_SESSION['adm-message'];
		unset($_SESSION['adm-message']);

		return 'alertify.alert("'.$type.'", "'.$message.'")';
	}
}

function is_same($a, $b, $out=""){
	if($a == $b){
		echo $out;
	}
}

function quote($txt){
	global $db;
	$qry = $db->quote($txt);
	return $qry;
}



function get_setting($param){
	$sql = query("SELECT * FROM skripsi_setting WHERE param = ".quote($param));
	if($sql->rowCount() > 0){
		//setting ketemu
		$row = $sql->fetch();
		return $row['value'];
	}
	return false;
}

function change_setting($param,$newvalue){
	$sql = query("UPDATE skripsi_setting SET value = ".quote($newvalue)." WHERE param = ".quote($param));
	return true;
}


function dump($arr, $hei = 300){
	echo "<textarea style='width:100%; height:".$hei."px;'>";
	var_dump($arr);
	echo "</textarea>";
}


function get_extension($filename){
	$exp = explode(".",$filename);
	$n = count($exp);
	return strtolower($exp[$n-1]);
}

function indo_date($tgl, $type="half"){
	$month = array(
		"", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"
	);

	$tahun = date("Y",strtotime($tgl));
	$bulan = $month[date("n",strtotime($tgl))];
	$tanggal = date("d",strtotime($tgl));

	$fullDate = "$tanggal $bulan $tahun";

	if($type <> "half"){
		$jam = date("H:i:s", strtotime($tgl));
		return $fullDate." ".$jam;
	}
	return $fullDate;
}
