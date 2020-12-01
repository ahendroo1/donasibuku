<?php 

if(!function_exists('get_dateformat')) {
	function get_dateformat($datetime,$sort=NULL,$space=' ') {

		if ($datetime =="000-00-00 00:00:00") {
			return $datetime;
		}

		$tgl = substr($datetime, 8, 2);
		$bln = substr($datetime, 5, 2);
		if ($bln == "01" || $bln == "02" || $bln == "03" || $bln == "04" || $bln == "05" || $bln == "06" || $bln == "07" || $bln == "08" || $bln == "09") {
			$bln_n = substr($bln, -1);
		}else{
			$bln_n = $bln;
		}
	  
		if ($sort == NULL) {
			$array_bulan = array(1=>"Januari","Februari","Maret", "April", "Mei", "Juni","Juli","Agustus","September","Oktober", "November","Desember");
		}else{
			$array_bulan = array(1=>"Jan","Feb","Mar", "Apr", "Mei", "Jun","Jul","Agust","sept","Okt", "Nov","Des");
		}

		if ($bln_n == '-' || $bln_n == '0' || $bln_n == '00' || empty($bln_n)) {
			$bulan = '';
		}else{
			$bulan = $array_bulan[$bln_n];
		}

		$tahun = substr($datetime, 0, 4);

		$show_date = $tgl.$space.$bulan.$space.$tahun;
		return $show_date;

	}
}



if(!function_exists('no_donasi')) {
	function no_donasi()
	{

		$donasi = DB::table('donasi')->where('no_donasi','LIKE','TBM'.date('Ymd').'%')->orderBy('id','DESC')->first();

		if($donasi) 
		{
			$urut     = substr($donasi->no_donasi, 11);
			$no_donasi = 'TBM'.date('Ymd').sprintf("%04s",$urut+ 1);
 		} else {
			$no_donasi = 'TBM'.date('Ymd').'0001';
		}
		return $no_donasi;
	}
}

if(!function_exists('total')) {
	function total($id)
	{

		$donasi_item = DB::table('donasi_item')->where('id_donasi',$id)->get();

		$total = 0;
		foreach ($donasi_item as $item) {
			$harga_qty = $item->qty*$item->harga;
			$total     += $harga_qty;
		}
		return $total;
	}
}


if(!function_exists('total_item')) {
	function total_item($id)
	{

		$donasi_item = DB::table('donasi_item')->where('id_donasi',$id)->count();
		return $donasi_item;
	}
}


if(!function_exists('total_tbm')) {
	function total_tbm($id,$field='provinsi')
	{
		if ($id == 'all') {
			$tbm = DB::table('tbm')->where('setujui',1)->count();
		}else{
			$tbm = DB::table('tbm')->where($field,$id)->where('setujui',1)->count();
		}
		return $tbm;
	}
}



?>