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
			<h1 class="text-center text-primary mb-4">宿泊予約</h1>
			<h3 class="text-center">予約日 {{$date}}</h3>
		</div>
 <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
<form method="post" action="./yoyaku_fix" class="row h-adr" id="yoyaku_form">
<span class="p-country-name" style="display:none;">Japan</span>
@csrf
<input type="hidden" name="date" value="{{$date}}">
<div class="col-6">
<table class="table">
<tr>
<th>部屋タイプ</th>
<th>料金</th>
<th>予約</th>
</tr>
@foreach($aki as $a)
<tr>
<td>{{$a['room'] . "-" . $a['type']}}</td>
<td class="text-start">{{number_format($a['kingaku'])}}</td>
<td><input type="checkbox" name="yoyaku[]" class="form-check" value="{{$a['room']}}"></td>
</tr>
@endforeach
</table>
</div>
<div class="col-md-4">
  <div class="mb-3">
    <label for="name" class="form-label">お名前</label>
    <input type="text" class="form-control" id="name" name="name" required>
  </div>
    <div class="mb-3">
    <label for="mail" class="form-label">メールアドレス</label>
    <input type="email" class="form-control" id="mail" name="mail" required>
  </div>
    <div class="mb-3">
    <label for="tel" class="form-label">電話番号</label>
    <input type="text" class="form-control" id="tel" name="tel" required>
  </div>
    <div class="mb-3">
    <label for="yubin" class="form-label">郵便番号</label>
    <input type="text" class="form-control p-postal-code" id="yubin" name="yubin" required>
  </div>
    <div class="mb-4">
    <label for="address" class="form-label">住所</label>
    <input type="text" class="form-control p-region p-locality p-street-address" id="address" name="address" required>
  </div>
   <div class="mb-3 text-center">
    <button type="button" class="btn btn-secondary">キャンセル</button>
    <button type="submit" class="btn btn-primary">予約する</button>

  </div>

</div>	
</form>
	</div>
</div>

</x-slot> 
<x-slot name="script">
 <script>

 $('form').on('submit', function(event){
	    event.preventDefault();//フォームの通常の送信をキャンセル
	    console.log('send');
	    var chval =[];
	    $('input[name="yoyaku[]"]:checked').each(function(){
		    chval.push($(this).val());
	    });
 console.log(chval);
 if(chval.length == 0){
	alert("予約する部屋部屋が選択されていません");
	return;
	 }else{
		 $('form').off('submit')
		 $('form').submit();
	 }
 });
 
/*  $("form").on("submit", function(e){
	    if($('input[name="yoyaku[]"]:checked').length === 0){
	      e.preventDefault();
	      alert('予約する部屋部屋が選択されていません');
	    }
	  }); */
</script>
</x-slot>

</x-page-base>