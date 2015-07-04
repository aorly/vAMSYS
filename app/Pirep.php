<?php namespace vAMSYS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Session;
use vAMSYS\Repositories\PilotRepository;

class Pirep extends Model {

    use SoftDeletes;

    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'pireps';

    protected $casts = [
        'pirep_data' => 'array',
    ];

    public function scopefromAirline($query, $airlineId = null)
    {
        if ($airlineId === null)
            $airlineId = Session::get('airlineId');

        $query->select('pireps.*')
            ->join('bookings', 'bookings.id', '=', 'pireps.booking_id')
            ->join('pilots', 'pilots.id', '=', 'bookings.pilot_id')
            ->where('pilots.airline_id', '=', $airlineId);
    }

    public function scopefromPilot($query, $pilotId = null)
    {
        if ($pilotId === null)
            $pilotId = PilotRepository::getCurrentPilot()->id;

        $query->select('pireps.*')
            ->join('bookings', 'bookings.id', '=', 'pireps.booking_id')
            ->join('pilots', 'pilots.id', '=', 'bookings.pilot_id')
            ->where('pilots.id', '=', $pilotId);
    }

    public function booking()
    {
        return $this->belongsTo('vAMSYS\Booking');
    }

    public function positionReports()
    {
        return $this->hasMany('vAMSYS\PositionReport', 'booking_id', 'booking_id');
    }

}
