@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('settings.update', [$user, $setting]) }}" id="update-form">
            @csrf
            @method('PUT')
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="{{ $setting->name }}" required>
            </div>
            <br>
            <div>
                <label for="value">Value:</label>
                <input type="text" id="value" name="value" value="{{ $setting->value }}" required>
            </div>
            <br>
            <div>
                <label for="method">Confirmation Method:</label>
                <select id="method" name="method" required>
                    <option value="sms">SMS</option>
                    <option value="email">Email</option>
                    <option value="telegram">Telegram</option>
                </select>
            </div>
            <button type="button" class="btn btn-primary" id="update-btn">Update</button>
        </form>
        <div class="modal fade" id="confirmation-modal" tabindex="-1" role="dialog"
            aria-labelledby="confirmation-modal-label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmation-modal-label">Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Please enter the confirmation code:</p>
                        <input type="text" name="confirmation_code" id="confirmation_code" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="verify-btn">Verify</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $('#update-btn').click(function(event) {
                event.preventDefault();
                var confirmationMethod = $('#method').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route('settings.send_confirmation_code', [$user, $setting]) }}',
                    method: 'post',
                    data: {
                        confirmationMethod: confirmationMethod,
                        setting_id: {{ $setting->id }}
                    },
                    success: function(data) {
                        if (data.success) {
                            alert(data.message);
                            $('#confirmation-modal').modal('show');
                        }
                    },
                    error: function() {
                        alert(
                            'An error occurred while sending the confirmation code!'
                        );
                    }
                });
            });
            $('#verify-btn').click(function() {
                var confirmationCode = $('#confirmation_code').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route('settings.check_confirmation_code', [$user, $setting]) }}',
                    method: 'post',
                    data: {
                        confirmation_code: confirmationCode,
                        setting_id: {{ $setting->id }}
                    },
                    success: function(data) {
                        if (data.success) {
                            alert(data.message);
                             $('#update-form').submit();
                        }
                        if (!data.success) {
                            alert(data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = xhr.responseJSON.message;
                        var errorMessages = '';
                        // loop through the errors and add them to the errorMessages variable
                        for (var key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                errorMessages += errors[key].join('\n') + '\n';
                            }
                        }
                        // display the error messages in an alert box
                        alert(errorMessage + '\n\n' + errorMessages);
                    }
                });
            });
        });
    </script>
@endsection
