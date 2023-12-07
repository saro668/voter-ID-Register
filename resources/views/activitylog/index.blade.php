@extends('layouts.app')
  
@section('title', 'Activity Log')

@section('contents')


      <div class="container">

         <table class="table table-bordered data-table">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>ip Address</th>
                  <th>Message</th>
                  <th>Date & Time</th>


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
                ajax: "{{ route('activity') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'ip_address' },
                    { data: 'msg' },
                    {
                        data: 'created_at',
                        render: function(data, type, full, meta) {
                            if (type === 'display') {
                                // Format the date using moment.js (replace 'YYYY-MM-DD' with your actual date format)
                                return moment(data).format('DD/MM/YYYY HH:mm:ss');
                            }
                            return data; // For all other types, return the data as is
                        }
                    }
                ]
            });

         });
</script>
 


 @endsection

