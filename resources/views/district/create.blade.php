@extends('layouts.app')
  
@section('title', 'Create District')
  
@section('contents')
    
    <hr />
   <form id="district" action="{{ route('district.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row mb-3">
        <div class="col">
            <label for="district_name" class="form-label">District Name</label>
            <input type="text" name="district_name" id="district_name" class="form-control" placeholder="District Name">
        </div>
        <div class="col">
            <label for="state_id" class="form-label">State</label>
            <select name="state_id" id="state_id" class="form-control">
                <option value="">Select State</option>
                @foreach($states as $state)
                    <option value="{{ $state->id }}">{{ $state->state_name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="d-grid">
            <button type="submit" class="btn btn-primary submit_btn">Submit</button>
        </div>
    </div>
</form>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#district').submit(function(e) {
                e.preventDefault(); 

                var formData = $(this).serialize();
                $('.error-feedback').remove();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    beforeSend: function() {
                        
                        $('.submit_btn').prop('disabled', true).html('Loading...');
                    },
                    complete: function() {
                       
                        $('.submit_btn').prop('disabled', false).html('Submit');
                    },
                    success: function(response) {
                 
                        window.location.href = '/district';
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
               
                        if (xhr.status == 422) {
                        
                            var errors = xhr.responseJSON.errors;
                            displayValidationErrors(errors);
                        } else {
                       
                            console.error(xhr.responseText);
                        }
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
