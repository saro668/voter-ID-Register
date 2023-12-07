@extends('layouts.app')
  
@section('title', 'Voters List Report')
  
@section('contents')
   

<form action="{{ route('report') }}" method="GET" class="mt-4">
    <div class="form-row align-items-center">
        <div class="col-md-4">
            <label for="district" class="sr-only">Filter by district</label>
          
            <select name="state" class="form-control" id="state_id">
                <?php
                    $stateId = request('state');
                 ?>
                    <option value="">Select State</option>
                    @foreach($states as $state)
                  
                        <option value="{{ $state->id }}" {{ $stateId == $state->id ? 'selected' : '' }}>
                            {{ $state->state_name }}
                        </option>
                       
                    @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="state" class="sr-only">Filter by state</label>
            <?php
                    $districtId = request('district');
            ?>
             <select name="district" class="form-control" id="district_id">
                    <option value="">Select District</option>
                     @foreach($districts as $district)
                  
                        <option value="{{ $state->id }}" {{ $districtId == $district->id ? 'selected' : '' }}>
                            {{ $district->district_name }}
                        </option>
                       
                    @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary mb-2">Filter</button>
        </div>
       
    </div>
</form>


<br>
<a href="{{ route('export', ['district' => request('district'), 'state' => request('state')]) }}">Export to Excel</a>
<br>
 <table class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>District</th>
                <th>State</th>
            </tr>
        </thead>
        <tbody>+
            @if($voters->count() > 0)
                @foreach($voters as $rs)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $rs->first_name }}</td>
                        <td class="align-middle">{{ $rs->last_name }}</td>
                        <td class="align-middle">{{ $rs->email }}</td>
                        <td class="align-middle">{{ $rs->mobile }}</td> 
                        <td class="align-middle">{{ $rs->district_name }}</td>  
                        <td class="align-middle">{{ $rs->state_name }}</td>  

                     </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="5">Product not found</td>
                </tr>
            @endif
        </tbody>
    </table>
    {{ $voters->links() }}


 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script type="text/javascript">
   $(document).ready(function() {
    
    $('#state_id').change(function() {
    
        var stateId = $(this).val();

        if(stateId == undefined || stateId == "") {
            $('#district_id').empty();

            return false;
        }

        $.ajax({
            url: '/district/get/' + stateId,
            type: 'GET',
            success: function(data) {
              
                $('#district_id').empty();


                $.each(data, function(key, value) {
                    $('#district_id').append('<option value="' + value.id + '">' + value.district_name + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

});


  </script>

 @endsection