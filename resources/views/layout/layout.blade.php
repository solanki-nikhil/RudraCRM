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

<body>
    <div class="container-fluid position-relative d-flex p-0 mb-4">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border" style="width: 3rem; height: 3rem;color:#f9603f" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        {{-- <div id="progress-container" style="display:none;">
            <div id="progress-bar" style="width: 0%; background-color: #4caf50; height: 5px;"></div>
            <div id="progress-text" style="text-align: center; font-weight: bold;">0%</div>
        </div> --}}
        <!-- Content Start -->
        <div class="col-12">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">

                <div id="progress-container" style="display: none;">
                    <div id="progress-bar">
                        <div id="progress-text">0%</div>
                    </div>

                </div>
                <!-- Progress Bar Container -->
                <div id="progress-container"
                    style="display: none; width: 100%; background-color: #ddd; margin-top: 10px;">
                    <div id="progress-bar" style="width: 0%; background-color: #4caf50; height: 5px;"></div>
                    <div id="progress-text"
                        style="text-align: center; font-weight: bold; font-size: 14px; padding: 5px 0;">0%</div>
                </div>
                <a href="dashboard" class="sidebar-toggler flex-shrink-0">
                    <img src="{{ asset('WHITELOGO.PNG-removebg-preview.png') }}" alt="" style="height: 45px">
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="{{ route('dashboard') }}" class="btn btn-info m-2"><i
                                class="fa fa-arrow-left me-2"></i>Back</a>
                    </div>
                </div>


            </nav>

            <!-- Navbar End -->


            <!-- Table Start -->
            @yield('content')
            <!-- Table End -->

        </div>
        <!-- Content End -->

    </div>

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

    <script>
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const progressContainer = document.getElementById('progress-container');
            const progressBar = document.getElementById('progress-bar');
            const progressText = document.getElementById('progress-text');

            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default form submission

                // Show the progress bar container and reset it
                progressContainer.style.display = 'block';
                progressBar.style.width = '0%';
                progressText.innerHTML = '0%';

                // Create FormData object to handle files
                const formData = new FormData(form);

                // Create a new XMLHttpRequest
                const xhr = new XMLHttpRequest();

                // Set up the request
                xhr.open('POST', form.action, true);

                // Monitor the upload progress
                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        const percentComplete = (e.loaded / e.total) * 100;
                        progressBar.style.width = percentComplete + '%';
                        progressText.innerHTML = Math.round(percentComplete) + '%';

                        // Change progress bar color as it progresses
                        if (percentComplete < 33) {
                            progressBar.style.backgroundColor = '#ff6347'; // Tomato color
                        } else if (percentComplete < 66) {
                            progressBar.style.backgroundColor = '#ffa500'; // Orange color
                        } else {
                            progressBar.style.backgroundColor = '#32cd32'; // LimeGreen color
                        }
                    }
                });

                // Handle the response when upload is complete
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        // Set progress to 100% instantly on completion
                        progressBar.style.width = '100%';
                        progressText.innerHTML = '100%';

                        // Redirect after a brief pause to ensure user sees 100%
                        setTimeout(function() {
                            window.location.href = '{{ route('dashboard') }}';
                        }, 200);
                    } else {
                        alert('Error uploading form. Please try again.');
                        progressContainer.style.display = 'none'; // Hide on error
                    }
                };

                // Send the form data
                xhr.send(formData);
            });
        });
    </script>

    <style>
        /* Progress bar container fixed at the top */
        #progress-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background-color: #ddd;
            z-index: 1000;
            display: none;
        }

        /* Progress bar style with smooth transition */
        /* #progress-bar {
            width: 0;
            height: 100%;
            background-color: #4caf50;
            transition: width 0.2s ease;
        } */

        #progress-bar {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #4caf50, #f9603f, #3498db);
            background-size: 200% 200%;
            animation: gradient 3s ease infinite;
            transition: width 0.2s ease;
        }

        /* Gradient animation */
        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Optional: Display percentage text in the center */
        #progress-text {
            position: fixed;
            top: 1%;
            width: 100%;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            color: #fff;
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

</body>

</html>
