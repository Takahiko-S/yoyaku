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
            {{ __('予約一覧') . $year ."年" . $month . "月"}}
        </h2>
    </x-slot>

    <div class="container">
    @csrf
        <div class="row p-3">
            <div class="col-12">
				<table class="table table-striped">
				<thead>
				<tr>
				<th>日付</th>
				<th>room1</th>
				<th>room2</th>
				<th>room3</th>
				<th>room4</th>
				<th>room5</th>
				<th>room6</th>
				<th>room7</th>
				<th>room8</th>
				<th>room9</th>
				<th>room10</th>
				</tr>
				</thead>
				@foreach($yoyaku_array as $yoyaku)
				@if($yoyaku->date == $today)
					<tr class="bg-warning">
				@else
					<tr>
				@endif
				<td class="select_data pointer" tag="{{$yoyaku->date}}">{{$yoyaku->date}}</td>
				@if($yoyaku->room1 == 0)
					<td>-</td>
				@else
					<td class="text-primary select pointer" tag = "{{$yoyaku->room1}}">あり</td>
				@endif
				@if($yoyaku->room2 == 0)
					<td>-</td>
				@else
					<td class="text-primary select pointer" tag = "{{$yoyaku->room2}}">あり</td>
				@endif
				@if($yoyaku->room3 == 0)
					<td>-</td>
				@else
					<td class="text-primary select pointer" tag = "{{$yoyaku->room3}}">あり</td>
				@endif
				@if($yoyaku->room4 == 0)
					<td>-</td>
				@else
					<td class="text-primary select pointer" tag = "{{$yoyaku->room4}}">あり</td>
				@endif
				@if($yoyaku->room5 == 0)
				
					<td>-</td>
				@else
					<td class="text-primary select pointer" tag = "{{$yoyaku->room5}}">あり</td>
				@endif
				@if($yoyaku->room6 == 0)
				
					<td>-</td>
				@else
					<td class="text-primary select pointer" tag = "{{$yoyaku->room6}}">あり</td>
				@endif
				@if($yoyaku->room7 == 0)
			
					<td>-</td>
				@else
					<td class="text-primary select pointer" tag = "{{$yoyaku->room7}}">あり</td>
				@endif
				@if($yoyaku->room8 == 0)
				
					<td>-</td>
				@else
					<td class="text-primary select pointer" tag = "{{$yoyaku->room8}}">あり</td>
				@endif
				@if($yoyaku->room9 == 0)
				
					<td>-</td>
				@else
					<td class="text-primary select pointer" tag = "{{$yoyaku->room9}}">あり</td>
				@endif
				@if($yoyaku->room10 == 0)
				
					<td>-</td>
				@else
					<td class="text-primary select pointer" tag = "{{$yoyaku->room10}}">あり</td>
				@endif

				</tr>				
				@endforeach				
				</table>
            </div>
        </div>
        <!-- Button trigger modal -->
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="modal_bt" style="display:none">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">予約詳細</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="modal_main"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>

      </div>
    </div>
  </div>
</div>

	<x-slot name="script">
    <script>
$('.select_data').on('click',function(e){
	var date = $(this).attr('tag');
	console.log(date);
	location.replace('./date_meisai?d=' + date);
		
});

$('.select').on('click',function(e){
	var order_num = $(this).attr('tag');
	console.log(order_num);	
	//ここからajax2
	document.body.style.cursor = 'wait';//waitはマウスカーソルがくるくるしてる状態 ここからajax
	//FormDataオブジェクトを用意
	let code = document.getElementsByName("_token").item(0).value;
	var fd = new FormData();//変数fdにFormDataをセット
	fd.append("_token",code);
	fd.append("order_num",order_num);

	    $.ajax({
	      url: "./get_meisai",
	      method:"post",
	      data: fd,
	      mode:"multiple",
			async: false,
			processData: false,
			contentType:false,
			timeout: 10000,   
	      success: function(response){
	        //ここに成功時の処理を書く。responseにはサーバーからのレスポンスデータが含まれる
	        console.log(response);	        
	   
	        $('#modal_main').html(response);
	        $('#modal_bt').trigger('click');
	        document.body.style.cursor = 'auto';
	      },
	      error: function(XHR, status, error){
	        //ここにエラー時の処理を書く
	    	  document.body.style.cursor = 'auto';
	      }
	    });


});




    </script>
    </x-slot>
</x-app-layout>
