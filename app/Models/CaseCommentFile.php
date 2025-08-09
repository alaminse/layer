<?php

namespace App\Models;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseCommentFile extends Model
{
    use HasFactory;
    use Tenantable;
    
    public function comment()
    {
        return $this->belongsTo(CaseComment::class, 'case_comment_id', 'id');
    }
}
