<?php

namespace App\Models;

use App\Traits\UuidSet;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistLoginLog extends Model
{
    use HasFactory, HasUuids;

    protected $table = "tb_hist_login_logs";

    protected $guarded = [];
}