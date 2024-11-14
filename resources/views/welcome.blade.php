<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>RUDRA GRAPHICS</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta
        content="At Rudra Graphics, we are passionate creators, dedicated to transforming your visions into captivating realities. Established in 2017, we have emerged as a premier destination for comprehensive graphic design and printing solutions."
        name="description">

    <!-- Favicon -->
    <link href="{{ asset('favicon2.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="{{ asset('https://fonts.googleapis.com') }}">
    <link rel="preconnect" href="{{ asset('https://fonts.gstatic.com" crossorigin') }}">
    <link
        href="{{ asset('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet') }}">
    <link rel="stylesheet"
        href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css') }}">

    <!-- Icon Font Stylesheet -->
    <link href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css') }}"
        rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body style="width: 100%;">
    <div class="container-fluid position-relative d-flex p-0 mb-3">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border" style="width: 3rem; height: 3rem;color:#f9603f" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Content Start -->
        <div class="col-12">
            <div class="container-fluid pt-4">
                <div class="row g-4">
                    <h2 style="text-align: center;">{{ $product->name }}</h2>
                    @foreach ($productMedia as $index => $media)
                        <div class="col-12">
                            <div class="bg-secondary rounded h-100 p-2">
                                <div class="mb-4">
                                    <h2 style="text-align: center;">{{ $setting->sample . ' ' . $index }}</h2>
                                </div>
                                <div class="table-responsive">
                                    <div class="product-container">
                                        <div class="product">
                                            <!-- Display Videos -->
                                            @if (!empty($media['video']))
                                                @php
                                                    $extension = pathinfo($media['video'], PATHINFO_EXTENSION);
                                                @endphp

                                                @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                                    <img src="{{ asset($media['video']) }}" alt="Image"
                                                        style="width: 100%; height: auto;">
                                                @elseif ($extension === 'mp4')
                                                    <video controls autoplay loop muted controlslist="nodownload"
                                                        style="width: 100%; height: auto;">
                                                        <source src="{{ asset($media['video']) }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                @endif
                                            @endif


                                            <!-- Display Images -->
                                            @if (!empty($media['images']))
                                                @foreach ($media['images'] as $mediaPath)
                                                    @php
                                                        $extension = pathinfo($mediaPath, PATHINFO_EXTENSION);
                                                    @endphp

                                                    @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                                        <img src="{{ asset('public/' . $mediaPath) }}"
                                                            alt="Product Image" style="width: 100%; height: auto;">
                                                    @elseif (in_array($extension, ['mp4', 'webm', 'ogg']))
                                                        <video controls autoplay loop muted controlslist="nodownload"
                                                            style="width: 100%; height: auto;">
                                                            <source src="{{ asset('public/' . $mediaPath) }}"
                                                                type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Content End -->

    <!-- JavaScript Libraries -->
    <script src="{{ asset('https://code.jquery.com/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('lib/chart/chart.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>

    <!-- Styles for Video and Image -->
    <style>
        body,
        html {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-family: Arial, sans-serif;
        }

        .product-container {
            text-align: center;
        }

        video {
            width: 100%;
            /* Full width */
            height: auto;
            /* Maintain aspect ratio */
        }

        img {
            width: 100%;
            /* Full width */
            height: auto;
            /* Maintain aspect ratio */
            object-fit: cover;
            margin-bottom: 2%;
        }

        body {
            -webkit-user-select: none;
            /* Safari */
            -moz-user-select: none;
            /* Firefox */
            -ms-user-select: none;
            /* Internet Explorer/Edge */
            user-select: none;
            /* Standard syntax */
        }
    </style>
    <script>
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        document.addEventListener("keydown", function(e) {
            if (e.key === "F12" || (e.ctrlKey && e.shiftKey && e.key === "I") || (e.ctrlKey && e.shiftKey && e
                    .key === "J") || (e.ctrlKey && e.key === "U")) {
                e.preventDefault();
            }
        });


        setInterval(function() {
            if (window.outerWidth - window.innerWidth > 100 || window.outerHeight - window.innerHeight > 100) {
                alert("Please close Developer Tools!");
                window.close();
            }
        }, 1000);
    </script>
</body>

</html>
