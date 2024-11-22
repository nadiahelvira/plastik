@extends('layouts.plain')
@section('styles')
<link rel="stylesheet" href="{{url('AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{url('http://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css') }}">
@endsection

<style>  

    th { font-size: 13px; }
    td { font-size: 13px; }
</style>

@section('content')
<div class="content-wrapper">

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
                <table class="table table-fixed table-striped table-border table-hover nowrap datatable" id="datatable">
                    <thead class="table-dark">
                        <tr>										
                            <th scope="col" style="text-align: center">No</th>
				     		            <th scope="col" style="text-align: center">-</th>							
                            <th scope="col" style="text-align: center">Type</th>
                            <th scope="col" style="text-align: center">Komisi</th>
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

<script>
  $(document).ready(function() {
        var dataTable = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            // 'scrollY': '200px',	
            // 'scrollX': '200px',	
            "order": [[ 0, "asc" ]],
            ajax: 
            {
                url: '{{ route('get-komisi') }}'
            },
            columns: 
            [
                {  data: 'DT_RowIndex', orderable: false, searchable: false },
                {
                   data: 'action',
                   name: 'action'
                },
				
                {data: 'TYPE', name: 'TYPE',
                  render : function ( data, type, row, meta )
                  {
                    return ' <h5><span class="badge badge-pill badge-warning">' + data + '</span></h5>';
                  }
                },
                {data: 'KOM', name: 'KOM'},
            ],


            columnDefs: [
                {
                    "className": "dt-center", 
                    "targets": [0,1,2]
                },
                {
                    "className": "dt-right", 
                    "targets": 3
                },
							
            ],

			
			      dom: "<'row'<'col-md-6'><'col-md-6'>>" +
                "<'row'<'col-md-2'l><'col-md-6 test_btn m-auto'><'col-md-4'f>>" +
                "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>",
		
			      stateSave:false,
        
        });
	

		
        $("div.test_btn").html('<a class="btn btn-lg btn-md btn-success" href="{{url('grup/edit?idx=0&tipx=new')}}"> <i class="fas fa-plus fa-sm md-3" ></i></a');
    });
	
	
	
</script>
@endsection