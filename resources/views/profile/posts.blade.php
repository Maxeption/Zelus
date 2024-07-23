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
                            <span class="active"><li class="sidebar-item"><a href="{{ route('profile.posts') }}">My Posts</a></li></span>
                            <li class="sidebar-item"><a href="{{ route('profile.Jposts') }}">Joined posts</a></li>
                            <li class="sidebar-item"><a href="{{ route('profile.connections') }}">Connections</a></li>
                        </ul>
                    </div>
                </div>
                <div class="profile-settings col-10">
                    <div class="profile-settings-header">
                        <h1>Created Posts</h1>
                    </div>
                    <section id="posts">
                        @foreach (Auth::user()->posts as $post)
                        <div class="post">
                            <div class="post-img">
                                <div class="filter"></div>
                                <img class="" src="{{ optional($post->gameList)->image }}" alt="">
                            </div>
                            <div class="post-cont">
                                <div class="post_top">
                                    <h1 class="post-title">{{$post->title}}</h1>
                                    <div class="post_top_right">
                                        <span class="post-date"><img width="30" height="30" src="https://img.icons8.com/ios-glyphs/30/clock--v1.png" alt="clock--v1"/> {{$post->created_at}}</span>
                                        <span class="post_game"><img width="24" height="24" src="https://img.icons8.com/android/24/controller.png" alt="controller"/>{{$post->game}}</span>
                                    </div>
                                </div>
                                <div class="post_desc">
                                    <p class="post-desc">{{$post->content}}</p>
                                </div>
                                <div class="post-bottom">
                                    <span class="post-players">{{$post->number_of_players}}/6</span>
                                    <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <a class="btn btn-danger plus" href="{{ route('posts.create') }}">+</a>
                    </section>
                </div>
            </div>
    </section>
@endsection
