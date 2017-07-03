@extends('admin::layouts.document')

@section('styles')
    @parent
    <link rel="stylesheet" href="css/login.css">
@append


@section('body')

    <div class="logo-login">
        <a href="" class="logo"><img src="{{ (!empty(SystemInc\LaravelAdmin\Setting::first()) && SystemInc\LaravelAdmin\Setting::first()->source !== null) ? asset('storage').'/'.SystemInc\LaravelAdmin\Setting::first()->source : 'images/logo.png' }}" alt="SystemInc Laravel admin logo"></a>
    </div>

    <div class="login-form">

        @if ($errors->first('login'))
            <div class="alert alert-error no-hide">
                <span class="help-block">
                    <strong>{{ $errors->first('login') }}</strong>
                </span>
            </div>
        @endif

        <form class="form-horizontal" role="form" method="POST" action="login">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                @if (session('message'))
                    <div class="alert alert-error no-hide">
                        <span class="help-block">
                            <strong>{{ session('message') }}</strong>
                        </span>
                    </div>
                @endif
                {{-- <label>E-Mail Address</label> --}}
                <input type="email" name="email" id="name" value="{{ old('email') }}" placeholder="Email Address">

            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                {{-- <label>Password</label> --}}
                <input type="password" name="password" id="password" placeholder="Password">

            </div>


            <button class="button full-button">Log in</button>

        </form>
    </div>


@stop