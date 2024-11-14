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
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <img src="{{ asset('WHITELOGO.PNG-removebg-preview.png') }}" alt="" style="height:45px">
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown" style="text-align: right;">
                        {{-- <a href="add" id="addButton" class="btn btn-info m-2" onclick="checkSample(event)">
                            <i class="fa fa-plus me-2"></i>Add
                        </a> --}}

                        <a href="add" id="addButton" class="btn btn-info m-2" >
                            <i class="fa fa-plus me-2"></i>Add
                        </a>

                        <a href="settings" class="btn btn-light m-2"><i class="fa fa-cog me-2"></i>Setting</a>
                        <a href="{{ route('signout') }}" class="btn btn-warning m-2"><i class="fa fa-sign-out me-2"
                                aria-hidden="true"></i>Logout</a>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">

                    <div class="col-12">
                        <div class="bg-secondary rounded h-100 p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Home</h6>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Mobile</th>
                                            <th scope="col">Banner/Product</th>
                                            <th scope="col">Views</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($producPortfolio as $index => $portfolio)
                                            <tr>
                                                <th scope="row">{{ $producPortfolio->count() - $index }}</th>
                                                <td>{{ $portfolio->name }}</td>
                                                <td>{{ $portfolio->mobile }}</td>
                                                <td>{{ $portfolio->video_count }} / {{ $portfolio->image_count }}</td>
                                                <td>{{ $portfolio->views }}</td>
                                                <td>{{ $portfolio->created_at ? $portfolio->created_at->format('d-m-Y') : 'N/A' }}
                                                </td>

                                                <td style="display: flex;">
                                                    <div>
                                                        <a href="{{ route('product.edit', $portfolio->id) }}"
                                                            type="button" class="btn btn-sm btn-success mb-1"><i
                                                                class="fa fa-edit me-2"></i>Edit</a>
                                                    </div>
                                                    <div>
                                                        <!-- Delete Button Trigger Modal -->
                                                        <button type="button" class="btn btn-sm btn-primary mb-1"
                                                            style="margin-left:5px;" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal"
                                                            data-form-id="delete-form-{{ $portfolio->id }}">
                                                            <i class="fa fa-trash me-2"></i>Delete
                                                        </button>

                                                        <!-- Hidden Delete Form -->
                                                        <form id="delete-form-{{ $portfolio->id }}"
                                                            action="{{ route('product.destroy', $portfolio->id) }}"
                                                            method="POST" style="display:none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                    <div>
                                                        <form action="{{ route('product.copy', Hashids::encode($portfolio->id)) }}"
                                                              method="POST" style="display:inline;"
                                                              onsubmit="event.preventDefault(); copyLink('{{ Hashids::encode($portfolio->id) }}');">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-info mb-1" style="margin-left:5px;">
                                                                <i class="fa fa-copy me-2"></i>Copy Link
                                                            </button>
                                                        </form>
                                                    </div>
                                                    
                                                </td>

                                                {{-- <td>
                                    <!-- Example action buttons -->
                                    <a href="{{ route('edit', $portfolio->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('delete', $portfolio->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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


    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-secondary">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: #f9603f;"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Copy Confirmation Modal -->
    <div class="modal fade" id="copyModal" tabindex="-1" aria-labelledby="copyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-secondary">
                <div class="modal-header">
                    <h5 class="modal-title" id="copyModalLabel">Link Copied</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: #f9603f;"></button>
                </div>
                <div class="modal-body">
                    The link has been copied to your clipboard.
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div> --}}
            </div>
        </div>
    </div>

    <!-- Limit Reached Alert Modal -->
    {{-- <div class="modal fade" id="limitReachedModal" tabindex="-1" aria-labelledby="limitReachedModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-secondary">
                <div class="modal-header">
                    <h5 class="modal-title" id="limitReachedModalLabel">Limit Reached</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: #f9603f;"></button>
                </div>
                <div class="modal-body">
                    You have reached the maximum limit for adding products. Please delete some entries to add new ones.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Limit Reached Alert Modal -->
    <div class="modal fade" id="limitReachedModal" tabindex="-1" aria-labelledby="limitReachedModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-secondary">
                <div class="modal-header">
                    <h5 class="modal-title" id="limitReachedModalLabel">Limit Reached</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: #f9603f;"></button>
                </div>
                <div class="modal-body">
                    You have reached the maximum limit for adding products. Please delete some entries to add new ones.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Warning Modal HTML -->
    <div class="modal fade" id="sampleModal" tabindex="-1" role="dialog" aria-labelledby="sampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-secondary">
                <div class="modal-header">
                    <h5 class="modal-title" id="sampleModalLabel">Warning</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: #f9603f;"></button>
                </div>
                <div class="modal-body">
                    Please fill in the sample setting before adding a new product.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // DELET MODEL
        // When the modal is about to be shown
        var deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function(event) {
            // Button that triggered the modal
            var button = event.relatedTarget;
            // Extract info from data-form-id attribute
            var formId = button.getAttribute('data-form-id');
            // Find the form element
            var form = document.getElementById(formId);

            // Attach form submission to confirm delete button
            var confirmDeleteButton = document.getElementById('confirmDelete');
            confirmDeleteButton.onclick = function() {
                form.submit(); // Submit the form
            };
        });


        // COPY MODEL
        function copyLink(encodedId) {
    const link = `https://rudragraphics.in/portfolio/${encodedId}`;
    // const link = `localhost:8000/welcome/${encodedId}`;

    navigator.clipboard.writeText(link).then(() => {
        var copyModal = new bootstrap.Modal(document.getElementById('copyModal'));
        copyModal.show();

        setTimeout(() => {
            copyModal.hide();
        }, 1000);
    }).catch(err => {
        console.error('Failed to copy: ', err);
    });
}





        // ADD LIMIT MODEL
        // document.getElementById('addButton').addEventListener('click', function(event) {
        //     // Get current count and settings count from PHP
        //     const currentCount = {{ $currentCount }};
        //     const settingsCount = {{ $settingsCount }};

        //     // Check if limit is reached
        //     if (currentCount >= settingsCount) {
        //         event.preventDefault(); // Prevent navigation

        //         // Show modal alert
        //         var limitReachedModal = new bootstrap.Modal(document.getElementById('limitReachedModal'));
        //         limitReachedModal.show();
        //     }
        // });

        // ADD LIMIT MODEL
        document.getElementById('addButton').addEventListener('click', function(event) {
            // Get current count and settings count from PHP
            const currentCount = {{ $currentCount }};
            const settingsCount = {{ $settingsCount }};

            // Check if limit is reached
            if (currentCount >= settingsCount) {
                event.preventDefault(); // Prevent navigation

                // Show modal alert
                var limitReachedModal = new bootstrap.Modal(document.getElementById('limitReachedModal'));
                limitReachedModal.show();
            }
        });
    </script>

    <script>
        // Warning For Settings
        function checkSample(event) {
            event.preventDefault(); // Prevents the default link behavior

            fetch("{{ route('get.sample.status') }}")
                .then(response => response.json())
                .then(data => {
                    if (data.sampleEmpty) {
                        $('#sampleModal').modal('show'); // Show the modal if sample is empty
                    } else {
                        window.location.href = event.target.href; // Proceed to the link if sample is not empty
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>

    <script>
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });
    </script>

    <style>
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
