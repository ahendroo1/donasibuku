@extends('crudbooster::admin_template')
@section('content')
<?php
	$tbm = DB::table('tbm')->get();
	$donatur = DB::table('donatur')->get();
	$total_buku = DB::table('donasi_item')->sum('qty');
	// function TotalData($year,$month){
 //        $datas = DB::table('donasi')
 //        ->select('donasi.*',
 //            DB::raw('(SELECT SUM(qty) FROM donasi_item WHERE id_donasi = donasi.id) AS total_buku'),
 //            DB::raw("DATE_FORMAT(tgl_donasi, '%m-%Y') new_date"),
 //            DB::raw("DATE_FORMAT(tgl_donasi, '%m') month"),
 //            DB::raw('YEAR(tgl_donasi) year, MONTH(tgl_donasi) month')
 //        )
 //        ->get();
 //        $total_buku = 0;
 //        foreach ($datas as $y) {
 //            if($y->month == $month && $y->year == $year){
 //                $total_buku += $y->total_buku;
 //            }
 //        }

 //        return $total_buku;
 //    }
?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<link rel="stylesheet" type="text/css" href="{{asset('assets/style.css')}}">
<div class="row">
	<div class="col-md-4 col-xl-12">
		<div class="mini-stat clearfix bg-white">
			<span class="mini-stat-icon bg-muted"><i class="fa fa-user text-white"></i></span>
			<div class="mini-stat-info text-right text-muted">
				<span class="counter text-warning"><b>{{count($tbm)}}</b></span>
				Jumlah TBM
			</div>
		</div>
	</div>
	<div class="col-md-4 col-xl-12">
		<div class="mini-stat clearfix bg-success">
			<span class="mini-stat-icon bg-white"><i class="fa fa-users text-success"></i></span>
			<div class="mini-stat-info text-right text-white">
				<span class="counter text-white"><b>{{count($donatur)}}</b></span>
				Jumlah Donatur
			</div>
		</div>
	</div>
	<div class="col-md-4 col-xl-12">
		<div class="mini-stat clearfix bg-info">
			<span class="mini-stat-icon bg-white"><i class="fa fa-book text-info"></i></span>
			<div class="mini-stat-info text-right text-white">
				<span class="counter text-white">{{number_format($total_buku)}}</span>
				Jumlah Buku Di Donasikan
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12 col-xl-12">
		<div class="mini-stat clearfix bg-white">
			<div class="btn-group btn-custom-group pull-right">
				<a class="caret-drop-down dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><span class="text-info-custom" id="change-year">{{date('Y')}}</span> <span class="caret"></span></a>
				<ul class="dropdown-menu drop-custom" role="menu">
					<?php
						for ($i=2016; $i <= 2020; $i++) { 
							echo '<li><a href="javascript:void(0)" onclick="doRefresh('.$i.')">'.$i.'</a></li>';
						}
					?>
				</ul>
			</div>
			<div id="container"></div>
		</div>
	</div>
</div>
@push('scripts')
    <script type="text/javascript">
		$(document).ready(function() {
			getChart();
		});
		function getChart(year){
			if(year == null){
				year = '{{date("Y")}}';
			}else{
				year = year;
			}
			var options = {
		        chart: {
		            renderTo: 'container',
		            type: 'line'
		        },
		        title: {
			        text: 'Grafik Donasi Buku / Bulan'
			    },
			    subtitle: {
			        text: ''
			    },
			    xAxis: {
			        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
			    },
			    yAxis: {
			        title: {
			            text: 'Quantity (Pcs)'
			        }
			    },
			    plotOptions: {
			        line: {
			            dataLabels: {
			                enabled: true
			            },
			            enableMouseTracking: true
			        }
			    },
		        series: [{}]
		    };
		    
		    var url =  "{{url('data-json')}}?year="+year;
		    $.getJSON(url,  function(data) {
		    	options.series[0].name = "Buku";
		        options.series[0].data = data;
		        var chart = new Highcharts.Chart(options);
		    });
		}
		function doRefresh(year){
			getChart(year);
			$('#change-year').html(year);
		}
    </script>
@endpush
@endsection