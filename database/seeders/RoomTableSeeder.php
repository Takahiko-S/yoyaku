<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $init_rooms = [
            [
            
                'room_name' =>'スタンダード',
                'room_number' =>'101',
                'price' => '10000'
             ],
              [
                'room_name' => 'スタンダード',
                'room_number' => '102',
                'price'=>'10000'
             ],
             [
                'room_name' => 'スタンダード',
                'room_number' => '103',
                'price'=>'10000'
             ],
             [
                'room_name' => 'スタンダード',
                'room_number' => '104',
                'price'=>'10000'
             ],
            [
                'room_name' => 'デラックス',
                'room_number' => '201',
                'price'=>'15000'
            ],
            [
                'room_name' => 'デラックス',
                'room_number' => '202',
                'price'=>'15000'
            ],
            [
                'room_name' => 'デラックス',
                'room_number' => '203',
                'price'=>'15000'
            ],
            [
                'room_name' => 'デラックス',
                'room_number' => '204',
                'price'=>'15000'
            ],
            [
                'room_name' => 'ラグジュアリー',
                'room_number' => '301',
                'price'=>'20000'
            ],
            [
                'room_name' => 'ラグジュアリー',
                'room_number' => '302',
                'price'=>'20000'
            ],
    ];
    
        
        $i = 1;
        foreach($init_rooms as $room){
            $data = new Room();
            $data->room_name = $room['room_name'];
            $data->room_number = $room['room_number'];
            $data->column_name = "room" .$i;
            $data->price = $room['price'];
            $data->save();
            $i ++;
        }
    }
}
