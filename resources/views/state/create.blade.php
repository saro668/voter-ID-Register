@extends('layouts.app')
  
@section('title', 'Create State')
  
@section('contents')
    
    <hr />
   <form id="state" action="{{ route('state.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row mb-3">
        <div class="col">
            <label for="state_name" class="form-label">State Name</label>
            <input type="text" name="state_name" id="state_name" class="form-control" placeholder="State Name">
        </div>
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
            $('#state').submit(function(e) {
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
                       
                        window.location.href = '/state';
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
