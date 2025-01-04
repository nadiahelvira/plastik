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

                <!-- filter kolom di index -->

                    <!-- Button to open modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#columnModal">
                        Filter Columns
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="columnModal" tabindex="-1" aria-labelledby="columnModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="columnModalLabel">Toggle Columns</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close">X</button>
                                </div>
                                <div class="modal-body">
                                    <!-- Column visibility checkboxes -->
                                    <form id="columnToggleForm">
                                        <div class="form-check">
                                            <input class="form-check-input column-checkbox" type="checkbox"
                                                value="0" id="columnNo" checked>
                                            <label class="form-check-label" for="columnNo">No</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input column-checkbox" type="checkbox"
                                                value="1" id="columnAction" checked>
                                            <label class="form-check-label" for="columnAction">Action</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input column-checkbox" type="checkbox"
                                                value="2" id="columnKode" checked>
                                            <label class="form-check-label" for="columnKode">Kode</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input column-checkbox" type="checkbox"
                                                value="3" id="columnNama" checked>
                                            <label class="form-check-label" for="columnNama">Nama</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input column-checkbox" type="checkbox"
                                                value="4" id="columnAlamat" checked>
                                            <label class="form-check-label" for="columnAlamat">Alamat</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input column-checkbox" type="checkbox"
                                                value="5" id="columnKota" checked>
                                            <label class="form-check-label" for="columnKota">Kota</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input column-checkbox" type="checkbox"
                                                value="6" id="columnTelpon">
                                            <label class="form-check-label" for="columnTelpon">Telpon</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input column-checkbox" type="checkbox"
                                                value="7" id="columnHP">
                                            <label class="form-check-label" for="columnHP">HP</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input column-checkbox" type="checkbox"
                                                value="8" id="columnNpwp">
                                            <label class="form-check-label" for="columnNpwp">NPWP</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input column-checkbox" type="checkbox"
                                                value="9" id="columnKet">
                                            <label class="form-check-label" for="columnKet">Ket</label>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary"
                                        id="applyColumnToggle">Apply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                
                <!-- batas filter -->

                <table class="table table-fixed table-striped table-border table-hover nowrap datatable" id="datatable">
                    <thead class="table-dark">
                        <tr>										
                            <th scope="col" style="text-align: center">No</th>
				     		            <th scope="col" style="text-align: center">-</th>							
                            <th scope="col" style="text-align: center">Kode</th>
                            <th scope="col" style="text-align: center">Nama</th>
                            <th scope="col" style="text-align: center">Alamat</th>
                            <th scope="col" style="text-align: center">Kota</th>
                            <th scope="col" style="text-align: center">Telpon</th>
                            <th scope="col" style="text-align: center">HP</th>
                            <th scope="col" style="text-align: center">NPWP</th>
                            <th scope="col" style="text-align: center">Ket</th>

                        </tr>
                    </thead>
    
                     <tbody>
                         
                    </tbody> 
                </table>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('javascripts')
<script src="{{url('AdminLTE/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{url('AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{url('http://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js') }}"></script>

<!-- filter kolom di index -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- batas filter  -->

<script>

        // filter kolom di index
        window.addEventListener('message', (event) => {
            if (event.origin !== window.location.origin) {
                console.warn('Origin mismatch!');
                return;
            }

            const currentData = event.data;
            console.log(currentData); // Use currentData as needed
        });
        // batas filter

  $(document).ready(function() {
        var dataTable = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            'scrollY': '400px',	
            "order": [[ 0, "asc" ]],
            ajax: 
            {
				
//  <!-- ganti 7a -->
 
                url: '{{ route('get-cust') }}'
            },
            columns: 
            [
                {  data: 'DT_RowIndex', orderable: false, searchable: false },

//  <!--// ganti 8 -->
			    {
				data: 'action',
				name: 'action'
			    },
				
				{data: 'KODEC', name: 'KODEC'},
                // {data: 'NAMAC', name: 'NAMAC' , visible: false  },
                {data: 'NAMAC', name: 'NAMAC',
                    render : function ( data, type, row, meta )
                        {
                            return ' <h5><span class="badge badge-pill badge-warning">' + data + '</span></h5>';
                        }
                },
                {data: 'ALAMAT', name: 'ALAMAT' },				
                {data: 'KOTA', name: 'KOTA'},
				{data: 'TELPON1', name: 'TELPON1'},
				{data: 'HP', name: 'HP'},
				{data: 'NPWP', name: 'NPWP'},
				{data: 'KET', name: 'KET'}

				
            ],


            columnDefs: [
                {
                    "className": "dt-center", 
                    "targets": 0
                },
							
            ],

			
			      dom: "<'row'<'col-md-6'><'col-md-6'>>" +
                "<'row'<'col-md-2'l><'col-md-6 test_btn m-auto'><'col-md-4'f>>" +
                "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>",
		
			      stateSave:false,
        
        });
	

        // filter kolom di index

        // Handle column visibility toggle
        $('#applyColumnToggle').on('click', function() {
            $('#columnToggleForm .column-checkbox').each(function() {
                var column = dataTable.column($(this).val());
                column.visible($(this).is(':checked'));
            });
            $('#columnModal').modal('hide'); // Close the modal
        });

        $('#columnToggleForm .column-checkbox').each(function() {
            var column = dataTable.column($(this).val());
            column.visible($(this).is(':checked'));
        });
        
        // batas filter
		
        $("div.test_btn").html('<a class="btn btn-lg btn-md btn-success" href="{{url('cust/edit?idx=0&tipx=new')}}"> <i class="fas fa-plus fa-sm md-3" ></i></a');
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