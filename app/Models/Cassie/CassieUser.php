<?php

namespace App\Models\Cassie;

use App\Enums\SearchEngines;
use App\Enums\UserPlatforms;
use Illuminate\Database\Eloquent\Casts\ArrayObject;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;

/**
 * @property int           $id
 * @property string        $name
 * @property string        $remember_token
 * @property string|Carbon $created_at
 * @property string|Carbon $updated_at
 * @property string        $shopify_access_token
 * @property UserPlatforms $platform
 * @property SearchEngines $current_engine
 * @property ArrayObject   $settings
 */
class CassieUser extends Authenticatable
{
    protected $connection = 'cassie';

    protected $table = 'users';
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'shopify_access_token',
        'platform',
        'current_engine',
        'settings',
    ];

    /**
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'platform'       => UserPlatforms::class,
            'current_engine' => SearchEngines::class,
            'settings'       => AsArrayObject::class,
        ];
    }
}
