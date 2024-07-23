@extends('layouts.master')

@section('title', 'Profile')

@Section('links')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')

    <section id="profile-settings">
            <div class="row cont">
                <div class="sidebar col-2">
                    <div class="sidebar-list">
                        <ul>
                            <li class="sidebar-item"><a href="{{ route('profile.show',['profile' => Auth::user()->id]) }}">Profile</a></li>
                            <li class="sidebar-item"><a href="{{ route('profile.posts') }}">My Posts</a></li>
                            <span class="active"><li class="sidebar-item"><a href="{{ route('profile.Jposts') }}">Joined posts</a></li></span>
                            <li class="sidebar-item"><a href="{{ route('profile.connections') }}">Connections</a></li>
                        </ul>
                    </div>
                </div>
                <div class="profile-settings col-10">
                    <div class="profile-settings-header">
                        <h1>Created Posts</h1>
                    </div>
                    <section id="posts">
                        @foreach ($user->joinedPosts as $post)
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
                                        @if (Auth::user()->joinedPosts->contains($post->id))
                                            <!-- Unjoin Button -->
                                            <form action="{{ route('posts.unjoin', ['post' => $post->id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-warning">Unjoin</button>
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
                    </section>
                </div>
            </div>
    </section>
@endsection
