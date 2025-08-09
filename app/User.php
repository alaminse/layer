<?php

namespace App;

use App\Models\Client;
use App\Models\Organization;
use App\Notifications\PasswordResetNotification;
use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Attendance\Entities\Attendance;
use Modules\Leave\Entities\ApplyLeave;
use Modules\Leave\Entities\LeaveDefine;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

class User extends Authenticatable
{
    use Notifiable;
    use Tenantable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'role_id', 'status', 'avatar', 'organization_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->hasOne('App\Models\Employee\Employee');
    }

    public function client()
    {
        return $this->hasOne(Client::class);
    }
    public function getProfile()
    {

        $profile = $this->employee;

        return $profile;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    public function leaves()
    {
        return $this->hasMany(ApplyLeave::class)->CarryForward();
    }

    public function leaveDefines()
    {
        return $this->hasMany(LeaveDefine::class, 'role_id', 'role_id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token));
    }
    public function apiKey()
    {
        if (moduleStatusCheck('Zoom') == true) {
            $apiCheck= \Modules\Zoom\Entities\ZoomSetting::first();

            if ($apiCheck->api_use_for==1) {
                return $this->zoom_api_key_of_user;
            } else {
                return env('ZOOM_CLIENT_KEY');

            }
        }
    }

    public function apiSecret()
    {
        if (moduleStatusCheck('Zoom') == true) {
            $apiCheck= \Modules\Zoom\Entities\ZoomSetting::first();
            if ($apiCheck->api_use_for==1) {
                return $this->zoom_api_serect_of_user;
            } else {
                return env('ZOOM_CLIENT_SECRET');
            }
        }
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
