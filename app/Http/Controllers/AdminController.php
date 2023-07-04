<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Yoyaku;
use App\Models\Order;
use App\Models\Room;

class AdminController extends Controller
{
    //予約一覧
    
    public function ichiran(Request $request) {
        if($request -> has('y') && $request->has('m')){
            $year = $request->y;
            $month = $request->m;
        }else{
            $year = date('Y');
            $month = date('m');
        }
        $lastDay = date ('Y-m-t',strtotime($year . '-' . $month . '-01'));
        
        $date_array = explode("-", $lastDay);
        $last_date = $date_array[2];
        $first_date = 1;
        sprintf('%02d', 1);
     
        $yoyaku_array = array();
        for($i = $first_date; $i <= $last_date; $i++){
            $date = $year . "-" . sprintf('%02d', $month) . "-" .sprintf('%02d', $i);
            $yoyaku = Yoyaku::where('date',$date)->first();
            if($yoyaku == null){
                $yoyaku = new Yoyaku();
                $yoyaku->date = $date;
                $yoyaku->save();
                $yoyaku = Yoyaku::where('date',$date)->first();
                
            }
            array_push($yoyaku_array,$yoyaku);
            
        }
        $today = date('Y-m-d');
        //dd($today);
        return view('admins.ichiran',compact('yoyaku_array','year','month','today'));
    }
    
//ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
//ajax呼び出し明細
    public function getMeisai(Request $request){
        //print_r($request->all());
        $order = Order::find($request->order_num);
        $html = "";
        $html .= "<table class='table table-striped'>";
        $html .= "<tr><th>宿泊日</th><td>" . $order->date . "</td></tr>";
        $html .= "<tr><th>RoomNo.タイプ</th><td>" .$order->room_number . " " . $order->room_type . "</td></tr>";
        $html .= "<tr><th>料金</th><td>" .  number_format($order->price) . "</td></tr>";
        $html .= "<tr><th>お名前</th><td>" . $order->name . "</td></tr>";
        $html .= "<tr><th>メールアドレス</th><td>" . $order->email . "</td></tr>";
        $html .= "<tr><th>電話番号</th><td>" . $order->tel . "</td></tr>";
        $html .= "</table>";
        return $html;
    }
    //ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
    //日別予約状況表示
    public function dateMeisai(Request $request){
        if(!$request->has('d')){
            exit("参照が不正です");
        }
       
        $yoyaku = Yoyaku::where('date',$request->d)->first();

        if($yoyaku == null){
            exit("日付が不正です");
        }
        $date = $request->d;
        $meisai = array();
        for($i = 1; $i <= 10; $i++){
            $column = "room" . $i;
            $room = Room::where('column_name',$column)->first();
            $order_num = $yoyaku->$column;
            if($order_num != 0){
                $meisai[] = array("room" => $room->room_number, "order" => Order::find($order_num));
            }else{
                $meisai[] = array("room" =>$room->room_number, "order" =>"" );
        }
        
        }
        //dd($meisai);
        return view('admins.date_meisai',compact('date','meisai'));
    }
}
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    



