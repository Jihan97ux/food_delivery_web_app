<div class="p-4 bg-white max-w-lg w-full rounded-md shadow-xl flex flex-col justify-between gap-y-3">
    <div class="flex w-full justify-center items-center">
        <div class="w-8 h-8 rounded-full bg-green-300 flex items-center justify-center">
            <i class='fa fa-check text-green-700 text-lg'></i>
        </div>
    </div>
    <h1 class="text-2xl text-center">{{ $successTitle }}</h1>
    <p class="text-gray-700 text-center">{{ $successText }}</p>
    <a href="{{ route($redirectRoute) }}" class="bg-orange-500 text-center hover:bg-orange-800 duration-200 text-white px-6 py-2 rounded-lg">{{ $successTextButton }}</a>
</div>
