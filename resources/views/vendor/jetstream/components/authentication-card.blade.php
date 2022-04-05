<div class="flex flex-col items-center justify-center min-h-screen pt-6 bg-cover sm:pt-0" style="background-image: url('{{asset('bg.gif')}}')">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
