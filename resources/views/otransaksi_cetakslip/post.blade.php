@extends('layouts.main')
@section('styles')
<link rel="stylesheet" href="{{url('http://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Cetak Slip</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Cetak Slip</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Status -->
    @if (session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
    @endif
    @if (session('gagal'))
        <div class="alert alert-danger">
            {{session('gagal')}}
        </div>
    @endif

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
              <form id="entri" action="{{url('cetakslip/posting')}}">
                @csrf	  
                <button class="btn btn-danger" type="button"  onclick="simpan()">Cetak</button>


                <div class="form-group row">
                    <div class="col-md-2" align="right">
                        <label for="JENIS" class="form-label">Pilih Print</label>
                    </div>
                    <div class="col-md-2">
                        <select id="JENIS" class="form-control" name="JENIS">
                          <option value="DANAMON" >DANAMON</option>
                          <option value="BRI" >BRI</option>
                          <option value="BCA-SETORAN" >BCA SETORAN</option>
                          <option value="BCA-SETORAN-KLIRING" >BCA SETORAN KLIRING</option>
                          <option value="DANAMON2" >DANAMON 2</option>
                          <option value="UOB" >UOB</option>
                          <option value="DANAMON-1B" >DANAMON 1B</option>
                          <option value="BRI-NEW" >BRI NEW</option>
                        </select>
                    </div>

                    <div class="col-md-1" align="right">
                        <label style="color:red;font-size:20px">* </label>
                        <label><strong>Wilayah :</strong></label>
                    </div>
                    <div class="col-md-2 input-group" >
                        <select name="wilayah1" id="wilayah1" class="form-control wilayah1" style="width: 200px">
                            <option value="">--Pilih Wilayah--</option>
                            @foreach($wilayah as $wilayahD)
                              <option value="{{$wilayahD->WILAYAH1}}"  {{ (session()->get('filter_wilayah') == $wilayahD->WILAYAH1) ? 'selected' : '' }}>{{$wilayahD->WILAYAH1}}</option>
                            @endforeach
                        </select>
                    </div>
					
					<div class="col-md-1" align="right">
						<label for="KOTA_SETOR" class="form-label">Kota Setor</label>
					</div>
					<div class="col-md-2">
						<input type="text" class="form-control KOTA_SETOR" id="KOTA_SETOR" name="KOTA_SETOR" placeholder="Kota Setor" value="" >
					</div>
                </div>

                
                
                <table class="table table-fixed table-striped table-border table-hover nowrap datatable" id="datatable">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" style="text-align: center">#</th>		
                            <th scope="col">Pilih</th>	
                            <th scope="col" style="text-align: left">Kodecus</th>
                            <th scope="col" style="text-align: center">Pemasaran</th>
                            <th scope="col" style="text-align: left">Toko</th>
                            <th scope="col" style="text-align: left">Flag</th>
                            <th scope="col" style="text-align: left">No BG</th>
                            <th scope="col" style="text-align: left">Bank</th>
                            <th scope="col" style="text-align: right">Jumlah</th>
                            <th scope="col" style="text-align: right">Jtempo</th>
                            <th scope="col" style="text-align: left">Cair Bank</th>
                            <th scope="col" style="text-align: left">Biaya</th>
                            <th scope="col" style="text-align: left">Tanggal setor</th>
                        </tr>
                    </thead>
    
                    <tbody>
                    </tbody> 
                </table>
              </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="browseWilayahModal" tabindex="-1" role="dialog" aria-labelledby="browseWilayahModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="browseWilayahModalLabel">Cari Wilayah</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
              </div>
                <div class="modal-body">
                  <table class="table table-stripped table-bordered" id="table-bwilayah">
                    <thead>
                      <tr>
                        <th>Kode#</th>
                        <th>Wilayah</th>
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

@section('javascripts')
<script src="{{ asset('js/autoNumerics/autoNumeric.min.js') }}"></script>

<script>
  $(document).ready(function() {
      var dataTable = $('.datatable').DataTable({
          processing: true,
          serverSide: true,
 //         autoWidth: true,
 //         'scrollX': true,
          'scrollY': '400px',
          "order": [[ 0, "asc" ]],
          ajax: 
          {
              url: "{{ route('get-cetakslip') }}",
              data: 
              {
                filterpost : 1,
              }
          },
          columns: 
          [
              {data: 'DT_RowIndex', orderable: false, searchable: false },
              {data: 'cek', name: 'cek'},	
              {data: 'KODEC', name: 'KODEC'},
              {data: 'WILAYAH1', name: 'WILAYAH1'},
              {data: 'NAMAC', name: 'NAMAC'},
              {data: 'FLAG', name: 'FLAG'},	
              {data: 'NO_CHBG', name: 'NO_CHBG'},
              {data: 'BANK', name: 'BANK'},			
              {data: 'TOTAL', name: 'TOTAL', render: $.fn.dataTable.render.number( ',', '.', 0, '' )},	
              {data: 'JTEMPO', name: 'JTEMPO'},		
              {data: 'BANK_SETOR', name: 'BANK_SETOR'},		
              {data: 'BIAYA', name: 'BIAYA', render: $.fn.dataTable.render.number( ',', '.', 0, '' )},
              {data: 'TGL_SETOR', name: 'TGL_SETOR'},
          ],
		  
          columnDefs: 
          [
            {
                "className": "dt-center", 
                "targets": 0
            },		
            {
                "className": "dt-right", 
                "targets": [8,11]
            },			
            {
              targets: [9,12],
              render: $.fn.dataTable.render.moment( 'DD-MM-YYYY' )
            },
          ],
      });

      //CHOOSE Wilayah
      var dTableBWilayah;
        loadDataBWilayah = function(){
          $.ajax(
          {
            type: 'GET',    
            url: '{{url('cetakslip/browsewilayah')}}',
            success: function( response )
            {
              resp = response;
              if(dTableBWilayah){
                dTableBWilayah.clear();
              }
              for(i=0; i<resp.length; i++){
                
                dTableBWilayah.row.add([
                  '<a href="javascript:void(0);" onclick="chooseWilayah(\''+resp[i].WILAYAH+'\',\''+resp[i].WILAYAH1+'\')">'+resp[i].WILAYAH+'</a>',
                  resp[i].WILAYAH1,
                ]);
              }
              dTableBWilayah.draw();
            }
          });
        }

        dTableBWilayah = $("#table-bwilayah").DataTable({
          
        });
        
        browseWilayah = function(){
          loadDataBWilayah();
          $("#browseWilayahModal").modal("show");
        }
        
        chooseWilayah = function(WILAYAH,WILAYAH1){
          $("#WILAYAH").val(WILAYAH);
          $("#WILAYAH1").val(WILAYAH1);
          $("#browseWilayahModal").modal("hide");
        }
        
        $("#WILAYAH").keypress(function(e){
          if(e.keyCode == 46){
            e.preventDefault();
            browseWilayah();
          }
        }); 
		
//////////////////////////////////////////////////////////////////////////////////////////////////
      
  });

  function cekQty(){
		$(".qtyt").each(function() {
      var qtyt = parseFloat($(this).val().replace(/,/g, ''));

      let z = $(this).closest('tr');
      var centang = z.find('.cek:checked').val();
      
      if(qtyt<0 && centang)
      {
        console.log(qtyt);
        return qtyt;
      }
		});
	}
  
  function hitung() {
		$(".qtyt").each(function() {
		  $(this).autoNumeric('init', {aSign: '<?php echo ''; ?>', vMin: '-999999999.99'});
		});
  }

	function simpanx() {
    // console.log(cekQty());
  }

	function simpan() {
		
		var check = '0';

		if ($('#wilayah1').val() == '') {
			check = '1';
			alert("Wilayah Harus di pilih.");
		}	
		
			if ($('#KOTA_SETOR').val() == '') {
			check = '1';
			alert("Kota Setor Harus di isi.");
		}	


		(check==0) ? document.getElementById("entri").submit() : alert('Masih ada kesalahan');
   
	}

  
</script>
@endsection
