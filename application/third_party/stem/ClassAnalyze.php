<?php
require_once APPPATH . 'third_party/stem/ClassNazief.php';
Class Analyze{
	var $data; //data latih komentar
	var $input; //stem2an data uji
	var $token; //list item kata
	var $use; //data analisa yg digunakan (data uji + data latih)
	var $tf;
	var $df;
	var $bobot;

	public function __construct(){
		ini_set('max_execution_time', 0); 
		ini_set('LSAPI_MAX_PROCESS_TIME', 0); 
$host = "localhost";
$port = "3306";
$dbname = "skp";
$dbuser = "root";
$dbpass = "";
$db = new PDO('mysql:host='.$host.';port='.$port.';dbname='.$dbname.';charset=utf8', $dbuser, $dbpass);
if(isset($_GET['persen']))
{
	$persen = $_GET['persen'];
	$sql = $db->query("SELECT* FROM ( SELECT skripsi_komentar.*, @counter := @counter +1 AS counter FROM (select @counter:=0) AS initvar, skripsi_komentar ORDER BY `no` DESC ) AS X where counter <= (100/100 * @counter) ORDER BY `no` DESC");
} else {
	$sql = $db->query("SELECT * FROM vw_komentar");
}		
		$arr = array();
		$no = 0;
		foreach($sql as $row){
			$arr[$no]['komentar'] = $row['komentar'];
			$pecah = explode(",",$row['stem']);
			foreach($pecah as $pc){
				$arr[$no]['stem'][] = trim($pc);
			}
			$arr[$no]['sentimen'] = $row['sentimen'];
			$no++;
		}
		$this->data = $arr;
		$this->sql = $sql;
	}

	public function stem($string){
		global $naz;
		$naz = new Nazief();
		$input = filter_var(strtolower($string), FILTER_SANITIZE_STRING);
		$result = preg_replace("/[^a-zA-Z ]/", "", $input);
		$pecah = explode(" ",$result);
		foreach($pecah as $item){
			if(strlen($item) > 0){
				$this->input[] = $naz->nazief($item);
			}
		}
	}


	public function stopword(){
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

		foreach($this->input as $inp){
			if(!in_array($inp, $stopword)){
				$saved[] = $inp;
			}
		}
		$this->input = $saved;
	}

	public function get_data_latih(){
		//cari di $data[]['stem'] yang arraynya intersect dengan array ini
		$use = array();
		$sip = 0;
		$n = 1;
		foreach($this->data as $row){
			if(count(array_intersect($row['stem'], $this->input)) > 0){
				//ada
				//$use["no"][$n] = $row['no'];
				$use["komentar"][$n] = $row['komentar'];
				$use["stem"][$n] = $row['stem'];
				$use["sentimen"][$n] = $row['sentimen'];
				$n++;
			}
			$sip++;
		}

		//tweak penyesuaian
		//$use["no"][0] = null;
		$use["komentar"][0] = null;
		$use["stem"][0] = $row['stem'];
		$use["sentimen"][0] = null;
		$use["nume"][0] = $this->input;

		$this->use = $use;
	}

	public function create_token(){
		foreach($this->use['stem'] as $tk){
			foreach($tk as $itm){
				$token[] = $itm;
			}
		}
		$token = array_unique($token);
		$this->token = $token;
	}

	public function create_tokend(){
		foreach($this->use['nume'] as $tkd){
			foreach($tkd as $itmd){
				$tokend[] = $itmd;
			}
		}
		$tokend = array_unique($tokend);
		$this->tokend = $tokend;
	}

	public function cari_tf(){
		foreach($this->token as $kata){
			foreach($this->use['stem'] as $key=>$value){
				$val = array_count_values($value);
				if(isset($val[$kata]))
					$tf[$kata][$key] = $val[$kata];
				else
					$tf[$kata][$key] = 0;
			}
		}
		$this->tf = $tf;
	}

	public function cari_df(){
		foreach($this->tf as $key=>$value){
			$df = 0;
			$n = count($value);
			for($i=1; $i<$n; $i++){
				if($value[$i] > 0)
					$df++;
			}
			$this->df[$key] = $df;
		}
	}

	
	public function hitung_bobot(){
		$jumlahdata = count($this->use['komentar'])-1;
		$idf = array();
		foreach($this->tf as $kk=>$vv){
			$ddf[$kk] = ($this->df[$kk] == 0) ? 1 : ($jumlahdata / $this->df[$kk]);
			$idf[$kk] = log10($ddf[$kk]);
		}


		$bobot = array();
				foreach($this->token as $kata){
			foreach($this->use['stem'] as $key=>$value){
				$val = array_count_values($value);
				if(isset($val[$kata]))
					
					$bobot[$kata][$key] = $val[$kata]*$idf[$kata];
				
				else
					$bobot[$kata][$key] = 0;
			}
		}
//start positif
$s= array_keys($this->use['sentimen'], "1");
$sumArray = array();
foreach ($s as $kata) {
foreach ($bobot as $k=>$subArray) {
  foreach ($subArray as $id=>$value) {
  	if ($id == $kata) {
  		$sumArray[$k]+=$value;
  	}
    
  }
}
}

$xy = count($this->use['sentimen'])-1;
$yzf =count(array_keys($this->use['sentimen'], "1"));
foreach($this->tokend as $kata){
	$tot[$kata] = ($sumArray[$kata] + 1) / ($yzf+$xy);
}

$temp = 1;
foreach($tot as $key => $value) {
$temp *= $value;
}
$nbc = $temp*0.5;
//end positif

//start negatif
$sn= array_keys($this->use['sentimen'], "0");
$sumArrayn = array();
foreach ($sn as $kata) {
foreach ($bobot as $k=>$subArray) {
  foreach ($subArray as $id=>$value) {
  	if ($id == $kata) {
  		$sumArrayn[$k]+=$value;
  	}
    
  }
}
}
$xy = count($this->use['sentimen'])-1;
$yz =count(array_keys($this->use['sentimen'], "0"));
foreach($this->tokend as $kata){
	$totn[$kata] = ($sumArrayn[$kata] + 1) / ($yz+$xy);
}

$tempn = 1;
foreach($totn as $key => $value) {
$tempn *= $value;
}
$nbcn = $tempn*0.5;
//end negatif

if ($nbc>$nbcn) {
	$res = 1;
  } else {
	$res = 0;
  }

		$this->bobot = $bobot;
		$this->idf = $idf;
		$this->nbc = $nbc;
		$this->nbcn = $nbcn;
		$this->$res = $res;
	}

	public function hitung_jarak(){


	}		

	public function single_process($kalimat, $debug=false){
		//clear old variable
		$this->input = $this->token = $this->use = $this->tf = $this->df = $this->bobot = null;

		$this->stem($kalimat);

		$this->stopword();
		$this->get_data_latih();
		$this->create_token();
		$this->create_tokend();

		$this->cari_tf();
		$this->cari_df();
		$this->hitung_jarak();

		$this->hitung_bobot();

		//$this->kmeans();
	}

		public function jarak_hasil_ke_pusat(){
		$pusat = $this->pusat;
		$bobot = $this->df[0];
		return abs(6 - $bobot);
	}

}