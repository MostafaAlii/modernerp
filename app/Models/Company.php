<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\Company\{CompanyStatus};
class Company extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    protected $table = 'companies';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'status',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date' => 'date',
        'status' => CompanyStatus::class,
    ];

    protected static function booted() {
        static::addGlobalScope('company_visibility', function ($builder) {
            $user = get_user_data();
            if ($user?->type !== \App\Enums\Admin\AdminType::OWNER || !is_null($user?->company_id)) {
                $builder->where('id', $user?->company_id);
            }
        });
    }
}