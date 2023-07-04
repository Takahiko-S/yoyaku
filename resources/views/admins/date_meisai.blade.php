<x-app-layout>
<x-slot name="css">
<style type="text/css">
.pointer{
    cursor:pointer;

}
</style>
</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('予約一覧 日別') }}
        </h2>
    </x-slot>

    <div class="container">
    @csrf
        <div class="row p-3">
            <div class="col-12">
				<table class="table table-striped">
				<thead>
				<tr><th>部屋</th><th>料金</th><th>お名前</th><th>電話番号</th><th>住所</th></tr>
				</thead>
				@foreach($meisai as $m)
    				@if($m['order'] == "")
    				<tr><th>{{$m['room']}}</th><td colspan="5">予約なし</td></tr>
    				@else
    					<tr>
    					<th>{{$m['room']}}</th>
    					<td>{{number_format($m['order']->price)}}</td>
    					<td>{{$m['order']->name}}</td>
    					<td>{{$m['order']->tel}}</td>
    					<td>{{$m['order']->address}}</td>
    					</tr>
    				@endif
				@endforeach
				</table>
            </div>
        </div>


	<x-slot name="script">
    <script>



    </script>
    </x-slot>
</x-app-layout>
