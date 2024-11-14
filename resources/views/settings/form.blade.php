@extends('layout.layout')
@section('content')
    <div class="container pt-4 px-4">
        <div class="row g-4" style="justify-content: center">
            <div class="col-sm-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Setting</h6>
                    </div>

                    {{-- Success message --}}
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('settings.storeOrUpdate') }}" method="POST" enctype="multipart/form-data"
                        id="settings-form">
                        @csrf

                        {{-- Sample input --}}
                        <div class="mb-3">
                            <label for="sample" class="form-label">Sample<span style="color: #ff0000;">*</span></label>
                            <input type="text" name="sample" id="sample" class="form-control"
                                value="{{ old('sample', $setting->sample ?? '') }}" required>
                        </div>

                        {{-- Count input --}}
                        <div class="mb-3">
                            <label for="count" class="form-label">Count<span style="color: #ff0000;">*</span></label>
                            <input type="number" name="count" id="count" class="form-control"
                                value="{{ old('count', $setting->count ?? '') }}" required>
                        </div>

                        {{-- Drag-and-drop video input --}}
                        <div class="mb-3">
                            <label for="video-upload" class="form-label">Upload Videos</label>
                            <div style="display: flex;flex-wrap:wrap;">
                                <div id="video-preview" class="video-preview"
                                    style="display: flex; flex-wrap: wrap; gap: 10px;align-items: center;"></div>
                                <div id="drop-zone" class="drop-zone">
                                    <img src="upload.png" alt="" style="width: 40%;" />
                                    <p style="font-size: 10px;">Drag & drop your images or videos here or click to upload
                                    </p>
                                    <input type="file" name="videos[]" style="display: none;" id="video-upload"
                                        class="form-control-file" multiple>
                                </div>
                            </div>
                        </div>

                        {{-- Display existing videos with remove button --}}
                        @if (isset($setting->videos) && is_array(json_decode($setting->videos)))
                            <h6 class="mb-3">Existing Videos</h6>
                            <div id="existing-videos-list" style="display: flex; flex-wrap: wrap; gap: 10px;"
                                class="video-list">
                                @foreach (json_decode($setting->videos) as $video)
                                    <div class="video-item" draggable="true" style="position: relative;">


                                        @if (Str::endsWith($video, ['.mp4', '.mpeg', '.mov']))
                                            <video src="{{ asset('public/video/' . $video) }}" width="195"
                                                controls></video>
                                        @else
                                            <img src="{{ asset('public/video/' . $video) }}" width="195" height="108"
                                                alt="Media">
                                        @endif

                                        <button type="button" class="btn  btn-sm remove-existing-video"
                                            style="position: absolute; top: -5px; right: -5px;border-radius: 50%;background: #bb2d3b;color:#fff;width:25px; height:25px;padding:0px;"
                                            {{-- style=" position: absolute;top: 0;right: 0;background: #ff0000; color: #fff; border: none; border-radius: 50%; cursor: pointer;  padding: 5px 8px 5px 8px; font-size: 14px;" --}} data-video="{{ $video }}">X</button>
                                        <input type="hidden" name="existing_videos[]" value="{{ $video }}">
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary mt-1">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .drop-zone {
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
            margin-top: 10px;
            transition: all 0.3s ease;
            padding: 10px;
            cursor: pointer;
        }

        .drop-zone.dragover {
            border-color: #333;
            background-color: #f0f0f0;
        }

        .video-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .video-item {
            position: relative;
        }
    </style>

    <script>
        // Drag and drop logic
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('video-upload');
        const videoPreview = document.getElementById('video-preview');
        const existingVideosList = document.getElementById('existing-videos-list');

        // Clicking on drop zone opens file input
        dropZone.addEventListener('click', () => fileInput.click());

        // Drag and Drop functionality
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('dragover');
        });

        dropZone.addEventListener('dragleave', (e) => {
            dropZone.classList.remove('dragover');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('dragover');
            const files = e.dataTransfer.files;
            handleFileSelect(files);
        });

        fileInput.addEventListener('change', (e) => {
            const files = e.target.files;
            handleFileSelect(files);
        });

        // Handle file selection and display video previews
        function handleFileSelect(files) {
            Array.from(files).forEach(file => {
                const videoElement = createVideoElement(file);
                videoPreview.appendChild(videoElement);
            });
        }

        // Create a video preview element with a remove button
        function createVideoElement(file) {
            const fileURL = URL.createObjectURL(file);

            // Create video wrapper
            const wrapper = document.createElement('div');
            wrapper.style.position = 'relative';
            wrapper.style.width = '200px';
            wrapper.style.marginRight = '10px';
            wrapper.style.height = 'auto';

            let video;

            // Check if file is a video or an image
            if (file.type.startsWith('video/')) {
                // Create video element
                video = document.createElement('video');
                video.controls = true;
                video.width = 200;
                video.src = fileURL;
            } else if (file.type.startsWith('image/')) {
                // Create image element
                video = document.createElement('img');
                video.width = 200;
                video.src = fileURL;
                video.style.objectFit = 'cover';
                video.style.height = '100px'; // Set consistent height for both image and video previews
            }

            // Create remove button
            // Create remove button
            const removeBtn = document.createElement('button');
            removeBtn.textContent = 'X';
            removeBtn.classList.add('btn', 'btn-danger', 'btn-sm');
            removeBtn.style.position = 'absolute';
            removeBtn.style.top = '-5px';
            removeBtn.style.right = '-5px';
            removeBtn.style.background = '#bb2d3b';
            removeBtn.style.color = '#fff'; // Optional: make the text white
            removeBtn.style.width = '25px';
            removeBtn.style.height = '25px';
            removeBtn.style.borderRadius = '50%';
            removeBtn.style.display = 'flex';
            removeBtn.style.alignItems = 'center';
            removeBtn.style.justifyContent = 'center';
            removeBtn.style.padding = '0';
            removeBtn.style.border = 'none';
            removeBtn.onclick = () => wrapper.remove(); // Remove video preview on click


            // Append video and button to wrapper
            wrapper.appendChild(video);
            wrapper.appendChild(removeBtn);

            return wrapper;
        }

        // Remove existing video from the list
        document.querySelectorAll('.remove-existing-video').forEach(button => {
            button.addEventListener('click', function() {
                const videoItem = this.closest('.video-item');
                videoItem.remove(); // Remove from DOM

                // Optionally, you could add an AJAX request here to delete the video from the server if needed.
            });
        });

        // Enable drag and drop for existing video items
        let draggedItem = null;

        existingVideosList.addEventListener('dragstart', (e) => {
            draggedItem = e.target;
            e.dataTransfer.effectAllowed = 'move';
        });

        existingVideosList.addEventListener('dragover', (e) => {
            e.preventDefault(); // Prevent default to allow drop
            e.dataTransfer.dropEffect = 'move';
        });

        existingVideosList.addEventListener('drop', (e) => {
            e.preventDefault();
            if (draggedItem) {
                const allItems = [...existingVideosList.querySelectorAll('.video-item')];
                const target = e.target.closest('.video-item');

                if (target && target !== draggedItem) {
                    const draggedIndex = allItems.indexOf(draggedItem);
                    const targetIndex = allItems.indexOf(target);

                    if (draggedIndex < targetIndex) {
                        existingVideosList.insertBefore(draggedItem, target.nextSibling);
                    } else {
                        existingVideosList.insertBefore(draggedItem, target);
                    }
                }
            }
        });

        document.getElementById('settings-form').onsubmit = function(event) {
            const sampleInput = document.getElementById('sample');
            const countInput = document.getElementById('count');
            let focusSet = false;

            if (!sampleInput.value.trim()) {
                sampleInput.focus();
                focusSet = true;
            } else if (!countInput.value.trim() && !focusSet) {
                countInput.focus();
                focusSet = true;
            }

            if (focusSet) {
                event.preventDefault(); // Prevent form submission
                // alert("Please fill out all required fields.");
            }
        };
    </script>

@endsection
