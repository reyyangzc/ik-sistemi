<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    /**
     * Veritabanına toplu olarak kaydedilmesine izin verilen sütunlar.
     */
    protected $fillable = [
        'employee_id', 
        'start_date', 
        'end_date', 
        'type',           // Formdaki name="type" ile eşleşir
        'leave_type_id',  // Eğer veritabanında bu isimdeyse yedek olarak kalsın
        'status',         // Varsayılan: pending
        'reason'
    ];

    /**
     * Tarih sütunlarını otomatik olarak Carbon objesine dönüştürür.
     * Bu sayede tarihler üzerinde kolayca işlem yapabilirsin.
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    /**
     * İzin talebi bir personele aittir.
     * (Çalışan bilgilerine ulaşmak için: $leave->employee->name)
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}