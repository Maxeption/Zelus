@extends('layouts.master')

@section('title', 'Profile')

@Section('links')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/connections.css') }}">
@endsection

@section('content')
    <section id="profile-settings">
        <div class="row cont">
            <div class="sidebar col-2">
                <div class="sidebar-list">
                    <ul>
                        <li class="sidebar-item"><a href="{{ route('profile.view', ['username' => $user->username]) }}">Profile</a></li>
                        <li class="sidebar-item"><a href="{{ route('profile.Sposts', ['username' => $user->username]) }}">Posts</a></li>
                        <span class="active"><li class="sidebar-item"><a href="{{ route('profile.Sconnections' , ['username' => $user->username]) }}">Connections</a></li></span>
                    </ul>
                </div>
            </div>
            <div class="profile-settings col-10">
                <div class="profile-settings-header">
                    <h1>Connect Accounts</h1>
                </div>
                <section id="connections">
                    <div class="steam platform_card">
                            <div class="form-group">
                                <div class="platform-logo"><i class="fa-brands fa-steam"></i> Steam</div>
                                <label for="steam">{{ $steamIGN }} </label>
                            </div>
                    </div>
                    <div class="epic platform_card">
                            <div class="form-group">
                                <div class="platform-logo"><i class="fa-brands fa-Epic Games"></i> Epic Games</div>
                                <label for="Epic Games">{{ $epicGamesIGN }} </label>
                            </div>
                    </div>
                    <div class="xbox platform_card">
                            <div class="form-group">
                                <div class="platform-logo"><i class="fa-brands fa-xbox"></i> Xbox</div>
                                <label for="Xbox">{{ $xboxIGN }}</label>
                            </div>
                    </div>
                    <div class="riot platform_card">
                            <div class="form-group">
                                <div class="platform-logo"><i class="fa-brands fa-Riot Games"></i> Riot Games</div>
                                <label for="Riot Games">{{ $riotIGN }} </label>
                            </div>
                    </div>
                    <div class="PSN platform_card">
                            <div class="form-group">
                                <div class="platform-logo"><i class="fa-brands fa-playstation"></i> PSN</div>
                                <label for="PSN">{{ $psnIGN }} </label>
                            </div>
                    </div>
                    <div class="discord platform_card">
                            <div class="form-group">
                                <div class="platform-logo"><i class="fa-brands fa-discord"></i> Discord</div>
                                <label for="discord">{{ $discordIGN }} </label>
                            </div>
                    </div>
                    <div class="bungie platform_card">
                            <div class="form-group">
                                <div class="platform-logo"><i class="fa-brands fa-bungie"></i> Bungie</div>
                                <label for="bungie">{{ $bungieIGN }} </label>
                            </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection
