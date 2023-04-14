{{-- <h1>Edit Setting</h1>
<div class="container">
    <div class="child">
        <form action="{{ route('settings.update', [$user, $setting]) }}" method="post">
            @csrf
            @method('put')
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
     
            <br>
            <button type="submit">Update Setting</button>
        </form>
    </div>
</div> --}}




@extends('layout')

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
            <button type="submit" class="btn btn-primary" id="update-btn">Update</button>
        </form>
        <div class="modal fade" id="confirmation-modal" tabindex="-1" role="dialog"
            aria-labelledby="confirmation-modal-label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmation-modal-label">Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Please enter the confirmation code:</p>
                        <input type="text" name="confirmation_code" id="confirmation_code" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="confirm-btn">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $('#update-form').submit(function(event) {
                event.preventDefault();
                $('#confirmation-modal').modal('show');
            });
            $('#confirm-btn').click(function() {
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
                        confirmation_code: confirmationCode
                    },
                    success: function(data) {
                        if (data.success) {
                            $('#update-form').submit();
                        } else {
                            $('#confirmation-error').show();
                        }
                    },
                    error: function() {
                        alert('An error occurred while checking the confirmation code');
                    }
                });
            });
        });
    </script>
@endsection
