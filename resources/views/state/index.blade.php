@extends('layouts.app')
  
@section('title', 'State List')
  
@section('contents')
   <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('state.create') }}" class="btn btn-primary">Add State</a>
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
                  <th>State Name</th>
                  <th>Status</th>
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
                ajax: "{{ route('state') }}",

                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    {data: 'state_name'},
                    { 
                        data: 'status',
                        render: function(data, type, row) {
                            if (type === 'display') {
                         
                                return `<select class="form-control" onchange="updateStatus(${row.id}, this.value)">
                                    <option value="Active" ${data === 'Active' ? 'selected' : ''}>Active</option>
                                    <option value="Inactive" ${data === 'Inactive' ? 'selected' : ''}>Inactive</option>
                                   
                                </select>`;
                            }
                            return data;
                        }
                    },
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
                            return `<a href="/state/${row.id}/edit">Edit</a> | <a href="/state/destroy/${row.id}">Delete</a>`;
                        }
                    }
                ]
            });

     
            window.updateState = function(id, value) {
                console.log(`Updating state_name for ID ${id} to ${value}`);
            };

       
            window.updateStatus = function(id, value) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                 $.ajax({
                        url: `/state/updateStatus/`+id,
                        type: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify({ status: value }),
                        success: function(data) {
                          
                            console.log('State name updated:', data.state_name);
                            // Perform any actions with the updated state_name
                        },
                        error: function(xhr, status, error) {
                            console.error('Error updating state_name:', error);
                        }
                });
             
            };
        });
    </script>
@endsection
