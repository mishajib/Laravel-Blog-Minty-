@extends('layouts.frontend.app')


@section('site-title')
    {{ $author->name }} Profile
@endsection

@push('css')
    <link href="{{ asset('assets/frontend/profile/styles.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/frontend/profile/responsive.css') }}" rel="stylesheet">

    <style>
        .favourite-post {
            color: blue;
        }

        .slider{
            background-image: url({{ asset('storage/profile/'.$author->image) }});
        }
    </style>

@endpush

@section('main-content')
    <div class="slider display-table center-text">
        <h1 class="title display-table-cell"><b>{{ $author->name }}</b></h1>
    </div><!-- slider -->

    <section class="blog-area section">
        <div class="container">

            <div class="row">

                <div class="col-lg-8 col-md-12">
                    <div class="row">
                        @if($posts->count() > 0)
                            @foreach($posts as $post)
                            <div class="col-lg-6 col-md-4 col-sm-12">
                                <div class="card h-auto">
                                    <div class="single-post post-style-1">

                                        <div class="blog-image"><img src="{{ asset('storage/post/'.$post->image) }}" alt="{{ $post->title }}"></div>

                                        <a class="avatar" href="{{ route('author.profile', $post->user->username) }}"><img src="{{ asset('storage/profile/'.$post->user->image) }}" alt="Profile Image"></a>

                                        <div class="blog-info">

                                            <h4 class="title"><a href="{{ route('post.details', $post->slug) }}"><b>{{ $post->title }}</b></a></h4>

                                            <ul class="post-footer">
                                                <li>
                                                    @guest()
                                                        <a onclick="toastr.info('To add favourite. You need to login first.', 'Info', {
                                                    closeButton: true,
                                                    progressBar: true,
                                                })" href="javascript:void(0);"><i class="ion-heart"></i>{{ $post->favourite_to_users->count() }}</a>
                                                    @else
                                                        <a onclick="document.getElementById('favourite-form-{{ $post->id }}').submit();" href="javascript:void(0);" class="{{ !Auth::user()->favourite_posts->where('pivot.post_id',$post->id)->count() == 0 ? 'favourite-post' : '' }}">
                                                            <i class="ion-heart"></i>{{ $post->favourite_to_users->count() }}
                                                        </a>
                                                        <form id="favourite-form-{{ $post->id }}" action="{{ route('post.favourite',$post->id) }}" method="POST" style="display: none;">
                                                            @csrf

                                                        </form>
                                                    @endguest
                                                </li>
                                                <li><a href="#"><i class="ion-chatbubble"></i>{{ $post->comments->count() }}</a></li>
                                                <li><a href="#"><i class="ion-eye"></i>{{ $post->view_count }}</a></li>
                                            </ul>

                                        </div><!-- blog-info -->
                                    </div><!-- single-post -->
                                </div><!-- card -->
                            </div><!-- col-lg-4 col-md-6 -->
                        @endforeach
                        @else
                            <div class="col-lg-4 col-md-6">
                                <div class="card h-auto">
                                    <div class="single-post post-style-1">
                                        <div class="blog-info">
                                            <h4 class="title">
                                                <strong>Sorry, No post found :(</strong>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div><!-- row -->

                    <a class="load-more-btn" href="{{ route('post.index') }}"><b>LOAD MORE</b></a>

                </div><!-- col-lg-8 col-md-12 -->

                <div class="col-lg-4 col-md-12 ">

                    <div class="single-post info-area ">

                        <div class="about-area">
                            <h4 class="title"><b>ABOUT AUTHOR</b></h4>
                            <p>{{ $author->name }}</p><br>
                            <hr>
                            <p>{{ $author->about }}</p>
                            <br>
                            <hr>
                            <strong>Author Since: {{ Carbon\Carbon::parse($author->created_at)->format('Y-m-d') }}</strong>
                            <br>
                            <strong>Total Posts : {{ $author->posts->count() }}</strong>
                        </div>

                    </div><!-- info-area -->

                </div><!-- col-lg-4 col-md-12 -->

            </div><!-- row -->

        </div><!-- container -->
    </section><!-- section -->
@endsection


@push('js')


@endpush
