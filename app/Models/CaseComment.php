<?php

namespace App\Models;

use App\Traits\Tenantable;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CaseComment extends Model
{
    use HasFactory;
    use Tenantable;

    public function files()
    {
        return $this->hasMany(CaseCommentFile::class, 'case_comment_id', 'id');
    }
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id', 'id')->withDefault();
    }

    public function read(){
        return $this->hasOne(CommentRead::class)->where('user_id', auth()->id())->withDefault();
    }
}
