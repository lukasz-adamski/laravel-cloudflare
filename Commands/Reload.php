<?php

namespace Adams\Cloudflare\Commands;

use Cache;
use Adams\Cloudflare\TrustProxiesLoader;
use Illuminate\Console\Command;

class Reload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cloudflare:reload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reload trust proxies IPs and store in cache.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Cache::forever(
            'cloudflare.proxies', 
            (new TrustProxiesLoader())->load()
        );
    }
}
