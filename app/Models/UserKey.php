<?php

namespace App\Models;

use App\Support\UuidScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserKey extends Model {
    use HasFactory, UuidScopeTrait, SoftDeletes;

    protected $dates = [
        'deleted_at',
        'active_since',
        'active_till'
    ];

    protected $fillable = [
        'uuid',
        'number',
        'secret',
        'counter',
        'active_since',
        'active_till',
        'is_revoked'
    ];

    protected $hidden = [
        'secret',
        'counter',
        'number',
        'active_since',
        'active_till'
    ];


    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }



    public function getIsActiveAttribute(): bool {
        return now()->isBetween($this->active_since, $this->active_till) && !$this->is_revoked;
    }


    public function check($code): bool {
        if ($this->isActive) {
            $window = 1000;
            $first = $this->counter;
            $last = $this->counter + $window;
            while ($this->counter < $last) {
                $this->counter++;
                if ($this->generate($this->counter) === intval($code)) return $this->save();
            }
            $this->counter = $first;
        }
        return false;
    }

    public function generate($count, $digits = 6): int {
        $secretBinStr  = pack('H*', $this->secret);
        $sha1_hash = hash_hmac('sha1', pack("NN", 0, $count), $secretBinStr);
        $dwOffset = hexdec(substr($sha1_hash, -1, 1));
        $dbc1 = hexdec(substr($sha1_hash, $dwOffset * 2, 8));
        $dbc2 = $dbc1 & 0x7fffffff;
        return $dbc2 % pow(10, $digits);
    }

    public function getCode($digits = 6): string {
        $res = $this->generate(++$this->counter, $digits);
        while (strlen($res) < $digits) {
            $res = "0{$res}";
        }
        return trim($res);
    }



}
