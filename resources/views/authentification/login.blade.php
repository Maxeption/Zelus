@extends('layouts.master')
@section('title', 'Zelus - Login')

@section('links')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')

    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form class="forms" action="{{ route('auth.store') }}" method="POST">
                @csrf
                <h1>Create Account</h1>
                <input type="text" name="username" id="username" placeholder="Username">
                <input type="email" name="email" id="email" placeholder="Email">
                <input type="password" name="password" id="password" placeholder="Password">
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" >
                <button class="form-btns" type="submit" >Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form class="forms" action="{{ route('authenticate') }}" method="POST">
                @csrf
                <h1>Sign in</h1>
                <input type="email" name="email" id="email" placeholder="Email">
                <input type="password" name="password" id="password" placeholder="Password">
                <button class="form-btns" type="submit">Sign In</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back to Zelus!</h1>
                    <p>Log in and continue the fight</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Welcome to Zelus!</h1>
                    <p>Join us and meet amazing people</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');

        signUpButton.addEventListener('click', () => {
            container.classList.add("right-panel-active");
            });

            signInButton.addEventListener('click', () => {
                container.classList.remove("right-panel-active");
                });
    </script>

@endsection
