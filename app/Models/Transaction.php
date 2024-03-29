<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'amount', 'type', 'description', 'balance'];

    public const CREDIT = 'credit';
    public const DEBIT = 'debit';
}
