<footer>

    <div class="container">
        <div class="row">

            <div class="col-lg-4 col-md-6">
                <div class="footer-section">

                    <a class="logo" href="#"><img class="img-responsive" height="40" width="40" src="{{ asset('assets/backend/images/Favicon.png') }}" alt="Logo Image"></a>
                    <p class="copyright">{{ config('app.name') }} @ {{ now()->year }}. All rights reserved.</p>
                    <p class="copyright">Designed by <a href="https://colorlib.com" target="_blank">Colorlib</a> and Developed by
                        <a target="_blank" href="https://www.mi-shajib.com">MI SHAJIB</a></p>
                    <ul class="icons">
                        <li><a href="#"><i class="ion-social-facebook-outline"></i></a></li>
                        <li><a href="#"><i class="ion-social-twitter-outline"></i></a></li>
                        <li><a href="#"><i class="ion-social-instagram-outline"></i></a></li>
                        <li><a href="#"><i class="ion-social-vimeo-outline"></i></a></li>
                        <li><a href="#"><i class="ion-social-pinterest-outline"></i></a></li>
                    </ul>

                </div><!-- footer-section -->
            </div><!-- col-lg-4 col-md-6 -->

            <div class="col-lg-4 col-md-6">
                <div class="footer-section">
                    <h4 class="title"><b>CATAGORIES</b></h4>
                    <ul>
                        @foreach($categories as $category)
                            <li><a href="{{ route('category.posts', $category->slug) }}">{{ $category->name }}</a></li>
                        @endforeach

                    </ul>
                </div><!-- footer-section -->
            </div><!-- col-lg-4 col-md-6 -->

            <div class="col-lg-4 col-md-6">
                <div class="footer-section">

                    <h4 class="title"><b>SUBSCRIBE</b></h4>
                    <div class="input-area">
                        <form action="{{ route('subscriber.store') }}" method="POST">
                            @csrf
                            <input class="email-input" type="email" name="email" placeholder="Enter your email">
                            <button class="submit-btn" type="submit"><i class="icon ion-ios-email-outline"></i></button>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</footer>
