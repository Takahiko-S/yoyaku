<x-page-base> <!-- カレンダー表示 --> 

<x-slot name="title">ホーム</x-slot>
 <x-slot	name="css">
 <style type="text/css">
 .pointer{
    cursor:pointer;
 }
 </style>
 </x-slot>
 
 <x-slot	name="main">
@csrf
<div class="container">
	<div class="row pt-5">

		<div class="col-12">
			<h1 class="text-center text-primary mb-4">空室情報 {{$year}}年{{$month}}月</h1>
		</div>

		<div class="col-6 text-start">
			<a href="{{route('index')}}?y={{$year}}&m={{$month - 1}}"
				class="btn btn-secondary btn-sm" id="befor">&lt;&lt;&nbsp;前の月</a>
		</div>

		<div class="col-6 text-end">
			<a href="{{route('index')}}?y={{$year}}&m={{$month + 1}}"
				class="btn btn-secondary btn-sm" id="after">次の月&nbsp;&gt;&gt;</a>
		</div>

		<div class="col-12">
			<table class="table">
				<tr class="text-center">
					<th class="text-danger">日</th>
					<th>月</th>
					<th>火</th>
					<th>水</th>
					<th>木</th>
					<th>金</th>
					<th class="text-primary">土</th> 
				</tr>
			@foreach($aki as $data)
				@if($loop->index % 7 == 0)
					<tr>
				@endif 
				
				@if($data['aki'] > 3) 
				@if($data['youbi']=="日")
    					<td class="text-center pointer select_date" value="{{$data['data_date']}}"tag="{{$data['aki']}}"><span class="text-danger">{{$data['date']}}</span><br>◯</td>
    				@elseif($data['youbi']=="土")
    					<td class="text-center pointer select_date" value="{{$data['data_date']}}"tag="{{$data['aki']}}"><span class="text-primary">{{$data['date']}}</span><br>◯</td>
    				@else
    					<td class="text-center pointer select_date" value="{{$data['data_date']}}"tag="{{$data['aki']}}">{{$data['date']}}<br>◯</td> 
				@endif 
				
				@elseif($data['aki'] <4 && $data['aki']>0)
    				@if($data['youbi']=="日")
    					<td class="text-center pointer select_date" value="{{$data['data_date']}}"tag="{{$data['aki']}}"><span class="text-danger">{{$data['date']}}</span><br>△</td>
    				@elseif($data['youbi']=="土")
    					<td class="text-center pointer select_date" value="{{$data['data_date']}}"tag="{{$data['aki']}}"><span class="text-primary">{{$data['date']}}</span><br>△</td>
    				@else
    					<td class="text-center pointer select_date" value="{{$data['data_date']}}"tag="{{$data['aki']}}">{{$data['date']}}<br>△</td> 
				@endif 
				
				@else 
    				@if($data['youbi']=="日")
    					<td class="text-center pointer select_date" value="{{$data['data_date']}}" tag="{{$data['aki']}}"><span class="text-danger">{{$data['date']}}</span><br>×</td>
    				@elseif($data['youbi']=="土")
    					<td class="text-center pointer select_date" value="{{$data['data_date']}}" tag="{{$data['aki']}}"><span class="text-primary">{{$data['date']}}</span><br>×</td>
    				@else
    					<td class="text-center pointer select_date" value="{{$data['data_date']}}" tag="{{$data['aki']}}">{{$data['date']}}<br>×</td> 
    				@endif 
				@endif 
				
				@if($loop->index % 7 == 6)
				</tr>
			@endif 
			@endforeach
			</table>
		</div>
	</div>
</div>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="modal_bt" style="display:none">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">空室情報&nbsp;<span id="data"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="table"></div>
      </div>
      <div class="modal-footer">
      <form method="post" action="./yoyaku">
		@csrf
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
        <button type="submit" class="btn btn-primary" id ="yoyaku_date" name="yoyaku_date" >予約を続ける</button>
      </form>
      </div>
    </div>
  </div>
</div>
</x-slot> 
<x-slot name="script">
 <script>
$('.select_date').on('click',function(e){
	var date = $(this).attr('value');
	var aki = $(this).attr('tag');
	if(aki == 0){
		alert('ご指定日の空室はありません');
		return;
		}
	$('#date').html(date);
	$('#yoyaku_date').val(date);
	getData(date);
	
	//$('#modal_bt').trigger('click');
});

 function getData(date){
	 
	 document.body.style.cursor = 'wait';//waitはマウスカーソルがくるくるしてる状態 ここからajax
		//FormDataオブジェクトを用意
		let code = document.getElementsByName("_token").item(0).value;
		var fd = new FormData();//変数fdにFormDataをセット
		fd.append("_token",code);
		fd.append("date",date);

		    $.ajax({
		      url: "./get_data",
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
		        
		        const keys = Object.keys(response[0]);
		        console.log(keys);

		        var table = "<table class='table'>";
		  		table = table +"<tr><th>部屋タイプ</th><th>料金</th><th>残数</th></tr>";
		  		
				keys.forEach(function(index){//indexで値を入れる
				  console.log(index);
			     table = table + "<tr>";
		        table = table + "<td>"+index+"</td>";
		        table = table + "<td>"+response[1][index].toLocaleString('ja-Jp')+"</td>";
		        table = table + "<td>"+response[0][index]+"</td>";   
		        table = table + "</tr>";
				});
		        
		        table = table + "</table>";
		        $('#table').html(table);
		        $('#modal_bt').trigger('click');
		        document.body.style.cursor = 'auto';
		      },
		      error: function(XHR, status, error){
		        //ここにエラー時の処理を書く
		    	  document.body.style.cursor = 'auto';
		      }
		    });
		  };

	
</script>

</x-slot>

</x-page-base>