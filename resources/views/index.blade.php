@extends('layouts.master')

@section('content')

    <section id="about">
        <div class="cont">
                <div class="about-text">
                    <h1 class="title">Welcome to <span class="active">Zelus</span></h1>
                    <div class="filter"></div>
                    <p class="desc"><span class="active">Zelus</span> is a platform that allows you to connect with other gamers and play together. You can create posts to find other players to play with, or join other players' posts. You can also rate other players based on your experience with them. </p>
                    <a href="{{ route('posts.create') }}" style="z-index: 1000" class="btn btn-danger">Start Creating!</a>
                </div>
                <div class="about-img">
                </div>
        </div>
    </section>
    <section id="games">
        <div class="cont-games">
            <h1 class="title">GAMES</h1>
            <div class="games">
                @if ($games->isEmpty())
                    <p>No games found.</p>
                @else
                    @foreach ($games as $game)
                    <div class="game">
                        <a href="{{ route('posts.index', ['game' => $game->name]) }}" class="btn btn-primary game-card" style="background-image: url('{{ $game->image }}'); background-size: cover; background-position: center;" >{{ $game->name }}
                            <div class="game-info-card">
                                <h1 class="nb-posts">{{ $game->posts_count}} Posts</h1>
                            </div>
                        </a>
                    </div>
                    @endforeach
                @endif
        </div>
    </section>
    <section id="posts">
        <div class="cont posts-cont">
            @if ($posts->isEmpty())
                <p>No posts found.</p>
            @else
                @foreach ($posts as $post)
                <div class="post">
                    <div class="post-img">
                        <div class="filter"></div>
                        <img class="" src="{{ optional($post->gameList)->image ?? asset('assets/main-bg.png') }}" alt="">
                    </div>
                    <div class="post-cont">
                        <div class="post_top">
                            <h1 class="post-title">{{$post->title}}</h1>
                            <div class="post_top_right">

                                <span class="post-date"><img width="30" height="30" src="https://img.icons8.com/ios-glyphs/30/clock--v1.png" alt="clock--v1"/> {{$post->formatted_creation_date}}</span>
                                <span class="post_game"><img width="24" height="24" src="https://img.icons8.com/android/24/controller.png" alt="controller"/>{{$post->game}}</span>
                            </div>
                        </div>
                        <div class="post_desc">
                            <p class="post-desc">{{$post->content}}</p>
                        </div>
                        <div class="post-bottom">
                            @auth
                                @if (Auth::id() === $post->user_id)
                                    <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                @elseif (Auth::user()->joinedPosts->contains($post->id))
                                    <!-- Unjoin Button -->
                                    <form action="{{ route('posts.unjoin', ['post' => $post->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-warning">Unjoin</button>
                                    </form>
                                @elseif (!Auth::user()->joinedPosts->contains($post->id) && $post->number_of_players < 6)
                                    <form action="{{ route('posts.join', ['post' => $post->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Join</button>
                                    </form>
                                @endif
                            @endauth
                            {{-- platforms --}}
                            <span class="post-platform">{{$post->platform}}</span>
                            <span class="post-players">{{$post->number_of_players}}/6</span>
                                <div class="post-user">
                                    <a href="{{ route('profile.view', ['username' => optional($post->user)->username]) }}">
                                        <span class="post-username">{{ optional($post->user)->username }}</span>
                                    </a>
                                </div>
                        </div>
                    </div>
                    </div>
                @endforeach
            @endif
            <div class="plus">
                <a class="btn btn-danger plus" href="{{ route('posts.create') }}">+</a>
            </div>
        </div>
    </section>

    @endsection
