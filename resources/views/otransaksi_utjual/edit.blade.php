@extends('layouts.plain')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .card {

    }

    .form-control:focus {
        background-color: #E0FFFF !important;
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

    /* menghilangkan padding */
    .content-header {
        padding: 0 !important;
    }

</style>

@section('content')



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
																
                    <form action="{{($tipx=='new')? url('/utjual/store?flagz='.$flagz.'') : url('/utjual/update/'.$header->NO_ID.'&flagz='.$flagz.'' ) }}" method="POST" name ="entri" id="entri" >
   
                        @csrf

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
        
                            <div class="form-group row">
                                <div class="col-md-1" align="right">
                                    <label for="NO_BUKTI" class="form-label">Bukti#</label>
                                </div>
								
                                <input type="text" class="form-control NO_ID" id="NO_ID" name="NO_ID"
                                    value="{{$header->NO_ID ?? ''}}" hidden readonly>
								<input name="tipx" class="form-control tipx" id="tipx" value="{{$tipx}}" hidden >
								<input name="flagz" class="form-control flagz" id="flagz" value="{{$flagz}}" hidden >
								<input name="searchx" class="form-control searchx" id="searchx" value="{{$searchx ?? ''}}" hidden >

								
                                <div class="col-md-2">
                                    <input type="text" class="form-control NO_BUKTI" id="NO_BUKTI" name="NO_BUKTI"
                                    placeholder="Masukkan Bukti#" value="{{$header->NO_BUKTI}}" readonly style="width:140px">
                                </div>
								
								
								<div class="col-md-4"></div>
					
								<div class="col-md-3 input-group">

									<input type="text" hidden class="form-control CARI" id="CARI" name="CARI"
                                    placeholder="Cari Bukti#" value="" >
									<button type="button" hidden id='SEARCHX'  onclick="CariBukti()" class="btn btn-outline-primary"><i class="fas fa-search"></i></button>

								</div> 								
								
                            </div>
        
			                <div class="form-group row">
                                <div class="col-md-1" align="right">
                                    <label for="TGL" class="form-label">Tanggal</label>
                                </div>
                                <div class="col-md-2">
                                   <input class="form-control date" id="TGL" name="TGL" data-date-format="dd-mm-yyyy" type="text" autocomplete="off" value="{{date('d-m-Y',strtotime($header->TGL))}}" style="width:140px">
                                </div>

                            </div>
 
                            <div class="form-group row">
                                <div class="col-md-1">	
                                    <label for="KODEC" class="form-label">Customer#</label>
                                </div>
								
                                <div class="col-md-3" >
                                   <select id="KODEC"  name="KODEC" style="width: 100%" ></select>        							      
                                </div>
		
                                <div class="col-md-3" >
                                  	<input type="checkbox" class="form-check-input" id="PKP" name="PKP" readonly  value="{{$header->PKP}}" {{ ($header->PKP == 1) ? 'checked' : '' }}>
                                    <label for="PKP" class="form-label">Pkp</label>
                                    <input type="text" hidden class="form-control ZPKP" id="ZPKP" name="ZPKP" value="{{$header->PKP}}" placeholder="Masukkan Pkp" >
                                   
                                    
                                </div>

                                
                                
		                        <div {{($flagz == 'UM') ? '' : 'hidden' }} class="col-md-1" align="center">
									<label for="TYPE" class="form-label">Type</label>
								</div>
								<div {{($flagz == 'UM') ? '' : 'hidden' }} class="col-md-2">
									<select id="TYPE" class="form-control"  name="TYPE">
										<option value="BANK" {{ ($header->TYPE == 'BANK') ? 'selected' : '' }}>Bank</option>
										<option value="KAS" {{ ($header->TYPE == 'KAS') ? 'selected' : '' }}>Kas</option>
									</select>
								</div>
								
							</div>
   

                            <div {{($flagz == 'TP') ? '' : 'hidden' }} class="form-group row">
                                
                                
                                        <div class="col-md-1">	
                                            <label for="ACNOB" class="form-label">Account#</label>
                                        </div>
        								
                                        <div class="col-md-4" >
                                           <select id="ACNOB"  name="ACNOB" style="width: 100%" ></select>        							      
                                        </div>
                                
							</div>
							
                            <div {{($flagz == 'UM') ? '' : 'hidden' }} class="form-group row">


                                        <div class="col-md-1">	
                                            <label for="BACNO" class="form-label">Account#</label>
                                        </div>
        								
                                        <div class="col-md-3" >
                                           <select id="BACNO" onchange="ambil_nacno()" name="BACNO" style="width: 100%" ></select>  
                                           <input type="text" hidden class="form-control BNAMA" id="BNAMA" name="BNAMA" value="{{$header->BNAMA}}" placeholder="Masukkan Nama" >
                                        </div>
        
        
                                       <div class="col-md-2">
                                            <input type="text" class="form-control NO_BANK" id="NO_BANK" name="NO_BANK" placeholder="-" value="{{ $header->NO_BANK }}" readonly>
                                        </div>
                                
                                                                
							</div>
							


                        	<div class="form-group row">
								
                                <div class="col-md-1" align="right">
                                    <label for="TOTAL" class="form-label">Total</label>
                                </div>
                                <div class="col-md-2" align="left">
                                    <input type="text" class="form-control TOTAL" id="TOTAL" onclick="select()" name="TOTAL" placeholder="TOTAL" value="{{ number_format($header->TOTAL, 2, '.', ',') }}" style="text-align: right; width:140px" readonly>
                                </div>

                            </div>

				
							<div class="loader" style="z-index: 1055;" id='LOADX' ></div>
                     
                        	<div class="form-group row">
								
								 <!-- code text box baru -->
								<div class="col-md-5 form-group row special-input-label">

									<input type="text" class="NOTES" id="NOTES" name="NOTES" 
										value="{{$header->NOTES}}" placeholder=" " >
									<label for="NOTES">Notes</label>
								</div>
								<!-- tutupannya -->

								
								
                            </div>
							
                    </div>
						    
						<div class="mt-3 col-md-12 form-group row">
							<div class="col-md-4">
								<button type="button" id='TOPX'  onclick="location.href='{{url('/utjual/edit/?idx=' .$idx. '&tipx=top&flagz='.$flagz.'' )}}'" class="btn btn-outline-primary">Top</button>
								<button type="button" id='PREVX' onclick="location.href='{{url('/utjual/edit/?idx='.$header->NO_ID.'&tipx=prev&flagz='.$flagz.'&buktix='.$header->NO_BUKTI )}}'" class="btn btn-outline-primary">Prev</button>
								<button type="button" id='NEXTX' onclick="location.href='{{url('/utjual/edit/?idx='.$header->NO_ID.'&tipx=next&flagz='.$flagz.'&buktix='.$header->NO_BUKTI )}}'" class="btn btn-outline-primary">Next</button>
								<button type="button" id='BOTTOMX' onclick="location.href='{{url('/utjual/edit/?idx=' .$idx. '&tipx=bottom&flagz='.$flagz.'' )}}'" class="btn btn-outline-primary">Bottom</button>
							</div>
							<div class="col-md-5">
								<button type="button" id='NEWX' onclick="location.href='{{url('/utjual/edit/?idx=0&tipx=new&flagz='.$flagz.'' )}}'" class="btn btn-warning">New</button>
								<button type="button" id='EDITX' onclick='hidup()' class="btn btn-secondary">Edit</button>                    
								<button type="button" id='UNDOX' onclick="location.href='{{url('/utjual/edit/?idx=' .$idx. '&tipx=undo&flagz='.$flagz.'' )}}'" class="btn btn-info">Undo</button>  
								<button type="button" id='SAVEX' onclick='simpan()'   class="btn btn-success" class="fa fa-save"></i>Save</button>

							</div>
							<div class="col-md-3">
								<button type="button" id='HAPUSX'  onclick="hapusTrans()" class="btn btn-outline-danger">Hapus</button>
								
								<!-- <button type="button" id='CLOSEX'  onclick="location.href='{{url('/utjual?flagz='.$flagz.'' )}}'" class="btn btn-outline-secondary">Close</button> -->
							
								<!-- tombol close sweet alert -->
								<button type="button" id='CLOSEX' onclick="closeTrans()" class="btn btn-outline-secondary">Close</button></div>
							</div>
						</div>
						
							
                    </form>

			</div>
            </div>
            </div>
        </div>
        </div>
    </div>
	
	<div class="modal fade" id="browseSoModal" tabindex="-1" role="dialog" aria-labelledby="browseSoModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseSoModalLabel">Cari So#</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-bso">
				<thead>
					<tr>
						<th>So#</th>
						<th>Customer</th>
						<th>Tanggal</th>
						<th>Kota</th>
						<th>Barang</th>
						<th>Harga</th>
						<th>Kg</th>
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

	<div class="modal fade" id="browseAccountModal" tabindex="-1" role="dialog" aria-labelledby="browseAccountModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseAccountModalLabel">Cari Account</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-baccount">
				<thead>
					<tr>
						<th>Acc#</th>
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


	<div class="modal fade" id="browseGdgModal" tabindex="-1" role="dialog" aria-labelledby="browseGdgModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseMklModalLabel">Cari Gudang</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-bgdg">
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
	


	<div class="modal fade" id="browseSoxModal" tabindex="-1" role="dialog" aria-labelledby="browseSoxModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseSoxModalLabel">Cari Sox#</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-bsox">
				<thead>
					<tr>
						<th>So#</th>
						<th>Customer#</th>
						<th>-</th>
						<th>Total</th>
						<th>Bayar</th>
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
	
	
@endsection

@section('footer-scripts')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script src="{{ asset('js/autoNumerics/autoNumeric.min.js') }}"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script> -->
<script src="{{asset('foxie_js_css/bootstrap.bundle.min.js')}}"></script>

<!-- tambahan untuk sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- tutupannya -->


<script>
	var idrow = 1;
    function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

	$(document).ready(function() {

		setTimeout(function(){

		$("#LOADX").hide();

		},500);

		$tipx = $('#tipx').val();
		$searchx = $('#CARI').val();
		
		
		 $('#KODEC').select2({
		
		placeholder:'Pilih Customer',
		allowClear: true,
        ajax: {
			url: '{{url('cust/browse')}}',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term // Search term
                };
            },
            processResults: function(data) {
                return {
                    results: data.map(item => ({
                        id: item.KODEC, // The ID of the user
                        text: item.NAMAC // The text to display
                    }))
                };
            },
            cache: true
        },
		
	});
	
		
		
			
			
        $('#BACNO').select2({
    		
    		placeholder:'Pilih Cash/Bank',
    		allowClear: true,
            ajax: {
    			url: '{{url('account/browsecashbank')}}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term // Search term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.map(item => ({
                            id: item.ACNO, // The ID of the user
                            text: item.NAMAX // The text to display
                        }))
                    };
                },
                cache: true
            },
    		
    	
    	});
	
	
	
	
	    $('#ACNOB').select2({
    		
    		placeholder:'Pilih Account',
    		allowClear: true,
            ajax: {
    			url: '{{url('account/browse')}}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term // Search term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.map(item => ({
                            id: item.ACNO, // The ID of the user
                            text: item.NAMAX // The text to display
                        }))
                    };
                },
                cache: true
            },
    		
    	
    	});
    	
    	
    	
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
		
        if ( $tipx == 'new' )
		{
			 baru();			
		}

        if ( $tipx != 'new' )
		{
			 ganti();		

			    var initkode ="{{ $header->BACNO }}";
			    var initcombo ="{{ $header->BNAMA }}";
				var defaultOption = { id: initkode, text: initcombo }; // Set your default option ID and text
                var newOption = new Option(defaultOption.text, defaultOption.id, true, true);
                $('#BACNO').append(newOption).trigger('change');
			 
			 
			    var initkode1 ="{{ $header->KODEC }}";			 
			    var initcombo1 ="{{ $header->NAMAC }}";
		    	var defaultOption1 = { id: initkode1, text: initcombo1 }; // Set your default option ID and text
                var newOption1 = new Option(defaultOption1.text, defaultOption1.id, true, true);
                $('#KODEC').append(newOption1).trigger('change');
			 
			 
			    var initkode2 ="{{ $header->ACNOB }}";	
			 	var initcombo2 ="{{ $header->NACNOB }}";
				var defaultOption2 = { id: initkode2, text: initcombo2 }; // Set your default option ID and text
                var newOption2 = new Option(defaultOption2.text, defaultOption2.id, true, true);
                $('#ACNOB').append(newOption2).trigger('change');
			 
			 			 
		}    
		
	
	
		$("#KG").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999'});
		$("#QTY").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999'});
		$("#HARGA").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#TOTAL").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#DPP").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		$("#PPN").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
        

		$(".date").datepicker({
			'dateFormat': 'dd-mm-yy',
		})
		
		
		hitung=function() {	
		//getKA();
		
			var KGX = parseFloat($('#KG').val().replace(/,/g, ''));
			var HARGAX = parseFloat($('#HARGA').val().replace(/,/g, ''));

					
            var TOTALX = (HARGAX * KGX);
			$('#TOTAL').val(numberWithCommas(TOTALX));
		    $("#TOTAL").autoNumeric('update');

			var PPNX = parseFloat($('#PPN').val().replace(/,/g, ''));
			var DPPX = parseFloat($('#DPP').val().replace(/,/g, ''));

				
			if ( PPNX != '0.00' )
			{
				DPPX = TOTALX * 100/111;
		    	$('#DPP').val(numberWithCommas(DPPX));
		        $("#DPP").autoNumeric('update');				
				
				PPNX = TOTALX - DPPX;
		    	$('#PPN').val(numberWithCommas(PPNX));
		        $("#PPN").autoNumeric('update');	
	
			}
			else
			{
                DPPX = TOTALX;
		    	$('#DPP').val(numberWithCommas(DPPX));
		        $("#DPP").autoNumeric('update');	
				
				
			}
			
			
			
           
			
		}				

		///////////////////////////////////////////////////////////////////////

 		var dTableBSo;
		loadDataBSo = function(){
			$.ajax(
			{
				type: 'GET',    
				url: '{{url('so/browse')}}',


				success: function( response )
				{

					resp = response;
					if(dTableBSo){
						dTableBSo.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBSo.row.add([
							'<a href="javascript:void(0);" onclick="chooseSo(\''+resp[i].NO_BUKTI+'\',  \''+resp[i].KODEC+'\', \''+resp[i].NAMAC+'\', \''+resp[i].TGL+'\', \''+resp[i].KOTA+'\' , \''+resp[i].KD_BRG+'\' , \''+resp[i].NA_BRG+'\' , \''+resp[i].HARGA+'\', \''+resp[i].KG+'\', \''+resp[i].KIRIM+'\', \''+resp[i].SISA+'\'    )">'+resp[i].NO_BUKTI+'</a>',
							resp[i].NAMAC,
							resp[i].TGL,
							resp[i].KOTA,
							resp[i].NA_BRG,
							resp[i].HARGA,	
							resp[i].KG,
							resp[i].KIRIM,
							resp[i].SISA,							
							
						]);
					}
					dTableBSo.draw();
				}
			});
		}
		
		dTableBSo = $("#table-bso").DataTable({
			columnDefs: [
				{
                    className: "dt-right", 
					targets:  [5,6,7,8],
					render: $.fn.dataTable.render.number( ',', '.', 2, '' )
				}
			],
		});
		
		browseSo = function(){
			loadDataBSo();
			$("#browseSoModal").modal("show");
		}
		
		chooseSo = function(NO_BUKTI,KODEC,NAMAC,ALAMAT, KOTA, KD_BRG, NA_BRG, HARGA, KG, KIRIM, SISA ){
			$("#NO_SO").val(NO_BUKTI);
			$("#KODEC").val(KODEC);
			$("#NAMAC").val(NAMAC);
			$("#ALAMAT").val(ALAMAT);
			$("#KOTA").val(KOTA);
			$("#KD_BRG").val(KD_BRG);
			$("#NA_BRG").val(NA_BRG);			
		//	$("#KG").val(SISA);	
			$("#HARGA").val(HARGA);	

			$("#browseSoModal").modal("hide");
			hitung();
			
		}
		
		$("#NO_SO").keypress(function(e){

			if(e.keyCode == 46){
				e.preventDefault();
				
				$flagz = $('#flagz').val();
				
				if ( $flagz == 'JL' ) {
					browseSo();
					
				} else {
					
					browseSox();

                }					
				
				
			}
			
		}); 
		
		
		/////////////////////////////////////////////////////////////////
		
		var dTableBSox;
		loadDataBSox = function(){
			
			$.ajax(
			{
				type: 'GET', 		
				url: "{{url('so/browseuang')}}",

				success: function( response )
				{

					resp = response;
					if(dTableBSox){
						dTableBSox.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBSox.row.add([
							'<a href="javascript:void(0);" onclick="chooseSox(\''+resp[i].NO_BUKTI+'\',  \''+resp[i].KODEC+'\', \''+resp[i].ALAMAT+'\', \''+resp[i].KOTA+'\'  )">'+resp[i].NO_BUKTI+'</a>',
							resp[i].KODEC,
							resp[i].NAMAC,	
							Intl.NumberFormat('en-US').format(resp[i].TOTAL),
							Intl.NumberFormat('en-US').format(resp[i].BAYAR),
							Intl.NumberFormat('en-US').format(resp[i].SISA),
							
						]);
					}
					dTableBSox.draw();
				}
			});
		}
		
		dTableBSox = $("#table-bsox").DataTable({
			columnDefs: [
				{
                    className: "dt-right", 
					targets:  [],
					render: $.fn.dataTable.render.number( ',', '.', 2, '' )
				}
			],
		});
		
		browseSox = function(){			
			loadDataBSox();
			$("#browseSoxModal").modal("show");
		}
		
		chooseSox = function(NO_BUKTI,KODEC,NAMAC, ALAMAT, KOTA){
			$("#NO_SO").val(NO_BUKTI);
			$("#KODEC").val(KODEC);
			$("#NAMAC").val(NAMAC);		
			$("#ALAMAT").val(ALAMAT);		
			$("#KOTA").val(KOTA);		
			$("#browseSoxModal").modal("hide");
		}
		
		
		///////////////////////////////////////////////////////////////////////////////

 	
		var dTableBGdg;
		var rowidGdg;
		loadDataBGdg = function(){
			$.ajax(
			{
				type: 'GET',    
				url: "{{url('gdg/browse')}}",

				success: function( response )
				{
					resp = response;
					if(dTableBGdg){
						dTableBGdg.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBGdg.row.add([
							'<a href="javascript:void(0);" onclick="chooseGdg(\''+resp[i].KODE+'\',  \''+resp[i].NAMA+'\' )">'+resp[i].KODE+'</a>',
							resp[i].NAMA,
						
						]);
					}
					dTableBGdg.draw();
				}
			});
		}
		
		dTableBGdg = $("#table-bgdg").DataTable({
			
		});
		
		browseGdg = function(){
			loadDataBGdg();
			$("#browseGdgModal").modal("show");
		}
		
		chooseGdg = function(KODE,NAMA){
			$("#GUDANG").val(KODE);			
			$("#browseGdgModal").modal("hide");
		}
		
		
		$("#GUDANG").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseGdg();
			}
		}); 
		
		
////////////////////////////////////////////////		
	

		var dTableBAccount;
		var tipex ;
		
		loadDataBAccount = function(){
			
		  if ( tipex == '0' )
		  {
			$.ajax(
			{
				type: 'GET',    
				url: '{{url('account/browse')}}',
				success: function( response )
				{
					resp = response;
					if(dTableBAccount){
						dTableBAccount.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBAccount.row.add([
							'<a href="javascript:void(0);" onclick="chooseAccount(\''+resp[i].ACNO+'\',  \''+resp[i].NAMA+'\' )">'+resp[i].ACNO+'</a>',
							resp[i].NAMA,
						]);
					}
					dTableBAccount.draw();
				}
			});
			
		  }
		  	
		  if ( tipex == '1' )
		  {
			
			  
			$.ajax(
			{
				type: 'GET',    
				url: '{{url('account/browsebank')}}',
				success: function( response )
				{
					resp = response;
					if(dTableBAccount){
						dTableBAccount.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBAccount.row.add([
							'<a href="javascript:void(0);" onclick="chooseAccount(\''+resp[i].ACNO+'\',  \''+resp[i].NAMA+'\' )">'+resp[i].ACNO+'</a>',
							resp[i].NAMA,
						]);
					}
					dTableBAccount.draw();
				}
			});
			
		  }
		  
			
		}
		
		dTableBAccount = $("#table-baccount").DataTable({
			
		});
		
		browseAccount = function(rid){
			tipex = rid;
			loadDataBAccount();
			$("#browseAccountModal").modal("show");
		}
		
		chooseAccount = function(ACNO, NAMA){
			
			if ( tipex =='0' )
			{
			  $("#ACNOB").val(ACNO);
			  $("#NACNOB").val(NAMA);
			}
			
			if ( tipex =='1' )
			{
			  $("#BACNO").val(ACNO);
			  $("#BNAMA").val(NAMA);
			}
			
			$("#browseAccountModal").modal("hide");
		}
		
		$("#ACNOB").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseAccount(0);
			}
		}); 

		$("#BACNO").keypress(function(e){
			if(e.keyCode == 46){
				e.preventDefault();
				browseAccount(1);
			}
		}); 





/////////////////////////////////////////////////

        
	});		

	

    function simpan() {
	//	hitung();

    	var flagz = $('#flagz').val();

			if ( flagz =='JL'  ){
                 hitung();			
			}
		
		
		var tgl = $('#TGL').val();
		var bulanPer = {{session()->get('periode')['bulan']}};
		var tahunPer = {{session()->get('periode')['tahun']}};
		
        var check = '0';
        //var cekDropship = '0';
        //var noDropship = '';
		

////////////////////////////////////////////////////////////////////////////////////////
		$tipx = $('#tipx').val();
		
        if ( $tipx != 'new' )
		{
		    
		    $pkp00 = $('#PKP').val();
		    $pkp11 = $('#ZPKP').val();
		    
		    
		    
			if ( $pkp00 != $pkp11   ) 
            {
               
                check = '1';
				Swal.fire({
					icon: 'warning',
					title: 'Warning',
					text: 'Type PKP beda dengan Type PKP awal.'
				});
				return;
                
            }			 
		}



////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////

		if ( $('#KODEC').val()=='' ) 
            {			
			    check = '1';
				Swal.fire({
					icon: 'warning',
					title: 'Warning',
					text: 'Customer Harus Diisi.'
				});
				return; // Stop function execution
			}
			
			
	    	var flagz = $('#flagz').val();
		    
			if ( flagz =='TP'  ){

        			if ( $('#ACNOB').val()=='' ) 
                    {			
        			    check = '1';
						Swal.fire({
							icon: 'warning',
							title: 'Warning',
							text: 'Account Harus Diisi.'
						});
						return; // Stop function execution
        			}
							
				
			}

			if ( flagz =='UM'  ){

        			if ( $('#BACNO').val()=='' ) 
                    {			
        			    check = '1';
						Swal.fire({
							icon: 'warning',
							title: 'Warning',
							text: 'Cash/Bank Harus Diisi.'
						});
						return; // Stop function execution
        			}

			}			
			
			if ( tgl.substring(3,5) != bulanPer ) 
			{
				check = '1';
				Swal.fire({
					icon: 'warning',
					title: 'Warning',
					text: 'Bulan tidak sama dengan Periode'
				});
				return; // Stop function execution
			}	
			
			if ( tgl.substring(tgl.length-4) != tahunPer )
			{
				check = '1';
				Swal.fire({
					icon: 'warning',
					title: 'Warning',
					text: 'Tahun tidak sama dengan Periode'
				});
				return; // Stop function execution
		    }	 


			if (check == '0') {
				Swal.fire({
					title: 'Are you sure?',
					text: 'Are you sure you want to save?',
					icon: 'question',
					showCancelButton: true,
					confirmButtonText: 'Yes, save it!',
					cancelButtonText: 'No, cancel',
				}).then((result) => {
					if (result.isConfirmed) {
						document.getElementById("entri").submit();
					} else {
						Swal.fire({
							icon: 'info',
							title: 'Cancelled',
							text: 'Your data was not saved'
						});
					}
				});
			} else {
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Masih ada kesalahan'
				});
			}

		// tutupannya

		$("#LOADX").hide();
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
	    //$("#CLOSEX").attr("disabled", true);

		$("#CARI").attr("readonly", true);	
	    $("#SEARCHX").attr("disabled", true);
		
	    $("#PLUSX").attr("hidden", false)
		   
			$("#NO_BUKTI").attr("readonly", true);		   
			$("#TGL").attr("readonly", false);

			$("#KODEC").attr("readonly", true);
			$("#NAMAC").attr("readonly", true);
			$("#ALAMAT").attr("readonly", true);
			$("#KOTA").attr("readonly", true);

    		$("#KODEC").attr("disabled", false);
    		$("#BACNO").attr("disabled", false);
    		$("#ACNOB").attr("disabled", false);
    		
			$("#TOTAL").attr("readonly", true);

	        var flagz = $('#flagz').val();
		 
		    
			if ( flagz !='JL' ){
			    $("#TOTAL").attr("readonly", false);
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
		
		$("#TGL").attr("readonly", true);

		$("#KODEC").attr("readonly", true);
		$("#NAMAC").attr("readonly", true);
		$("#ALAMAT").attr("readonly", true);
		$("#KOTA").attr("readonly", true);

    		$("#KODEC").attr("disabled", true);
    		$("#BACNO").attr("disabled", true);
    		$("#ACNOB").attr("disabled", true);

		$("#TOTAL").attr("readonly", true)

		
	}


	function kosong() {
				
		 $('#NO_BUKTI').val("+");	
	//	 $('#TGL').val("");	

		 $('#KODEC').val("");	
		 $('#NAMAC').val("");
		 $('#ALAMAT').val("");	
		 $('#KOTA').val("");
		 
		 $('#TOTAL').val("0.00");		 

		 
		 $('#ACNOB').val("");	
		 $('#NACNOB').val("");
		 $('#BACNO').val("");	
		 $('#BNAMA').val("");
		 

		var flagz = $('#flagz').val();
		    
			if ( flagz =='JL'  ){

			    $('#ACNOB').val('411101');					
			    $('#NACNOB').val('PENJUALAN');					
				
			}

			if ( flagz =='UM'  ){

			    $('#ACNOB').val('212101');					
			    $('#NACNOB').val('UANG MUKA PENJUALAN');					
				
			}
			
			
			
		
	}
	
	// function hapusTrans() {
	// 	let text = "Hapus Transaksi "+$('#NO_BUKTI').val()+"?";
	// 	if (confirm(text) == true) 
	// 	{
	// 		window.location ="{{url('/utjual/delete/'.$header->NO_ID .'/?flagz='.$flagz.'' )}}";
	// 		//return true;
	// 	} 
	// 	return false;
	// }
	
	// sweetalert untuk tombol hapus dan close
	
	function hapusTrans() {
		let text = "Hapus Transaksi "+$('#NO_BUKTI').val()+"?";

		var loc ='';
		var flagz = "{{ $flagz }}";
		
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
	            	loc = "{{ url('/utjual/delete/'.$header->NO_ID) }}" + '?flagz=' + encodeURIComponent(flagz) ;

		            // alert(loc);
	            	window.location = loc;
		
				});
			}
		});
	}
	
	function closeTrans() {
		console.log("masuk");
		var loc ='';
		var flagz = "{{ $flagz }}";
		
		Swal.fire({
			title: 'Are you sure?',
			text: 'Do you really want to close this page? Unsaved changes will be lost.',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Yes, close it',
			cancelButtonText: 'No, stay here'
		}).then((result) => {
			if (result.isConfirmed) {
	        	loc = "{{ url('/utjual/') }}" + '?flagz=' + encodeURIComponent(flagz) ;
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
	
	function ambil_nacno() {

		    
		$.ajax(
		{
			type: 'GET',    
			url: "{{url('account/browse_nacno')}}",
			data: {
					'BACNO' : $("#BACNO").val(),
			},
			
			success: function( response )

			{
				resp = response;
				$("#BNAMA").val( resp[0].NAMA );
        				
			}
		});
		
		  
	}

	function CariBukti() {
		
		var flagz = "{{ $flagz }}";
		var cari = $("#CARI").val();
		var loc = "{{ url('/utjual/edit/') }}" + '?idx={{ $header->NO_ID}}&tipx=search&flagz=' + encodeURIComponent(flagz) + '&buktix=' +encodeURIComponent(cari);
		window.location = loc;
		
	}

   
    
</script>
@endsection