@extends('layout.layout')
@section('content')
    <div class="container pt-4 px-4">
        <div class="row g-4" style="justify-content: center">
            <div class="col-sm-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Edit Product</h6>
                    </div>
                    {{-- Form to update the product --}}
                    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Name Field --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Name<span style="color: #ff0000;">*</span></label>
                            <input name="name" id="name" type="text" class="form-control"
                                value="{{ $product->name }}" required>
                        </div>

                        {{-- Mobile Field --}}
                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile (Optional)</label>
                            <input name="mobile" id="mobile" type="number" class="form-control"
                                value="{{ old('mobile', $product->mobile) }}" maxlength="10"
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



                        {{-- Loop for videos and images --}}
                        @foreach (range(0, 5) as $i)
                            <div class="mb-3" style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                                <div class="mb-3">
                                    <h6>{{ $setting->sample . ' ' . ($i + 1) }}</h6>

                                    {{-- Media Select --}}
                                    <label for="media-select-{{ $i }}" class="form-label">Select Media
                                        (Optional)
                                    </label>
                                    <select name="video[{{ $i }}]" id="media-select-{{ $i }}"
                                        class="form-select media-select"
                                        data-preview-target="media-preview-{{ $i }}">
                                        <option value="" disabled selected>Select a media file (Optional)</option>
                                        @php
                                            $videos = json_decode($setting->videos, true); // Decode JSON string to array
                                            $selectedVideo = isset($product->{'video_path' . ($i + 1)})
                                                ? asset($product->{'video_path' . ($i + 1)})
                                                : null;
                                        @endphp
                                        @if (is_array($videos) && count($videos) > 0)
                                            @foreach ($videos as $video)
                                                <option value="{{ asset('public/video/' . $video) }}"
                                                    {{ $selectedVideo && asset('public/video/' . $video) == $selectedVideo ? 'selected' : '' }}>
                                                    {{ $video }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option value="" disabled>No media available</option>
                                        @endif
                                    </select>

                                </div>

                                {{-- Media Preview --}}
                                <div id="media-preview-{{ $i }}" class="media-preview"
                                    style="{{ isset($product->{'video_path' . ($i + 1)}) ? 'display:block' : 'display:none' }}">
                                    @if (isset($product->{'video_path' . ($i + 1)}))
                                        @php
                                            $mediaPath = $product->{'video_path' . ($i + 1)};
                                            $mediaExtension = pathinfo($mediaPath, PATHINFO_EXTENSION);
                                        @endphp
                                        @if (in_array(strtolower($mediaExtension), ['mp4', 'avi', 'mov']))
                                            <video src="{{ asset($mediaPath) }}" controls
                                                style="width:100%;max-width:300px;border-radius:8px;"></video>
                                        @else
                                            <img src="{{ asset($mediaPath) }}" alt="Media Preview"
                                                style="width:100%;max-width:300px;border-radius:8px;">
                                        @endif
                                        <button type="button" class="remove-media"
                                            data-index="{{ $i }}">X</button>
                                    @endif
                                </div>
                                <hr>
                            </div>


                            {{-- Image Upload --}}
                            <div class="mb-3">
                                <label for="image-upload-{{ $i }}" class="form-label">Upload Media</label>
                                <div style="display: flex; flex-wrap: wrap;">
                                    <div id="image-list-{{ $i }}" class="image-list">
                                        {{-- Display existing images if available --}}
                                        @if (isset($product->{'image_path' . ($i + 1)}))
                                            @foreach (json_decode($product->{'image_path' . ($i + 1)}) as $mediaPath)
                                                <div style="position: relative; margin-right: 10px;">
                                                    @php
                                                        $extension = pathinfo($mediaPath, PATHINFO_EXTENSION); // Get the file extension
                                                    @endphp

                                                    @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                                        <!-- Image file check -->
                                                        <img src="{{ asset('public/' . $mediaPath) }}"
                                                            alt="Image {{ $i + 1 }}"
                                                            style="width:100px;height:100px;object-fit:cover;border-radius:8px;margin-top:-10px;">
                                                    @elseif (in_array(strtolower($extension), ['mp4', 'avi', 'mov']))
                                                        <!-- Video file check -->
                                                        <video src="{{ asset('public/' . $mediaPath) }}" controls
                                                            style="height:100px;object-fit:cover;border-radius:8px;">
                                                        </video>
                                                    @endif

                                                    <button type="button" class="remove-image"
                                                        data-index="{{ $i }}"
                                                        data-path="{{ $mediaPath }}">X</button>
                                                </div>
                                            @endforeach
                                        @endif

                                    </div>
                                    <div class="drag-and-drop-area" id="drag-area-{{ $i }}">
                                        <img src="../upload.png" alt="" style="height: 40%;">
                                        <p style="font-size: 10px;">Drag & drop your images or videos here or click to
                                            upload</p>
                                        <input type="file" name="images[{{ $i }}][]"
                                            id="image-upload-{{ $i }}" class="form-control-file"
                                            accept="image/*,,video/*" multiple hidden>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        @endforeach


                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        const mediaSelectElements = document.querySelectorAll('.media-select');

        mediaSelectElements.forEach(select => {
            select.addEventListener('change', function() {
                const selectedMedia = this.value;
                const previewTargetId = this.dataset.previewTarget;
                const previewContainer = document.getElementById(previewTargetId);

                if (selectedMedia) {
                    previewContainer.innerHTML = '';
                    previewContainer.style.display = 'block';

                    const mediaExtension = selectedMedia.split('.').pop().toLowerCase();

                    if (['mp4', 'avi', 'mov'].includes(mediaExtension)) {
                        // It's a video
                        const videoElement = document.createElement('video');
                        videoElement.src = selectedMedia;
                        videoElement.controls = true;
                        videoElement.style.width = '100%';
                        videoElement.style.maxWidth = '300px';
                        videoElement.style.borderRadius = '8px';

                        const removeBtn = document.createElement('button');
                        removeBtn.textContent = 'X';
                        removeBtn.className = 'remove-media';
                        removeBtn.dataset.index = previewTargetId.split('-')[2];
                        removeBtn.onclick = () => {
                            previewContainer.style.display = 'none';
                            previewContainer.innerHTML = '';
                            select.value = '';
                        };

                        previewContainer.appendChild(videoElement);
                        previewContainer.appendChild(removeBtn);
                    } else if (['jpg', 'jpeg', 'png', 'gif'].includes(mediaExtension)) {
                        // It's an image
                        const imgElement = document.createElement('img');
                        imgElement.src = selectedMedia;
                        imgElement.alt = 'Image Preview';
                        imgElement.style.width = '100%';
                        imgElement.style.maxWidth = '300px';
                        imgElement.style.borderRadius = '8px';

                        const removeBtn = document.createElement('button');
                        removeBtn.textContent = 'X';
                        removeBtn.className = 'remove-media';
                        removeBtn.dataset.index = previewTargetId.split('-')[2];
                        removeBtn.onclick = () => {
                            previewContainer.style.display = 'none';
                            previewContainer.innerHTML = '';
                            select.value = '';
                        };

                        previewContainer.appendChild(imgElement);
                        previewContainer.appendChild(removeBtn);
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const videoSelectElements = document.querySelectorAll('.video-select');

            // videoSelectElements.forEach(select => {
            //     select.addEventListener('change', function() {
            //         const selectedVideo = this.value;
            //         const previewTargetId = this.dataset.previewTarget;
            //         const previewContainer = document.getElementById(previewTargetId);

            //         if (selectedVideo) {
            //             previewContainer.innerHTML = '';
            //             previewContainer.style.display = 'block';

            //             const videoElement = document.createElement('video');
            //             videoElement.src = selectedVideo;
            //             videoElement.controls = true;
            //             // videoElement.style.width = '100%';
            //             videoElement.style.maxWidth = '300px';
            //             videoElement.style.borderRadius = '8px';

            //             const removeBtn = document.createElement('button');
            //             removeBtn.textContent = 'X';
            //             removeBtn.className = 'remove-video';
            //             removeBtn.dataset.index = previewTargetId.split('-')[2];
            //             removeBtn.onclick = () => {
            //                 previewContainer.style.display = 'none';
            //                 previewContainer.innerHTML = '';
            //                 select.value = '';
            //             };

            //             previewContainer.appendChild(videoElement);
            //             previewContainer.appendChild(removeBtn);
            //         }
            //     });
            // });

            // Remove video on button click
            document.querySelectorAll('.remove-media').forEach(button => {
                button.addEventListener('click', function() {
                    const index = this.dataset.index;
                    const videoPreview = document.getElementById(`media-preview-${index}`);
                    videoPreview.innerHTML = '';
                    videoPreview.style.display = 'none';
                    document.getElementById(`media-select-${index}`).value = '';
                });
            });

            // Drag and drop functionality for images
            document.querySelectorAll('.drag-and-drop-area').forEach((dragArea, index) => {
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
                        const extension = file.name.split('.').pop().toLowerCase();
                        const wrapper = document.createElement('div');
                        wrapper.style.position = 'relative';
                        wrapper.style.display = 'inline-block';
                        wrapper.style.marginRight = '10px';

                        // Check if it's a video or image
                        if (['mp4', 'avi', 'mov'].includes(extension)) {
                            const video = document.createElement('video');
                            video.src = e.target.result;
                            video.controls = true;
                            // video.style.width = '100px';
                            video.style.height = '100px';
                            video.style.objectFit = 'cover';
                            video.style.borderRadius = '8px';

                            wrapper.appendChild(video);
                        } else if (['jpg', 'jpeg', 'png', 'gif'].includes(extension)) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.style.width = '100px';
                            img.style.height = '100px';
                            img.style.objectFit = 'cover';
                            img.style.borderRadius = '8px';

                            wrapper.appendChild(img);
                        }

                        // Create and append remove button
                        const removeBtn = document.createElement('button');
                        removeBtn.textContent = 'X';
                        removeBtn.className = 'remove-image';
                        removeBtn.onclick = () => {
                            wrapper.remove();
                        };
                        wrapper.appendChild(removeBtn);

                        imageList.appendChild(wrapper);
                    };
                    reader.readAsDataURL(file);
                });
            }
        });


        document.querySelectorAll('.remove-image').forEach(button => {
            button.addEventListener('click', function() {
                const index = this.getAttribute('data-index');
                const imagePath = this.getAttribute('data-path');

                // Remove image from the UI
                this.parentElement.remove();

                // Add the image path to a hidden input for removal
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `remove_images[${index}][]`;
                input.value = imagePath;
                document.getElementById(`image-list-${index}`).appendChild(input);
            });
        });

        document.querySelectorAll('.remove-media').forEach(button => {
            button.addEventListener('click', function() {
                const index = this.getAttribute('data-index');

                // Hide the video preview and clear contents
                const videoPreview = document.getElementById(`media-preview-${index}`);
                videoPreview.style.display = 'none';
                videoPreview.innerHTML = '';

                // Set an empty value in a hidden input to signal removal
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `video[${index}]`;
                input.value = ''; // Empty string to indicate removal
                document.getElementById(`media-select-${index}`).appendChild(input);
            });
        });

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

    <style>
        .media-preview,
        .image-list div {
            position: relative;
            display: inline-block;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .remove-media,
        .remove-image {
            position: absolute;
            top: -5px;
            right: -5px;
            border-radius: 50%;
            background: #bb2d3b;
            color: #fff;
            width: 25px;
            height: 25px;
            padding: 0px;
            border: none;
        }

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

        .image-list {
            display: flex;
            flex-wrap: wrap;
            /* margin-top: 10px; */
            align-items: center;
        }
    </style>
@endsection
