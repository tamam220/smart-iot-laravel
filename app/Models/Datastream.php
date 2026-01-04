<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Datastream extends Model
{
    protected $fillable = ['device_id', 'name', 'pin', 'type'];
}