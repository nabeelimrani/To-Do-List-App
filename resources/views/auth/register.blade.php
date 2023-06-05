@extends('layouts.app')

@section('content')
<div class="container   ">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"> <i class="fas fa-user-plus"></i>&nbsp;{{ __('User Registeration') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">
                                <i class="fas fa-user"></i>
                                {{ __('Name') }}
                            </label>

                            <div class="col-md-8">
                                <div class="input-group">
                                    <input id="name" type="text" class="form-control rounded-pill @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                </div>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">
                                <i class="fas fa-envelope"></i>
                                {{ __('Email Address') }}
                            </label>

                            <div class="col-md-8">
                                <div class="input-group">
                                    <input id="email" type="email" class="form-control rounded-pill @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                </div>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">
                                <i class="fas fa-lock"></i>
                                {{ __('Password') }}
                            </label>

                            <div class="col-md-8">
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control rounded-pill @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                </div>
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">
                                <i class="fas fa-lock"></i>
                                {{ __('Confirm Password') }}
                            </label>

                            <div class="col-md-8">
                                <div class="input-group">
                                    <input id="password-confirm" type="password" class="form-control rounded-pill" name="password_confirmation" required autocomplete="new-password">
                                </div>
                                @error('password_confirmation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-outline-primary rounded-pill">
                                    <i class="fas fa-user-plus"></i>&nbsp; {{ __('Register') }}
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
