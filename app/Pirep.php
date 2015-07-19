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

    protected $dates = ['pirep_start_time', 'off_blocks_time', 'departure_time', 'landing_time', 'on_blocks_time', 'pirep_end_time'];

    public function scopefromAirline($query, $airlineId = null)
    {
        if ($airlineId === null)
            $airlineId = Session::get('airlineId');

        $query->select('pireps.*')
            ->join('bookings', 'bookings.id', '=', 'pireps.booking_id')
            ->join('pilots', 'pilots.id', '=', 'bookings.pilot_id')
            ->where('pilots.airline_id', '=', $airlineId)
            ->where('pireps.pirep_data', '!=', '{"jumpseat":true}'); // TODO Improve this detection
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
        return $this->belongsTo('vAMSYS\Booking')->withTrashed();
    }

    public function positionReports()
    {
        return $this->hasMany('vAMSYS\PositionReport', 'booking_id', 'booking_id');
    }

}
