	@extends('layouts.main')

	@section('content')
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
			<div class="col-sm-6">
<!-- GANTI 1 -->
				<h1 class="m-0">Laporan Surat Jalan </h1>
			</div>
			<!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
<!-- GANTI 2 -->
				<li class="breadcrumb-item active">Laporan Surat Jalan </li>
				</ol>
			</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->
		<!-- Main content -->
		<div class="content">
			<div class="container-fluid">
			<div class="row">
				<div class="col-12">
				<div class="card">
					<div class="card-body">
						<form method="POST" action="{{url('jasper-surats-report')}}" target="_blank">
						@csrf
						<div class="form-group nowrap">
							<label><strong>Customer :</strong></label>
<!-- GANTI 2.1 -->
							<select name="kodec" id="kodec" class="form-control kodec" style="width: 200px">
								<option value="">--Pilih Customer--</option>
								@foreach($kodec as $kodecD)
									<option value="{{$kodecD->KODEC}}">{{$kodecD->KODEC}} {{$kodecD->NAMAC}}</option>
								@endforeach
							</select>
						</div>
						
						<!-- Filter Tanggal -->
						<div class="form-group row">
							<div class="col-md-3">
								<input class="form-control date tglDr" id="tglDr" name="tglDr"
								type="text" autocomplete="off" value="{{ now()->format('d-m-Y') }}"> 
							</div>
							<div>s.d.</div> 
							<div class="col-md-3">
								<input class="form-control date tglSmp" id="tglSmp" name="tglSmp"
								type="text" autocomplete="off" value="{{ now()->format('d-m-Y') }}">
							</div>

							<div class="col-md-1">
								<label><strong>Cabang :</strong></label>
								<select name="cbg" id="cbg" class="form-control cbg" style="width: 200px">
									<option value="">--Pilih Cabang--</option>
									@foreach($cbg as $cbgD)
										<option value="{{$cbgD->CBG}}"  {{ (session()->get('filter_cbg') == $cbgD->CBG) ? 'selected' : '' }}>{{$cbgD->CBG}}</option>
									@endforeach
								</select>
							</div>
						</div>
						
						
						<button class="btn btn-primary" type="button" id="filter" class="filter">Filter</button>
						<button class="btn btn-danger" type="button" id="resetfilter" class="resetfilter">Reset</button>
						<button class="btn btn-warning" type="submit" id="cetak" class="cetak">Cetak</button>
						</form>
						<div style="margin-bottom: 15px;"></div>
						<table class="table table-fixed table-striped table-border table-hover nowrap datatable">
							<thead class="table-dark">
								<tr>
<!-- GANTI 3 -->
									<th scope="col" style="text-align: center">#</th>
									<th scope="col" style="text-align: left">Bukti#</th>
									<th scope="col" style="text-align: left">Tgl</th>
									<th scope="col" style="text-align: left">SO#</th>
									<th scope="col" style="text-align: center">Kode</th>
									<th scope="col" style="text-align: left">Customer</th>
									<th scope="col" style="text-align: right">Total</th>
									<th scope="col" style="text-align: center">Notes</th>
								</tr>
							</thead>
							<tbody>
							</tbody> 
						</table>
					</div>
				</div>
				<!-- /.card -->
				</div>
			</div>
			<!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
	@endsection

	@section('javascripts')
	<script>
		$(document).ready(function() {
			
			$('.date').datepicker({  
				dateFormat: 'dd-mm-yy'
			}); 
			
//			fill_datatable();
// GANTI 3.1 SESUAI GANTI 2.1
			function fill_datatable( kodec = '' , tglDr = '', tglSmp = '' )
			{
				var dataTable = $('.datatable').DataTable({
					dom: '<"row"<"col-4">>fltip',
					lengthMenu: [
						[ 10, 25, 50, -1 ],
						[ '10 rows', '25 rows', '50 rows', 'Show all' ]
					],
					processing: true,
					serverSide: true,
					autoWidth: true,
					'scrollX': true,
					'scrollY': '400px',
					"order": [[ 0, "asc" ]],
					ajax: 
					{
// GANTI 4 SESUAI resources -routes - web - GANTI 1
						url: '{{ route('get-surats-report') }}',
						data: {
// GANTI 4.1 SESUAI GANTI 2.1
							kodec: kodec,
							tglDr: tglDr,
							tglSmp: tglSmp
						}
					},
					columns: 
					[
// GANTI 5 SESUAI DENGAN GANTI 3
						{data: 'DT_RowIndex', orderable: false, searchable: false },
						{data: 'NO_BUKTI', name: 'NO_BUKTI'},
						{data: 'TGL', name: 'TGL'},
						{data: 'NO_SO', name: 'NO_SO'},
						{data: 'KODEC', name: 'KODEC'},
						{data: 'NAMAC', name: 'NAMAC'},
				        {
					     data: 'TOTAL',
					     name: 'TOTAL',
					     render: $.fn.dataTable.render.number( ',', '.', 0, '' )
				        },
						{data: 'NOTES', name: 'NOTES'}
					],
					
					columnDefs: [
                    {
                    "className": "dt-center", 
                    "targets": 0
                    },
				    {
						targets: 2,
						render: $.fn.dataTable.render.moment( 'DD-MM-YYYY' )
				    },
				    {
                    "className": "dt-right", 
                    "targets": [6]
                    }
					
					],
					
					
				});
			}
			
			$('#filter').click(function() {
// GANTI 5.1 SESUAI GANTI 2.1
				var kodec = $('#kodec').val();
				var tglDr = $('#tglDr').val();
				var tglSmp = $('#tglSmp').val();
				
				if (kodec != '' || (tglDr != '' && tglSmp != ''))
				{
					$('.datatable').DataTable().destroy();
					fill_datatable(kodec, tglDr, tglSmp);
				}
			});
			$('#resetfilter').click(function() {
				var kodec = '';
				var tglDr = '';
				var tglSmp = '';

				$('.datatable').DataTable().destroy();
				fill_datatable(kodec, tglDr, tglSmp);
// BATAS GANTI 5.1
			});
		});
	</script>
	@endsection
