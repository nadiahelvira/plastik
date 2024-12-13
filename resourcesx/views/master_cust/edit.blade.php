@extends('layouts.plain')

<style>
    .card {

    }

    .form-control:focus {
        background-color: #E0FFFF !important;
    }

	/* perubahan tab warna di form edit  */
	.nav-item .nav-link.active {
		background-color: red !important; /* Use !important to ensure it overrides */
		color: white !important;
	}

	/* query LOADX */

	.loader {
      position: fixed;
        top: 50%;
        left: 50%;
      width: 100px;
      aspect-ratio: 1;
      background:
        radial-gradient(farthest-side,#ffa516 90%,#0000) center/16px 16px,
        radial-gradient(farthest-side,green   90%,#0000) bottom/12px 12px;
      background-repeat: no-repeat;
      animation: l17 1s infinite linear;
      position: relative;
    }
    .loader::before {    
      content:"";
      position: absolute;
      width: 8px;
      aspect-ratio: 1;
      inset: auto 0 16px;
      margin: auto;
      background: #ccc;
      border-radius: 50%;
      transform-origin: 50% calc(100% + 10px);
      animation: inherit;
      animation-duration: 0.5s;
    }
    @keyframes l17 { 
      100%{transform: rotate(1turn)}
    }

	/* penutup LOADX */
</style>

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Data Customer </h1>
            </div>
            <!-- /.col -->
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
  
                    <form action="{{($tipx=='new')? url('/cust/store/') : url('/cust/update/'.$header->NO_ID ) }}" method="POST" name ="entri" id="entri" >
  
                      @csrf
						
                        <ul class="nav nav-tabs">
                            <li class="nav-item active">
                                <a class="nav-link active" href="#custInfo" data-toggle="tab">Cust Info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#bankInfo" data-toggle="tab">Bank Info</a>
                            </li>
                        </ul>
        
                        <div class="tab-content mt-3">

							<!-- style text box model baru -->

							<style>
								/* Ensure specificity with class targeting */
								.form-group.special-input-label {
									position: relative;
									margin-left: 5px ;
								}
						
								/* Ensure only bottom border for input */
								.form-group.special-input-label input {
									width: 100%;
									padding: 10px 0;
									border: none !important;
									border-bottom: 2px solid #ccc !important;
									outline: none !important;
									font-size: 16px !important;
									background: transparent !important; /* Remove any background color */
								}
						
								/* Bottom border color change on focus */
								.form-group.special-input-label input:focus {
									border-bottom: 2px solid #007BFF !important; /* Change color on focus */
								}
						
								/* Style the label with a higher specificity */
								.form-group.special-input-label label {
									position: absolute;
									top: 12px;
									color: #888 !important;
									font-size: 16px !important;
									transition: 0.3s ease all;
									pointer-events: none;
								}
						
								/* Move label above input when focused or has content */
								.form-group.special-input-label input:focus + label,
								.form-group.special-input-label input:not(:placeholder-shown) + label {
									top: -10px !important;
									font-size: 12px !important;
									color: #007BFF !important;
								}
							</style>

							<!-- tutupannya -->


							<div id="custInfo" class="tab-pane active">
        
                             <div class="form-group row">
 
                                    <input type="text" class="form-control NO_ID" id="NO_ID" name="NO_ID"
                                    placeholder="Masukkan NO_ID" value="{{$header->NO_ID ?? ''}}" hidden readonly>

									<input name="tipx" class="form-control flagz" id="tipx" value="{{$tipx}}" hidden>

								<!-- code text box baru -->
								<div class="col-md-3 form-group row special-input-label">

									<input type="text" class="KODEC" id="KODEC" name="KODEC" 
										value="{{$header->KODEC}}" placeholder=" " >
									<label for="KODEC">Kode</label>
								</div>
								<!-- tutupannya -->  

								<div class="col-md-1">
								</div>
								
								<!-- code text box baru -->
								<div class="col-md-3 form-group row special-input-label">

									<input type="text" class="NAMAC" id="NAMAC" name="NAMAC" 
										value="{{$header->NAMAC}}" placeholder=" " >
									<label for="NAMAC">Nama</label>
								</div>
								<!-- tutupannya -->  
									
								<div class="col-md-1">
								</div>

								<div class="col-md-1">
									<input type="checkbox" class="form-check-input" id="PKP" name="PKP" value="1" {{ ($header->PKP == 1) ? 'checked' : '' }}>
									<label for="PKP">PKP</label>
								</div>	

								<div class="col-md-1" align="right">
									<label for="GOL" class="form-label">Golongan</label>
								</div>
								<div class="col-md-1">
									<select id="GOL" class="form-control"  name="GOL">
										<option value="Y" {{ ($header->GOL == 'Y') ? 'selected' : '' }}>Y</option>
										<option value="Z" {{ ($header->GOL == 'Z') ? 'selected' : '' }}>Z</option>
									</select>
                            	</div> 
							
								<div class="col-md-4" hidden>
									<input type="checkbox" class="form-check-input" id="AKT"name="AKT"
									placeholder="Masukkan Aktif/Tidak" value="1" {{ ($header->AKT == 1) ? 'checked' : '' }}>
									<label for="AKT">Aktif</label>
								</div>                                             
                            </div>
        
                            <div class="form-group row">
                                <!-- code text box baru -->
								<div class="col-md-3 form-group row special-input-label">

									<input type="text" class="ALAMAT" id="ALAMAT" name="ALAMAT" 
										value="{{$header->ALAMAT}}" placeholder=" " >
									<label for="ALAMAT">Alamat 1</label>
								</div>
								<!-- tutupannya -->  

								<div class="col-md-1">
								</div>

								<!-- code text box baru -->
								<div class="col-md-3 form-group row special-input-label">

									<input type="text" class="KOTA" id="KOTA" name="KOTA" 
										value="{{$header->KOTA}}" placeholder=" " >
									<!-- <label style="color:red">*</label>	 -->
									<label for="KOTA" style="color:red">*Kota (pilih kota)</label>
								</div>
								<!-- tutupannya -->  

								<div class="col-md-1" align="right">
									<label for="RING" class="form-label">Ring</label>
								</div>
								
								 <div class="col-md-1">
									<select id="RING" class="form-control"  name="RING">
										<option value="LOKAL" {{ ($header->RING == 'LOKAL') ? 'selected' : '' }}>Lokal</option>
										<option value="1" {{ ($header->RING == '1') ? 'selected' : '' }}>1</option>
										<option value="2" {{ ($header->RING == '2') ? 'selected' : '' }}>2</option>
										<option value="3" {{ ($header->RING == '3') ? 'selected' : '' }}>3</option>
									</select>
								</div>
							</div>
        
							<div class="form-group row">
							
								<!-- code text box baru -->
								<div class="col-md-3 form-group row special-input-label">

									<input type="text" class="KONTAK" id="KONTAK" name="KONTAK" 
										value="{{$header->KONTAK}}" placeholder=" " >
									<label for="KONTAK">Kontak</label>
								</div>
								<!-- tutupannya -->

								<div class="col-md-1">
								</div>

								 <!-- code text box baru -->
								 <div class="col-md-3 form-group row special-input-label">

									<input type="text" class="TELPON1" id="TELPON1" name="TELPON1" 
										value="{{$header->TELPON1}}" placeholder=" " >
									<label for="TELPON1">Telepon</label>
								</div>
								<!-- tutupannya --> 

								<div class="col-md-1">
								</div>

								<!-- code text box baru -->
								<div class="col-md-3 form-group row special-input-label">

									<input type="text" class="HP" id="HP" name="HP" 
										value="{{$header->HP}}" placeholder=" " >
									<label for="HP">HP</label>
								</div>
								<!-- tutupannya -->

                            </div>

							
							<div class="form-group row">
								<!-- code text box baru -->
								<div class="col-md-3 form-group row special-input-label">

									<input type="text" class="FAX" id="FAX" name="FAX" 
										value="{{$header->FAX}}" placeholder=" " >
									<label for="FAX">Fax</label>
								</div>
								<!-- tutupannya -->

								<div class="col-md-1">
								</div>

								<!-- code text box baru -->
								<div class="col-md-3 form-group row special-input-label">

									<input type="text" class="EMAIL" id="EMAIL" name="EMAIL" 
										value="{{$header->EMAIL}}" placeholder=" " >
									<label for="EMAIL">Email</label>
								</div>
								<!-- tutupannya -->

								<div class="col-md-1">
								</div>

								<!-- code text box baru -->
								<div class="col-md-3 form-group row special-input-label">

									<input type="text" class="NPWP" id="NPWP" name="NPWP" 
										value="{{$header->NPWP}}" placeholder=" " >
									<label for="NPWP">NPWP</label>
								</div>
								<!-- tutupannya -->

							</div>

							<div class="form-group row">

                                <!-- code text box baru -->
								<div class="col-md-3 form-group row special-input-label">

									<input type="text" class="KET" id="KET" name="KET" 
										value="{{$header->KET}}" placeholder=" " >
									<label for="KET">Ket</label>
								</div>
								<!-- tutupannya -->

								<div class="col-md-1">
								</div>

								<!-- code text box baru -->
								<div class="col-md-1 form-group row special-input-label">

									<input type="text" class="KODEP" id="KODEP" name="KODEP" 
										value="{{$header->KODEP}}" placeholder=" " >
									<label for="KODEP">Sales</label>

								</div>

								<div class="col-md-1 form-group row special-input-label">
									<button type="button" class="btn btn-primary" onclick="browsePegawai()" style="width:40px"><i class="fa fa-search"></i></button>
								</div>
								<!-- tutupannya -->  
        
                                <div class="col-md-3 form-group row special-input-label">

									<input type="text" class="NAMAP" id="NAMAP" name="NAMAP" 
										value="{{$header->NAMAP}}" placeholder=" " >
									<label for="NAMAP"></label>
									
								</div>
                            </div>

							<!-- loader tampil di modal  -->
							<div class="loader" style="z-index: 1055;" id='LOADX' ></div>
 
							
						 </div>

							
							<div id="bankInfo" class="tab-pane">
				
								<div class="form-group row">
									<div class="col-md-1">
										<label for="BANK" class="form-label">Bank</label>
									</div>
									<div class="col-md-2">
										<select name="BANK" id="BANK" class="form-control BANK" style="width: 300px">
											<option value="">--Pilih Bank--</option>
											@foreach($pilihbank as $pilihbankD)
												<option value="{{$pilihbankD->KODE}}" {{ $header->BANK == $pilihbankD->KODE ? 'selected' : '' }}>{{ $pilihbankD->NAMA }}</option>
											@endforeach
										</select>
									</div>       

									<div class="col-md-1">
									</div>			

									<!-- code text box baru -->
									<div class="col-md-3 form-group row special-input-label">

										<input type="text" class="BANK_CAB" id="BANK_CAB" name="BANK_CAB" 
											value="{{$header->BANK_CAB}}" placeholder=" " >
										<label for="BANK_CAB">Cabang</label>
									</div>
									<!-- tutupannya -->

									<div class="col-md-1">
									</div>			

									<!-- code text box baru -->
									<div class="col-md-3 form-group row special-input-label">

										<input type="text" class="BANK_KOTA" id="BANK_KOTA" name="BANK_KOTA" 
											value="{{$header->BANK_KOTA}}" placeholder=" " >
										<label for="BANK_KOTA">Kota</label>
									</div>
									<!-- tutupannya -->

								</div>
								
								<div class="form-group row">
									<!-- code text box baru -->
									<div class="col-md-3 form-group row special-input-label">

										<input type="text" class="BANK_NAMA" id="BANK_NAMA" name="BANK_NAMA" 
											value="{{$header->BANK_NAMA}}" placeholder=" " >
										<label for="BANK_NAMA">A/N</label>
									</div>
									<!-- tutupannya -->

									<div class="col-md-1">
									</div>			

									<!-- code text box baru -->
									<div class="col-md-3 form-group row special-input-label">

										<input type="text" class="BANK_REK" id="BANK_REK" name="BANK_REK" 
											value="{{$header->BANK_REK}}" placeholder=" " >
										<label for="BANK_REK">Rek</label>
									</div>
									<!-- tutupannya -->

									<div class="col-md-1">
									</div>			

									<!-- code text box baru -->
									<div class="col-md-3 form-group row special-input-label">

										<input type="text" class="LIM" id="LIM" name="LIM" 
											value="{{$header->LIM}}" placeholder=" " >
										<label for="LIM">Kredit Limit</label>
									</div>
									<!-- tutupannya -->
									

								</div>

								<div class="form-group row">
									
									<div class="col-md-3 form-group row special-input-label">

										<input type="text" class="HARI" id="HARI" name="HARI" 
											value="{{$header->HARI}}" placeholder=" " >
										<label for="HARI">Jatuh Tempo (Hari)</label>
									</div>
									<!-- tutupannya -->

								</div>
								
							</div>
						</div>
                                
                        </div>
        
						<div class="mt-3 col-md-12 form-group row">
							<div class="col-md-4">
								<button type="button" id='TOPX'  onclick="location.href='{{url('/cust/edit/?idx=' .$idx. '&tipx=top')}}'" class="btn btn-outline-primary">Top</button>
								<button type="button" id='PREVX' onclick="location.href='{{url('/cust/edit/?idx='.$header->NO_ID.'&tipx=prev&kodex='.$header->KODEC )}}'" class="btn btn-outline-primary">Prev</button>
								<button type="button" id='NEXTX' onclick="location.href='{{url('/cust/edit/?idx='.$header->NO_ID.'&tipx=next&kodex='.$header->KODEC )}}'" class="btn btn-outline-primary">Next</button>
								<button type="button" id='BOTTOMX' onclick="location.href='{{url('/cust/edit/?idx=' .$idx. '&tipx=bottom')}}'" class="btn btn-outline-primary">Bottom</button>
							</div>
							<div class="col-md-5">
								<button type="button" id='NEWX' onclick="location.href='{{url('/cust/edit/?idx=0&tipx=new')}}'" class="btn btn-warning">New</button>
								<button type="button" id='EDITX' onclick='hidup()' class="btn btn-secondary">Edit</button>                    
								<button type="button" id='UNDOX' onclick="location.href='{{url('/cust/edit/?idx=' .$idx. '&tipx=undo' )}}'" class="btn btn-info">Undo</button> 
								<button type="button" id='SAVEX' onclick='simpan()'   class="btn btn-success" class="fa fa-save"></i>Save</button>

							</div>
							<div class="col-md-3">
								<button type="button" id='HAPUSX'  onclick="hapusTrans()" class="btn btn-outline-danger">Hapus</button>
								
								<!-- <button type="button" id='CLOSEX'  onclick="location.href='{{url('/cust' )}}'" class="btn btn-outline-secondary">Close</button> -->

								<!-- tombol close sweet alert -->
								<button type="button" id='CLOSEX' onclick="closeTrans()" class="btn btn-outline-secondary">Close</button></div>
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

	<div class="modal fade" id="browsePegawaiModal" tabindex="-1" role="dialog" aria-labelledby="browsePegawaiModalLabel" aria-hidden="true">
	 <div class="modal-dialog mw-100 w-75" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browsePegawaiModalLabel">Cari Pegawai</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-pegawai">
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

	<div class="modal fade" id="browseKotaModal" tabindex="-1" role="dialog" aria-labelledby="browseKotaModalLabel" aria-hidden="true">
	 <div class="modal-dialog mw-100 w-75" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseKotaModalLabel">Cari Kota</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-kota">
				<thead>
					<tr>
						<th>Kota</th>
						<th>Ring</th>
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


<!-- tambahan untuk sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- tutupannya -->

<script>
    var target;
	var idrow = 1;

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

    $(document).ready(function () {

		setTimeout(function(){

		$("#LOADX").hide();

		},500);	

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
		}

        if ( $tipx != 'new' )
		{
			 //mati();	
    		 ganti();
		} 

		$("#LIM").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		// $("#HARI").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999'});
		
    });

	//////////////////////////////////////////////////////////////////////////////////////////////////


		//CHOOSE Pegawai
		var dTableBPegawai;
		loadDataBPegawai = function(){
			$.ajax(
			{
				type: 'GET',    
				url: '{{url('pegawai/browse')}}',

				beforeSend: function(){
					$("#LOADX").show();
				},

				success: function( response )
				{
					$("#LOADX").hide();
			
					resp = response;
					if(dTableBPegawai){
						dTableBPegawai.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBPegawai.row.add([
							'<a href="javascript:void(0);" onclick="choosePegawai(\''+resp[i].KODEP+'\',  \''+resp[i].NAMAP+'\' )">'+resp[i].KODEP+'</a>',
							resp[i].NAMAP,
						]);
					}
					dTableBPegawai.draw();
				}
			});
		}
		
		dTableBPegawai = $("#table-pegawai").DataTable({
			
		});
		
		browsePegawai = function(){
			loadDataBPegawai();
			$("#browsePegawaiModal").modal("show");
		}
		
		choosePegawai = function(KODEP,NAMAP){
			$("#KODEP").val(KODEP);
			$("#NAMAP").val(NAMAP);
			$("#browsePegawaiModal").modal("hide");
		}
		
		$("#KODEP").keypress(function(e){

			if(e.keyCode == 46){
				e.preventDefault();
				browsePegawai();
			}
		}); 
		
		
		//////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////


		//CHOOSE Kota
		var dTableBKota;
		loadDataBKota = function(){
			$.ajax(
			{
				type: 'GET',    
				url: '{{url('kota/browse')}}',

				success: function( response )
				{
			
					resp = response;
					if(dTableBKota){
						dTableBKota.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBKota.row.add([
							'<a href="javascript:void(0);" onclick="chooseKota(\''+resp[i].KOTA+'\',  \''+resp[i].RING+'\' )">'+resp[i].KOTA+'</a>',
							resp[i].RING,
						]);
					}
					dTableBKota.draw();
				}
			});
		}
		
		dTableBKota = $("#table-kota").DataTable({
			
		});
		
		browseKota = function(){
			loadDataBKota();
			$("#browseKotaModal").modal("show");
		}
		
		chooseKota = function(KOTA,RING){
			$("#KOTA").val(KOTA);
			$("#browseKotaModal").modal("hide");
		}
		
		$("#KOTA").keypress(function(e){

			if(e.keyCode == 46){
				e.preventDefault();
				browseKota();
			}
		}); 
		
		
		//////////////////////////////////////////////////////////////////////////////////////////////////


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
	    $("#CLOSEX").attr("disabled", true);
		
		
 		$tipx = $('#tipx').val();
		
        if ( $tipx == 'new' )		
		{	
		  	
			$("#KODEC").attr("readonly", false);	

		   }
		else
		{
	     	$("#KODEC").attr("readonly", true);	

		   }
		   
		
		$("#NAMAC").attr("readonly", false);	
		$("#ALAMAT").attr("readonly", false);			
		$("#KOTA").attr("readonly", true);		
		$("#TELPON1").attr("readonly", false);			
		$("#FAX").attr("readonly", false);	
		$("#HP").attr("readonly", false);			
		$("#AKT").attr("readonly", false);		
		$('#KONTAK').attr("readonly", false);

		 $('#EMAIL').attr("readonly", false);	
		 $('#NPWP').attr("readonly", false);	
		 $('#KET').attr("readonly", false);


		 $('#BANK').attr("readonly", false);	
		 $('#BANK_CAB').attr("readonly", false);	
		 $('#BANK_KOTA').attr("readonly", false);	
		 $('#BANK_NAMA').attr("readonly", false);		
		 $('#BANK_REK').attr("readonly", false);
		 $('#HARI').attr("readonly", false);
		 $('#LIM').attr("readonly", false);
		
		//document.getElementById("KET").disabled = false;
		
	
	
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
		
		$("#KODEC").attr("readonly", true);			
		$("#NAMAC").attr("readonly", true);	
		$("#ALAMAT").attr("readonly", true);			
		$("#KOTA").attr("readonly", true);		
		$("#TELPON1").attr("readonly", true);			
		$("#FAX").attr("readonly", true);	
		$("#HP").attr("readonly", true);			
		$("#AKT").attr("readonly", true);		
		$('#KONTAK').attr("readonly", true);

		 $('#EMAIL').attr("readonly", true);	
		 $('#NPWP').attr("readonly", true);	
		 $('#KET').attr("readonly", true);


		 $('#BANK').attr("readonly", true);	
		 $('#BANK_CAB').attr("readonly", true);	
		 $('#BANK_KOTA').attr("readonly", true);	
		 $('#BANK_NAMA').attr("readonly", true);		
		 $('#BANK_REK').attr("readonly", true);
		 $('#HARI').attr("readonly", true);
		 $('#LIM').attr("readonly", true);	
		
	}


	function kosong() {
				
		 $('#KODEC').val("");	
		 $('#NAMAC').val("");	
		 $('#ALAMAT').val("");	
		 $('#KOTA').val("");		

		 $('#TELPON1').val("");	
		 $('#FAX').val("");	
		 $('#HP').val("");	
		 $('#AKT').val("0");		
		 $('#KONTAK').val("");

		 $('#EMAIL').val("");	
		 $('#NPWP').val("");	
		 $('#KET').val("");	


		 $('#BANK').val("");	
		 $('#BANK_CAB').val("");	
		 $('#BANK_KOTA').val("");	
		 $('#BANK_NAMA').val("");		
		 $('#BANK_REK').val("");
		 $('#HARI').val("0");
		 $('#LIM').val("0");	

		 
	}
	
	// function hapusTrans() {
	// 	let text = "Hapus Master "+$('#KODEC').val()+"?";
	// 	if (confirm(text) == true) 
	// 	{
	// 		window.location ="{{url('/cust/delete/'.$header->NO_ID )}}'";
	// 		//return true;
	// 	} 
	// 	return false;
	// }

	// sweetalert untuk tombol hapus dan close
	
	function hapusTrans() {
		let text = "Hapus Transaksi "+$('#NO_BUKTI').val()+"?";

		var loc ='';
		
		Swal.fire({
			title: 'Are you sure?',
			text: text,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!',
			cancelButtonText: 'Cancel'
		}).then((result) => {
			if (result.isConfirmed) {
				// Show a success message before redirecting to delete the data
				Swal.fire({
					title: 'Deleted!',
					text: 'Data has been deleted.',
					icon: 'success',
					confirmButtonText: 'OK'
				}).then(() => {
					// Redirect to delete the data after user confirms the success message
	            	loc = "{{ url('/cust/delete/'.$header->NO_ID) }}"  ;

		            // alert(loc);
	            	window.location = loc;
		
				});
			}
		});
	}
	
	function closeTrans() {
		console.log("masuk");
		var loc ='';
		
		Swal.fire({
			title: 'Are you sure?',
			text: 'Do you really want to close this page? Unsaved changes will be lost.',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Yes, close it',
			cancelButtonText: 'No, stay here'
		}).then((result) => {
			if (result.isConfirmed) {
	        	loc = "{{ url('/cust/') }}" ;
				window.location = loc ;
			} else {
				Swal.fire({
					icon: 'info',
					title: 'Cancelled',
					text: 'You stayed on the page'
				});
			}
		});
	}

	// tutupannya

	function CariBukti() {
		
		var cari = $("#CARI").val();
		var loc = "{{ url('/cust/edit/') }}" + '?idx={{ $header->NO_ID}}&tipx=search&kodex=' +encodeURIComponent(cari);
		window.location = loc;
		
	}
	

     var hasilCek;
	function cekCust(kodec) {
		$.ajax({
			type: "GET",
			url: "{{url('cust/cekcust')}}",
            async: false,
			data: ({ KODEC: kodec, }),
			success: function(data) {
                if (data.length > 0) {
                    $.each(data, function(i, item) {
                        hasilCek=data[i].ADA;
                    });
                }
			},
			error: function() {
				alert('Error cekCust occured');
			}
		});
		return hasilCek;
	}
    
	function simpan() {
        cekCust($('#KODEC').val());
        (hasilCek==0) ? document.getElementById("entri").submit() : alert('Customer '+$('#KODEC').val()+' sudah ada!');
        // document.getElementById("entri").submit() 

		$("#LOADX").hide();
	}
</script>
@endsection

