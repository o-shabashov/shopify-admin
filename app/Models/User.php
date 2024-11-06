<?php

namespace App\Models;

use App\Models\Cassie\CassieUser;
use App\Orchid\Presenters\UserPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Orchid\Access\UserAccess;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;
use Osiset\ShopifyApp\Contracts\ShopModel as IShopModel;
use Osiset\ShopifyApp\Traits\ShopModel;

/**
 * @property int $shopify_id
 * @method static CassieUser cassieUser()
 * @property CassieUser $cassieUser
 */
class User extends Authenticatable implements IShopModel
{
    use HasFactory, Notifiable;

    // Shopify
    use ShopModel;

    // Orchid admin platform
    use AsSource, Chartable, Filterable, UserAccess;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'shopify_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
        'permissions',
    ];


    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected array $allowedFilters = [
        'id'         => Where::class,
        'name'       => Like::class,
        'email'      => Like::class,
        'updated_at' => WhereDateStartEnd::class,
        'created_at' => WhereDateStartEnd::class,
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected array $allowedSorts = [
        'id',
        'name',
        'email',
        'updated_at',
        'created_at',
    ];

    public function hasAnyAccess(): true
    {
        return true;
    }

    public function hasAccess(): true
    {
        return true;
    }

    /**
     * @return UserPresenter
     */
    public function presenter(): UserPresenter
    {
        return new UserPresenter($this);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'permissions'       => 'array',
        ];
    }

    public function cassieUser(): HasOne
    {
        return $this->hasOne(CassieUser::class, 'id', 'cassie_id');
    }
}
