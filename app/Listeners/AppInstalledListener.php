<?php

namespace App\Listeners;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
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
        Log::info($this->shopId->toNative());
    }
}
