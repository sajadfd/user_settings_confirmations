@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Change Setting</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('user.setting') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="setting" class="col-md-4 col-form-label text-md-right">{{ __('Setting') }}</label>

                                <div class="col-md-6">
                                    <input id="setting" type="text" class="form-control @error('setting') is-invalid @enderror" name="setting" value="{{ old('setting') }}" required autofocus>

                                    @error('setting')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="value" class="col-md-4 col-form-label text-md-right">{{ __('Value') }}</label>

                                <div class="col-md-6">
                                    <input id="value" type="text" class="form-control @error('value') is-invalid @enderror" name="value" value="{{ old('value') }}" required>

                                    @error('value')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="verification_method" class="col-md-4 col-form-label text-md-right">{{ __('Verification Method') }}</label>

                                <div class="col-md-6">
                                    <select id="verification_method" class="form-control @error('verification_method') is-invalid @enderror" name="verification_method" required>
                                        <option value="sms">SMS</option>
                                        <option value="email">Email</option>
                                        <option value="telegram">Telegram</option>
                                    </select>

                                    @error('verification_method')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Save') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection