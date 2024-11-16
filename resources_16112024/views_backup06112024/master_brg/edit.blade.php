@extends('layouts.main')
<style>
    .card {

    }

    .form-control:focus {
        background-color: #E0FFFF !important;
    }
</style>

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Data Barang</h1>
            </div>
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">
        <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{($tipx=='new')? url('/brg/store/') : url('/brg/update/'.$header->NO_ID ) }}" method="POST" name ="entri" id="entri" >
  
                        @csrf
                        {{-- <ul class="nav nav-tabs">
                            <li class="nav-item active">
                                <a class="nav-link active" href="#data" data-toggle="tab">Data</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#dokumen" data-toggle="tab">Dokumen</a>
                            </li>
                        </ul> --}}
        
                        <div class="tab-content mt-3">
        
                            <div class="form-group row">
                                <div class="col-md-1">
                                    <label for="KD_BRG" class="form-label">Kode</label>
                                </div>
								
                                    <input type="text" class="form-control NO_ID" id="NO_ID" name="NO_ID"
                                    placeholder="Masukkan NO_ID" value="{{$header->NO_ID ?? ''}}" hidden readonly>

									<input name="tipx" class="form-control flagz" id="tipx" value="{{$tipx}}" hidden>
		 								
								
                                <div class="col-md-2">
                                    <input type="text" class="form-control KD_BRG" id="KD_BRG" name="KD_BRG"
                                    placeholder="Masukkan Barang" value="{{$header->KD_BRG}}" readonly>
                                </div>

								
                                <div class="col-md-1">
                                    <label for="NA_BRG" class="form-label">Nama</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control NA_BRG" id="NA_BRG" name="NA_BRG"
                                    placeholder="Masukkan Nama Barang" value="{{$header->NA_BRG}}" >
                                </div>

								
                                <div class="col-md-1">
									<label for="GOL" class="form-label">Golongan</label>
								</div>
								<div class="col-md-1">
									<select id="GOL" class="form-control"  name="GOL">
										<option value="J" {{ ($header->GOL == 'J') ? 'selected' : '' }}>Barang</option>
										<option value="N" {{ ($header->GOL == 'N') ? 'selected' : '' }}>Non</option>
									</select>
								</div>

								<div class="col-md-1" align="center">
									<label for="PN" class="form-label">PPN</label>
								</div>
								<div class="col-md-1">
									<select id="PN" class="form-control"  name="PN">
										<option value="0" {{ ($header->PN == '0') ? 'selected' : '' }}>0</option>
										<option value="11" {{ ($header->PN == '11') ? 'selected' : '' }}>11</option>
										<option value="12" {{ ($header->PN == '12') ? 'selected' : '' }}>12</option>
									</select>
								</div>	
								
							
								<div class="col-md-1" hidden>
                                    <input type="checkbox" class="form-check-input" id="AKTIF"name="AKTIF"
                                    placeholder="Masukkan Aktif/Tidak" value="1" {{ ($header->AKTIF == 1) ? 'checked' : '' }}>
									<label for="AKTIF">Aktif</label>
                                </div>

                            </div>

							
							<div class="form-group row">
								<div class="col-md-1">
									<label style="color:red">*</label>	
                                    <label for="KD_GRUP" class="form-label">Grup</label>
                                </div>
								
                                <div class="col-md-2">
                                    <input type="text" class="form-control KD_GRUP" id="KD_GRUP" name="KD_GRUP"
                                    placeholder="" value="{{$header->KD_GRUP}}" readonly>
                                </div>

                                <div class="col-md-2">
                                    <input type="text" class="form-control NA_GRUP" id="NA_GRUP" name="NA_GRUP"
                                    placeholder="" value="{{$header->NA_GRUP}}" readonly>
                                </div>
								
								<div class="col-md-1">
									<label style="color:red">*</label>	
                                    <label for="LOKASI" class="form-label">Lokasi</label>
                                </div>
								
                                <div class="col-md-2">
                                    <input type="text" class="form-control LOKASI" id="LOKASI" name="LOKASI"
                                    placeholder="" value="{{$header->LOKASI}}" readonly>
                                </div>
							</div>
							
                            <div class="form-group row">
                                <div class="col-md-1">
                                    <label for="SATUAN_BELI" class="form-label">Satuan Beli</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control SATUAN_BELI" id="SATUAN_BELI" name="SATUAN_BELI"
                                    placeholder="Masukkan Satuan Beli" value="{{$header->SATUAN_BELI}}">
                                </div>

								<div class="col-md-1">
                                    <label for="KALI" class="form-label" style="text-align: left; width:200px">Konversi</label>
                                </div>
                                <div class="col-md-2">
									<input type="text" class="form-control KALI" onclick="select()"  id="KALI" name="KALI" placeholder="KALI" 
									value="{{ number_format($header->KALI, 2, '.', ',') }}" style="text-align: right; width:140px">
                                </div>

                                <div class="col-md-1">
                                    <label for="SATUAN" class="form-label">Satuan Pakai</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control SATUAN" id="SATUAN" name="SATUAN"
                                    placeholder="Masukkan Satuan Pakai" value="{{$header->SATUAN}}">
                                </div>

								
                            </div>

							<div class="form-group row">

                                <div class="col-md-1">
									<label for="MERK" class="form-label">Merk</label>
								</div>
								<div class="col-md-2">
                                    <input type="text" class="form-control MERK" id="MERK" name="MERK"
                                    placeholder="Masukkan Merk" value="{{$header->MERK}}">
                                </div>

                                <div class="col-md-1">
									<label for="JENIS" class="form-label">Jenis</label>
								</div>
								<div class="col-md-2">
                                    <input type="text" class="form-control JENIS" id="JENIS" name="JENIS"
                                    placeholder="Masukkan Jenis" value="{{$header->JENIS}}">
                                </div>
								
                            </div>

							<div class="form-group row">
								<div class="col-md-1">
                                    <label for="PANJANG" class="form-label">Panjang</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" onclick="select()" class="form-control PANJANG" id="PANJANG" name="PANJANG" placeholder="Masukkan PANJANG" 
									value="{{ number_format( $header->PANJANG, 0, '.', ',') }}" style="text-align: right" >
                                </div>

								<div class="col-md-1">
									<label for="LEBAR" class="form-label">Lebar</label>
								</div>
								<div class="col-md-2">
									<input type="text" onclick="select()" class="form-control LEBAR" id="LEBAR" name="LEBAR" placeholder="Masukkan LEBAR" 
									value="{{ number_format( $header->LEBAR, 0, '.', ',') }}" style="text-align: right" >
								</div>

								
								<div class="col-md-1">
                                    <label for="DIMENSI" class="form-label">Dimensi</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" onclick="select()" class="form-control DIMENSI" id="DIMENSI" name="DIMENSI" placeholder="Masukkan DIMENSI" 
									value="{{ number_format( $header->DIMENSI, 0, '.', ',') }}" style="text-align: right" >
                                </div>

								<div class="col-md-1">
									<label for="VOLUME" class="form-label">Volume</label>
								</div>
								<div class="col-md-2">
									<input type="text" onclick="select()" class="form-control VOLUME" id="VOLUME" name="VOLUME" placeholder="Masukkan VOLUME" 
									value="{{ number_format( $header->VOLUME, 0, '.', ',') }}" style="text-align: right" >
								</div>
							</div>

							<div class="form-group row">
								<div class="col-md-1">
                                    <label for="ROP" class="form-label">ROP</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" onclick="select()" class="form-control ROP" id="ROP" name="ROP" placeholder="Masukkan ROP" 
									value="{{ number_format( $header->ROP, 0, '.', ',') }}" style="text-align: right" >
                                </div>

								<div class="col-md-1" hidden>
									<label for="HJUAL" class="form-label">Harga Jual</label>
								</div>
								<div class="col-md-2" hidden>
									<input type="text" onclick="select()" class="form-control HJUAL" id="HJUAL" name="HJUAL" placeholder="Masukkan HJUAL" 
									value="{{ number_format( $header->HJUAL, 0, '.', ',') }}" style="text-align: right" >
								</div>
							</div>

							<div class="form-group row">
								<div class="col-md-1">
                                    <label for="SMIN" class="form-label">SMIN</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" onclick="select()" class="form-control SMIN" id="SMIN" name="SMIN" placeholder="Masukkan SMIN" 
									value="{{ number_format( $header->SMIN, 0, '.', ',') }}" style="text-align: right" >
                                </div>

								<div class="col-md-1">
									<label for="SMAX" class="form-label">SMAX</label>
								</div>
								<div class="col-md-2">
									<input type="text" onclick="select()" class="form-control SMAX" id="SMAX" name="SMAX" placeholder="Masukkan SMAX" 
									value="{{ number_format( $header->SMAX, 0, '.', ',') }}" style="text-align: right" >
								</div>
							</div>


							<div class="form-group row">
                                <div class="col-md-1">
									<label style="color:red">*</label>									
                                    <label for="ACNOA" class="form-label">Acno Debet</label>
                                </div>
                               	<div class="col-md-2 input-group" >
                                  <input type="text" class="form-control ACNOA" id="ACNOA" name="ACNOA" placeholder="Pilih Acno Debet"value="{{$header->ACNOA}}" style="text-align: left" readonly >
        						  <button type="button" class="btn btn-primary" onclick="browseAcno()" style="width:40px"><i class="fa fa-search"></i></button>
                                </div>
        
                                <div class="col-md-3">
                                    <input type="text" class="form-control NACNOA" id="NACNOA" name="NACNOA" placeholder="" value="{{$header->NACNOA}}" readonly>
                                </div>

								<div class="col-md-1">
									<label style="color:red">*</label>									
                                    <label for="ACNOB" class="form-label">Acno Kredit</label>
                                </div>
                               	<div class="col-md-2 input-group" >
                                  <input type="text" class="form-control ACNOB" id="ACNOB" name="ACNOB" placeholder="Pilih Acno Kredit"value="{{$header->ACNOB}}" style="text-align: left" readonly >
        						  <button type="button" class="btn btn-primary" onclick="browseAcnob()"><i class="fa fa-search"></i></button>
                                </div>
        
                                <div class="col-md-3">
                                    <input type="text" class="form-control NACNOB" id="NACNOB" name="NACNOB" placeholder="" value="{{$header->NACNOB}}" readonly>
                                </div>
                            </div>
							
							<!--------------------------------------------------------------->

							<ul class="nav nav-tabs">
								
								<li class="nav-item">
									<a class="nav-link active" href="#brgdxInfo" data-toggle="tab">Detail</a>
								</li>
							</ul>

							<!--------------------------------------------------------------->
                                
                        </div>

						<div class="tab-content mt-3">
							<div id="brgdxInfo" class="tab-pane active">
							
                            <table id="datatable" class="table table-striped table-border">
                                <thead>
                                    <tr>
										<th style="text-align: center;">No.</th>
										<th style="text-align: center;">
									       <label style="color:red;font-size:20px">* </label>									
                                           <label for="KD_PRS" class="form-label">Ring#</label></th>
										<th style="text-align: center;">Paket 1</th>
                                        <th style="text-align: center;">Paket 6</th>
										<th style="text-align: center;">Paket 25</th>
										<th style="text-align: center;">Paket 50</th>
										<th style="text-align: center;">Paket 100</th>
										<th style="text-align: center;">Paket 150</th>
										<th style="text-align: center;">Paket 200</th>
                                        <!-- <th></th> -->
                                       						
                                    </tr>
                                </thead>
        
								<tbody>
								<?php $no=0 ?>
								@foreach ($detail as $detail)		
                                    <tr>
                                        <td>
                                            <input type="hidden" name="NO_ID[]{{$no}}" id="NO_ID" type="text" value="{{$detail->NO_ID}}" 
                                            class="form-control NO_ID" onkeypress="return tabE(this,event)" readonly>
											
                                            <input name="REC[]" id="REC{{$no}}" type="text" value="{{$detail->REC}}" class="form-control REC" onkeypress="return tabE(this,event)" readonly style="text-align:center">
                                        </td>

										<td>
                                            <input name="RING[]" data-rowid={{$no}} id="RING{{$no}}" type="text" value="{{$detail->RING}}" class="form-control RING" readonly>
                                        </td>
										
										<td>
											<input name="HARGA[]" onclick="select()" onkeyup="hitung()" value="{{$detail->HARGA}}" id="HARGA{{$no}}" type="text" style="text-align: right"  class="form-control HARGA text-primary">
										</td>
										<td>
											<input name="HARGA2[]" onclick="select()" onkeyup="hitung()" value="{{$detail->HARGA2}}" id="HARGA2{{$no}}" type="text" style="text-align: right"  class="form-control HARGA2 text-primary">
										</td>
										<td>
											<input name="HARGA3[]" onclick="select()" onkeyup="hitung()" value="{{$detail->HARGA3}}" id="HARGA3{{$no}}" type="text" style="text-align: right"  class="form-control HARGA3 text-primary">
										</td>
										<td>
											<input name="HARGA4[]" onclick="select()" onkeyup="hitung()" value="{{$detail->HARGA4}}" id="HARGA4{{$no}}" type="text" style="text-align: right"  class="form-control HARGA4 text-primary">
										</td>
										<td>
											<input name="HARGA5[]" onclick="select()" onkeyup="hitung()" value="{{$detail->HARGA5}}" id="HARGA5{{$no}}" type="text" style="text-align: right"  class="form-control HARGA5 text-primary">
										</td>
										<td>
											<input name="HARGA6[]" onclick="select()" onkeyup="hitung()" value="{{$detail->HARGA6}}" id="HARGA6{{$no}}" type="text" style="text-align: right"  class="form-control HARGA6 text-primary">
										</td>
										<td>
											<input name="HARGA7[]" onclick="select()" onkeyup="hitung()" value="{{$detail->HARGA7}}" id="HARGA7{{$no}}" type="text" style="text-align: right"  class="form-control HARGA7 text-primary">
										</td>
                                        
										<!-- <td>
                                            <button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete del1" onclick="">
                                                <i class="fa fa-fw fa-trash"></i>
                                            </button>
                                        </td> -->

                                    </tr>
								
								<?php $no++; ?>
								@endforeach
                                </tbody>

								<tfoot>
									<td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
									<td></td>
									<td></td>
                                </tfoot>
                            </table>
							
                            <!-- <div class="col-md-2 row">
                               <a type="button" id='PLUSX1' onclick="tambah()" class="fas fa-plus fa-sm md-3" ></a>					
							</div>		 -->
							
						</div>

						<!----------------------------------------------------------------------------------------------->

        
						<div class="mt-3 col-md-12 form-group row">
							<div class="col-md-4">
								<button type="button" id='TOPX'  onclick="location.href='{{url('/brg/edit/?idx=' .$idx. '&tipx=top')}}'" class="btn btn-outline-primary">Top</button>
								<button type="button" id='PREVX' onclick="location.href='{{url('/brg/edit/?idx='.$header->NO_ID.'&tipx=prev&kodex='.$header->KD_BRG )}}'" class="btn btn-outline-primary">Prev</button>
								<button type="button" id='NEXTX' onclick="location.href='{{url('/brg/edit/?idx='.$header->NO_ID.'&tipx=next&kodex='.$header->KD_BRG )}}'" class="btn btn-outline-primary">Next</button>
								<button type="button" id='BOTTOMX' onclick="location.href='{{url('/brg/edit/?idx=' .$idx. '&tipx=bottom')}}'" class="btn btn-outline-primary">Bottom</button>
							</div>
							<div class="col-md-5">
								<button type="button" id='NEWX' onclick="location.href='{{url('/brg/edit/?idx=0&tipx=new')}}'" class="btn btn-warning">New</button>
								<button type="button" id='EDITX' onclick='hidup()' class="btn btn-secondary">Edit</button>                    
								<button type="button" id='UNDOX' onclick="location.href='{{url('/brg/edit/?idx=' .$idx. '&tipx=undo' )}}'" class="btn btn-info">Undo</button> 
								<button type="button" id='SAVEX' onclick='simpan()'   class="btn btn-success" class="fa fa-save"></i>Save</button>

							</div>
							<div class="col-md-3">
								<button type="button" id='HAPUSX'  onclick="hapusTrans()" class="btn btn-outline-danger">Hapus</button>
								<button type="button" id='CLOSEX'  onclick="location.href='{{url('/brg' )}}'" class="btn btn-outline-secondary">Close</button>


							</div>
						</div>		
		
                    </form>
                </div>
            </div>
            <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->


	<div class="modal fade" id="browseSuplierModal" tabindex="-1" role="dialog" aria-labelledby="browseSuplierModalLabel" aria-hidden="true">
	 <div class="modal-dialog mw-100 w-75" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseSuplierModalLabel">Cari Suplier</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-bsuplier">
				<thead>
					<tr>
						<th>Suplier</th>
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

	<div class="modal fade" id="browseAcnoModal" tabindex="-1" role="dialog" aria-labelledby="browseAcnoModalLabel" aria-hidden="true">
	 <div class="modal-dialog mw-100 w-75" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseAcnoModalLabel">Cari Acno</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-bacno">
				<thead>
					<tr>
						<th>Acno</th>
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

	<div class="modal fade" id="browseAcnobModal" tabindex="-1" role="dialog" aria-labelledby="browseAcnobModalLabel" aria-hidden="true">
	 <div class="modal-dialog mw-100 w-75" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseAcnobModalLabel">Cari Acnob</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-bacnob">
				<thead>
					<tr>
						<th>Acno</th>
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

	<div class="modal fade" id="browseGrupModal" tabindex="-1" role="dialog" aria-labelledby="browseGrupModalLabel" aria-hidden="true">
	 <div class="modal-dialog mw-100 w-75" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseGrupModalLabel">Cari Grup</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-bgrup">
				<thead>
					<tr>
						<th>Grup</th>
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

	<div class="modal fade" id="browseLokasiModal" tabindex="-1" role="dialog" aria-labelledby="browseLokasiModalLabel" aria-hidden="true">
	 <div class="modal-dialog mw-100 w-75" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseLokasiModalLabel">Cari Lokasi</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-blokasi">
				<thead>
					<tr>
						<th>Kode</th>
						<th>Lokasi</th>
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
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script> -->
<script src="{{asset('foxie_js_css/bootstrap.bundle.min.js')}}"></script>


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
				
        if ( $tipx == 'new' )
		{
			 baru();	
             tambah();
			 
			 $("#RING0").val('LOKAL');
			 tambah();
			 $("#RING1").val('1');
			 tambah();
			 $("#RING2").val('2');
			 tambah();
			 $("#RING3").val('3');
			 
		}

        if ( $tipx != 'new' )
		{
			 //mati();	
    		 ganti();
		} 


		$("#KALI").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#ROP").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#HJUAL").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#SMIN").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#SMAX").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});


		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#HARGA" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#HARGA2" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#HARGA3" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#HARGA4" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#HARGA5" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#HARGA6" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
			$("#HARGA7" + i.toString()).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
		
		}	

		$('body').on('click', '.del', function() {
			var val = $(this).parents("tr").remove();
			baris--;
			nomor();
			
		});

		$('.date').datepicker({  
            dateFormat: 'dd-mm-yy'
		});

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////			
		
		
		//CHOOSE Supplier
		var dTableBSuplier;
		loadDataBSuplier = function(){
			$.ajax(
			{
				type: 'GET',    
				url: '{{url('sup/browse')}}',

				success: function( response )
				{
			
					resp = response;
					if(dTableBSuplier){
						dTableBSuplier.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBSuplier.row.add([
							'<a href="javascript:void(0);" onclick="chooseSuplier(\''+resp[i].KODES+'\',  \''+resp[i].NAMAS+'\', \''+resp[i].ALAMAT+'\',  \''+resp[i].KOTA+'\')">'+resp[i].KODES+'</a>',
							resp[i].NAMAS,
							resp[i].ALAMAT,
							resp[i].KOTA,
						]);
					}
					dTableBSuplier.draw();
				}
			});
		}
		
		dTableBSuplier = $("#table-bsuplier").DataTable({
			
		});
		
		browseSuplier = function(){
			loadDataBSuplier();
			$("#browseSuplierModal").modal("show");
		}
		
		chooseSuplier = function(KODES,NAMAS, ALAMAT, KOTA){
			$("#KODES").val(KODES);
			$("#NAMAS").val(NAMAS);
			$("#ALAMAT").val(ALAMAT);
			$("#KOTA").val(KOTA);
			$("#browseSuplierModal").modal("hide");
		}
		
		$("#KODES").keypress(function(e){

			if(e.keyCode == 46){
				e.preventDefault();
				browseSuplier();
			}
		}); 
		
		
//////////////////////////////////////////////////////////////////////////////////////////////////


		//CHOOSE Acno
		var dTableBAcno;
		loadDataBAcno = function(){
			$.ajax(
			{
				type: 'GET',    
				url: '{{url('account/browse')}}',

				success: function( response )
				{
			
					resp = response;
					if(dTableBAcno){
						dTableBAcno.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBAcno.row.add([
							'<a href="javascript:void(0);" onclick="chooseAcno(\''+resp[i].ACNO+'\',  \''+resp[i].NAMA+'\' )">'+resp[i].ACNO+'</a>',
							resp[i].NAMA,
						]);
					}
					dTableBAcno.draw();
				}
			});
		}
		
		dTableBAcno = $("#table-bacno").DataTable({
			
		});
		
		browseAcno = function(){
			loadDataBAcno();
			$("#browseAcnoModal").modal("show");
		}
		
		chooseAcno = function(ACNO,NAMA){
			$("#ACNOA").val(ACNO);
			$("#NACNOA").val(NAMA);
			$("#browseAcnoModal").modal("hide");
		}
		
		$("#ACNOA").keypress(function(e){

			if(e.keyCode == 46){
				e.preventDefault();
				browseAcno();
			}
		}); 
		
		
		//////////////////////////////////////////////////////////////////////////////////////////////////

		//////////////////////////////////////////////////////////////////////////////////////////////////


		//CHOOSE Acno
		var dTableBAcnob;
		loadDataBAcnob = function(){
			$.ajax(
			{
				type: 'GET',    
				url: '{{url('account/browse')}}',

				success: function( response )
				{
			
					resp = response;
					if(dTableBAcnob){
						dTableBAcnob.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBAcnob.row.add([
							'<a href="javascript:void(0);" onclick="chooseAcnob(\''+resp[i].ACNO+'\',  \''+resp[i].NAMA+'\' )">'+resp[i].ACNO+'</a>',
							resp[i].NAMA,
						]);
					}
					dTableBAcnob.draw();
				}
			});
		}
		
		dTableBAcnob = $("#table-bacnob").DataTable({
			
		});
		
		browseAcnob = function(){
			loadDataBAcnob();
			$("#browseAcnobModal").modal("show");
		}
		
		chooseAcnob = function(ACNO,NAMA){
			$("#ACNOB").val(ACNO);
			$("#NACNOB").val(NAMA);
			$("#browseAcnobModal").modal("hide");
		}
		
		$("#ACNOB").keypress(function(e){

			if(e.keyCode == 46){
				e.preventDefault();
				browseAcnob();
			}
		}); 
		
		
		//////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////


		//CHOOSE Grup
		var dTableBGrup;
		loadDataBGrup = function(){
			$.ajax(
			{
				type: 'GET',    
				url: '{{url('grup/browse')}}',

				success: function( response )
				{
			
					resp = response;
					if(dTableBGrup){
						dTableBGrup.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBGrup.row.add([
							'<a href="javascript:void(0);" onclick="chooseGrup(\''+resp[i].KODE+'\',  \''+resp[i].NAMA+'\' )">'+resp[i].KODE+'</a>',
							resp[i].NAMA,
						]);
					}
					dTableBGrup.draw();
				}
			});
		}
		
		dTableBGrup = $("#table-bgrup").DataTable({
			
		});
		
		browseGrup = function(){
			loadDataBGrup();
			$("#browseGrupModal").modal("show");
		}
		
		chooseGrup = function(KODE,NAMA){
			$("#KD_GRUP").val(KODE);
			$("#NA_GRUP").val(NAMA);
			$("#browseGrupModal").modal("hide");
		}
		
		$("#KD_GRUP").keypress(function(e){

			if(e.keyCode == 46){
				e.preventDefault();
				browseGrup();
			}
		}); 
		
		
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////


		//CHOOSE Lokasi
		var dTableBLokasi;
		loadDataBLokasi = function(){
			$.ajax(
			{
				type: 'GET',    
				url: '{{url('lokasi/browse')}}',

				success: function( response )
				{
			
					resp = response;
					if(dTableBLokasi){
						dTableBLokasi.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBLokasi.row.add([
							'<a href="javascript:void(0);" onclick="chooseLokasi( \''+resp[i].NAMA+'\' )">'+resp[i].KODE+'</a>',
							resp[i].NAMA,
						]);
					}
					dTableBLokasi.draw();
				}
			});
		}
		
		dTableBLokasi = $("#table-blokasi").DataTable({
			
		});
		
		browseLokasi = function(){
			loadDataBLokasi();
			$("#browseLokasiModal").modal("show");
		}
		
		chooseLokasi = function(NAMA){
			$("#LOKASI").val(NAMA);
			$("#browseLokasiModal").modal("hide");
		}
		
		$("#LOKASI").keypress(function(e){

			if(e.keyCode == 46){
				e.preventDefault();
				browseLokasi();
			}
		}); 
		
		
//////////////////////////////////////////////////////////////////////////////////////////////////


		
    });

	function nomor() {
		var i = 1;
		$(".REC").each(function() {
			$(this).val(i++);
		});
		
	//	hitung();
	
	}

	function hitung() {
		// var TTOTAL_QTY = 0;
		// // var TTOTAL = 0;


		
		// $(".QTY").each(function() {
			
		// 	let z = $(this).closest('tr');
		// 	var QTYX = parseFloat(z.find('.QTY').val().replace(/,/g, ''));
		// 	// var HARGAX = parseFloat(z.find('.HARGA').val().replace(/,/g, ''));
	
	
        //     // var TOTALX  =  ( QTYX * HARGAX );
		// 	// z.find('.TOTAL').val(TOTALX);

		//     // z.find('.HARGA').autoNumeric('update');			
		//     // z.find('.QTY').autoNumeric('update');	
		//     // z.find('.TOTAL').autoNumeric('update');			

        //     TTOTAL_QTY +=QTYX;		
        //     // TTOTAL +=TOTALX;				
		
		// });
		

		
		// if(isNaN(TTOTAL_QTY)) TTOTAL_QTY = 0;

		// $('#TTOTAL_QTY').val(numberWithCommas(TTOTAL_QTY));		
		// $("#TTOTAL_QTY").autoNumeric('update');
		
		// if(isNaN(TTOTAL)) TTOTAL = 0;

		// $('#TTOTAL').val(numberWithCommas(TTOTAL));		
		// $("#TTOTAL").autoNumeric('update');



		
	}

	function baru() {
		
		 kosong();
		 hidup();
		 
	}
	
	function ganti() {
		
		mati();
		// hidup();
	
	}
	
	function batal() {
			
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
	    //$("#CLOSEX").attr("disabled", true);
		
		
 		$tipx = $('#tipx').val();
		
        if ( $tipx == 'new' )		
		{	
		  	
			$("#KD_BRG").attr("readonly", false);	

		   }
		else
		{
	     	$("#KD_BRG").attr("readonly", true);	

		}
		   
		
		$("#NA_BRG").attr("readonly", false);		
		$("#KD_GRUP").attr("readonly", true);			
		$("#NA_GRUP").attr("readonly", true);

		$("#LOKASI").attr("readonly", true);
		$("#SATUAN_BELI").attr("readonly", false);
		$("#KALI").attr("readonly", false);
		$("#SATUAN").attr("readonly", false);
		$("#MERK").attr("readonly", false);
		$("#JENIS").attr("readonly", false);
		$("#PANJANG").attr("readonly", false);
		$("#LEBAR").attr("readonly", false);
		$("#DIMENSI").attr("readonly", false);
		$("#VOLUME").attr("readonly", false);
		$("#ROP").attr("readonly", false);
		$("#SMIN").attr("readonly", false);
		$("#SMAX").attr("readonly", false);
		$("#GOL").attr("readonly", false);
		$("#PN").attr("readonly", false);

		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#REC" + i.toString()).attr("readonly", true);
			$("#RING" + i.toString()).attr("readonly", true);
			$("#HARGA" + i.toString()).attr("readonly", false);
			$("#HARGA1" + i.toString()).attr("readonly", false);
			$("#HARGA2" + i.toString()).attr("readonly", false);
			$("#HARGA3" + i.toString()).attr("readonly", false);
			$("#HARGA4" + i.toString()).attr("readonly", false);
			$("#HARGA5" + i.toString()).attr("readonly", false);
			$("#HARGA6" + i.toString()).attr("readonly", false);
			$("#HARGA7" + i.toString()).attr("readonly", false);

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
		
		$("#KD_BRG").attr("readonly", true);			
		$("#NA_BRG").attr("readonly", true);		
		$("#KD_GRUP").attr("readonly", true);			
		$("#NA_GRUP").attr("readonly", true);

		$("#LOKASI").attr("readonly", true);
		$("#SATUAN_BELI").attr("readonly", true);
		$("#KALI").attr("readonly", true);
		$("#SATUAN").attr("readonly", true);
		$("#MERK").attr("readonly", true);
		$("#JENIS").attr("readonly", true);
		$("#PANJANG").attr("readonly", true);
		$("#LEBAR").attr("readonly", true);
		$("#DIMENSI").attr("readonly", true);
		$("#VOLUME").attr("readonly", true);
		$("#ROP").attr("readonly", true);
		$("#SMIN").attr("readonly", true);
		$("#SMAX").attr("readonly", true);
		$("#GOL").attr("readonly", true);
		$("#PN").attr("readonly", true);

		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#REC" + i.toString()).attr("readonly", true);
			$("#RING" + i.toString()).attr("readonly", true);
			$("#HARGA" + i.toString()).attr("readonly", true);
			$("#HARGA1" + i.toString()).attr("readonly", true);
			$("#HARGA2" + i.toString()).attr("readonly", true);
			$("#HARGA3" + i.toString()).attr("readonly", true);
			$("#HARGA4" + i.toString()).attr("readonly", true);
			$("#HARGA5" + i.toString()).attr("readonly", true);
			$("#HARGA6" + i.toString()).attr("readonly", true);
			$("#HARGA7" + i.toString()).attr("readonly", true);

		}
		
	}


	function kosong() {
				
		 $('#KD_BRG').val("");	
		 $('#NA_BRG').val("");	
		 $('#GRUP').val("");	
		 $('#DR').val("");
		 $('#SUB').val("");		 
	}
	
	function hapusTrans() {
		let text = "Hapus Master "+$('#KD_BRG').val()+"?";
		if (confirm(text) == true) 
		{
			window.location ="{{url('/brg/delete/'.$header->NO_ID )}}'";
			//return true;
		} 
		return false;
	}

	function CariBukti() {
		
		var cari = $("#CARI").val();
		var loc = "{{ url('/brg/edit/') }}" + '?idx={{ $header->NO_ID}}&tipx=search&kodex=' +encodeURIComponent(cari);
		window.location = loc;
		
	}

    var hasilCek;
	function cekBarang(kdbrg) {
		$.ajax({
			type: "GET",
			url: "{{url('brg/cekbarang')}}",
            async: false,
			data: ({ KDBRG: kdbrg, }),
			success: function(data) {
                // hasilCek=data;
                if (data.length > 0) {
                    $.each(data, function(i, item) {
                        hasilCek=data[i].ADA;
                    });
                }
			},
			error: function() {
				alert('Error cekBarang occured');
			}
		});
		return hasilCek;
	}
    
	function simpan() {
        //cekBarang($('#KD_BRG').val());
        //(hasilCek==0) ? document.getElementById("entri").submit() : alert('Kode Barang '+$('#KD_BRG').val()+' sudah ada!');
        
        document.getElementById("entri").submit()
	}

	function tambah() {

		var x = document.getElementById('datatable').insertRow(baris + 1);

		html=`<tr>

				<td>
					<input name='NO_ID[]' id='NO_ID${idrow}' type='hidden' class='form-control NO_ID' value='new' readonly> 
					<input name='REC[]' id='REC${idrow}' type='text' class='REC form-control' onkeypress='return tabE(this,event)' readonly>
				</td>		
				
				<td>
					<input name='RING[]'   id='RING${idrow}' type='text' class='form-control  RING' readonly>
				</td>

				<td>
					<input name='HARGA[]' onclick='select()' onblur='hitung()' value='0' id='HARGA${idrow}' type='text' style='text-align: right' class='form-control HARGA text-primary' required >
				</td>
				<td>
					<input name='HARGA2[]' onclick='select()' onblur='hitung()' value='0' id='HARGA2${idrow}' type='text' style='text-align: right' class='form-control HARGA2 text-primary' required >
				</td>
				<td>
					<input name='HARGA3[]' onclick='select()' onblur='hitung()' value='0' id='HARGA3${idrow}' type='text' style='text-align: right' class='form-control HARGA3 text-primary' required >
				</td>
				<td>
					<input name='HARGA4[]' onclick='select()' onblur='hitung()' value='0' id='HARGA4${idrow}' type='text' style='text-align: right' class='form-control HARGA4 text-primary' required >
				</td>
				<td>
					<input name='HARGA5[]' onclick='select()' onblur='hitung()' value='0' id='HARGA5${idrow}' type='text' style='text-align: right' class='form-control HARGA5 text-primary' required >
				</td>
				<td>
					<input name='HARGA6[]' onclick='select()' onblur='hitung()' value='0' id='HARGA6${idrow}' type='text' style='text-align: right' class='form-control HARGA6 text-primary' required >
				</td>
				<td>
					<input name='HARGA7[]' onclick='select()' onblur='hitung()' value='0' id='HARGA7${idrow}' type='text' style='text-align: right' class='form-control HARGA7 text-primary' required >
				</td>			
		</tr>`;
				
		x.innerHTML = html;
		var html='';



		jumlahdata = 100;
		for (i = 0; i <= jumlahdata; i++) {
			$("#QTY" + i.toString()).autoNumeric('init', {
				aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
					
		}


		idrow++;
		baris++;
		nomor();

		$(".ronly").on('keydown paste', function(e) {
			e.preventDefault();
			e.currentTarget.blur();
		});
		}
</script>
@endsection