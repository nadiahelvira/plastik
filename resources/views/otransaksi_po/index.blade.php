@extends('layouts.plain')
@section('styles')
<!-- <link rel="stylesheet" href="{{url('http://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css') }}"> -->
<link rel="stylesheet" href="{{asset('foxie_js_css/jquery.dataTables.min.css')}}" />

@endsection

<style>

    .card {
        padding: 5px 10px !important;
    }


    .table thead {
        background-color: #FFFFFF;
        color: #000000;
    }


    .datatable tbody td {
        padding: 5px !important;
        background-color: #FFFFFF;
    }

    .datatable {
        border-right: solid 2px #000;
        border-left: solid 2px #000;
    }
	
 
    .btn-secondary {
        background-color: #42047e !important;
    }
    
    

      
    th { font-size: 12px; }
    td { font-size: 12px; }
</style>


@section('content')
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h5 class="m-0">Transaksi {{$judul}} </h5>
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

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
			  
              <form method="POST" id="entri" action="{{url('po/posting')}}">

              <input name="flagz"  class="form-control flagz" id="flagz" value="{{$flagz}}" hidden >
              <input name="golz"  class="form-control golz" id="golz" value="{{$golz}}" hidden >
 
                <!-- <button class="btn btn-danger" type="button"  onclick="simpan()">Posting</button> -->

                <table class="table table-fixed table-striped table-border table-hover nowrap datatable" id="datatable">
                   

                    <thead class="table-dark">
                        <tr>
                            <th scope="col" style="text-align: center">#</th>
				     	    <th scope="col" style="text-align: center">-</th>							
                            <th scope="col" style="text-align: left">Bukti#</th>
                            <th scope="col" style="text-align: center">Tgl</th>
                            <th scope="col" style="text-align: left">Suplier#</th>
                            <th scope="col" style="text-align: left">Nama</th>
                            <th scope="col" style="text-align: right">Total-Qty</th>
						    <th scope="col" style="text-align: right">Total</th>
                            <th scope="col" style="text-align: left">Notes</th>
                            <th scope="col" style="text-align: left">User</th>
                            <th scope="col" style="text-align: right">Posted</th>
                        </tr>
                    </thead>
    
                    <tbody>
                    </tbody> 
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
@endsection

@section('javascripts')
<script>
  $(document).ready(function() {
	  

			  
        var dataTable = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            // 'scrollX': true,
            // 'scrollY': '400px',
            "order": [[ 0, "asc" ]],
            ajax: 
            {
                url: "{{ route('get-po') }}",
				        data: 
                {
                    flagz : $('#flagz').val(),
                    golz : $('#golz').val(),
				   
                }
            },

            columns: 
            [
                { data: 'DT_RowIndex', orderable: false, searchable: false },
			    { data: 'action', name: 'action'},
                { data: 'NO_BUKTI', name: 'NO_BUKTI'},
                { data: 'TGL', name: 'TGL'},
                { data: 'KODES', name: 'KODES'},
                { data: 'NAMAS', name: 'NAMAS',
                  render : function ( data, type, row, meta )
                  {
                           return ' <p style="font-family: Tahoma; font-size: 2px; color: brown; "><span class="badge badge-pill badge-danger"> ' + data + ' </span></p> ';
                  }},
                { data: 'TOTAL_QTY', name: 'TOTAL_QTY', render: $.fn.dataTable.render.number( ',', '.', 0, '' )},			
                { data: 'TOTAL', name: 'TOTAL', render: $.fn.dataTable.render.number( ',', '.', 0, '' )},				
                { data: 'NOTES', name: 'NOTES'},
				        { data: 'USRNM', name: 'USRNM'},
                { data: 'POSTED', name: 'POSTED',
                  render : function(data, type, row, meta) {
                    if(row['POSTED']=="0"){
                        return '';
                    }else{
                        return '<input type="checkbox" checked style="pointer-events: none;">';
                    }
                  }
                },
            ],
            columnDefs: 
            [
                {
                    "className": "dt-center", 
                    "targets": 9
                },			
                {
                  targets: 3,
                  render: $.fn.dataTable.render.moment( 'DD-MM-YYYY' )
                },
                
		        {
                    "className": "dt-right", 
                    "targets": 6
                },
			
                
                
            ],
            lengthMenu: 
            [
                [8, 10, 20, 50, 100, -1],
                [8, 10, 20, 50, 100, "All"]
            ],
            dom: "<'row'<'col-md-6'><'col-md-6'>>" +
                "<'row'<'col-md-2'l><'col-md-6 test_btn m-auto'><'col-md-4'f>>" +
                "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>",

        });
		
        $("div.test_btn").html('<a class="btn btn-lg btn-md btn-success" href="{{url('po/edit?flagz='.$flagz.'&golz='.$golz.'&idx=0&tipx=new')}}"> <i class="fas fa-plus fa-sm md-3" ></i></a');
    });
	
	
	function simpan() {
    var check = '0';
    var min = '0';
		
	
	document.getElementById("entri").submit();

	}
	
	
	
	
</script>
@endsection
