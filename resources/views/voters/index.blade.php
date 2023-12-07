@extends('layouts.app')
  
@section('title', 'Voters List')
  
@section('contents')
    <div class="d-flex align-items-center justify-content-between">
      
        <a href="{{ route('voters.create') }}" class="btn btn-primary">Add Voters</a>
    </div>
    <hr />
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

    
      <div class="container">

         <table class="table table-bordered data-table">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Dob</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>State</th>
                  <th>District</th>
                  <th>Created At</th>
                  <th>Action</th>



               </tr>
            </thead>
            <tbody>
            </tbody>
         </table>
      </div>

      <script type="text/javascript">
    $(document).ready(function() {

           var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                scrollY: '400px', // Set the vertical scroll height (adjust as needed)
                scrollCollapse: true,
                ajax: "{{ route('voters') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    {
                        data: null,
                        render: function (data, type, row) {
                            return row.first_name + ' ' + row.last_name;
                        }
                    },
                    {
                        data: 'dob',
                        render: function(data, type, full, meta) {
                            if (type === 'display') {
                           
                                return moment(data).format('DD/MM/YYYY');
                            }
                            return data;
                        }
                    },
                    { data: 'email' },
                    { data: 'mobile' },
                    { data: 'state_name' },
                    { data: 'district_name' },

                    {
                        data: 'created_at',
                        render: function(data, type, full, meta) {
                            if (type === 'display') {
                             
                                return moment(data).format('DD/MM/YYYY HH:mm:ss');
                            }
                            return data; 
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return '<a href="/voters/show/' + row.id + '">View</a> | <a href="/voters/destroy/' + row.id + '">Delete</a>';
                        }
                    }
                ]
            });

         });
</script>
 
@endsection