@extends('layouts.head')

@section('body')
    <div class="welcome-container">
        <div class="d-flex flex-column bd-highlight welcome-width">
            <div class="d-flex flex-column bd-highlight mb-3">
                <div class="p-2 align-self-center">
                    <img src="images/logo.jpeg" alt="logo" style="width: 150px"/>
                </div>
                <div class="p-2 align-self-center">
                    <h1 class="m-0">Selamat Datang</h1>
                </div>
                <div class="p-2 align-self-center">
                    <h4>Yayasan YPI Al-Hasanah</h4>
                </div>
            </div>
            <div class="d-flex flex-row bd-highlight mb-3">
                <div class="p-2 flex-fill bd-highlight">
                    <a class="btn btn-green btn-lg btn-block welcome-box" href="{{ route('login', 'admin') }}">
                        <i class="fa fa-desktop welcome-icon-btn"></i><br/>
                        <label class="welcome-btn-text">Login Admin</label>
                    </a>
                </div>
                <div class="p-2 flex-fill bd-highlight">
                    <a class="btn btn-green btn-lg btn-block welcome-box" href="{{ route('login', 'operator') }}">
                        <i class="fa fa-credit-card welcome-icon-btn"></i><br/>
                        <label class="welcome-btn-text">Login Operator</label>
                    </a>
                </div>
                <div class="p-2 flex-fill bd-highlight">
                    <a class="btn btn-green btn-lg btn-block welcome-box" href="{{ route('login', 'siswa') }}">
                        <i class="fa fa-users welcome-icon-btn"></i><br/>
                        <label class="welcome-btn-text">Login Siswa</label>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
