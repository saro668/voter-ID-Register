@extends('layouts.app')
  
@section('title', 'Create Voters')
  
@section('contents')
    
    <hr />
    <form id="voter" action="{{ route('voters.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="first_name" class="form-control" placeholder="First Name">
               
            </div>
            <div class="col">
                <input type="text" name="last_name" class="form-control" placeholder="Last Name">
             
            </div>
        </div>
 
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="email" class="form-control" placeholder="Email">
                
            </div>
            <div class="col">
                <input type="text" name="mobile" class="form-control" placeholder="Mobile">
                
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <input type="date" name="dob" class="form-control" placeholder="dob">
                
            </div>
            <div class="col">
                <textarea class="form-control" name="address" placeholder="address"></textarea>
               
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <select name="state_id" class="form-control" id="state_id">
                    <option value="">Select State</option>
                    @foreach($states as $state)
                        <option value="{{ $state->id }}">{{ $state->state_name }}</option>
                    @endforeach
                </select>
            </div>

             <div class="col">
                <select name="district_id" class="form-control" id="district_id">
                    <option value="">Select District</option>
                    @foreach($districts as $district)
                        <option value="{{ $state->id }}">{{ $district->district_name }}</option>
                    @endforeach
                </select>
            </div>

    
        </div>

         <div class="row mb-3">
              <div class="col">
                <input type="text" name="taluk" class="form-control" placeholder="taluk">
                
            </div>
        </div>

 
        <div class="row">
            <div class="d-grid">
                <button type="submit" class="btn btn-primary sumbmit_btn">Submit</button>
            </div>
        </div>
    </form>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script type="text/javascript">
   $(document).ready(function() {
    $('#voter').submit(function(e) {
        e.preventDefault(); 

        var formData = $(this).serialize(); 
        $('.error-feedback').remove();
        $.ajax({
            url: $(this).attr('action'), 
            type: 'POST',
            data: formData, 
            beforeSend: function() {
                    
                    $('.sumbmit_btn').prop('disabled', true).html('Loading...');
            },
            complete: function() {
                    $('.sumbmit_btn').prop('disabled', false).html('Submit');
                    
            },
            success: function(response) {
                // Handle success response
                window.location.href = '/voters';
                console.log(response);
            },
            error: function(xhr, status, error) {
                // Handle error response
                if (xhr.status == 422) {
             
                    var errors = xhr.responseJSON.errors;
                    displayValidationErrors(errors);
                } else {
             
                    console.error(xhr.responseText);
                }
            }
        });

    });


    $('#state_id').change(function() {
    
        var stateId = $(this).val();

     
        $.ajax({
            url: '/district/get/' + stateId,
            type: 'GET',
            success: function(data) {
                // Clear existing options
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

    function displayValidationErrors(errors) {
       
        for (var field in errors) {
            var errorMessage = errors[field][0];

            $('[name='+field+']').after('<div class="error-feedback" style="color: red">'+errorMessage+'</div>');
                   }
    }
});


  </script>
@endsection