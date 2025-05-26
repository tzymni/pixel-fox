@extends('layouts.app')

@section('content')
    <style>
        @keyframes spin-y {
            from {
                transform: rotateY(0deg);
            }
            to {
                transform: rotateY(360deg);
            }
        }

        .spin-y {
            animation: spin-y 1s linear infinite;
            transform-style: preserve-3d;
        }
        #preview-area {
            perspective: 1000px;
        }
    </style>

    <div class="container mx-auto text-center py-0">
        <!-- Image Display Area -->
        <div id="preview-area" class="relative mx-auto mb-0 aspect-[3/4] w-96 sm:w-[28rem] md:w-[31rem]">
            <!-- Frame Image (on top) -->
            <img src="{{ asset('images/fox-frame.png') }}" alt="Fox Frame"
                 class="w-full h-auto relative z-10 pointer-events-none select-none">

            <img id="preview-image" src="#"
                 alt="Uploaded Image"
                 class="absolute top-[40%] left-1/2 transform -translate-x-1/2 -translate-y-1/2 object-contain hidden z-0
                 max-w-[60%] max-h-[50%] origin-center transition-transform duration-500 ease-linear"
            >
        </div>

        <!-- Image Upload Form -->
        <form id="pixel-form" method="post" enctype="multipart/form-data" data-generate-url="{{ route('pixel.generate') }}">
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
                class="px-6 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded transition mt-4">
                Generate Pixel Art
            </button>
        </form>

        <div id="status" class="mt-4 text-sm text-gray-600"></div>
    </div>

@endsection
