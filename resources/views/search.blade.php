@extends ('layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/search.css') }}" />
@endsection

@section('content')
    <section id="search">
        <div class="cont-search">
            <h1 class="search-title">Search Results</h1>
            <div class="search-results">
                @if ($users->isEmpty())
                    <p>No players found.</p>
                @else
                    @foreach ($users as $user)
                    <div class="user-div">
                        <a href="{{ route('profile.view', $user->username) }}" class="btn btn-primary user-card">
                            {{-- <div class="user-image" style="background-image: url('{{ $user->image }}');"></div> --}}
                            <div class="user-info-card">
                                <h2 class="username">{{ $user->username }}</h2>
                                <h3>{{ $user->avgRating }} <i class="fa-solid fa-star"></i></h3>
                                <p class="nbs-posts">{{ $user->postsCount }} Posts</p>
                                <h4>Favorite Games:</h4>
                                <div class="favorite-games">
                                    @forelse ($user->favoriteGames as $game)
                                        <div class="fav_user_game">
                                            <img src="{{ $game->image ? asset($game->image) : asset('assets/main-bg.png') }}">
                                            <p>{{ $game->name }}</p>
                                        </div>
                                    @empty
                                        <p>No games found</p>
                                    @endforelse
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
@endsection
