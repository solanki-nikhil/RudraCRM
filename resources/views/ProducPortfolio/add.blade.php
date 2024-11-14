@extends('layout.layout')
@section('content')
    <div class="container pt-4 px-4">
        <div class="row g-4" style="justify-content: center">
            <div class="col-sm-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Add Product</h6>
                    </div>
                    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name<span style="color: #ff0000;">*</span></label>
                            <input name="name" id="name" type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile (Optional)</label>
                            <input name="mobile" id="mobile" type="number" class="form-control" maxlength="10"
                                oninput="limitInputLength(this)">
                            <small id="mobile-error" class="text-danger" style="display: none;">Mobile number must be
                                exactly 10 digits.</small>
                        </div>



                        <script>
                            function limitInputLength(input) {
                                const mobileError = document.getElementById('mobile-error');

                                // Check if the input length is less than 10 digits
                                // if (input.value.length < 10) {
                                //     mobileError.style.display = 'block'; // Show error message if less than 10 digits
                                // } else {
                                //     mobileError.style.display = 'none'; // Hide error message if 10 digits
                                // }

                                // Limit the input to 10 digits
                                if (input.value.length > 10) {
                                    input.value = input.value.slice(0, 10);
                                }
                            }
                        </script>




                        @foreach (range(0, 5) as $i)
                            <div class="mb-3" style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                                <div class="mb-3">
                                    <h6>{{ $setting->sample . ' ' . ($i + 1) }}</h6>
                                    <div class="mb-3">
                                        <label for="media-select-{{ $i }}" class="form-label">Select Media
                                            (Optional)
                                        </label>
                                        <select name="video[]" id="media-select-{{ $i }}"
                                            class="form-select media-select"
                                            data-preview-target="media-preview-{{ $i }}">
                                            <option value="" selected>Select a media (Optional)</option>

                                            <!-- Loop through videos -->
                                            @if (isset($setting->videos) && is_array(json_decode($setting->videos)))
                                                @foreach (json_decode($setting->videos) as $video)
                                                    <option value="{{ asset('public/video/' . $video) }}">
                                                        {{ $video }}</option>
                                                @endforeach
                                            @endif

                                            <!-- Loop through images -->
                                            @if (isset($setting->images) && is_array(json_decode($setting->images)))
                                                @foreach (json_decode($setting->images) as $image)
                                                    <option value="{{ asset('public/image/' . $image) }}">
                                                        {{ $image }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div id="media-preview-{{ $i }}" class="media-preview"
                                    style="display: none; position: relative;"></div>
                                <hr>
                            </div>

                            {{-- <hr> --}}

                            <div class="mb-3">
                                <label for="media-upload-{{ $i }}" class="form-label">Upload Media</label>
                                <!-- Drag and drop area -->
                                <div style="display: flex; flex-wrap: wrap;">
                                    <div id="media-list-{{ $i }}" class="media-list"></div>
                                    <div class="drag-and-drop-area" id="drag-area-{{ $i }}">
                                        <img src="upload.png" alt="" style="height: 40%;">
                                        <p style="font-size: 10px;">Drag & drop your images or videos here or click to
                                            upload</p>
                                        <input type="file" name="images[{{ $i }}][]"
                                            id="media-upload-{{ $i }}" class="form-control-file" multiple hidden
                                            accept="image/*,video/*">
                                    </div>
                                </div>
                            </div>

                            <hr>
                        @endforeach

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mediaSelectElements = document.querySelectorAll('.media-select');

            mediaSelectElements.forEach(select => {
                select.addEventListener('change', function() {
                    const selectedMedia = this.value;
                    const previewTargetId = this.dataset.previewTarget;
                    const previewContainer = document.getElementById(previewTargetId);

                    if (selectedMedia) {
                        previewContainer.innerHTML = '';
                        previewContainer.style.display = 'block';

                        // Extract file extension to determine media type (image or video)
                        const fileExtension = selectedMedia.split('.').pop().toLowerCase();

                        // Check for image types
                        if (['jpeg', 'jpg', 'png', 'gif'].includes(fileExtension)) {
                            const imgElement = document.createElement('img');
                            imgElement.src = selectedMedia;
                            imgElement.style.width = '100%';
                            imgElement.style.maxWidth = '300px';
                            imgElement.style.borderRadius = '8px';
                            previewContainer.appendChild(imgElement);
                        }
                        // Check for video types
                        else if (['mp4', 'avi', 'mov', 'mkv'].includes(fileExtension)) {
                            const videoElement = document.createElement('video');
                            videoElement.src = selectedMedia;
                            videoElement.controls = true;
                            videoElement.style.width = '100%';
                            videoElement.style.maxWidth = '300px';
                            videoElement.style.borderRadius = '8px';
                            previewContainer.appendChild(videoElement);
                        }

                        // Add a remove button
                        const removeBtn = document.createElement('button');
                        removeBtn.textContent = 'X';
                        removeBtn.style.position = 'absolute';
                        removeBtn.style.top = '-5px';
                        removeBtn.style.right = '-5px';
                        removeBtn.style.width = '25px';
                        removeBtn.style.height = '25px';
                        removeBtn.style.background = '#bb2d3b';
                        removeBtn.style.color = '#fff';
                        removeBtn.style.border = 'none';
                        removeBtn.style.borderRadius = '50%';
                        removeBtn.style.cursor = 'pointer';
                        removeBtn.style.padding = '0px';
                        removeBtn.onclick = () => {
                            previewContainer.style.display = 'none';
                            previewContainer.innerHTML = '';
                            this.value = '';
                        };

                        previewContainer.appendChild(removeBtn);
                    }
                });
            });
        });


        // Drag and drop functionality
        const dragAreas = document.querySelectorAll('.drag-and-drop-area');

        dragAreas.forEach((dragArea, index) => {
            const mediaList = document.getElementById(`media-list-${index}`);

            // Click to trigger file input
            dragArea.addEventListener('click', () => {
                const input = dragArea.querySelector('input[type="file"]');
                input.click();
            });

            // Drag over events
            dragArea.addEventListener('dragover', (event) => {
                event.preventDefault();
                dragArea.classList.add('hover');
            });

            dragArea.addEventListener('dragleave', () => {
                dragArea.classList.remove('hover');
            });

            // Drop event
            dragArea.addEventListener('drop', (event) => {
                event.preventDefault();
                dragArea.classList.remove('hover');
                const files = event.dataTransfer.files;
                handleFiles(files, mediaList);
            });

            // Handle file selection via file input
            const input = dragArea.querySelector('input[type="file"]');
            input.addEventListener('change', (event) => {
                const files = event.target.files;
                handleFiles(files, mediaList);
            });
        });

        // Function to handle files (images and videos)
        function handleFiles(files, mediaList) {
            [...files].forEach(file => {
                const reader = new FileReader();

                reader.onload = (e) => {
                    const fileUrl = e.target.result;
                    const fileWrapper = document.createElement('div');
                    fileWrapper.style.position = 'relative';
                    fileWrapper.style.display = 'inline-block';
                    fileWrapper.style.marginRight = '10px';

                    if (file.type.startsWith('image/')) {
                        // Handle image files
                        const img = document.createElement('img');
                        img.src = fileUrl;
                        img.style.width = '100px';
                        img.style.height = '95px';
                        img.style.objectFit = 'cover';
                        img.style.borderRadius = '8px';
                        fileWrapper.appendChild(img);
                    } else if (file.type.startsWith('video/')) {
                        // Handle video files
                        const video = document.createElement('video');
                        video.src = fileUrl;
                        // video.style.width = '100px';
                        video.style.height = '100px';
                        video.style.borderRadius = '8px';
                        video.controls = true; // Add controls for video (play, pause, etc.)
                        fileWrapper.appendChild(video);
                    }

                    // Create remove button
                    const removeBtn = document.createElement('button');
                    removeBtn.textContent = 'X';
                    removeBtn.style.position = 'absolute';
                    removeBtn.style.top = '-5px';
                    removeBtn.style.right = '-5px';
                    removeBtn.style.width = '25px';
                    removeBtn.style.height = '25px';
                    removeBtn.style.background = '#bb2d3b';
                    removeBtn.style.color = '#fff';
                    removeBtn.style.border = 'none';
                    removeBtn.style.borderRadius = '50%';
                    removeBtn.style.cursor = 'pointer';
                    removeBtn.style.padding = '0px';
                    removeBtn.onclick = () => {
                        fileWrapper.remove();
                    };

                    // Append the media item and remove button to the list
                    fileWrapper.appendChild(removeBtn);
                    mediaList.appendChild(fileWrapper);
                };

                reader.readAsDataURL(file); // Read the file as a data URL
            });
        }


        document.addEventListener('DOMContentLoaded', function() {
            // Get the form element
            const form = document.querySelector('form');
            const mobileInput = document.getElementById('mobile');

            // Handle form submission
            form.addEventListener('submit', function(event) {
                // Check if the mobile number is less than 10 digits
                if (mobileInput.value.length < 10 && mobileInput.value !== '') {
                    event.preventDefault(); // Prevent form submission
                    mobileInput.focus(); // Focus the mobile input field
                    mobileInput.select(); // Optionally, select the text in the input
                    // alert('Mobile number must be exactly 10 digits.'); // Show an alert (optional)
                }
            });
        });
    </script>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const videoSelectElements = document.querySelectorAll('.video-select');

            videoSelectElements.forEach(select => {
                select.addEventListener('change', function() {
                    const selectedVideo = this.value;
                    const previewTargetId = this.dataset.previewTarget;
                    const previewContainer = document.getElementById(previewTargetId);

                    if (selectedVideo) {
                        previewContainer.innerHTML = '';
                        previewContainer.style.display = 'block';

                        const videoElement = document.createElement('video');
                        videoElement.src = selectedVideo;
                        videoElement.controls = true;
                        videoElement.style.width = '100%';
                        videoElement.style.maxWidth = '300px';
                        videoElement.style.borderRadius = '8px';

                        const removeBtn = document.createElement('button');
                        removeBtn.textContent = 'X';
                        removeBtn.style.position = 'absolute';
                        removeBtn.style.top = '-5px';
                        removeBtn.style.right = '-5px';
                        removeBtn.style.width = '25px';
                        removeBtn.style.height = '25px';
                        removeBtn.style.background = '#bb2d3b';
                        removeBtn.style.color = '#fff';
                        removeBtn.style.border = 'none';
                        removeBtn.style.borderRadius = '50%';
                        removeBtn.style.cursor = 'pointer';
                        removeBtn.style.padding = '0px';
                        removeBtn.onclick = () => {
                            previewContainer.style.display = 'none';
                            previewContainer.innerHTML = '';
                            this.value = '';
                        };

                        previewContainer.appendChild(videoElement);
                        previewContainer.appendChild(removeBtn);
                    }
                });
            });

            // Drag and drop functionality
            const dragAreas = document.querySelectorAll('.drag-and-drop-area');

            dragAreas.forEach((dragArea, index) => {
                const imageList = document.getElementById(`image-list-${index}`);

                dragArea.addEventListener('click', () => {
                    const input = dragArea.querySelector('input[type="file"]');
                    input.click();
                });

                dragArea.addEventListener('dragover', (event) => {
                    event.preventDefault();
                    dragArea.classList.add('hover');
                });

                dragArea.addEventListener('dragleave', () => {
                    dragArea.classList.remove('hover');
                });

                dragArea.addEventListener('drop', (event) => {
                    event.preventDefault();
                    dragArea.classList.remove('hover');
                    const files = event.dataTransfer.files;
                    handleFiles(files, imageList);
                });

                const input = dragArea.querySelector('input[type="file"]');
                input.addEventListener('change', (event) => {
                    const files = event.target.files;
                    handleFiles(files, imageList);
                });
            });

            function handleFiles(files, imageList) {
                [...files].forEach(file => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.width = '100px';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';
                        img.style.borderRadius = '8px';
                        img.style.position = 'relative';
                        img.style.marginRight = '10px';

                        const removeBtn = document.createElement('button');
                        removeBtn.textContent = 'X';
                        removeBtn.style.position = 'absolute';
                        removeBtn.style.top = '-5px';
                        removeBtn.style.right = '-5px';
                        removeBtn.style.width = '25px';
                        removeBtn.style.height = '25px';
                        removeBtn.style.background = '#bb2d3b';
                        removeBtn.style.color = '#fff';
                        removeBtn.style.border = 'none';
                        removeBtn.style.borderRadius = '50%';
                        removeBtn.style.cursor = 'pointer';
                        removeBtn.style.padding = '0px';
                        removeBtn.onclick = () => {
                            img.remove();
                            removeBtn.remove();
                        };

                        const wrapper = document.createElement('div');
                        wrapper.style.position = 'relative';
                        wrapper.style.display = 'inline-block';
                        wrapper.appendChild(img);
                        wrapper.appendChild(removeBtn);
                        imageList.appendChild(wrapper);
                    };
                    reader.readAsDataURL(file);
                });
            }
        });

       
    </script> --}}

    <style>
        /* .video {
                                        display: flex;
                                        flex-wrap: wrap;
                                        justify-content: space-between;
                                    } */

        /* .video-preview {
                    position: relative;
                    max-width: 300px;
                }

                .video-preview video {
                    width: 100%;
                    border-radius: 8px;
                }

                .video-preview button {
                    position: absolute;
                    top: 0;
                    right: 0;
                    background: #ff0000;
                    color: #fff;
                    border: none;
                    border-radius: 50%;
                    cursor: pointer;
                    padding: 5px;
                } */

        .drag-and-drop-area {
            border: 2px dashed #ccc;
            border-radius: 50%;
            width: 110px;
            height: 110px;
            /* display: flex; */
            color: #aaa;
            align-content: center;
            /* justify-content: center; */
            text-align: center;
            margin-bottom: 10px;
            transition: background 0.3s;
            padding: 10px;
            cursor: pointer;
        }


        .drag-and-drop-area.hover {
            background: #f0f0f0;
        }

        .media-list {
            display: flex;
            flex-wrap: wrap;
            /* margin-top: 10px; */
            align-items: center;
        }

        .media-list div {
            position: relative;
            margin-right: 10px;
            margin-bottom: 10px;
        }
    </style>
@endsection
