<?php

namespace App\Providers;

use App\Models\Document;
use App\Policies\DocumentPolicy;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Document::class => DocumentPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}