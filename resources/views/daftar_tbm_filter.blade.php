@extends('layouts')
@section('content')
<!-- content -->
<div class="bg-white">
	<div class="box-container" id="box-container">
		<div class="title-content">
			<h1>Daftar TBM</h1>
			<div class="center-line"></div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="pull-left">
						@if(!empty(g('provinsi')))
							<p>Jumlah Total TBM Adalah ({{total_tbm(g('provinsi'),'provinsi')}}) TBM</p>
						@else
							<p>Jumlah Total TBM Adalah ({{total_tbm('all')}}) TBM</p>
						@endif
					</div>
					<div class="pull-right">
						<form>
							<div class="group-search">
								<input type="text" name="q" class="form-control radius" placeholder="Cari...">
								<i class="fas fa-search icon-search"></i>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="row box-list-tbm">
				@foreach($dataLokasi as $item)
				<div class="col-sm-4">
					@if(Request::get('provinsi'))
					<a href="{{url('tbm?provinsi='.Request::get('provinsi').'&kota='.$item->id)}}">
						<div class="box-tbm">
							<h4>{{$item->value}}</h4>
							<h4 class="color-blue">({{total_tbm($item->id,'kota')}} TBM)</h4>
						</div>
					</a>
					@else
					<a href="{{url('tbm?provinsi='.$item->id)}}">
						<div class="box-tbm">
							<h4>{{$item->value}}</h4>
							<h4 class="color-blue">({{total_tbm($item->id,'provinsi')}} TBM)</h4>
						</div>
					</a>
					@endif
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
@endsection