<?php

namespace App\Listeners;

use App\DTOs\ShopifyUserDto;
use App\Jobs\Cassie\UserSignUpJob;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Osiset\ShopifyApp\Messaging\Events\AppInstalledEvent;
use Osiset\ShopifyApp\Objects\Values\ShopId;

class AppInstalledListener implements ShouldQueue
{
    use Queueable;

    protected ShopId $shopId;

    public function __construct()
    {
    }

    public function handle(AppInstalledEvent $event): void
    {
        $user           = User::find($event->shopId->toNative());
        $shopifyUserDto = ShopifyUserDto::fromModel($user);

        UserSignUpJob::dispatch($shopifyUserDto);
    }
}
