@extends('layouts.master')

@section('title', 'Profile')

@section('links')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile-games.css') }}">
@endsection

@section('content')
    <section id="profile-settings">
        <div class="row cont">
            <div class="sidebar col-2">
                <div class="sidebar-list">
                    <ul>
                        <span class="active">
                            <li class="sidebar-item"><a href="{{ route('profile.show', ['profile' => $user->id]) }}">Profile</a></li>
                        </span>
                        <li class="sidebar-item"><a href="{{ route('profile.posts', ['profile' => $user->id]) }}">Posts</a>
                        </li>
                        <li class="sidebar-item"><a href="{{ route('profile.Jposts') }}">Joined posts</a></li>
                        <li class="sidebar-item"><a href="{{ route('profile.connections') }}">Connections</a></li>
                    </ul>
                </div>
            </div>
            <div class="profile-settings col-10">
                <div class="profile-settings-header">
                    <h1>Profile</h1>
                </div>
                <div class="profile-settings-top">
                    <div class="profile-settings-avatar">
                        <div class="upload">
                            <i class="fa-solid fa-upload"></i>
                        </div>
                        <input type="file" name="" id="">
                        <img src="https://cdn.cloudflare.steamstatic.com/steam/apps/1085660/header.jpg?t=1710538394"
                            alt="">
                    </div>
                    <div class="profile-settings-score">
                        <div class="score">
                            <span class="score-title">Reputation</span>
                            <spam class="score-number">{{ $avgRating }}</spam>
                            <span id="rating-word">
                                @if ($avgRating < 1)
                                    avoid at all costs
                                @elseif ($avgRating < 2)
                                    needs work
                                @elseif ($avgRating < 3)
                                    Fair
                                @elseif ($avgRating < 4)
                                    Good
                                @elseif ($avgRating < 5 || $avgRating == 5)
                                    MVP
                                @endif
                            </span>
                        </div>
                        <div class="stars">
                            <span>
                                <label class="star-cont" for="star">
                                    <input value="1" type="radio" name="rating-star" class="rating-star"
                                        data-user-id = "{{ $user->id }}">
                                    <i class="fa-solid fa-star"></i>
                                </label>
                                <label class="star-cont" for="star">
                                    <input value="2" type="radio" name="rating-star" class="rating-star"
                                        data-user-id = "{{ $user->id }}">
                                    <i class="fa-solid fa-star"></i>
                                </label>
                                <label class="star-cont" for="star">
                                    <input value="3" type="radio" name="rating-star" class="rating-star"
                                        data-user-id = "{{ $user->id }}">
                                    <i class="fa-solid fa-star"></i>
                                </label>
                                <label class="star-cont" for="star">
                                    <input value="4" type="radio" name="rating-star" class="rating-star"
                                        data-user-id = "{{ $user->id }}">
                                    <i class="fa-solid fa-star"></i>
                                </label>
                                <label class="star-cont" for="star">
                                    <input value="5" type="radio" name="rating-star" class="rating-star"
                                        data-user-id = "{{ $user->id }}">
                                    <i class="fa-solid fa-star"></i>
                                </label>
                            </span>
                        </div>
                    </div>
                </div>

                <script>
                    document.querySelectorAll('input[name="rating-star"]').forEach((radio) => {
                        radio.addEventListener("change", function() {
                            var ratedUserId = this.getAttribute('data-user-id');
                            var rating = this.value;

                            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                            fetch('{{ route('user.rating') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrfToken
                                    },
                                    body: JSON.stringify({
                                        rating: rating,
                                        rated_user_id: ratedUserId
                                    })
                                })
                                .then(response => response.json())
                                .then(response => {
                                    if (response.status === "success") {
                                        alert('Rating submitted successfully.');
                                    } else if (response.error) {
                                        alert(response.error);
                                    } else {
                                        alert('An error occurred. Please try again.');
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                        });
                    });
                </script>
                <div class="profile-settings-all">
                    <div class="profile-settings-content">
                        <form class="form" method="POST"
                            action="{{ route('profile.update', ['profile' => $user->id]) }}">
                            @csrf
                            @method('PATCH')

                            <div class="profile-settings-content-item">
                                <label for="username">Username</label>
                                <input class="inputs" id="username" type="text" name="username"
                                    placeholder="{{ $user->username }}" required>
                            </div>

                            <div class="profile-settings-content-item">
                                <label for="email">Email</label>
                                <input class="inputs" id="email" type="email" name="email"
                                    placeholder="{{ $user->email }}">
                            </div>

                            <div class="profile-settings-content-item">
                                <label for="password">Old Password</label>
                                <input class="inputs" type="password" id="password" name="password">
                            </div>

                            <div class="profile-settings-content-item">
                                <label for="new_password">New Password</label>
                                <input class="inputs" type="password" id="new_password" name="new_password">
                            </div>

                            <div class="profile-settings-content-item">
                                <label for="new_password_confirmation">Confirm New Password</label>
                                <input class="inputs" type="password" id="new_password_confirmation"
                                    name="new_password_confirmation">
                            </div>

                            <div class="profile-settings-content-item">
                                <label for="bio">Bio</label>
                                <textarea class="inputs text-area" name="bio" id="bio" cols="30" rows="10">{{ $user->bio }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </form>
                    </div>
                    <div class="profile-settings-games">
                        <h2>Favorite Games</h2>
                        <div class="profile-settings-games-list">
                            @foreach ($favoriteGames as $game)
                                <div class="profile-settings-games-item">
                                    <img src="{{ $game->image ? asset($game->image) : asset('assets/main-bg.png') }}" alt="">
                                    <span>{{ $game->name }}</span>
                                    <form action="{{ route('profile.removeFavorite', ['profile' => $user->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="game_id" value="{{ $game->id }}">
                                        <button type="submit" class="btn btn-danger">Remove</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                            @if(count($user->favoriteGames) < 4)
                            <div class="add-game-btns">
                                <form action="{{ route('profile.favorite', ['profile' => $user->id]) }}" method="POST">
                                    @csrf
                                    <select class="add-game-btn" id="gameSelect" name="game_id">
                                        <option style="text-align: center" value="" selected disabled>+</option>
                                        @foreach ($games as $game)
                                            <option data-img="{{ $game->image ? asset($game->image) : asset('assets/main-bg.png') }}" value="{{ $game->id }}">{{ $game->name }}</option>
                                        @endforeach
                                    </select>
                                    <button id="addGame">Add</button>
                                </form>
                            </div>
                            @else
                                <div class="add-game-btns">
                                    <form action="{{ route('profile.favorite', ['profile' => $user->id]) }}" method="POST">
                                        @csrf
                                        <select class="add-game-btn" id="gameSelect" name="game_id" style="display: none">
                                            <option style="text-align: center" value="" selected disabled>+</option>
                                            @foreach ($games as $game)
                                                <option data-img="{{ $game->image ? asset($game->image) : asset('assets/main-bg.png') }}" value="{{ $game->id }}">{{ $game->name }}</option>
                                            @endforeach
                                        </select>
                                        <button id="addGame" style="display: none">Add</button>
                                    </form>
                                </div>
                            @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- limit the user to only have 4 games in theiur favorites by hidding the select and button --}}


    </section>
@endsection
