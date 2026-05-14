<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    /**
     * Veritabanına toplu kayda izin verilen sütunlar.
     */
    protected $fillable = [
        'user_id', 
        'first_name', 
        'last_name', 
        'email', 
        'phone', 
        'department_id', 
        'position_id', 
        'salary',      // Veritabanındaki gerçek ad
        'base_salary', // Formdan 'base_salary' olarak gelirse Laravel hata vermesin diye ekledik
        'hire_date',
        'birth_date',
        'marital_status',
        'children_count',
        'leave_balance'
    ];

    // --- İLİŞKİLER ---

    // Bir personel bir departmana aittir
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Bir personel bir pozisyona aittir (positions tablosundaki title'ı buradan çekeriz)
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    // Bir personelin kullanıcı hesabı vardır
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Personelin eğitim bilgileri
    public function education() {
        return $this->hasMany(Education::class);
    }

    // Personelin izin talepleri
    public function leaveRequests() {
        return $this->hasMany(LeaveRequest::class);
    }

    // Personelin belgeleri
    public function documents() {
        return $this->hasMany(Document::class);
    }

    // Personelin maaş geçmişi
    public function salaries() {
        return $this->hasMany(Salary::class);
    }

    // Personelin şikayet ve istekleri
    public function complaints() {
        return $this->hasMany(Complaint::class);
    }
}