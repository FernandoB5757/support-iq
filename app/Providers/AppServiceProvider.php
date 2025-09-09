<?php

namespace App\Providers;

use App\Contracts\OpenAICreator;
use App\Models\Ticket;
use App\Service\OpenAITicketCreator;
use App\Service\OpenAITicketCreatorFaker;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (config('openai.classify_enabled')) {
            $this->app->scoped(OpenAICreator::class, OpenAITicketCreator::class);
        } else {
            $this->app->scoped(OpenAICreator::class, OpenAITicketCreatorFaker::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->ip());
        });

        RateLimiter::for('api.openai', function (Request $request) {

            if ($request->routeIs('tickets.classify')) {
                $ticket = Ticket::query()
                    ->select('id')
                    ->toBase()
                    ->firstOrFail($request->route('ticket'));

                return Limit::perDay(1)
                    ->by($ticket->id);
            }

            return Limit::perMinute(60)->by($request->ip());
        });
    }
}
