@extends('layouts.app')

@section('content')

    <div class="container mx-auto text-center py-0" >
        <!-- Image Display Area -->
        <div id="preview-area" class="relative mx-auto mb-0 aspect-[3/4] w-96 sm:w-[28rem] md:w-[31rem]">
            <!-- Frame Image (on top) -->
            <img src="{{ asset('images/fox-frame.png') }}" alt="Fox Frame"
                 class="w-full h-auto relative z-10 pointer-events-none select-none">

            <!-- User Uploaded Image (below) -->
            <img id="preview-image" src="#"
                 alt="Uploaded Image"
                 class="absolute top-[40%] left-1/2 transform -translate-x-1/2 -translate-y-1/2 object-contain z-0 hidden
                 max-w-[60%] max-h-[50%]"
                 >
        </div>

        <!-- Image Upload Form -->
{{--        <form action="{{ route('pixel.generate') }}" method="POST" enctype="multipart/form-data" class="space-y-4">--}}
        <form  id="pixel-form" enctype="multipart/form-data">
            @csrf
            <div>
                <input type="file" name="image" id="image"
                       class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4
                          file:rounded file:border-0 file:text-sm file:font-semibold
                          file:bg-orange-100 file:text-orange-700 hover:file:bg-orange-200
                          cursor-pointer"
                       accept="image/*" required>
            </div>
            <button
                    class="px-6 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded transition">
                Generate Pixel Art
            </button>
        </form>
        <div id="status" class="mt-4 text-sm text-gray-600"></div>

    </div>

    <!-- Image Preview Script -->
    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const img = document.getElementById('preview-image');
                img.src = reader.result;
                img.classList.remove('hidden');
            };
            reader.readAsDataURL(event.target.files[0]);
        });
    </script>

    <script>
        document.querySelector('form').addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const response = await fetch("{{ route('pixel.generate') }}", {
                method: 'POST',
                body: formData,
            });

            const data = await response.json();
            const taskId = data.task_id;

            console.log('Task queued. ID:', taskId);

            // Start polling
            Echo.channel('pixel-task.' + taskId)
                .listen('PixelArtGenerated', (e) => {
                    console.log('✔️ Pixel art gotowy:', e.taskId);
                    alert('🎉 Pixel art gotowy!');
                });
        });


    </script>
@endsection
