@extends('layouts.plain')
@section('styles')
<link rel="stylesheet" href="{{url('AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{url('http://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css') }}">

@endsection


<style>

    th { font-size: 13px; }
    td { font-size: 13px; }

    /* menghilangkan padding */
    .content-header {
        padding: 0 !important;
    }
</style>


@section('content')

<!-- Sweetalert delete -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!--  -->

<div class="content-wrapper">
  
    <!-- Status -->
    @if (session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>

        <!-- tambahan notifikasinya untuk delete di index -->
          <script>
              Swal.fire({
                title: 'Deleted!',
                text: 'Data has been deleted. {{session('status')}}',
                icon: 'success',
                confirmButtonText: 'OK'
              })
          </script>
        <!-- tutupannya -->

    @endif

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
  
                <input name="flagz" class="form-control flagz" id="flagz" value="{{$flagz}}" hidden>                
                <input name="golz" class="form-control golz" id="golz" value="{{$golz}}" hidden>                

  
				        <table class="table table-fixed table-striped table-border table-hover nowrap datatable" id="datatable">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" style="text-align: center">#.</th>
                            <th scope="col" style="text-align: center">-</th>	
                            <th scope="col" style="text-align: left">Bukti#</th>
                            <th scope="col" style="text-align: center">Tgl</th>
                            <th scope="col" style="text-align: left">Kode#</th>
                            <th scope="col" style="text-align: left">Suplier</th>
                            <th scope="col" style="text-align: center">Total</th>
                            <!-- <th scope="col" style="text-align: center">RpTotal</th>							 -->
                            <th scope="col" style="text-align: center">Notes</th>
                             
                              
                            <th scope="col" style="text-align: center">Posted</th>
                            <th scope="col" style="text-align: center">User</th>
                            <th {{($flagz == 'TH') ? 'hidden' : '' }} scope="col" style="text-align: center">Bank#</th>							
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
                url: "{{ route('get-utbeli') }}",
                data: {
                  'flagz': "{{$flagz}}",
                  'golz': "{{$golz}}",
                },
				
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
                    return ' <h5><span class="badge badge-pill badge-warning">' + data + '</span></h5>';
                  }
                },			
                { data: 'TOTAL', name: 'TOTAL', render: $.fn.dataTable.render.number( ',', '.', 0, '' )},	
                // { data: 'RPTOTAL', name: 'RPTOTAL', render: $.fn.dataTable.render.number( ',', '.', 2, '' )},
                { data: 'NOTES', name: 'NOTES'},
                { data: 'POSTED', name: 'POSTED',
                  render : function(data, type, row, meta) {
                    if(row['POSTED']=="0"){
                        return '';
                    }else{
                        return '<input type="checkbox" checked style="pointer-events: none;">';
                    }
                  }
                },
                { data: 'USRNM', name: 'USRNM'},
                { data: 'NO_BANK', name: 'NO_BANK'},
            ],
            columnDefs: 
            [
                {
                    "className": "dt-center", 
                    "targets": [0],
                },			
                {
                  targets: 3,
                  render: $.fn.dataTable.render.moment( 'DD-MM-YYYY' )
                },
				        {
                    "className": "dt-right", 
                    "targets":[6]
                },
				        {
                    "className": "dt-left", 
                    "targets":[4,5]
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
			stateSave:true,

       });


            // if ( '{{$flagz}}' == 'BL' ) {
              
            //   dataTable.columns([7,11,12,13]).visible(true);
              
            // }
            // else
            // {
              
            //   dataTable.columns([7,11,12,13]).visible(false);
              
            // }
			
			if ( '{{$flagz}}' == 'TH' ) {
              
              dataTable.columns([10]).visible(true);
              
            }
            else
            {
              
              dataTable.columns([10]).visible(false);
              
            }

       $("div.test_btn").html('<a class="btn btn-lg btn-md btn-success" href="{{url('utbeli/edit?flagz='.$flagz.'&golz='.$golz.'&idx=0&tipx=new')}}"> <i class="fas fa-plus fa-sm md-3" ></i></a');

       

		
		
    });
    
    function deleteRow(link) {
        console.log('Masuk');
        Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = link;
            }
        });
    }
	
</script>
@endsection


