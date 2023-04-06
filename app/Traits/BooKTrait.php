<?php

namespace App\Traits;

use App\Models\Booking;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use App\Notifications\BookingInquiryNotification;
use App\Notifications\GuestInquiryNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Livewire\WithPagination;

trait BookTrait {
    use UserTrait, RoomTrait, DateTrait, WithPagination;

    // Get all Booking inquiries
    public function getBookingInquiries(){
        return Reservation::get()->pageinate(10);
    }

    // Returns all booked rooms with booking information dates
    public function getBookings(){
        return Booking::where('booking_status', 1)->with('room.room_types')->with('guests.users')->get();
    }

    // Returns all booked rooms with booking information dates
    public function getCalendarBookings(){
        $events = [];
        $bookings = Booking::get()->toArray();
        $total_rooms = $this->getTotalRooms();
        // Merge booked rooms
        foreach($bookings as $b){
            $events = [
                'title' => count($bookings).' Booked Rooms',
                'url' => '/calendar-and-bookings',
                'start' => $this->convertNormal($b['checkin_date']),
                'end' => $this->convertNormal($b['checkout_date']),
                'className' => 'bg-danger'
            ];
            
            // $events = [
            //     'title' => $total_rooms - count($bookings).' Rooms Available',
            //     'url' => '/calendar-and-bookings',
            //     'start' => $this->convertNormal($b['checkin_date']),
            //     'end' => $this->convertNormal($b['checkout_date']),
            //     'className' => 'bg-success'
            // ];
        }
        return $events;
        

        // // Merge available rooms
        foreach ($bookings as $a) {
           $x = $this->getFreeRoomOnDate($a['checkin_date'], $a['checkout_date']);
            //   dd($x);
        }
    }

    // Returns all available rooms on a specific date range
    public function getFreeRoomOnDate($from, $to){

    }


    public function checkAvailability($request){
        return Room::with('categories')
        ->where('room_types_id', $request->input('room_type'))
        ->where('num_adult', '>=' , $request->input('adult_num'))
        ->where('num_children', '>=', $request->input('children_num') + 1)
        ->where('is_available', 1)
        ->get();

        // Search from the booked rooms about to checkout
        // "check_in_date" => "03/01/2023"
        // "check_out_date" => "03/01/2023"
    }

    public function makeReservation($request){
        $admin = User::first();
        // Enter User Information
        $user = $this->registerUser($request);
        // Enter reservation information
        $data = Reservation::create([
            'guests_id' => $user->id,
            'reservation_date' => now(),
            'reservation_code' => Str::orderedUuid(4),
            'checkin_date' => $request->input('check_in_date'),
            'checkout_date' =>  $request->input('check_out_date'),
            'num_adults' => $request->input('adult_num'),
            'num_children' => $request->input('children_num'),
            'special_requests' => $request->input('special_requests'),
            'is_confirmed' => 0,
            'is_cancelled' => 0
        ]);
        $note = [
            'name' => Reservation::fullName($user->id),
            'msg' => "You have received a new booking inquiry. Date of Arival ".$request->input('check_in_date')." and Date of Departure ".$request->input('check_out_date'),
            'type' => 'inquiry',
            'special_req' => $request->input('special_requests') ?? 'None',
            'room_type' => $request->input('room_type'),
            'user_id' => $user->id,
            'data_id' => $data->id
        ];
        Notification::send($admin, new BookingInquiryNotification($note));
        Notification::send($user, new GuestInquiryNotification($note));
        if(!empty($data->toArray())){
            return true;
        }else{
            return false;
        }
    }

    public function saveBooking($data){
        $admin = User::first();
        // Enter reservation information
        $data = Booking::create([
            'guests_id' => $data['guest_id'],
            'rooms_id' => $data['room_id'],
            'reservations_id' => $data['reserve_id'],
            'user_id' => auth()->user()->id,
            'booking_code' => Str::orderedUuid(4),
            'checkin_date' => $data['in'],
            'checkout_date' => $data['out'],
            'num_adults' => $data['adults'],
            'num_children' => $data['children'],
            'booking_date' => now(),
            'total_price' => $data['price'],
            'payment_status' => 1,
            'booking_status' => 1
        ]);
        $note = [
            'msg' => "Booked Room. Date checked in ".$data['in']." and Date of Check-out ".$data['out'],
            'type' => 'booking'
        ];
        // Notification::send($admin, new BookingInquiryNotification($note));
        // Notification::send($user, new GuestInquiryNotification($note));
        if(!empty($data->toArray())){
            return true;
        }else{
            return false;
        }
    }

    public function acceptInquiry($id){
        $inq = Reservation::where('id', $id)->first();
        $inq->is_confirmed = 1;
        $inq->is_cancelled = 0;
        $inq->save();
    }

    public function denyInquiry($id){
        $inq = Reservation::where('id', $id)->first();
        $inq->is_confirmed = 1;
        $inq->is_cancelled = 1;
        $inq->save();
    }
}