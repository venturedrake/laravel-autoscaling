<?php

namespace VentureDrake\LaravelAutoscaling\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
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

            foreach (config('autoscaling.vertical.servers') as $serverName => $server) {
                $this->line('Vertically scaling '.$serverName);

                foreach ($forge->servers() as $forgeServer) {
                    if ($forgeServer->name == $serverName) {
                        if ($forgeServer->provider == 'akamai') {
                            $linode = $repository->find($forgeServer->identifier);

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

    protected function getVerticalPeriodType($server)
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
    }
}
