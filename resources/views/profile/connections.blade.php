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
                        <li class="sidebar-item"><a href="{{ route('profile.show',['profile' => Auth::user()->id]) }}">Profile</a></li>
                        <li class="sidebar-item"><a href="{{ route('profile.posts') }}">My Posts</a></li>
                        <li class="sidebar-item"><a href="{{ route('profile.Jposts') }}">Joined posts</a></li>
                        <span class="active"><li class="sidebar-item"><a href="{{ route('profile.connections') }}">Connections</a></li></span>
                    </ul>
                </div>
            </div>
            <div class="profile-settings col-10">
                <div class="profile-settings-header">
                    <h1>Connect Accounts</h1>
                </div>
                <section id="connections">
                    <div class="steam platform_card">
                        <form action="{{ route('profile.connect', ['platform' => 'steam', 'profile' => Auth::user()->id]) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="platform-logo"><i class="fa-brands fa-steam"></i> Steam</div>
                                <label for="steam">{{ $steamIGN }} </label>
                                <div class="inputs">
                                    <input type="text" class="form-control" id="IGN" name="IGN" placeholder="{{ $steamIGN }}">
                                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="epic platform_card">
                        <form action="{{ route('profile.connect', ['platform' => 'epic', 'profile' => Auth::user()->id]) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="platform-logo"><i class="fa-brands fa-Epic Games"></i> Epic Games</div>
                                <label for="Epic Games">{{ $epicGamesIGN }} </label>
                                <div class="inputs">
                                    <input type="text" class="form-control" id="IGN" name="IGN" placeholder="{{ $epicGamesIGN }}">
                                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="xbox platform_card">
                        <form action='{{ route('profile.connect', ['platform' => 'xbox', 'profile' => Auth::user()->id]) }}' method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="platform-logo"><i class="fa-brands fa-xbox"></i> Xbox</div>
                                <label for="Xbox">{{ $xboxIGN }}</label>
                                <div class="inputs">
                                    <input type="text" class="form-control" id="IGN" name="IGN" placeholder="{{ $xboxIGN }}">
                                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="riot platform_card">
                        <form action="{{ route('profile.connect', ['platform' => 'riot', 'profile' => Auth::user()->id]) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="platform-logo"><i class="fa-brands fa-Riot Games"></i> Riot Games</div>
                                <label for="Riot Games">{{ $riotIGN }} </label>
                                <div class="inputs">
                                    <input type="text" class="form-control" id="IGN" name="IGN" placeholder="{{ $riotIGN }}">
                                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="PSN platform_card">
                        <form action="{{ route('profile.connect', ['platform' => 'PSN', 'profile' => Auth::user()->id]) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="platform-logo"><i class="fa-brands fa-playstation"></i> PSN</div>
                                <label for="PSN">{{ $psnIGN }} </label>
                                <div class="inputs">
                                    <input type="text" class="form-control" id="IGN" name="IGN" placeholder="{{ $psnIGN }}">
                                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="discord platform_card">
                        <form action="{{ route('profile.connect', ['platform' => 'discord', 'profile' => Auth::user()->id]) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="platform-logo"><i class="fa-brands fa-discord"></i> Discord</div>
                                <label for="discord">{{ $discordIGN }} </label>
                                <div class="inputs">
                                    <input type="text" class="form-control" id="IGN" name="IGN" placeholder="{{ $discordIGN }}">
                                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="bungie platform_card">
                        <form action="{{ route('profile.connect', ['platform' => 'bungie', 'profile' => Auth::user()->id]) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="platform-logo"><i class="fa-brands fa-bungie"></i> Bungie</div>
                                <label for="bungie">{{ $bungieIGN }} </label>
                                <div class="inputs">
                                    <input type="text" class="form-control" id="IGN" name="IGN" placeholder="{{ $bungieIGN }}">
                                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection
