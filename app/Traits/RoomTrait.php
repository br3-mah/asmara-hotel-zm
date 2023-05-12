<?php

namespace App\Traits;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

trait RoomTrait {
    use WithPagination;
    public function getTotalRooms(){
        return Room::get()->count();
    }

    public function getAllBookedRooms(){
        return Room::where('is_available', 0)->with('staff')->with('room_types')->get();
    }

    public function getAllRooms(){
        return Room::with('staff')->with('room_types')->paginate(9);
    }

    public function getAvailableRooms(){
        return Room::where('is_available', 1)->with('staff')->with('room_types')->get();
    }

    public function getAllRoomTypes2(){
        return RoomType::with('users')->get();
    }
    public function getAllRoomTypes(){
        return RoomType::with('users')->paginate(2);
    }

    public function getRoomType($id){
        return RoomType::where('id', $id)->get()->first();
    }

    public function saveRoomType($request){
        // Bug: image unable to save
        if ($request->file('image_path')) {
            $cover_image = Storage::put('public/room_types', $request->file('image_path'));
        }
        $data = RoomType::create($request->toArray());
        $data->cover = $cover_image;
        $data->save();

        if(!empty($data->toArray())){
            return true;
        }else{
            return false;
        }
    }
    public function updateRoomType($request){
        $inputs = $request->except(['type_id', '_token']);
        $data = RoomType::find($request->input('type_id'));
        $data->update($inputs);
        if ($request->file('image_path')) {
            $cover_image = Storage::put('public/room_types', $request->file('image_path'));
            $data->cover = $cover_image;
            $data->save();
        }

        if(!empty($data->toArray())){
            return true;
        }else{
            return false;
        }
    }
    public function saveRoom($request){
        
        if ($request->file('image_path')) {
            $image_path = Storage::put('public/rooms', $request->file('image_path'));
        }
        $data = Room::create($request->toArray());
        $data->image_path = $image_path;
        $data->save();

        if(!empty($data->toArray())){
            return true;
        }else{
            return false;
        }
    }

    public function toggleRoomStatus($id){
        $room = Room::find($id);
        $room->is_available = !$room->is_available;
        $room->save();
    }

    public function removeRoomType($id){
    
        try {
            DB::table('room_types')->where('id', '=', $id)->delete();
            DB::table('rooms')->where('room_types_id', '=', $id)->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}