@extends('layouts.plain')

  <link rel="icon" href="http://material.joshadmin.com/assets/img/logo_small.png" type="image/x-icon">
    <link href="http://material.joshadmin.com/assets/css/app.css" rel="stylesheet" type="text/css"/>

	
<style>
    .card {

    }
	
	/*default css*/
        .navbar-right .btn-danger{
            color: #FFF !important;
            padding:8px 15px !important;
            margin:7px 7px 0 0;


        }
        .navbar-right .btn-danger:hover,.btn-danger:focus{
            background:#EF6F6C !important;
            border-color:#EF6F6C !important;
        }
        .btn_fixed{
            position: absolute;
            top:5px;
            right:17px;
        }
        @media (max-width:320px){
            body > .header .logo{
                text-align:left !important;
            }
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

	/* style tambahan baru */
	.form-control:disabled,
    .form-control[readonly] {
        background-color: #f7d8b4 !important;
        opacity: 1;
    }

    .row {
        margin-bottom: 8px !important;
    }
</style>

@section('content')
<div class="content-wrapper">

    <div class="content">
        <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <div class="card">
                <div class="card-body">
  
                    <form action="{{($tipx=='new')? url('/kota/store/') : url('/kota/update/'.$header->NO_ID ) }}" method="POST" name ="entri" id="entri" >
  
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
								<!-- code text box baru -->
								<div class="col-md-5 form-group row special-input-label">

									<input type="text" class="KOTA" id="KOTA" name="KOTA" 
										value="{{$header->KOTA}}" placeholder=" " >
									<label for="KOTA">Kota</label>
								</div>
								<!-- tutupannya -->
							</div>
                                

					
                            <!-- <div class="form-group row">
                                <div class="col-md-1" >
									<label style="color:red">*</label>	
									<label for="RING" class="form-label">Ring</label>
								</div>
								<div class="col-md-1">
									<select id="RING" class="form-control"  name="RING">
										<option value="LOKAL" {{ ($header->RING == 'LOKAL') ? 'selected' : '' }}>Lokal</option>
										<option value="1" {{ ($header->RING == '1') ? 'selected' : '' }}>Ring 1</option>
										<option value="2" {{ ($header->RING == '2') ? 'selected' : '' }}>Ring 2</option>
										<option value="3" {{ ($header->RING == '3') ? 'selected' : '' }}>Ring 3</option>
										</select>
								</div>  
                            </div> -->
                            
							<!-- loader tampil di modal  -->
							<div class="loader" style="z-index: 1055;" id='LOADX' ></div>

                            <!-- </div> -->
                                
                        </div>
    

    
        
						<div class="mt-3 col-md-12 form-group row">
							<div class="col-md-4">
								<button type="button" id='TOPX'  onclick="location.href='{{url('/kota/edit/?idx=' .$idx. '&tipx=top')}}'" class="btn btn-outline-primary">Top</button>
								<button type="button" id='PREVX' onclick="location.href='{{url('/kota/edit/?idx='.$header->NO_ID.'&tipx=prev&kodex='.$header->KOTA )}}'" class="btn btn-outline-primary">Prev</button>
								<button type="button" id='NEXTX' onclick="location.href='{{url('/kota/edit/?idx='.$header->NO_ID.'&tipx=next&kodex='.$header->KOTA )}}'" class="btn btn-outline-primary">Next</button>
								<button type="button" id='BOTTOMX' onclick="location.href='{{url('/kota/edit/?idx=' .$idx. '&tipx=bottom')}}'" class="btn btn-outline-primary">Bottom</button>
							</div>
							<div class="col-md-5">
								<button type="button" id='NEWX' onclick="location.href='{{url('/kota/edit/?idx=0&tipx=new')}}'" class="btn btn-warning">New</button>
								<button type="button" id='EDITX' onclick='hidup()' class="btn btn-secondary">Edit</button>                    
								<button type="button" id='UNDOX' onclick="location.href='{{url('/kota/edit/?idx=' .$idx. '&tipx=undo' )}}'" class="btn btn-info">Undo</button> 
								<button type="button" id='SAVEX' onclick='simpan()'   class="btn btn-success" class="fa fa-save"></i>Save</button>

							</div>
							<div class="col-md-3">
								<button type="button" id='HAPUSX'  onclick="hapusTrans()" class="btn btn-outline-danger">Hapus</button>
								
								<!-- <button type="button" id='CLOSEX'  onclick="location.href='{{url('/kota' )}}'" class="btn btn-outline-secondary">Close</button> -->

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



<script src="http://material.joshadmin.com/assets/js/app.js" type="text/javascript"></script>
    
<script src="http://material.joshadmin.com/assets/vendors/bootstrap-tagsinput/js/bootstrap-tagsinput.js" ></script>
    
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

		// $("#UMAKAN").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		// $("#KOM").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		// $("#GAJI").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999.99'});
		
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
		  	
			$("#KOTA").attr("readonly", false);	

		   }
		else
		{
	     	$("#KOTA").attr("readonly", true);	

		   }
		   
		
		// $("#RING").attr("readonly", false);	
		
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
		
		$("#KOTA").attr("readonly", true);			
		// $("#RING").attr("readonly", true);	
		
	}


	function kosong() {
				
		//  $('#KOTA').val("");	
		//  $('#RING').val("");	

		 
	}
	
	// function hapusTrans() {
	// 	let text = "Hapus Master "+$('#KOTA').val()+"?";
	// 	if (confirm(text) == true) 
	// 	{
	// 		window.location ="{{url('/kota/delete/'.$header->NO_ID )}}'";
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
	            	loc = "{{ url('/kota/delete/'.$header->NO_ID) }}"  ;

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
	        	loc = "{{ url('/kota/') }}" ;
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
		var loc = "{{ url('/kota/edit/') }}" + '?idx={{ $header->NO_ID}}&tipx=search&kodex=' +encodeURIComponent(cari);
		window.location = loc;
		
	}
	

    var hasilCek;

	function cekKota(kode) {
		$.ajax({
			type: "GET",
			url: "{{url('kota/cekkota')}}",
            async: false,
			data: ({ KOTA: kode, }),
			success: function(data) {
                if (data.length > 0) {
                    $.each(data, function(i, item) {
                        hasilCek=data[i].ADA;
                    });
                }
			},
			error: function() {
				alert('Error cekKota occured');
			}
		});
		return hasilCek;
	}
    
	function simpan() {
        hasilCek=0;
		$tipx = $('#tipx').val();
				
        if ( $tipx == 'new' )
		{
			cekKota($('#KOTA').val());		
		}
		

        (hasilCek==0) ? document.getElementById("entri").submit() : alert('Kota '+$('#KOTA').val()+' sudah ada!');
	
		$("#LOADX").hide();
	}
</script>
@endsection

