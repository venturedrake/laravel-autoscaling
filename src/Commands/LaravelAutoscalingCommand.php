<?php

namespace VentureDrake\LaravelAutoscaling\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Laravel\Forge\Exceptions\RateLimitExceededException;
use Laravel\Forge\Forge;
use Linode\LinodeClient;

class LaravelAutoscalingCommand extends Command
{
    public $signature = 'autoscaling:run';

    public $description = 'Processes autoscaling events';

    public function handle(): int
    {
        $this->info('Laravel Autoscaling');

        $forge = new Forge(config('autoscaling.forge_api_token'));
        $client = new LinodeClient(config('autoscaling.linode_api_token'));
        $repository = $client->linodes;

        if (config('autoscaling.vertical.enabled')) {
            $this->info('Vertical scaling started...');

            try {
                $organization = $this->getForgeOrganization($forge);
            } catch (RateLimitExceededException $e) {
                return $this->handleRateLimitExceeded($e);
            }

            if (! $organization) {
                return self::FAILURE;
            }

            foreach (config('autoscaling.vertical.servers') as $serverName => $server) {
                $this->line('Vertically scaling '.$serverName);

                try {
                    $forgeServers = iterator_to_array($forge->servers($organization, [
                        'filter' => ['name' => $serverName],
                    ])->lazy(), false);
                } catch (RateLimitExceededException $e) {
                    return $this->handleRateLimitExceeded($e, $serverName);
                }

                foreach ($forgeServers as $forgeServer) {
                    if ($forgeServer->name == $serverName) {
                        if ($forgeServer->provider == 'akamai') {
                            $linode = $repository->find($forgeServer->identifier);

                            if (! $linode) {
                                $this->error('Linode not found: '.$forgeServer->identifier);

                                continue;
                            }

                            $this->line('Linode type: '.$linode->type);

                            $serverPeriodType = $this->getVerticalPeriodType($server);

                            if ($serverPeriodType) {
                                if ($linode->type != $serverPeriodType) {
                                    $response = Http::withToken(config('autoscaling.linode_api_token'))->post('https://api.linode.com/v4/linode/instances/'.$linode->id.'/resize', [
                                        'type' => $serverPeriodType,
                                        'allow_auto_disk_resize' => false,
                                        'migration_type' => 'warm',
                                    ]);

                                    if ($response->successful()) {
                                        $this->line('Linode resizing: '.$serverPeriodType);
                                    } else {
                                        $this->error('Linode resizing failed: '.$response->body());
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $this->info('Vertical scaling complete.');
        }

        return self::SUCCESS;
    }

    /**
     * Forge API v2 scopes all server endpoints to an organization.
     */
    protected function getForgeOrganization(Forge $forge): ?string
    {
        if ($organization = config('autoscaling.forge_organization')) {
            return $organization;
        }

        $organizations = $forge->organizations()->toArray();

        if (count($organizations) === 1) {
            return $organizations[0]->slug;
        }

        $this->error('Unable to determine the Forge organization. Set LARAVEL_AUTOSCALING_FORGE_ORGANIZATION to your organization slug.');

        return null;
    }

    protected function handleRateLimitExceeded(RateLimitExceededException $e, ?string $serverName = null): int
    {
        Log::warning('Autoscaling skipped: Forge API rate limit exceeded. Will retry on next scheduled run.', [
            'server' => $serverName,
            'message' => $e->getMessage(),
        ]);

        $this->warn('Forge API rate limit exceeded. Skipping this run.');

        return self::SUCCESS;
    }

    protected function getVerticalPeriodType($server): ?string
    {
        $hourly = $server['hourly'];
        $current = Carbon::now()->timezone(config('autoscaling.timezone'));

        if (isset($hourly[$current->format('Hi')])) {
            return $hourly[$current->format('Hi')];
        }

        $i = 1;
        while ($i <= 1440) {
            $current = $current->subMinutes(1);

            if (isset($hourly[$current->format('Hi')])) {
                return $hourly[$current->format('Hi')];
            }

            $i++;
        }

        return null;
    }
}
