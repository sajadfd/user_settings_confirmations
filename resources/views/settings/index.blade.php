@extends('layouts.app')
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