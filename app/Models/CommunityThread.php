<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CommunityThread extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'user_id',
        'title',
        'last_activity_at',
    ];

    protected $casts = [
        'last_activity_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(CommunityMessage::class)->orderBy('created_at', 'asc');
    }

    public function latestMessage()
    {
        return $this->hasOne(CommunityMessage::class)->latest('created_at');
    }

    // Accessors
    public function getReplyCountAttribute()
    {
        return $this->messages->count();
    }

    public function getLastMessagePreviewAttribute()
    {
        $lastMessage = $this->latestMessage()->first();
        if (!$lastMessage) {
            return 'No messages yet';
        }

        $preview = substr($lastMessage->message, 0, 60);
        return strlen($lastMessage->message) > 60 ? $preview . '...' : $preview;
    }
}
