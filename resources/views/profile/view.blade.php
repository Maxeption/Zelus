@extends('layouts.master')

@section('title', 'Profile')

@Section('links')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/view.css') }}">
@endsection

@section('content')
    <section id="profile-settings">

        <div class="row cont">
            <div class="sidebar col-2">
                <div class="sidebar-list">
                    <ul>
                        <span class="active">
                            <li class="sidebar-item"><a
                                    href="{{ route('profile.view', ['username' => $user->username]) }}">Profile</a></li>
                        </span>
                        <li class="sidebar-item"><a
                                href="{{ route('profile.Sposts', ['username' => $user->username]) }}">Posts</a></li>
                        <li class="sidebar-item"><a
                                href="{{ route('profile.Sconnections', ['username' => $user->username]) }}">Connections</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="profile-settings col-10">
                <div class="bg-img">
                    <img src="{{ asset('assets/jett-black.png') }}" alt="">
                </div>
                <div class="profile-settings-header">
                    <h1>{{ $user->username }}</h1>
                </div>
                <div class="profile-settings-top">
                    <div class="profile-settings-avatar">
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

                <div class="profile-settings-content">
                    <div class="comments">
                        <h1>Comments</h1>
                        <div id="commentsContainer" class="comments-list">
                            @foreach ($comments as $comment)
                                <div class="comment">
                                    <div class="comment-header">
                                        <div class="comment-user">
                                            <div class="comment-user-image">
                                                <img src="{{ $comment->user->profile_image_url }}" alt="">
                                            </div>
                                            <div class="comment-user-name">
                                                <span>{{ $comment->user->username }}</span>
                                                <span>{{ $comment->user->averageRating }}<i
                                                        class="fa-solid fa-star"></i></span>
                                            </div>
                                        </div>
                                        <div class="comment-date">
                                            <span>{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <div class="comment-content">
                                        <p>{{ $comment->content }}</p>
                                    </div>
                                    @if (Auth::check() && $comment->user_id === Auth::id())
                                        <form action="{{ route('comment.destroy', ['comment' => $comment->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        @if (Auth::check())
                            <div class="comment-form">
                                <form class="commentform" id="commentForm" action="{{ route('comment.store') }}"
                                    method="POST">
                                    <div class="commentform-inputs">
                                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                        <input type="hidden" name="profile_id" value="{{ $user->id }}">
                                        <textarea name="content" class="inputs-create-comment comment-input" id="comment-input" placeholder="Comment"></textarea>
                                        <button type="submit" class="btn btn-primary">Send</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                    <script>
                        document.getElementById('commentForm').addEventListener('submit', function(e) {
                            e.preventDefault();

                            const formData = new FormData(this);

                            fetch('/comment', {
                                    method: 'POST',
                                    body: formData,
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                            'content')
                                    },
                                })
                                .then(response => {
                                    if (response.ok) {
                                        const contentType = response.headers.get("content-type");
                                        if (contentType && contentType.indexOf("application/json") !== -1) {
                                            return response.json();
                                        } else {
                                            throw new Error('Received non-JSON response from server.');
                                        }
                                    } else {
                                        throw new Error('Network response was not ok.');
                                    }
                                })
                                .then(data => {
                                    console.log(data);
                                    const deleteButtonHtml = data.can_delete ?
                                        `
                                                <form action="/comment/${data.comment_id}" method="POST">
                                                    <input type="hidden" name="_token" value="${data.csrf_token}">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            ` :
                                        '';
                                    const newCommentHtml = `
                                        <div class="comment">
                                            <div class="comment-header">
                                                <div class="comment-user">
                                                    <div class="comment-user-image">
                                                        <img src="${data.profile_image_url}" alt="">
                                                    </div>
                                                    <div class="comment-user-name">
                                                        <span>${data.username}</span>
                                                        <span>${data.averageRating}<i class="fa-solid fa-star"></i></span>
                                                    </div>
                                                </div>
                                                <div class="comment-date">
                                                    <span>${data.created_at}</span>
                                                </div>
                                            </div>
                                            <div class="comment-content">
                                                <p>${data.content}</p>
                                            </div>
                                            ${deleteButtonHtml}
                                        </div>
                                    `;
                                    // Append the new comment to the comments container
                                    const commentsContainer = document.getElementById('commentsContainer');
                                    if (commentsContainer) {
                                        commentsContainer.insertAdjacentHTML('beforeend', newCommentHtml);
                                    } else {
                                        console.error('Comments container not found');
                                    }
                                    // Optionally, clear the textarea after submitting
                                    document.querySelector('textarea[name="content"]').value = '';
                                })
                                .catch(error => {
                                    console.error('There has been a problem with your fetch operation:', error);
                                });
                        });
                    </script>
                </div>
            </div>
    </section>
@endsection
