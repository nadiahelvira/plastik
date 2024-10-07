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
            <h1 class="m-0">Data Group </h1>
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
  
                    <form action="{{($tipx=='new')? url('/grup/store/') : url('/grup/update/'.$header->NO_ID ) }}" method="POST" name ="entri" id="entri" >
  
                      @csrf
						
                        <ul class="nav nav-tabs">
                            <!-- <li class="nav-item active">
                                <a class="nav-link active" href="#grupInfo" data-toggle="tab">Pegawai Info</a>
                            </li> -->
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="#bankInfo" data-toggle="tab">Bank Info</a>
                            </li> -->
                        </ul>
        
                        <div class="tab-content mt-3">

							<!-- <div id="grupInfo" class="tab-pane active"> -->
        
                             <div class="form-group row">
                                <div class="col-md-1">
                                    <label for="KODE" class="form-label">Kode</label>
                                </div>
 
                                    <input type="text" class="form-control NO_ID" id="NO_ID" name="NO_ID"
                                    placeholder="Masukkan NO_ID" value="{{$header->NO_ID ?? ''}}" hidden readonly>

									<input name="tipx" class="form-control flagz" id="tipx" value="{{$tipx}}" hidden>
		 

								<div class="col-md-2">
                                    <input type="text" class="form-control KODE" id="KODE" name="KODE"
                                    placeholder="Masukkan Kode Group" value="{{$header->KODE}}" readonly>
                                </div>   
								
                                <div class="col-md-1">
                                    <label for="NAMA" class="form-label">Nama</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control NAMA" id="NAMA" name="NAMA"
                                    placeholder="Masukkan Nama Group" value="{{$header->NAMA}}">
                                </div>   

                            <!-- </div> -->
                                
                        </div>
        
						<div class="mt-3 col-md-12 form-group row">
							<div class="col-md-4">
								<button type="button" id='TOPX'  onclick="location.href='{{url('/grup/edit/?idx=' .$idx. '&tipx=top')}}'" class="btn btn-outline-primary">Top</button>
								<button type="button" id='PREVX' onclick="location.href='{{url('/grup/edit/?idx='.$header->NO_ID.'&tipx=prev&kodex='.$header->KODE )}}'" class="btn btn-outline-primary">Prev</button>
								<button type="button" id='NEXTX' onclick="location.href='{{url('/grup/edit/?idx='.$header->NO_ID.'&tipx=next&kodex='.$header->KODE )}}'" class="btn btn-outline-primary">Next</button>
								<button type="button" id='BOTTOMX' onclick="location.href='{{url('/grup/edit/?idx=' .$idx. '&tipx=bottom')}}'" class="btn btn-outline-primary">Bottom</button>
							</div>
							<div class="col-md-5">
								<button type="button" id='NEWX' onclick="location.href='{{url('/grup/edit/?idx=0&tipx=new')}}'" class="btn btn-warning">New</button>
								<button type="button" id='EDITX' onclick='hidup()' class="btn btn-secondary">Edit</button>                    
								<button type="button" id='UNDOX' onclick="location.href='{{url('/grup/edit/?idx=' .$idx. '&tipx=undo' )}}'" class="btn btn-info">Undo</button> 
								<button type="button" id='SAVEX' onclick='simpan()'   class="btn btn-success" class="fa fa-save"></i>Save</button>

							</div>
							<div class="col-md-3">
								<button type="button" id='HAPUSX'  onclick="hapusTrans()" class="btn btn-outline-danger">Hapus</button>
								<button type="button" id='CLOSEX'  onclick="location.href='{{url('/grup' )}}'" class="btn btn-outline-secondary">Close</button>


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


<script>
    var target;
	var idrow = 1;

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

    $(document).ready(function () {

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
		  	
			$("#KODE").attr("readonly", false);	

		   }
		else
		{
	     	$("#KODE").attr("readonly", true);	

		   }
		   
		
		$("#NAMA").attr("readonly", false);	
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
		
		$("#KODE").attr("readonly", true);			
		$("#NAMA").attr("readonly", true);	
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
				
		 $('#KODE').val("");	
		 $('#NAMA').val("");	
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
	
	function hapusTrans() {
		let text = "Hapus Master "+$('#KODE').val()+"?";
		if (confirm(text) == true) 
		{
			window.location ="{{url('/grup/delete/'.$header->NO_ID )}}'";
			//return true;
		} 
		return false;
	}

	function CariBukti() {
		
		var cari = $("#CARI").val();
		var loc = "{{ url('/grup/edit/') }}" + '?idx={{ $header->NO_ID}}&tipx=search&kodex=' +encodeURIComponent(cari);
		window.location = loc;
		
	}
	

    var hasilCek;

	function cekGrup(kode) {
		$.ajax({
			type: "GET",
			url: "{{url('grup/cekgrup')}}",
            async: false,
			data: ({ KODE: kode, }),
			success: function(data) {
                if (data.length > 0) {
                    $.each(data, function(i, item) {
                        hasilCek=data[i].ADA;
                    });
                }
			},
			error: function() {
				alert('Error cekGrup occured');
			}
		});
		return hasilCek;
	}
    
	function simpan() {
        hasilCek=0;
		$tipx = $('#tipx').val();
				
        if ( $tipx == 'new' )
		{
			cekGrup($('#KODE').val());		
		}
		

        (hasilCek==0) ? document.getElementById("entri").submit() : alert('Grup '+$('#KODE').val()+' sudah ada!');
	}
</script>
@endsection

