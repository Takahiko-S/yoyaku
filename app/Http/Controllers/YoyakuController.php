<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Yoyaku;
use App\Models\Room;
use App\Models\Order;

class YoyakuController extends Controller
{    
    public function test(){
        $calendar_array = $this->makeCalendarData(6);
      //  print_r($calendar_array);
        $aki = array();
        
        foreach($calendar_array as $array){
            $yoyaku_data = Yoyaku::where('date',$array['date'])->first();
            if($yoyaku_data == null){
                $yoyaku_data = new Yoyaku();
                $yoyaku_data -> date = $array['date'];
                $yoyaku_data -> save();
                $yoyaku_data = Yoyaku::where('date',$array['date'])->first();
            }
            //カラムチェック 開いてる部屋の数チェック
            $aki_count = 0;
            for($i = 1; $i <= 10; $i++){
                $col = "room" . $i;
                if($yoyaku_data->$col == 0){
                    $aki_count++;
                }
            }
            
            //お休みフラグチェック 休みの日をチェック
            if($yoyaku_data->k_flag == 1){
                $aki_count = 0;

            }
            array_push($aki,array('aki' => $aki_count,'date'=>$array['date'],'youbi' =>$array['week']));
        }
                dd($aki);
        
    }
    
//ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
    public function index(Request $request){
        if($request->has('m')){
            $month = $request->m;
        }else{
            $month = intval(date('m'));
            //dd($month);
        }
        
        if($request->has('y')){
            if($month < 1){
                $year=$request->y - 1;
                $month = 12;
            }elseif($month > 12){
                $year=$request->y + 1;
                $month = 1;
            }else{
                
                $year=$request->y;
            }
        }else{
            $year = intval(date('Y'));
            $month = intval(date('m'));
        }
        $today = new \DateTime();
        $serch_day = new \DateTime($year . "-" . $month . "-1");
        
        if($serch_day->format('Y')==$today->format('Y') && $serch_day->format('m') < $today->format('m')){
            $year = intval($today->format('Y'));//  print_r($calendar_array);
            $month = intval($today->format('m'));
            $calendar_array = $this->makeCalendarData($year,$month);
        }else{
       
            $calendar_array = $this->makeCalendarData($year,$month);
        }
            $aki = array();
            //$today->modify("+1 day");
            
            foreach($calendar_array as $array){
                $yoyaku_data = Yoyaku::where('date',$array['date'])->first();
                if($yoyaku_data == null){
                    $yoyaku_data = new Yoyaku();
                    $yoyaku_data -> date = $array['date'];
                    $yoyaku_data -> save();
                    $yoyaku_data = Yoyaku::where('date',$array['date'])->first();
                }
                //カラムチェック 開いてる部屋の数チェック
                $aki_count = 0;
                for($i = 1; $i <= 10; $i++){
                    $col = "room" . $i;
                    if($yoyaku_data->$col == 0){
                        $aki_count++;
                    }
                }
                
                //お休みフラグチェック 休みの日をチェック
                if($yoyaku_data->k_flag == 1){
                    $aki_count = 0;
                    
                }
                $d = explode("-", $array['date']);
                $d_str = $d[1] ."/" . $d[2];
                $check_date = new \DateTime($array['date']);
                if($check_date < $today){
                    $aki_count =0;
                }
                array_push($aki,array('aki' => $aki_count,'date'=>$d_str,'youbi' =>$array['week'],'data_date'=>$array['date']));
            }
            //dd($aki);
                  
        
        return view('contents.index',compact('aki','year','month'));
    }
    //ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
    
    public function getData(Request $request){
        
        $yoyaku = Yoyaku::where('date',$request->date)->first();
        
        for($i = 1; $i <= 10; $i++){
            $column[] = "room" . $i;
            
        }
        foreach ($column as $c){//配列作ってる
            $check = $yoyaku->$c;
            if($check == 0){
                    $room = Room::where('column_name',$c)->first();            
                $aki[] = array('room' => $room->room_number,'type' => $room->room_name, 'kingaku' => $room->price); 
            }
        }
        //部屋別集計  日にちごとの部屋の空き数
        $typeCounts =array();
        foreach($aki as $room){
            $type = $room["type"];
            if(isset($typeCounts[$type])){
                $typeCounts[$type]++;
            }else{
                $typeCounts[$type] = 1;
            }
        }
        $price = array('スタンダード' => 10000,'デラックス' => 15000,'ラグジュアリー' => 20000,);
        $data = array ($typeCounts,$price);
        //連想配列のキーを取得
        $keys = array_keys($typeCounts);
        return $data;
    }
    //ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
    //宿泊予約
    
    public function yoyaku(Request $request){
        //dd($request->all());
        $date = $request->yoyaku_date;
        $yoyaku = Yoyaku::where('date',$date)->first();
       //dd($yoyaku);
        for($i = 1; $i <= 10; $i++){
            $column[] = "room" . $i;
            
        }
        
          foreach ($column as $c){//配列作ってる
         $check = $yoyaku->$c;
         if($check == 0){
         $room = Room::where('column_name',$c)->first();
         $aki[] = array('room' => $room->room_number,'type' => $room->room_name, 'kingaku' => $room->price);
         } 
          }
        //dd($aki);
        return view('contents.yoyaku',compact('aki','date'));
    }
    
    
//ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
//予約完了
    public function yoyakuFix(Request $request){
        //dd($request->all());
        $yoyaku = $request->yoyaku;
        foreach($yoyaku as $y){
          $order = new Order();
          $order->name = $request->name;
          $order->email = $request->mail;
          $order->tel = $request->tel;
          $order->date = $request->date;
          $room = Room::where('room_number',$y)->first();
          $order->room_type = $room->room_name;
          $order->room_number = $y;
          $order->yubin = $request->yubin;
          $order->address = $request->address;
          $order->price = $room->price;
          $order->save();
          
          $col_str = $room->column_name;
          $yoyaku_cal = Yoyaku::where('date',$request->date)->first();
          $yoyaku_cal->$col_str=$order->id;
          $yoyaku_cal->save();
    }
    
  //  dd($yoyaku_cal);
   return redirect(route('index'));
    }
   
    
    
    
    
    
    
    
    
    
    
//ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
    //カレンダー用日付生成ファンクション
    private function makeCalendarData($year,$month){
        $youbi = array('日','月','火','水','木','金','土',);
        $calendar_array = array();
        //print $month . "<br>";
       // $year = date('Y');
        //print $year . "<br>";
        $date = new \DateTime($year."-" . $month . "-1");
        
        $start = $date->format('w');
        $num= -$start . " day";
        if($start != 0){
            $date->modify($num);
        }
        
        for($i = $start; $i > 0; $i--){
            //print $date->format('Y-m-d') . $youbi[$date->format('w')] . "<br>";
            
            array_push($calendar_array,array('date' =>$date->format('Y-m-d'),'week' =>$youbi[$date->format('w')]));
            $date->modify('+1 day');
        }
        
        while($date->format('m') == $month){
            //print $date->format('Y-m-d') . $youbi[$date->format('w')] . "<br>";
            array_push($calendar_array,array('date' =>$date->format('Y-m-d'),'week' =>$youbi[$date->format('w')]));
            $date->modify('+1 day');
            
        }
        while($date->format('w') != 0){//0になるまで回す一週間区切り
           // print $date->format('Y-m-d') . $youbi[$date->format('w')] . "<br>";
            array_push($calendar_array,array('date' =>$date->format('Y-m-d'),'week' =>$youbi[$date->format('w')]));
            $date->modify('+1 day');
        }
        //print $date->format('Y-m-d') . "<br>";
         
        return $calendar_array;
    }
}
