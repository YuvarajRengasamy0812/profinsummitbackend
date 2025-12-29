<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['ticket_type', 'refer_code', 'refer_count'];

    public function users()
    {
        return $this->hasMany(TicketUser::class, 'ticket_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'ticket_id');
    }
}

