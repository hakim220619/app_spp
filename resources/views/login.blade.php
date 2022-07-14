@extends('layouts.head')

{{--@if($errors->any())--}}
{{--    {{ implode('', $errors->all('<div>:message</div>')) }}--}}
{{--@endif--}}

@section('body')
    <div class="global-container">
        <div class="card login-form">
            <div class="card-body">
                <div style="text-align: center; margin-bottom: 4px">
                    <img src="/images/logo.jpeg" style="width: 75px;" />
                </div>
                <h3 class="card-title text-center">Log in {{ucfirst($as)}}</h3>
                <div class="card-text">
                    <form method="post" action="{{route('do.login')}}">
                        @csrf
                        <input type="hidden" name="as" value="{{$as}}">
                        <!-- to error: add class "has-danger" -->
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email') <span
                                class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            {{--                            <a href="#" style="float:right;font-size:12px;">Forgot password?</a>--}}
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror" name="password" required
                                   autocomplete="current-password">
                            @error('password') <span
                                class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                        <button type="submit" class="btn btn-green btn-block">Sign in</button>

                        {{--                        <div class="sign-up">--}}
                        {{--                            Don't have an account? <a href="#">Create One</a>--}}
                        {{--                        </div>--}}
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
