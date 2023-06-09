<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Mail\RespondReservationMail;
use App\Models\ReservationList;
use App\Models\Room;
use App\Models\User;
use App\Traits\BookTrait;
use App\Traits\RoomTrait;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class GuestInfoView extends Component
{
    use BookTrait, RoomTrait;
    public $user, $reservations, $inquiries, $hasCurrentBooking, $hasCurrentReservation, $lastReservation, $lastBooking;
    public $message, $optresp;
    public $inquiry_id = null;
    public $book_room_id;
    public $room;
    public $rooms;
    public $reservation;

    public function mount($id){
        $this->user = User::where('id', $id)->with('guests')->first();
        $this->hasCurrentBooking = $this->hasCurrentBooking($this->user->id);
        $this->hasCurrentReservation = $this->hasCurrentReservation($this->user->id);
        $this->lastBooking = $this->getLastBooking($this->user->id);
        $this->lastReservation = $this->getLastReservation($this->user->id);
        
    }

    public function render(){
        $bookings = $this->getCustomerBookings($this->user->guests->id);
        $this->rooms = $this->getAvailableRooms();
        return view('livewire.dashboard.admin.guest-info-view',[
            'bookings' => $bookings
        ]);
    }
    public function bookRoom($id){
        $this->inquiry_id = $id;
        $this->reservation = ReservationList::where('id', $id)->first();
        // $this->reservation = Reservation::where('id', $id)->first();
        $this->user = User::where('id', $this->reservation->guests_id)->first();
    }

    public function makeBooking(){
        try {
            $room = Room::where('id', $this->book_room_id)->with('room_types')->first();
            $room->is_available = 0;
            $room->save();

            $data = [
                'guest_id' => $this->user->id,
                'room_id' => $this->book_room_id,
                'reserve_id' => $this->inquiry_id,
                'in' => $this->reservation->checkin_date,
                'out' =>  $this->reservation->checkout_date,
                'adults' =>  $this->reservation->num_adults,
                'children' =>  $this->reservation->num_children,
                'price' =>  $room->room_types->price,
            ];
            $this->saveBooking($data);
            session()->flash('success', 'Room successfully booked.');
        } catch (\Throwable $th) {
            dd($th);
            session()->flash('error', 'Room booking failed.');
        }
    }

    public function bulkResponse($id){
        $this->inquiry_id = $id;
        $data = ReservationList::where('id', $id)->first();
        // $data = Reservation::where('id', $id)->first();
        $this->user = User::where('id', $data->guests_id)->first();
    }

    public function sendResponse(){
        try {
            $this->acceptInquiry($this->inquiry_id);
            $mail = [
                'to' => $this->user->email,
                'msg' => $this->message,
                'subject' => $this->optresp,
                'name' => $this->user->fname.' '.$this->user->lname
            ];
            
            $contact_email = new RespondReservationMail($mail);
            Mail::to($mail['to'])->send($contact_email);
            $this->clear();
            session()->flash('success', 'Reservation response was sent successfully.');
        } catch (\Throwable $th) {
            session()->flash('error', 'Reservation response failed to send.');
        }
    }

    public function clear(){
        $this->message = ''; 
        $this->optresp = '';
        $this->user = null;
        $this->reservation = '';
        $this->inquiry_id = null;
    }
}
