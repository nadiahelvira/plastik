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
            <h1 class="m-0">Data Pegawai </h1>
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
  
                    <form action="{{($tipx=='new')? url('/pegawai/store/') : url('/pegawai/update/'.$header->NO_ID ) }}" method="POST" name ="entri" id="entri" >
  
                      @csrf
						
                        <ul class="nav nav-tabs">
                            <li class="nav-item active">
                                <a class="nav-link active" href="#pegawaiInfo" data-toggle="tab">Pegawai Info</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="#bankInfo" data-toggle="tab">Bank Info</a>
                            </li> -->
                        </ul>
        
                        <div class="tab-content mt-3">
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

							<div id="pegawaiInfo" class="tab-pane active">
                             <div class="form-group row">
 
                                    <input type="text" class="form-control NO_ID" id="NO_ID" name="NO_ID"
                                    placeholder="Masukkan NO_ID" value="{{$header->NO_ID ?? ''}}" hidden readonly>

									<input name="tipx" class="form-control flagz" id="tipx" value="{{$tipx}}" hidden>

								<!-- code text box baru -->
								<div class="col-md-3 form-group row special-input-label">

									<input type="text" class="KODEP" id="KODEP" name="KODEP" 
										value="{{$header->KODEP}}" placeholder=" " >
									<label for="KODEP">Kode</label>
								</div>
								<!-- tutupannya -->
								
								<div class="col-md-1">
								</div>

								<!-- code text box baru -->
								<div class="col-md-3 form-group row special-input-label">

									<input type="text" class="NAMAP" id="NAMAP" name="NAMAP" 
										value="{{$header->NAMAP}}" placeholder=" " >
									<label for="NAMAP">Nama</label>
								</div>
								<!-- tutupannya -->
								
								<div class="col-md-1">
								</div>

								<div class="col-md-1">
									<label for="STA" class="form-label">Status</label>
								</div>
								<div class="col-md-1">
									<select id="STA" class="form-control"  name="STA">
										<option value="SALES" {{ ($header->STA == 'SALES') ? 'selected' : '' }}>Sales</option>
										<option value="PEGAWAI" {{ ($header->STA == 'PEGAWAI') ? 'selected' : '' }}>Pegawai</option>
										<option value="SOPIR" {{ ($header->STA == 'SOPIR') ? 'selected' : '' }}>Sopir</option>
									</select>
								</div>
                            </div>
        
                            <div class="form-group row">
								<!-- code text box baru -->
								<div class="col-md-3 form-group row special-input-label">

									<input type="text" class="NO_KTP" id="NO_KTP" name="NO_KTP" 
										value="{{$header->NO_KTP}}" placeholder=" " >
									<label for="NO_KTP">No. KTP</label>
								</div>
								<!-- tutupannya -->

								<div class="col-md-1">
								</div>
								
								<!-- code text box baru -->
								<div class="col-md-3 form-group row special-input-label">

									<input type="text" class="ALAMAT" id="ALAMAT" name="ALAMAT" 
										value="{{$header->ALAMAT}}" placeholder=" " >
									<label for="ALAMAT">Alamat</label>
								</div>
								<!-- tutupannya -->

								<div class="col-md-1">
								</div>

                               <!-- code text box baru -->
								<div class="col-md-3 form-group row special-input-label">

									<input type="text" class="KOTA" id="KOTA" name="KOTA" 
										value="{{$header->KOTA}}" placeholder=" " >
									<label for="KOTA">Kota</label>
								</div>
								<!-- tutupannya -->
							</div>
 
							<div class="form-group row">
								<!-- code text box baru -->
								<div class="col-md-3 form-group row special-input-label">

									<input type="text" class="TELPON" id="TELPON" name="TELPON" 
										value="{{$header->TELPON}}" placeholder=" " >
									<label for="TELPON">Telpon</label>
								</div>
								<!-- tutupannya -->

								<div class="col-md-1">
								</div>

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

									<input type="text" class="HP" id="HP" name="HP" 
										value="{{$header->HP}}" placeholder=" " >
									<label for="HP">HP</label>
								</div>
								<!-- tutupannya -->
                            </div>

							<!-- loader tampil di modal  -->
							<div class="loader" style="z-index: 1055;" id='LOADX' ></div>
 
							<div class="form-group row">
                                <!-- <div class="col-md-1">
                                    <label for="UMAKAN" class="form-label">Uang Makan / hari</label>
                                </div>
								<div class="col-md-2">
									<input type="text" class="form-control UMAKAN" onclick="select()"  id="UMAKAN" name="UMAKAN" placeholder="" value="{{ number_format($header->UMAKAN, 2, '.', ',') }}" style="text-align: right; width:140px" readonly>
								</div>  -->

								<!-- code text box baru -->
								<div class="col-md-3 form-group row special-input-label">

									<input type="text" class="UMAKAN" id="UMAKAN" name="UMAKAN" 
										value="{{$header->UMAKAN}}" placeholder=" " >
									<label for="UMAKAN">Uang Makan / Hari</label>
								</div>
								<!-- tutupannya -->

								<div class="col-md-1">
								</div>

                                <!-- <div class="col-md-1">
                                    <label for="KOM" class="form-label">Komisi (%)</label>
                                </div>
								<div class="col-md-2">
									<input type="text" class="form-control KOM" onclick="select()"  id="KOM" name="KOM" placeholder="" value="{{ number_format($header->KOM, 2, '.', ',') }}" style="text-align: right; width:140px" readonly>
								</div>  -->

								<!-- code text box baru -->
								<div class="col-md-3 form-group row special-input-label" hidden>

									<input type="text" class="KOM" id="KOM" name="KOM" 
										value="{{$header->KOM}}" placeholder=" " >
									<label for="KOM">Komisi (%)</label>
								</div>
								<!-- tutupannya -->

								<!-- code text box baru -->
								<div class="col-md-3 form-group row special-input-label">

									<input type="text" class="PINJAM" id="PINJAM" name="PINJAM" 
										value="{{$header->PINJAM}}" placeholder=" " >
									<label for="PINJAM">Kas Bon</label>
								</div>
								<!-- tutupannya -->

								<div class="col-md-1">
								</div>

								<!-- <div class="col-md-1">
									<label for="GAJI" class="form-label">Gaji / hari</label>
								</div>
								<div class="col-md-2">
									<input type="text" class="form-control GAJI" onclick="select()"  id="GAJI" name="GAJI" placeholder="" value="{{ number_format($header->GAJI, 2, '.', ',') }}" style="text-align: right; width:140px" readonly>
								</div> -->

								<!-- code text box baru -->
								<div class="col-md-3 form-group row special-input-label">

									<input type="text" class="GAJI" id="GAJI" name="GAJI" 
										value="{{$header->GAJI}}" placeholder=" " >
									<label for="GAJI">Gaji / Hari</label>
								</div>
								<!-- tutupannya -->
                            </div> 
							
							
						</div>
                                
                        </div>
        
						<div class="mt-3 col-md-12 form-group row">
							<div class="col-md-4">
								<button type="button" id='TOPX'  onclick="location.href='{{url('/pegawai/edit/?idx=' .$idx. '&tipx=top')}}'" class="btn btn-outline-primary">Top</button>
								<button type="button" id='PREVX' onclick="location.href='{{url('/pegawai/edit/?idx='.$header->NO_ID.'&tipx=prev&kodex='.$header->KODEP )}}'" class="btn btn-outline-primary">Prev</button>
								<button type="button" id='NEXTX' onclick="location.href='{{url('/pegawai/edit/?idx='.$header->NO_ID.'&tipx=next&kodex='.$header->KODEP )}}'" class="btn btn-outline-primary">Next</button>
								<button type="button" id='BOTTOMX' onclick="location.href='{{url('/pegawai/edit/?idx=' .$idx. '&tipx=bottom')}}'" class="btn btn-outline-primary">Bottom</button>
							</div>
							<div class="col-md-5">
								<button type="button" id='NEWX' onclick="location.href='{{url('/pegawai/edit/?idx=0&tipx=new')}}'" class="btn btn-warning">New</button>
								<button type="button" id='EDITX' onclick='hidup()' class="btn btn-secondary">Edit</button>                    
								<button type="button" id='UNDOX' onclick="location.href='{{url('/pegawai/edit/?idx=' .$idx. '&tipx=undo' )}}'" class="btn btn-info">Undo</button> 
								<button type="button" id='SAVEX' onclick='simpan()'   class="btn btn-success" class="fa fa-save"></i>Save</button>

							</div>
							<div class="col-md-3">
								<button type="button" id='HAPUSX'  onclick="hapusTrans()" class="btn btn-outline-danger">Hapus</button>
								
								<!-- <button type="button" id='CLOSEX'  onclick="location.href='{{url('/pegawai' )}}'" class="btn btn-outline-secondary">Close</button> -->

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

		$("#UMAKAN").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#KOM").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#GAJI").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		
    });


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
		  	
			$("#KODEP").attr("readonly", false);	

		   }
		else
		{
	     	$("#KODEP").attr("readonly", true);	

		   }
		   
		
		$("#NAMAP").attr("readonly", false);	
		$("#ALAMAT").attr("readonly", false);			
		$("#KOTA").attr("readonly", false);		
		$("#TELPON").attr("readonly", false);			
		$("#NO_KTP").attr("readonly", false);	
		$("#HP").attr("readonly", false);			
		$("#AKT").attr("readonly", false);		
		$('#TELPON').attr("readonly", false);

		 $('#UMAKAN').attr("readonly", false);	
		 $('#KOM').attr("readonly", false);	
		 $('#GAJI').attr("readonly", false);


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
		
		$("#KODEP").attr("readonly", true);			
		$("#NAMAP").attr("readonly", true);	
		$("#ALAMAT").attr("readonly", true);			
		$("#KOTA").attr("readonly", true);		
		$("#TELPON").attr("readonly", true);			
		$("#NO_KTP").attr("readonly", true);	
		$("#HP").attr("readonly", true);			
		$("#AKT").attr("readonly", true);		
		$('#TELPON').attr("readonly", true);

		$('#UMAKAN').attr("readonly", true);	
		$('#KOM').attr("readonly", true);	
		$('#GAJI').attr("readonly", true);


		 $('#BANK').attr("readonly", true);	
		 $('#BANK_CAB').attr("readonly", true);	
		 $('#BANK_KOTA').attr("readonly", true);	
		 $('#BANK_NAMA').attr("readonly", true);		
		 $('#BANK_REK').attr("readonly", true);
		 $('#HARI').attr("readonly", true);
		 $('#LIM').attr("readonly", true);	
		
	}


	function kosong() {
				
		 $('#KODEP').val("");	
		 $('#NAMAP').val("");	
		 $('#ALAMAT').val("");	
		 $('#KOTA').val("");		

		 $('#TELPON').val("");	
		 $('#NO_KTP').val("");	
		 $('#HP').val("");	
		 $('#AKT').val("0");		
		 $('#TELPON').val("");

		 $('#EMAIL').val("");	
		 $('#NPWP').val("");	
		 $('#KET').val("");	


		 $('#BANK').val("");	
		 $('#BANK_CAB').val("");	
		 $('#BANK_KOTA').val("");	
		 $('#BANK_NAMA').val("");		
		 $('#BANK_REK').val("");
		 $('#UMAKAN').val("0");
		 $('#KOM').val("0");	
		 $('#GAJI').val("0");	

		 
	}
	
	// function hapusTrans() {
	// 	let text = "Hapus Master "+$('#KODEP').val()+"?";
	// 	if (confirm(text) == true) 
	// 	{
	// 		window.location ="{{url('/pegawai/delete/'.$header->NO_ID )}}'";
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
	            	loc = "{{ url('/pegawai/delete/'.$header->NO_ID) }}"  ;

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
	        	loc = "{{ url('/pegawai/') }}" ;
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
		var loc = "{{ url('/pegawai/edit/') }}" + '?idx={{ $header->NO_ID}}&tipx=search&kodex=' +encodeURIComponent(cari);
		window.location = loc;
		
	}
	

     var hasilCek;
	function cekPegawai(kodep) {
		$.ajax({
			type: "GET",
			url: "{{url('pegawai/cekpegawai')}}",
            async: false,
			data: ({ KODEP: kodep, }),
			success: function(data) {
                if (data.length > 0) {
                    $.each(data, function(i, item) {
                        hasilCek=data[i].ADA;
                    });
                }
			},
			error: function() {
				alert('Error cekPegawai occured');
			}
		});
		return hasilCek;
	}
    
	function simpan() {
        hasilCek=0;
		$tipx = $('#tipx').val();
				
        if ( $tipx == 'new' )
		{
			cekPegawai($('#KODEP').val());		
		}
		

        (hasilCek==0) ? document.getElementById("entri").submit() : alert('Pegawai '+$('#KODEP').val()+' sudah ada!');
	
		$("#LOADX").hide();
	}
</script>
@endsection

