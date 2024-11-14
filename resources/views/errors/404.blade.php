<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>RUDRA GRAPHICS</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="At Rudra Graphics, we are passionate creators, dedicated to transforming your visions into captivating realities. Established in 2017, we have emerged as a premier destination for comprehensive graphic design and printing solutions." name="description">

    <!-- Favicon -->
    <link href="{{asset('favicon2.ico')}}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="{{asset('https://fonts.googleapis.com')}}">
    <link rel="preconnect" href="{{asset('https://fonts.gstatic.com" crossorigin')}}">
    <link href="{{asset('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet')}}"> 
    <link rel="stylesheet" href="{{asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css')}}">
    
    <!-- Icon Font Stylesheet -->
    <link href="{{asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css')}}" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css')}}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0 mb-4">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border" style="width: 3rem; height: 3rem;color:#f9603f" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

 <!-- 404 Start -->
 <div class="container-fluid pt-4 px-4">
    <div class="row vh-100 bg-secondary rounded align-items-center justify-content-center mx-0">
        <div class="col-md-6 text-center p-4">
            <i class="bi bi-exclamation-triangle display-1 text-primary"></i>
            <h1 class="display-1 fw-bold">Oops!</h1>
            <h1 class="mb-4">The link you are trying to access has expired.</h1>
            <p class="mb-4">Redirecting you to the homepage...</p>

                <div class="mb-4">
                    <a href="https://rudragraphics.in" class="sidebar-toggler flex-shrink-0">
                        <img src="{{ asset('WHITELOGO.PNG-removebg-preview.png') }}" alt="" style="height:45px">
                    </a>
                </div>
            <a class="btn btn-primary rounded-pill py-3 px-5" href="https://rudragraphics.in">Go Back To Home</a>
        </div>
    </div>
</div>
<!-- 404 End -->
 {{-- <!-- 404 Start -->
 <div class="container-fluid pt-4 px-4">
    <div class="row vh-100 bg-secondary rounded align-items-center justify-content-center mx-0">
        <div class="col-md-6 text-center p-4">
            <i class="bi bi-exclamation-triangle display-1 text-primary"></i>
            <h1 class="display-1 fw-bold">404</h1>
            <h1 class="mb-4">Page Not Found</h1>
            <p class="mb-4">We’re sorry, the page you have looked for does not exist in our website!
                Maybe go to our home page or try to use a search?</p>

                <div class="mb-4">
                    <a href="#" class="sidebar-toggler flex-shrink-0">
                        <img src="{{ asset('WHITELOGO.PNG-removebg-preview.png') }}" alt="" style="height:45px">
                    </a>
                </div>
            <a class="btn btn-primary rounded-pill py-3 px-5" href="https://rudragraphics.in">Go Back To Home</a>
        </div>
    </div>
</div>
<!-- 404 End --> --}}

    </div>

     <!-- JavaScript Libraries -->
     <script src="{{asset('https://code.jquery.com/jquery-3.4.1.min.js')}}"></script>
     <script src="{{asset('https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js')}}"></script>
     <script src="{{asset('lib/chart/chart.min.js')}}"></script>
     <script src="{{asset('lib/easing/easing.min.js')}}"></script>
     <script src="{{asset('lib/waypoints/waypoints.min.js')}}"></script>
     <script src="{{asset('lib/owlcarousel/owl.carousel.min.js')}}"></script>
     <script src="{{asset('lib/tempusdominus/js/moment.min.js')}}"></script>
     <script src="{{asset('lib/tempusdominus/js/moment-timezone.min.js')}}"></script>
     <script src="{{asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js')}}"></script>
 
     <!-- Template Javascript -->
     <script src="{{asset('js/main.js')}}"></script>

     <script>
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });
    </script>
    
</body>

</html>