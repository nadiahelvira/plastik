@extends('layouts.main')

<style>
    .card {

    }

    .form-control:focus {
        background-color: #b5e5f9 !important;
    }
</style>

@section('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dropdown with Select2</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
</head>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">

        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{($tipx=='new')? url('/surats/store?flagz='.$flagz.'&golz='.$golz.'') : url('/surats/update/'.$header->NO_ID.'&flagz='.$flagz.'&golz='.$golz.'' ) }}" method="POST" name ="entri" id="entri" >
  
                        @csrf
                        <div class="tab-content mt-3">
                            <div class="form-group row">
                                <div class="col-md-1" align="left">
                                    <label for="NO_BUKTI" class="form-label">Bukti#</label>
                                </div>
								

                                   <input type="text" class="form-control NO_ID" id="NO_ID" name="NO_ID"
                                    placeholder="Masukkan NO_ID" value="{{$header->NO_ID ?? ''}}" hidden readonly>

									<input name="tipx" class="form-control tipx" id="tipx" value="{{$tipx}}" hidden>
									<input name="flagz" class="form-control flagz" id="flagz" value="{{$flagz}}" hidden>
									<input name="golz" class="form-control golz" id="golz" value="{{$golz}}" hidden>

								
								
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI"
                                    placeholder="Masukkan Bukti#" value="{{$header->NO_BUKTI}}" readonly>
                                </div>

                                <div class="col-md-1" align="right">
                                    <label for="TGL" class="form-label">Tgl</label>
                                </div>
                                <div class="col-md-2">
								  <input class="form-control date" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" type="text" autocomplete="off" value="{{date('d-m-Y',strtotime($header->TGL))}}">
                                </div>

								<div class="col-md-2" align="right">
									<label for="JTEMPO" class="form-label">Jatuh Tempo</label>
								</div>
								<div class="col-md-2">
									<input class="form-control date" id="JTEMPO" name="JTEMPO" data-date-format="dd-mm-yyyy" type="text" autocomplete="off" value="{{date('d-m-Y',strtotime($header->JTEMPO))}}">
								</div> 
								
								
                            </div>

                            <div class="form-group row">
								<div {{( $flagz =='AJ') ? '' : 'hidden' }} class="col-md-1" align="left">
									<label style="color:red">*</label>									
                                    <label for="NO_SURAT" class="form-label">SJ#</label>
                                </div>
                               	<div {{( $flagz =='AJ') ? '' : 'hidden' }} class="col-md-2 input-group" >
                                  <input type="text" class="form-control NO_SURAT" id="NO_SURAT" name="NO_SURAT" placeholder="Pilih SJ"value="{{$header->NO_SURAT}}" style="text-align: left" readonly >
        						  <button type="button" class="btn btn-primary" onclick="browseSurats()"><i class="fa fa-search"></i></button>
                                </div>
                            </div>

							<!-- <div class="form-group row">
								<div class="col-md-1" align="left">
									<label style="color:red">*</label>									
									<label for="NO_SO" class="form-label">SO#</label>
								</div>
								<div class="col-md-2 input-group" >
								<input type="text" class="form-control NO_SO" id="NO_SO" name="NO_SO" placeholder="Pilih SO"value="{{$header->NO_SO}}" style="text-align: left" readonly >
								<button type="button" class="btn btn-primary" onclick="browseSo()"><i class="fa fa-search"></i></button>
								</div>
							</div> -->

							<div class="form-group row">
								<div class="col-md-1" align="left">
									<label style="color:red">*</label>									
									<label for="NO_DO" class="form-label">DO#</label>
								</div>
								<div class="col-md-2 input-group" >
								<input type="text" class="form-control NO_DO" id="NO_DO" name="NO_DO" placeholder="Pilih DO"value="{{$header->NO_DO}}" style="text-align: left" readonly >
								<button type="button" class="btn btn-primary" onclick="browseDo()"><i class="fa fa-search"></i></button>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-md-1" align="left">
									<!-- <label style="color:red;font-size:20px">* </label>	 -->
                                    <label for="KODEC" class="form-label">Cust</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control KODEC" id="KODEC" name="KODEC" placeholder="Kode Customer" value="{{$header->KODEC}}" readonly>
                                </div>

								<div class="col-md-4">
                                    <input type="text" class="form-control NAMAC" id="NAMAC" name="NAMAC" placeholder="-" value="{{$header->NAMAC}}" readonly>
                                    <input hidden type="text" class="form-control KODEP" id="KODEP" name="KODEP" placeholder="-" value="{{$header->KODEP}}" readonly>
                                    <input hidden type="text" class="form-control NAMAP" id="NAMAP" name="NAMAP" placeholder="-" value="{{$header->NAMAP}}" readonly>
                                    <input hidden type="text" class="form-control RING" id="RING" name="RING" placeholder="-" value="{{$header->RING}}" readonly>
									<input hidden type="text" class="form-control KOM" onclick="select()"  id="KOM" name="KOM" placeholder="KOM" value="{{ number_format($header->KOM, 2, '.', ',') }}" style="text-align: right; width:140px" readonly>
                                
									<input hidden type="text" onclick="select()" onblur="hitung()" class="form-control HARI" id="HARI" name="HARI" placeholder="Masukkan HARI" 
									value="{{ number_format( $header->HARI, 0, '.', ',') }}" style="text-align: right" >
								   
								</div>
                            </div>
							
							
                            <div class="form-group row">


								<div class="col-md-1" align="right">
                                    <label for="ALAMAT" class="form-label"></label>
                                </div>
								<div class="col-md-4">
                                    <input type="text" class="form-control ALAMAT" id="ALAMAT" name="ALAMAT" value="{{$header->ALAMAT}}"placeholder="Alamat" readonly >
                                </div>

								<div class="col-md-2">
									<input type="text" class="form-control KOTA" id="KOTA" name="KOTA" value="{{$header->KOTA}}"placeholder="Kota" readonly>
								</div>
                            </div>

							<div class="form-group row">
                                <div class="col-md-1" align="left">
									<label style="color:red;font-size:20px">* </label>	
                                    <label for="TRUCK" class="form-label">Truck</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control TRUCK" id="TRUCK" name="TRUCK" placeholder="Masukkan Truck" value="{{$header->TRUCK}}">
                                </div>

                                <div class="col-md-1" align="right">
									<label style="color:red;font-size:20px">* </label>	
                                    <label for="SOPIR" class="form-label">Sopir</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control SOPIR" id="SOPIR" name="SOPIR" placeholder="Sopir" value="{{$header->SOPIR}}">
                                </div>

                            </div>

							<div class="form-group row">
                                <div class="col-md-1" align="left">
									<!-- <label style="color:red">*</label>									 -->
                                    <label for="NOTES" class="form-label">Notes</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control NOTES" id="NOTES" name="NOTES" value="{{$header->NOTES}}" placeholder="Masukkan Notes" >
                                </div>
        
                            </div>
							


                        <div class="tab-content mt-3">
							
                            <table id="datatable" class="table table-striped table-border">
                                <thead>
                                    <tr>
										<th width="50px" style="text-align: center;">No.</th>
                                        <th {{($golz == 'B') ? 'hidden' : '' }} style="text-align: center;">No SO</th>
                                        <th {{($golz == 'B') ? 'hidden' : '' }} style="text-align: center;">Kode Barang</th>
                                        <th {{($golz == 'B') ? 'hidden' : '' }} style="text-align: center;">Uraian</th>
                                        <th {{($golz == 'J') ? 'hidden' : '' }} style="text-align: center;">Kode Bahan</th>
                                        <th {{($golz == 'J') ? 'hidden' : '' }} style="text-align: center;">Uraian</th>
                                        <th style="text-align: center;">Satuan</th>
                                        <th style="text-align: center;">Qty</th>
										<th style="text-align: center;">Ket</th>
										<th style="text-align: center;"></th>
                                        <th></th>
                                       						
                                    </tr>
                                </thead>
        
                                <tbody id="detailDod">
								<?php $no=0 ?>
								@foreach ($detail as $detail)		
                                    <tr>
                                        <td>
                                            <input type="hidden" name="NO_ID[]{{$no}}" id="NO_ID" type="text" value="{{$detail->NO_ID}}" 
                                            class="form-control NO_ID" onkeypress="return tabE(this,event)" readonly>
											
                                            <input name="REC[]" id="REC{{$no}}" type="text" value="{{$detail->REC}}" class="form-control REC" onkeypress="return tabE(this,event)" readonly style="text-align:center">

										</td>
										
                                        <td {{($golz == 'B') ? 'hidden' : '' }}>
                                            <input name="NO_SO[]"  id="NO_SO{{$no}}" type="text" class="form-control NO_SO" placeholder="Barang#" value="{{$detail->NO_SO}}">
                                        </td>
                                        <td {{($golz == 'B') ? 'hidden' : '' }}>
                                            <input name="KD_BRG[]"  id="KD_BRG{{$no}}" type="text" class="form-control KD_BRG" placeholder="Barang#" value="{{$detail->KD_BRG}}">
                                        </td>
                                        <td {{($golz == 'B') ? 'hidden' : '' }}>
                                            <input name="NA_BRG[]" id="NA_BRG{{$no}}" type="text" class="form-control NA_BRG" placeholder="Nama" value="{{$detail->NA_BRG}}">
                                        </td>

										<td {{($golz == 'J') ? 'hidden' : '' }}>
                                            <input name="KD_BHN[]"  id="KD_BHN{{$no}}" type="text" class="form-control KD_BHN" placeholder="Barang#" value="{{$detail->KD_BHN}}">
                                        </td>
                                        <td {{($golz == 'J') ? 'hidden' : '' }}>
                                            <input name="NA_BHN[]" id="NA_BHN{{$no}}" type="text" class="form-control NA_BHN" placeholder="Nama" value="{{$detail->NA_BHN}}">
                                        </td>


                                        <td>
                                            <input name="SATUAN[]" id="SATUAN{{$no}}" type="text" class="form-control SATUAN" placeholder="Satuan" value="{{$detail->SATUAN}}">
                                        </td>
										<td>
											<input name="QTY[]" onkeyup="hitung()" id="QTY{{$no}}" type="text" style="text-align: right"  class="form-control QTY text-primary" value="{{$detail->QTY}}">
											<input hidden name="QTY_KIRIM[]" onkeyup="hitung()" id="QTY_KIRIM{{$no}}" type="text" style="text-align: right"  class="form-control QTY_KIRIM text-primary" value="{{$detail->QTY_KIRIM}}">
											<input hidden name="HARGA[]" onkeyup="hitung()" id="HARGA{{$no}}" type="text" style="text-align: right"  class="form-control HARGA text-primary" value="{{$detail->HARGA}}">
											<input hidden name="TOTAL[]" onkeyup="hitung()" id="TOTAL{{$no}}" type="text" style="text-align: right"  class="form-control TOTAL text-primary" value="{{$detail->TOTAL}}" readonly>
											<input hidden name="PPNX[]"  onblur="hitung()" value="{{$detail->PPN}}" id="PPNX{{$no}}" type="text" style="text-align: right"  class="form-control PPNX text-primary" readonly >
											<input hidden name="DPP[]"  onblur="hitung()" value="{{$detail->DPP}}" id="DPP{{$no}}" type="text" style="text-align: right"  class="form-control DPP text-primary" readonly >
											<input hidden name="DISK[]"  onblur="hitung()" value="{{$detail->DISK}}" id="DISK{{$no}}" type="text" style="text-align: right"  class="form-control DISK text-primary" readonly >
										</td>
										<td>
                                            <input name="KET[]" id="KET{{$no}}" type="text" class="form-control KET" placeholder="Ket" value="{{$detail->KET}}" required>
                                        </td>

                                    </tr>
								
								<?php $no++; ?>
								@endforeach
                                </tbody>

								<tfoot>
								<td></td>
                                    <td></td>
                                    <td {{($golz == 'B') ? 'hidden' : '' }}></td>
                                    <td {{($golz == 'B') ? 'hidden' : '' }}></td>
                                    <td {{($golz == 'B') ? 'hidden' : '' }}></td>
                                    <td {{($golz == 'J') ? 'hidden' : '' }}></td>
                                    <td {{($golz == 'J') ? 'hidden' : '' }}></td>
                                    <td><input class="form-control TQTY  text-primary font-weight-bold" style="text-align: right"  id="TQTY" name="TQTY" value="{{$header->TOTAL_QTY}}" readonly></td>
                                    <td></td>
                                </tfoot>
                            </table>

							<!-- <div class="col-md-2 row">
								<a type="button" id='PLUSX' onclick="tambah()" class="fas fa-plus fa-sm md-3" style="font-size: 20px" ></a>

							</div>	 -->
						
					</div>
                        </div> 

                        <hr style="margin-top: 30px; margin-buttom: 30px">
						<!-- dari sini shelvi-->
						
						<!-- sampai sini shelvi-->
						   
						<div class="mt-3 col-md-12 form-group row">
							<div class="col-md-4">
								<button type="button" id='TOPX'  onclick="location.href='{{url('/surats/edit/?idx=' .$idx. '&tipx=top&flagz='.$flagz.'&golz='.$golz.'' )}}'" class="btn btn-outline-primary">Top</button>
								<button type="button" id='PREVX' onclick="location.href='{{url('/surats/edit/?idx='.$header->NO_ID.'&tipx=prev&flagz='.$flagz.'&golz='.$golz.'&buktix='.$header->NO_BUKTI )}}'" class="btn btn-outline-primary">Prev</button>
								<button type="button" id='NEXTX' onclick="location.href='{{url('/surats/edit/?idx='.$header->NO_ID.'&tipx=next&flagz='.$flagz.'&golz='.$golz.'&buktix='.$header->NO_BUKTI )}}'" class="btn btn-outline-primary">Next</button>
								<button type="button" id='BOTTOMX' onclick="location.href='{{url('/surats/edit/?idx=' .$idx. '&tipx=bottom&flagz='.$flagz.'&golz='.$golz.'' )}}'" class="btn btn-outline-primary">Bottom</button>
							</div>
							<div class="col-md-5">
								<button type="button" id='NEWX' onclick="location.href='{{url('/surats/edit/?idx=0&tipx=new&flagz='.$flagz.'&golz='.$golz.'' )}}'" class="btn btn-warning">New</button>
								<button type="button" id='EDITX' onclick='hidup()' class="btn btn-secondary">Edit</button>                    
								<button type="button" id='UNDOX' onclick="location.href='{{url('/surats/edit/?idx=' .$idx. '&tipx=undo&flagz='.$flagz.'&golz='.$golz.'' )}}'" class="btn btn-info">Undo</button>  
								<button type="button" id='SAVEX' onclick='simpan()'   class="btn btn-success" class="fa fa-save"></i>Save</button>

							</div>
							<div class="col-md-3">
								<button type="button" id='HAPUSX'  onclick="hapusTrans()" class="btn btn-outline-danger">Hapus</button>
								<button type="button" id='CLOSEX'  onclick="location.href='{{url('/surats?flagz='.$flagz.'&golz='.$golz.'' )}}'" class="btn btn-outline-secondary">Close</button>
							</div>
						</div>
						
						
                    </form>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>


	<div class="modal fade" id="browseCustModal" tabindex="-1" role="dialog" aria-labelledby="browseCustModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseCustModalLabel">Cari Customer</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-customer">
				<thead>
					<tr>
						<th>Kode</th>
						<th>Nama</th>
						<th>Alamat</th>
						<th>Kota</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		  </div>
		</div>
	  </div>
	</div>
	
	<div class="modal fade" id="browseSoModal" tabindex="-1" role="dialog" aria-labelledby="browseSoModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseSoModalLabel">Cari Sales Order</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-so">
				<thead>
					<tr>
						<th>No Bukti</th>
						<th>Tanggal</th>
						<!-- <th>No Terima</th> -->
						<th>Customer</th>
						<th>Kode</th>
						<th>Barang</th>
						<th>Satuan</th>
						<!-- <th>Seri#</th> -->
						<!-- <th>Ket</th> -->
						<th>Qty</th>
						<th>Kirim</th>
						<th>Sisa</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		  </div>
		</div>
	  </div>
	</div>

	<div class="modal fade" id="browseDoModal" tabindex="-1" role="dialog" aria-labelledby="browseDoModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseDoModalLabel">Cari DO</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-bdo">
				<thead>
					<tr>
						<th>No Bukti</th>
						<th>No SO</th>
						<th>Tgl</th>
						<th>Customer</th>
						<th>Barang</th>
						<th>Satuan</th>
						<th>Qty</th>
						<th>Kirim</th>
						<th>Sisa</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		  </div>
		</div>
	  </div>
	</div>

	<div class="modal fade" id="browseSuratsModal" tabindex="-1" role="dialog" aria-labelledby="browseSuratsModalLabel" aria-hidden="true">
	  <div class="modal-dialog mw-100 w-75" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseSuratsModalLabel">Cari Surat Jalan</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-bsurats">
				<thead>
					<tr>
						<th>No Surat Jalan</th>
						<th>SO</th>
						<th>Customer</th>
						<th>Nama</th>
						<th>Alamat</th>
						<th>Kota</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		  </div>
		</div>
	  </div>
	</div>

	<div class="modal fade" id="browseSopirModal" tabindex="-1" role="dialog" aria-labelledby="browseSopirModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseSopirModalLabel">Cari Sopir</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-sopir">
				<thead>
					<tr>
						<th>Kode</th>
						<th>Nama</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		  </div>
		</div>
	  </div>
	</div>

	<div class="modal fade" id="browseTruckModal" tabindex="-1" role="dialog" aria-labelledby="browseTruckModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseTruckModalLabel">Cari Truck</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-truck">
				<thead>
					<tr>
						<th>Kode</th>
						<th>Nopol</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		  </div>
		</div>
	  </div>
	</div>
	
	
	

@endsection

@section('footer-scripts')
<script src="{{ asset('js/autoNumerics/autoNumeric.min.js') }}"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script> -->
<script src="{{asset('foxie_js_css/bootstrap.bundle.min.js')}}"></script>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script> -->

<script>
	var idrow = 1;
	var baris = 1;

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
	
    $(document).ready(function () {
    idrow=<?=$no?>;
    baris=<?=$no?>;

		$('body').on('keydown', 'input, select', function(e) {
			if (e.key === "Enter") {
				var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
				focusable = form.find('input,select,textarea').filter(':visible');
				next = focusable.eq(focusable.index(this)+1);
				console.log(next);
				if (next.length) {
					next.focus().select();
				} else {
					// tambah();
					// var nomer = idrow-1;
					// console.log("REC"+nomor);
					// document.getElementById("REC"+nomor).focus();
					// form.submit();
				}
				return false;
			}
		});


		$tipx = $('#tipx').val();
		$searchx = $('#CARI').val();
		
		
        if ( $tipx == 'new' )
		{
			 baru();
            //  tambah();				 
		}

        if ( $tipx != 'new' )
		{
			 ganti();			
		}    
		
		$("#TQTY").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TTOTAL").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});


		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#QTY" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#HARGA" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#TOTAL" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
		}	


		
		// $('#supxz').select2({
        //     minimumInputLength:2,
        //     placeholder:'Select Suplier',
        //     ajax:{
        //         url:route('sup/browsesupz'),
        //         dataType:'json',
        //         processResults:data=>{
                    
        //             return {
        //                 results:data.map(res=>{
        //                     return {text:res.NAMAS,id:res.KODES}
        //                 })
        //             }
        //         }
        //     }
        // })
		
		
				
		
        $('body').on('click', '.btn-delete', function() {
			var val = $(this).parents("tr").remove();
			baris--;
			hitung();
			nomor();
			
		});

		$('.date').datepicker({  
            dateFormat: 'dd-mm-yy'
		});
		
		
 	
		
///////////////////////////////////////////////////////////////////////
		// var dTableCustomer;
		// loadDataCustomer = function(){
		// 	$.ajax(
		// 	{
		// 		type: 'GET',    
		// 		url: "{{url('surats/browseCust')}}",
		// 		// data: {
		// 		// 	'GOL': "{{$golz}}",
		// 		// },
		// 		success: function( resp )
		// 		{
		// 			if(dTableCustomer){
		// 				dTableCustomer.clear();
		// 			}
		// 			for(i=0; i<resp.length; i++){
						
		// 				dTableCustomer.row.add([
		// 					'<a href="javascript:void(0);" onclick="chooseCustomer(\''+resp[i].KODEC+'\',\''+resp[i].NAMAC+'\',\''+resp[i].ALAMAT+'\',\''+resp[i].KOTA+'\')">'+resp[i].KODEC+'</a>',
		// 					resp[i].NAMAC,
		// 					resp[i].ALAMAT,
		// 					resp[i].KOTA,
		// 				]);
		// 			}
		// 			dTableCustomer.draw();
		// 		}
		// 	});
		// }
		
		// dTableCustomer = $("#table-customer").DataTable({
			
		// });
		
		// browseCust = function(){
		// 	loadDataCustomer();
		// 	$("#browseCustModal").modal("show");
		// }
		
		// chooseCustomer = function(kodec,namac,alamat,kota){
		// 	$("#KODEC").val(kodec);
		// 	$("#NAMAC").val(namac);
		// 	$("#ALAMAT").val(alamat);
		// 	$("#KOTA").val(kota);
		// 	$("#browseCustModal").modal("hide");
		// }
		
		// $("#KODEC").keypress(function(e){
		// 	if(e.keyCode == 46){
		// 		e.preventDefault();
		// 		browseCust();
		// 	}
		// }); 

//////////////////////////////////////////////////////////////////////////////////////////////////


		//CHOOSE Sopir
		var dTableBSopir;
		loadDataBSopir = function(){
			$.ajax(
			{
				type: 'GET',    
				url: '{{url('pegawai/browse_sopir')}}',

				success: function( response )
				{
			
					resp = response;
					if(dTableBSopir){
						dTableBSopir.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBSopir.row.add([
							'<a href="javascript:void(0);" onclick="chooseSopir( \''+resp[i].NAMAP+'\' )">'+resp[i].KODEP+'</a>',
							resp[i].NAMAP,
						]);
					}
					dTableBSopir.draw();
				}
			});
		}
		
		dTableBSopir = $("#table-sopir").DataTable({
			
		});
		
		browseSopir = function(){
			loadDataBSopir();
			$("#browseSopirModal").modal("show");
		}
		
		chooseSopir = function(NAMAP){
			$("#SOPIR").val(NAMAP);
			$("#browseSopirModal").modal("hide");
		}
		
		$("#SOPIR").keypress(function(e){

			if(e.keyCode == 46){
				e.preventDefault();
				browseSopir();
			}
		}); 
		
		
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////


		//CHOOSE Truck
		var dTableBTruck;
		loadDataBTruck = function(){
			$.ajax(
			{
				type: 'GET',    
				url: '{{url('truck/browse')}}',

				success: function( response )
				{
			
					resp = response;
					if(dTableBTruck){
						dTableBTruck.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBTruck.row.add([
							'<a href="javascript:void(0);" onclick="chooseTruck( \''+resp[i].NOPOL+'\' )">'+resp[i].KODE+'</a>',
							resp[i].NOPOL,
						]);
					}
					dTableBTruck.draw();
				}
			});
		}
		
		dTableBTruck = $("#table-truck").DataTable({
			
		});
		
		browseTruck = function(){
			loadDataBTruck();
			$("#browseTruckModal").modal("show");
		}
		
		chooseTruck = function(NOPOL){
			$("#TRUCK").val(NOPOL);
			$("#browseTruckModal").modal("hide");
		}
		
		$("#TRUCK").keypress(function(e){

			if(e.keyCode == 46){
				e.preventDefault();
				browseTruck();
			}
		}); 
		
		
//////////////////////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////

	var dTableDo;
	var rowidDo;
	loadDataDo = function(){
		
		$.ajax(
		{
			type: 'GET',    
			url: "{{url('surats/browseDo')}}",
			data: {
				// kdbrg: kode,
				// 'GOL': "{{$golz}}",
				// kodec: $("#KODEC").val(),
			},
			success: function( response )
			{
				resp = response;
				if(dTableDo){
					dTableDo.clear();
				}
				for(i=0; i<resp.length; i++){
					
					dTableDo.row.add([
						'<a href="javascript:void(0);" onclick="chooseDo(\''+resp[i].NO_BUKTI+'\',  \''+resp[i].NO_SO+'\', \''+resp[i].KD_BRG+'\',  \''+resp[i].NA_BRG+'\', \''+resp[i].SATUAN+'\',  \''+resp[i].SISA+'\', \''+resp[i].NO_ID+'\',  \''+resp[i].HARGA+'\',  \''+resp[i].KODEP+'\',  \''+resp[i].NAMAP+'\',  \''+resp[i].RING+'\',  \''+resp[i].KOM+'\',  \''+resp[i].KODEC+'\',  \''+resp[i].NAMAC+'\',  \''+resp[i].ALAMAT+'\',  \''+resp[i].KOTA+'\')">'+resp[i].NO_BUKTI+'</a>',
						resp[i].NO_SO,
						resp[i].TGL,
						resp[i].NAMAC,
						resp[i].KD_BRG,
						resp[i].NA_BRG,
						resp[i].SATUAN,
						resp[i].QTY,
						resp[i].KIRIM,
						resp[i].SISA,
					]);
				}
				dTableDo.draw();
			}
		});
	}
	
	dTableDo = $("#table-bdo").DataTable({

		// columnDefs: 
		// [
		// 	{
		// 		className: "dt-right", 
		// 		targets: [6,7,8],
		// 	},		
		// 	{
		// 		targets: 1,
		// 		render: $.fn.dataTable.render.moment( 'DD-MM-YYYY' ),
		// 	}
		// ],

	});
	
		browseDo = function(rid){
			rowidDo = rid;
			loadDataDo();
			$("#browseDoModal").modal("show");
		}
	
	chooseDo = function(NO_BUKTI, NO_SO, KD_BRG,NA_BRG,SATUAN,QTY,NO_ID,HARGA, KODEP, NAMAP, RING, KOM, KODEC, NAMAC, ALAMAT, KOTA, HARI){
		$("#NO_DO").val(NO_BUKTI);
		$("#KODEP").val(KODEP);
		$("#NAMAP").val(NAMAP);
		$("#RING").val(RING);
		$("#KOM").val(KOM);
		$("#KODEC").val(KODEC);
		$("#NAMAC").val(NAMAC);
		$("#ALAMAT").val(ALAMAT);
		$("#KOTA").val(KOTA);
		$("#HARI").val(HARI);
		$("NO_SO"+rowidDo).val(NO_SO);
		$("#KD_BRG"+rowidDo).val(KD_BRG);
		$("#NA_BRG"+rowidDo).val(NA_BRG);
		$("#SATUAN"+rowidDo).val(SATUAN);
		$("#QTY"+rowidDo).val(QTY!=0 ? QTY : 0);
		$("#ID_SOD"+rowidDo).val(NO_ID);
		$("#HARGA"+rowidDo).val(HARGA);	
		$("#browseDoModal").modal("hide");

		getDod(NO_BUKTI);
	}
	
	$("#NO_DO").keypress(function(e){
		if(e.keyCode == 46){
			e.preventDefault();
			browseDo();
		}
	}); 

//////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////

		var dTableBSurats;
		loadDataBSurats = function(){
		
			$.ajax(
			{
				type: 'GET', 		
				url: '{{url('surats/browse')}}',
				data: {
					'GOL': "{{$golz}}",
				},
				success: function( response )
				{
					resp = response;
					if(dTableBSurats){
						dTableBSurats.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBSurats.row.add([
							'<a href="javascript:void(0);" onclick="chooseSurats(\''+resp[i].NO_BUKTI+'\' , \''+resp[i].NO_SO+'\', \''+resp[i].KODEC+'\',  \''+resp[i].NAMAC+'\', \''+resp[i].ALAMAT+'\',  \''+resp[i].KOTA+'\',  \''+resp[i].SOPIR+'\',  \''+resp[i].TRUCK+'\')">'+resp[i].NO_BUKTI+'</a>',
							resp[i].NO_SO,
							resp[i].KODEC,
							resp[i].NAMAC,
							resp[i].ALAMAT,
							resp[i].KOTA,
						]);
					}
					dTableBSurats.draw();
				}
			});
		}
		
		dTableBSurats = $("#table-bsurats").DataTable({
			
		});
		
		browseSurats = function(){
			loadDataBSurats();
			$("#browseSuratsModal").modal("show");
		}
		
		chooseSurats = function(NO_BUKTI, NO_SO, KODEC,NAMAC, ALAMAT, KOTA, SOPIR, TRUCK){
			$("#NO_SURAT").val(NO_BUKTI);
			$("#NO_SO").val(NO_SO);
			$("#KODEC").val(KODEC);
			$("#NAMAC").val(NAMAC);
			$("#ALAMAT").val(ALAMAT);
			$("#KOTA").val(KOTA);			
			$("#SOPIR").val(SOPIR);			
			$("#TRUCK").val(TRUCK);			
			$("#browseSuratsModal").modal("hide");

			getSuratsd(NO_BUKTI);
		}
		
		$("#NO_SURAT").keypress(function(e){

			if(e.keyCode == 46){
				 e.preventDefault();
				 browseSurats();
			}
		}); 

////////////////////////////////////////////////////////////////////


	function getDod(bukti)
	{
		
		var mulai = (idrow==baris) ? idrow-1 : idrow;

		$.ajax(
			{
				type: 'GET',    
				url: "{{url('surats/do_detail')}}",
				data: {
					nobukti: bukti,
				},
				success: function( resp )
				{
					var html = '';
					for(i=0; i<resp.length; i++){
						html+=`<tr>
                                    <td><input name='REC[]' id='REC${i}' value=${resp[i].REC+1} type='text' class='REC form-control' onkeypress='return tabE(this,event)' readonly></td>
                                    <td {{($golz == 'B') ? 'hidden' : '' }} ><input name='NO_SO[]' data-rowid=${i} id='NO_SO${i}' value="${resp[i].NO_SO}" type='text' class='form-control NO_SO' readonly></td>
                                    <td {{($golz == 'B') ? 'hidden' : '' }} ><input name='KD_BRG[]' data-rowid=${i} id='KD_BRG${i}' value="${resp[i].KD_BRG}" type='text' class='form-control KD_BRG' readonly></td>
                                    <td {{($golz == 'B') ? 'hidden' : '' }}><input name='NA_BRG[]' data-rowid=${i} id='NA_BRG${i}' value="${resp[i].NA_BRG}" type='text' class='form-control  NA_BRG' readonly></td>
                                    <td {{($golz == 'J') ? 'hidden' : '' }} ><input name='KD_BHN[]' data-rowid=${i} id='KD_BHN${i}' value="${resp[i].KD_BHN}" type='text' class='form-control KD_BHN' readonly></td>
                                    <td {{($golz == 'J') ? 'hidden' : '' }} ><input name='NA_BHN[]' data-rowid=${i} id='NA_BHN${i}' value="${resp[i].NA_BHN}" type='text' class='form-control  NA_BHN' readonly></td>
                                    <td><input name='SATUAN[]' data-rowid=${i} id='SATUAN${i}' value="${resp[i].SATUAN}" type='text' class='form-control  SATUAN' placeholder="Satuan"  readonly></td>
                                    <td>
										<input name='QTY[]' onclick='select()' onkeyup='hitung()' id='QTY${i}' value="${resp[i].QTY}" type='text' style='text-align: right' class='form-control QTY text-primary' readonly >
										<input hidden name='QTY_KIRIM[]' onclick='select()' onkeyup='hitung()' id='QTY_KIRIM${i}' value="${resp[i].QTY}" type='text' style='text-align: right' class='form-control QTY_KIRIM text-primary' readonly >
										<input hidden name='HARGA[]' onclick='select()' onkeyup='hitung()' id='HARGA${i}' value="${resp[i].HARGA}" type='text' style='text-align: right' class='form-control HARGA text-primary' readonly> 
										<input hidden name='TOTAL[]' onclick='select()' onkeyup='hitung()' id='TOTAL${i}' value="${resp[i].TOTAL}" type='text' style='text-align: right' class='form-control TOTAL text-primary' readonly> 
										<input hidden name='PPNX[]' onclick='select()' onkeyup='hitung()' id='PPNX${i}' value="${resp[i].PPNX}" type='text' style='text-align: right' class='form-control PPNX text-primary' readonly> 
										<input hidden name='DPP[]' onclick='select()' onkeyup='hitung()' id='DPP${i}' value="${resp[i].DPP}" type='text' style='text-align: right' class='form-control DPP text-primary' readonly> 
										<input hidden name='DISK[]' onclick='select()' onkeyup='hitung()' id='DISK${i}' value="${resp[i].DISK}" type='text' style='text-align: right' class='form-control DISK text-primary' readonly> 
									</td>
                                    <td><input name='KET[]' id='KET${i}' value="${resp[i].KET}" type='text' class='form-control  KET' required></td>
                                    <td><button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button></td>
                                </tr>`;
					}
					$('#detailDod').html(html);

					$(".QTY").autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
					$(".QTY").autoNumeric('update');

					$(".HARGA").autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
					$(".HARGA").autoNumeric('update');

					$(".TOTAL").autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
					$(".TOTAL").autoNumeric('update');

					$(".PPNX").autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
					$(".PPNX").autoNumeric('update');

					$(".DPP").autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
					$(".DPP").autoNumeric('update');

					$(".DISK").autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
					$(".DISK").autoNumeric('update');

					idrow=resp.length;
					baris=resp.length;

					nomor();
				}
			});
	}

//////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////


	function getSuratsd(bukti)
	{
		
		var mulai = (idrow==baris) ? idrow-1 : idrow;

		$.ajax(
			{
				type: 'GET',    
				url: "{{url('surats/browse_suratsd')}}",
				data: {
					nobukti: bukti,
				},
				success: function( resp )
				{
					var html = '';
					for(i=0; i<resp.length; i++){
						html+=`<tr>
                                    <td><input name='REC[]' id='REC${i}' value=${resp[i].REC+1} type='text' class='REC form-control' onkeypress='return tabE(this,event)' readonly></td>
                                    <td {{($golz == 'B') ? 'hidden' : '' }} ><input name='KD_BRG[]' data-rowid=${i} id='KD_BRG${i}' value="${resp[i].KD_BRG}" type='text' class='form-control KD_BRG' readonly></td>
                                    <td {{($golz == 'B') ? 'hidden' : '' }}><input name='NA_BRG[]' data-rowid=${i} id='NA_BRG${i}' value="${resp[i].NA_BRG}" type='text' class='form-control  NA_BRG' readonly></td>
                                    <td {{($golz == 'J') ? 'hidden' : '' }} ><input name='KD_BHN[]' data-rowid=${i} id='KD_BHN${i}' value="${resp[i].KD_BHN}" type='text' class='form-control KD_BHN' readonly></td>
                                    <td {{($golz == 'J') ? 'hidden' : '' }} ><input name='NA_BHN[]' data-rowid=${i} id='NA_BHN${i}' value="${resp[i].NA_BHN}" type='text' class='form-control  NA_BHN' readonly></td>
                                    <td><input name='SATUAN[]' data-rowid=${i} id='SATUAN${i}' value="${resp[i].SATUAN}" type='text' class='form-control  SATUAN' placeholder="Satuan"  readonly></td>
                                    <td>
										<input name='QTY[]' onclick='select()' onkeyup='hitung()' id='QTY${i}' value="${resp[i].QTY}" type='text' style='text-align: right' class='form-control QTY text-primary' readonly >
										<input hidden name='HARGA[]' onclick='select()' onkeyup='hitung()' id='HARGA${i}' value="${resp[i].HARGA}" type='text' style='text-align: right' class='form-control HARGA text-primary' readonly> 
										<input hidden name='TOTAL[]' onclick='select()' onkeyup='hitung()' id='TOTAL${i}' value="${resp[i].TOTAL}" type='text' style='text-align: right' class='form-control TOTAL text-primary' readonly> 
										<input hidden name='PPNX[]' onclick='select()' onkeyup='hitung()' id='PPNX${i}' value="${resp[i].PPNX}" type='text' style='text-align: right' class='form-control PPNX text-primary' readonly> 
										<input hidden name='DPP[]' onclick='select()' onkeyup='hitung()' id='DPP${i}' value="${resp[i].DPP}" type='text' style='text-align: right' class='form-control DPP text-primary' readonly> 
										<input hidden name='DISK[]' onclick='select()' onkeyup='hitung()' id='DISK${i}' value="${resp[i].DISK}" type='text' style='text-align: right' class='form-control DISK text-primary' readonly> 
									</td>
                                    <td><input name='KET[]' id='KET${i}' value="${resp[i].KET}" type='text' class='form-control  KET' required></td>
                                    <td><button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button></td>
                                </tr>`;
					}
					$('#detailSuratsd').html(html);

					$(".QTY").autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
					$(".QTY").autoNumeric('update');

					$(".HARGA").autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
					$(".HARGA").autoNumeric('update');

					$(".TOTAL").autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
					$(".TOTAL").autoNumeric('update');

					$(".PPNX").autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
					$(".PPNX").autoNumeric('update');

					$(".DPP").autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
					$(".DPP").autoNumeric('update');

					$(".DISK").autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
					$(".DISK").autoNumeric('update');
					/*
					$(".KD_BHN").each(function() {
						var getid = $(this).attr('id');
						var noid = getid.substring(6,11);

						$("#KD_BHN"+noid).keypress(function(e){
							if(e.keyCode == 46){
								e.preventDefault();
								browseBhn(noid);
							}
						}); 
					});*/

					idrow=resp.length;
					baris=resp.length;

					nomor();
				}
			});
	}

//////////////////////////////////////////////////////////////////



}); 


//////////////////////////////////////////////////////////////////
	function cekDetail(){
		var cekBarang = '';
		$(".KD_BRG").each(function() {
			
			let z = $(this).closest('tr');
			var KD_BRGX = z.find('.KD_BRG').val();
			
			if( KD_BRGX =="" )
			{
					cekBarang = '1';
					
			}	
		});
		
		return cekBarang;
	}


 	function simpan() {
		hitung();
		
		var tgl = $('#TGL').val();
		var bulanPer = {{session()->get('periode')['bulan']}};
		var tahunPer = {{session()->get('periode')['tahun']}};
		
        var check = '0';
		
		
		
			// if (cekDetail())
			// {	
			//     check = '1';
			// 	alert("#Barang ada yang kosong. ")
			// }
			
			
			$(".NO_SO").each(function() {
			var noso = $(this).val();
			if(noso=='')
			{
				var val = $(this).parents("tr").remove();
				baris--;
				nomor();
			}
		});

		if ( $('#KODEC').val()=='' ) 
		{			
			check = '1';
			alert("No Customer Harus diisi.");
		}
		if ( $('#TRUCK').val()=='' ) 
		{			
			check = '1';
			alert("Truk Harus diisi.");
		}
		if ( $('#SOPIR').val()=='' ) 
		{			
			check = '1';
			alert("Sopir Harus diisi.");
		}
		if ( tgl.substring(3,5) != bulanPer ) 
		{
			check = '1';
			alert("Bulan ("+tgl+") tidak sama dengan Periode");
		}	
		if ( tgl.substring(tgl.length-4) != tahunPer )
		{
			check = '1';
			alert("Tahun ("+tgl+") tidak sama dengan Periode");
		}	 
	
		// if ( check == '0' )
		// {
		// 	document.getElementById("entri").submit();  
		// }

		(check==0) ? document.getElementById("entri").submit() : alert('Masih ada kesalahan');
			
	}
		
    function nomor() {
		var i = 1;
		$(".REC").each(function() {
			$(this).val(i++);
		});
		
	//	hitung();
	
	}

   function hitung() {
	var TQTY = 0;
		var TTOTAL = 0;

		$(".QTY").each(function() {
			let z = $(this).closest('tr');
			var QTYX = parseFloat($(this).val().replace(/,/g, ''));
			var HARGAX = parseFloat(z.find('.HARGA').val().replace(/,/g, ''));
		
            var TOTALX = HARGAX * QTYX;
			z.find('.TOTAL').val(TOTALX);
		    z.find('.TOTAL').autoNumeric('update');
		
            TQTY += QTYX;	
            TTOTAL += TOTALX;	
		});
		

		if(isNaN(TQTY)) TQTY = 0;
		if(isNaN(TTOTAL)) TTOTAL = 0;

		$('#TQTY').val(numberWithCommas(TQTY));		
		$('#TTOTAL').val(numberWithCommas(TTOTAL));		

		$("#TQTY").autoNumeric('update');
		$("#TTOTAL").autoNumeric('update');
	}


	$(".NO_SO").keypress(function(e){
		if(e.keyCode == 46){
			e.preventDefault();
			browseSo(eval($(this).data("rowid")));
		}
	});
	
  
	function baru() {
		
		 kosong();
		 hidup();
	
	}
	
	function ganti() {
		
		 mati();
	
	}
	
	function batal() {
		
		// alert($header[0]->NO_BUKTI);
		
		 //$('#NO_BUKTI').val($header[0]->NO_BUKTI);	
		 mati();
	
	}
	
 

	
	
	function hidup() {

		
		$("#TOPX").attr("disabled", true);
	    $("#PREVX").attr("disabled", true);
	    $("#NEXTX").attr("disabled", true);
	    $("#BOTTOMX").attr("disabled", true);

	    $("#NEWX").attr("disabled", true);
	    $("#EDITX").attr("disabled", true);
	    $("#UNDOX").attr("disabled", false);
	    $("#SAVEX").attr("disabled", false);
		
	    $("#HAPUSX").attr("disabled", true);
//	    $("#CLOSEX").attr("disabled", true);

		$("#CARI").attr("readonly", true);	
	    $("#SEARCHX").attr("disabled", true);
		
	    $("#PLUSX").attr("hidden", false)
		   
			$("#NO_BUKTI").attr("readonly", true);		   
			$("#NO_SO").attr("readonly", true);		   
			$("#TGL").attr("readonly", false);
			$("#JTEMPO").attr("readonly", false);
			$("#KODES").attr("readonly", true);
			$("#NAMAS").attr("readonly", true);			
			$("#ALAMAT").attr("readonly", true);
			$("#KOTA").attr("readonly", true);
			$("#TRUCK").attr("readonly", true);
			$("#SOPIR").attr("readonly", true);
			$("#VIA").attr("readonly", false);

			
			$("#NOTES").attr("readonly", false);
				

		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#REC" + i.toString()).attr("readonly", true);
			$("#KD_BRG" + i.toString()).attr("readonly", true);
			$("#NA_BRG" + i.toString()).attr("readonly", true);
			$("#KD_BHN" + i.toString()).attr("readonly", true);
			$("#NA_BHN" + i.toString()).attr("readonly", true);
			$("#SATUAN" + i.toString()).attr("readonly", true);
			$("#QTY" + i.toString()).attr("readonly", false);
			$("#HARGA" + i.toString()).attr("readonly", false);
			$("#TOTAL" + i.toString()).attr("readonly", true);
			$("#KET" + i.toString()).attr("readonly", false);
			$("#DELETEX" + i.toString()).attr("hidden", false);

			$tipx = $('#tipx').val();
		
			
			// if ( $tipx != 'new' )
			// {
			// 	$("#NO_SO" + i.toString()).attr("readonly", true);	
			// 	$("#NO_SO" + i.toString()).removeAttr('onblur');
				
			// 	$("#KD_BRG" + i.toString()).attr("readonly", true);	
			// 	$("#KD_BRG" + i.toString()).removeAttr('onblur');
			// } 
		}

		
	}


	function mati() {

		
	    $("#TOPX").attr("disabled", false);
	    $("#PREVX").attr("disabled", false);
	    $("#NEXTX").attr("disabled", false);
	    $("#BOTTOMX").attr("disabled", false);


	    $("#NEWX").attr("disabled", false);
	    $("#EDITX").attr("disabled", false);
	    $("#UNDOX").attr("disabled", true);
	    $("#SAVEX").attr("disabled", true);
	    $("#HAPUSX").attr("disabled", false);
	    $("#CLOSEX").attr("disabled", false);

		$("#CARI").attr("readonly", false);	
	    $("#SEARCHX").attr("disabled", false);
		
		
	    $("#PLUSX").attr("hidden", true)
		
	    $(".NO_BUKTI").attr("readonly", true);	
	    $(".NO_SO").attr("readonly", true);	
		
		$("#TGL").attr("readonly", true);
		$("#JTEMPO").attr("readonly", true);
		$("#KODES").attr("readonly", true);
		$("#NAMAS").attr("readonly", true);
		$("#ALAMAT").attr("readonly", true);
		$("#KOTA").attr("readonly", true);
		$("#TRUCK").attr("readonly", true);
		$("#SOPIR").attr("readonly", true);
		$("#VIA").attr("readonly", true);
	
		
		$("#NOTES").attr("readonly", true);

		
		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#REC" + i.toString()).attr("readonly", true);
			$("#KD_BRG" + i.toString()).attr("readonly", true);
			$("#NA_BRG" + i.toString()).attr("readonly", true);
			$("#KD_BHN" + i.toString()).attr("readonly", true);
			$("#NA_BHN" + i.toString()).attr("readonly", true);
			$("#SATUAN" + i.toString()).attr("readonly", true);
			$("#QTY" + i.toString()).attr("readonly", true);
			$("#HARGA" + i.toString()).attr("readonly", true);
			$("#TOTAL" + i.toString()).attr("readonly", true);
			$("#KET" + i.toString()).attr("readonly", true);
			
			$("#DELETEX" + i.toString()).attr("hidden", true);
		}


		
	}


	function kosong() {
				
		 $('#NO_BUKTI').val("+");		
		 $('#KODES').val("");	
		 $('#NAMAS').val("");	
		 $('#ALAMAT').val("");	
		 $('#KOTA').val("");	
		 $('#NOTES').val("");	
		 $('#TTOTAL_QTY').val("0.00");	
		 $('#TTOTAL').val("0.00");
		 
		var html = '';
		$('#detailx').html(html);	
		
	}
	
	function hapusTrans() {
		let text = "Hapus Transaksi "+$('#NO_BUKTI').val()+"?";
		if (confirm(text) == true) 
		{
			window.location ="{{url('/surats/delete/'.$header->NO_ID .'/?flagz='.$flagz.'' )}}";
			//return true;
		} 
		return false;
	}
	

	function CariBukti() {
		
		var flagz = "{{ $flagz }}";
		var cari = $("#CARI").val();
		var loc = "{{ url('/surats/edit/') }}" + '?idx={{ $header->NO_ID}}&tipx=search&flagz=' + encodeURIComponent(flagz) + '&buktix=' +encodeURIComponent(cari);
		window.location = loc;
		
	}


    // function tambah() {

    //     var x = document.getElementById('datatable').insertRow(baris + 1);
 
	// 	html=`<tr>

    //             <td>
 	// 				<input name='NO_ID[]' id='NO_ID${idrow}' type='hidden' class='form-control NO_ID' value='new' readonly> 
	// 				<input name='REC[]' id='REC${idrow}' type='text' class='REC form-control' onkeypress='return tabE(this,event)' readonly>
	//             </td>

	// 			<td>
	// 				<input name='KD_BHN[]' data-rowid=${idrow} id='KD_BHN${idrow}' type='text' class='form-control KD_BHN' >
	// 			</td>
	// 			<td>
	// 				<input name='NA_BHN[]' id='NA_BHN${idrow}' type='text' class='form-control  NA_BHN'  readonly>
	// 			</td>


    //             <td>
	// 			    <input name='SATUAN[]' id='SATUAN${idrow}' type='text' class='form-control SATUAN'>
    //             </td>

	// 			<td>
	// 	            <input name='QTY[]' onclick='select()' onblur='hitung()' value='0' id='QTY${idrow}' type='text' style='text-align: right' class='form-control QTY text-primary' required >
    //             </td>

	// 			<td>
	// 	            <input name='HARGA[]' onclick='select()' onblur='hitung()' value='0' id='HARGA${idrow}' type='text' style='text-align: right' class='form-control HARGA text-primary' required >
    //             </td>

				
	// 			<td>
	// 	            <input name='TOTAL[]' onclick='select()' onblur='hitung()' value='0' id='TOTAL${idrow}' type='text' style='text-align: right' class='form-control TOTAL text-primary' >
    //             </td>				
					
    //             <td>
	// 			    <input name='KET[]'   id='KET${idrow}' type='text' class='form-control  KET' required>
    //             </td>
				
    //             <td>
	// 				<button type='button' id='DELETEX${idrow}'  class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>
    //             </td>				
    //      </tr>`;
				
    //     x.innerHTML = html;
    //     var html='';
		
		
		
	// 	jumlahdata = 100;
	// 	for (i = 0; i <= jumlahdata; i++) {
	// 		$("#QTY" + i.toString()).autoNumeric('init', {
	// 			aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});


	// 		$("#HARGA" + i.toString()).autoNumeric('init', {
	// 			aSign: '<?php echo ''; ?>',
	// 			vMin: '-999999999.99'
	// 		});

	// 		$("#TOTAL" + i.toString()).autoNumeric('init', {
	// 			aSign: '<?php echo ''; ?>',
	// 			vMin: '-999999999.99'
	// 		});			 

					
	// 	}

		


    //     idrow++;
    //     baris++;
    //     nomor();
		
	// 	$(".ronly").on('keydown paste', function(e) {
    //          e.preventDefault();
    //          e.currentTarget.blur();
    //      });
    // }
</script>
<!-- 
<script src="autonumeric.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>
<script src="https://unpkg.com/autonumeric"></script> -->
@endsection