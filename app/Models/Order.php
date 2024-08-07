<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }


    public function post()
    {
        return $this->belongsTo(Post::class, 'posts_id');
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
