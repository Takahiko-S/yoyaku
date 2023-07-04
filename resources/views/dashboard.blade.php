<x-app-layout>
<x-slot name="css"></x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="row p-3">
            <div class="col-md-3 d-grid mb-3">
				<a href="./ichiran" class="btn btn-primary">予約一覧表示</a>
            </div>
        </div>
    </div>
    <x-slot name="script"></x-slot>
</x-app-layout>
