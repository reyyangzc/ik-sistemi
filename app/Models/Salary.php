<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    // PDF Madde 51: Toplu atama (Mass Assignment) koruması için gereklidir.
    protected $fillable = [
        'employee_id',
        'amount',
        'payment_date'
    ];

    /**
     * Maaşın ait olduğu personel ilişkisi.
     * PDF Madde 47: Tablolar arası foreign key ilişkilerini Model seviyesinde tanımlar.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}