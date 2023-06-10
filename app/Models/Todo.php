<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Todo extends Model
{
    use HasFactory;

    const STATUS = [
        'open' => 'Open',
        'progress' => 'In Progress',
        'completed' => 'Completed'
    ];

    const UPLOAD_PATH = 'uploads/todo/';

    const RECORD_PER_PAGE = 20;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image',
        'due_date',
        'status'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model){
            $model->user_id = Auth::user()->id;
        });

        static::updating(function ($model) {
            $model->user_id = Auth::user()->id;
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
