@extends('layout')

@section('content')
    <h1>User Settings</h1>

    <p>User: {{ $user->name }}</p>

    <table class="table table-bordered table-responsive-lg table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Name</th>
                <th>Value</th>
                 <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if ($settings)
                @foreach ($settings as $setting)
                    <tr>
                        <td>{{ $setting->name }}</td>
                        <td>{{ $setting->value }}</td>
                         <td>
                            <a href="{{ route('settings.edit', [$user, $setting]) }}">Edit</a>
                            <form action="{{ route('settings.destroy', [$user, $setting]) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <a href="{{ route('settings.create', $user) }}">Add Setting</a>
@endsection




{{-- @extends('layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Laravel </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success text-light" data-toggle="modal" id="mediumButton" data-target="#mediumModal"
                    data-attr="{{ route('settings.create', $user) }}" title="Create a setting"> <i
                        class="fas fa-plus-circle"></i>
                </a>
            </div>
        </div>
    </div>



    <table class="table table-bordered table-responsive-lg table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Value</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($settings as $setting)
                <tr>
                    <td>{{ $setting->name }}</td>
                    <td>{{ $setting->value }}</td>
                     <td>
                        <form action="{{ route('settings.destroy', [$user, $setting]) }}" method="POST">
                            <a class="text-secondary" data-toggle="modal" id="mediumButton" data-target="#mediumModal"
                                data-attr="{{ route('settings.edit', [$user, $setting]) }}">
                                <i class="fas fa-edit text-gray-300"></i>
                            </a>
                            @csrf
                            @method('DELETE')

                            <button type="submit" title="delete" style="border: none; background-color:transparent;">
                                <i class="fas fa-trash fa-lg text-danger"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>





    <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="mediumBody">
                    <div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).on('click', '#mediumButton', function(event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');
            $.ajax({
                url: href,
                beforeSend: function() {
                    $('#loader').show();
                },
                success: function(result) {
                    $('#mediumModal').modal("show");
                    $('#mediumBody').html(result).show();
                },
                complete: function() {
                    $('#loader').hide();
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                    $('#loader').hide();
                },
                timeout: 8000
            })
        });
    </script>
@endsection --}}
