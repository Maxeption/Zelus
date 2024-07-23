@extends('layouts.master')
@section('title', 'Zelus - Register')
@section('content')


    <section id="login">
        <div class="cont">
            <div class="login-form">
                <h1 class="title">Register</h1>
                <form action="{{ route('auth.store') }}" method="POST">
                    @csrf

                    <div class="form-group login-form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}">
                    </div>
                    <div class="form-group login-form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                    </div>
                    <div class="form-group login-form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="form-group login-form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    <div class="form-group login-form-group">
                        <button type="submit" class="btn btn-danger">Login</button>
                    </div>

                </form>
            </div>
        </div>
    </section>


@endsection
