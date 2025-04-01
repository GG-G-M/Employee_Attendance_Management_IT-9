<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'status',
        'check_in',
        'check_out',
        'notes'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Status constants
    const STATUS_PRESENT = 1;
    const STATUS_LATE = 2;
    const STATUS_ABSENT = 3;
    const STATUS_HOLIDAY = 4;

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper methods
    public function getStatusText()
    {
        return match($this->status) {
            self::STATUS_PRESENT => 'Present',
            self::STATUS_LATE => 'Late',
            self::STATUS_ABSENT => 'Absent',
            self::STATUS_HOLIDAY => 'Holiday',
            default => 'Unknown',
        };
    }
}