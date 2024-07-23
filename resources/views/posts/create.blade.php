@extends('layouts.master')
@section('title', 'Create Post')
@section('links')
    <link rel="stylesheet" href="{{ asset('css/create_post.css') }}">
@endsection
@section('content')


    <section id="posts">
        <div class="cont posts-cont">
            <div class="post">
                <form action="{{ route('posts.store') }}" method="POST">
                    @csrf
                    <div class="post-img">
                        <div class="filter"></div>
                        <img src="{{ asset('assets/main-bg.png') }}" alt="">
                    </div>
                    <div class="post-cont">
                        <div class="post_top">
                            <input name="title" type="text" placeholder="Title" class="inputs-create post-title" value="">
                            <div class="post_top_right">
                                <span class="post-date"><img width="30" height="30" src="https://img.icons8.com/ios-glyphs/30/clock--v1.png" alt="clock--v1" />{{ now()->format('H:i') }}</span>
                                <select id="gameSelect" name="game" class="inputs-create post-game" >
                                    <option value="" selected disabled>Choose game</option>
                                    @foreach ($games as $game)
                                    <option data-img="{{ $game->image ? asset($game->image) : asset('assets/main-bg.png') }}" value="{{ $game->name }}">{{ $game->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="post_desc">
                            <textarea name="content" class="inputs-create post-content" placeholder="Description"></textarea>
                        </div>

                        <div class="post-bottom">
                            <button type="submit" class="btn btn-danger">Save</button>
                            <select name="platform" class="inputs-create post-platform">
                                <option value="" selected disabled>Choose platform</option>
                                <option value="steam">Steam</option>
                                <option value="PSN">PSN</option>
                                <option value="xbox">Xbox</option>
                                <option value="epic">Epic Games</option>
                                <option value="riot">Riot Games</option>
                            </select>
                            <input name="number_of_players" type="number" id="number_of_players" class="inputs-create numbers" placeholder="NOB"
                                min="1" max="5">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('gameSelect').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var imageUrl = selectedOption.getAttribute('data-img');
            document.querySelector('.post-img img').src = imageUrl;
        });
    </script>
@endsection
