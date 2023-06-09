<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Reservation;
use App\Models\ReservationList;
use App\Models\Room;
use App\Models\User;
use App\Traits\BookTrait;
use Livewire\Component;

class IndexView extends Component
{
    use BookTrait;
    public $tt_booking, $tt_inquiries, $checkin, $checkout, $tt_rooms_available, $tt_rooms_booked, $tt_total_site_visitors;

    public function render()
    {
        
        $bookings = $this->getBookings();
        
        $this->tt_booking = $this->totalBookings();
        $this->tt_inquiries = ReservationList::count();
        $this->checkin = $this->totalCheckIns();
        $this->checkout =  $this->totalCheckOuts();
        $this->tt_rooms_available =  Room::where('is_available', 1)->count();
        $this->tt_rooms_booked =  $this->totalCheckIns();
        $this->tt_total_site_visitors = User::count();

        return view('livewire.dashboard.admin.index-view',[
            'bookings' => $bookings
        ]);
    }
}
