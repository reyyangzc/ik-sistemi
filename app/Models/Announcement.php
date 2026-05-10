<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    /**
     * Toplu atama yapılabilecek alanlar.
     * PDF Madde 51: Bu tanımlama mass assignment saldırılarını engelleyerek güvenlik sağlar. [cite: 51, 105]
     */
    protected $fillable = [
        'title',
        'content',
        'user_id'
    ];

    /**
     * Duyuruyu yayınlayan kullanıcı (Admin) ile ilişki.
     * PDF Madde 47 & 48: Tablolar arası foreign key ilişkilerini Model seviyesinde tanımlar. [cite: 47, 48]
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}