@extends('layouts.backend.app')


@section('site-title', 'Show Post')


@push('css')

@endpush

@section('main-content')
    <div class="container-fluid">
        <!-- Vertical Layout | With Floating Label -->
        <a class="btn btn-danger waves-effect" href="{{ route('admin.post.index') }}">Back</a>

        @if($post->is_approved == false)
            <button type="button" class="btn btn-success pull-right waves-effect" onclick="approvePost({{ $post->id }})">
                <i class="material-icons">done</i>
                <span>Pending</span>
            </button>
            <form action="{{ route('admin.post.approved', $post->id) }}" id="approval-form" style="display: none;" method="POST">
                @csrf
                @method('PUT')
            </form>
        @else
            <button type="button" class="btn btn-success pull-right waves-effect" disabled>
                <i class="material-icons">done</i>
                <span>Approved</span>
            </button>
        @endif

        <br>
        <br>
            <div class="row clearfix">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">

                <div class="card">
                    <div class="header">
                        <h2>
                           {{ $post->title }}
                            <small>Posted By <strong><a href="">{{ $post->user->name }}</a></strong> on
                                {{ $post->updated_at->toFormattedDateString() }}</small>
                        </h2>
                    </div>
                    <div class="body">
                            {!! $post->body !!}
                </div>
            </div>

                </div>


                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan">
                            <h2>
                                Categories
                            </h2>
                        </div>
                        <div class="body">
                            @foreach($post->categories as $category)
                                <span class="label bg-cyan">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>


                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-green">
                            <h2>
                                Tags
                            </h2>
                        </div>
                        <div class="body">
                            @foreach($post->tags as $tag)
                                <span class="label bg-green">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-right">
                    <div class="card">
                        <div class="header bg-amber">
                            <h2>
                                Featured Image
                            </h2>
                        </div>
                        <div class="body">
                            <img class="img-responsive thumbnail" src="{{ asset('storage/post/'.$post->image)  }}" alt="{{ $post->title }}">
                        </div>
                    </div>
                </div>


            </div>
    </div>
        <!-- Vertical Layout | With Floating Label -->
@endsection


@push('js')
    <!-- Sweet Alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.3.0/dist/sweetalert2.all.min.js"></script>
    <!-- Sweet Alert 2 End -->


    <script type="text/javascript">
        function approvePost(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false,
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You wanted to appove this post!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, approve it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('approval-form').submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'The post remain pending :)',
                        'info'
                    )
                }
            })
        }
    </script>

@endpush
