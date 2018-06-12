<?php

namespace Adams\Cloudflare;

class TrustProxiesLoader
{
    /**
     * Constant flags used to determine
     * proxy IP address version.
     */
    const IP_VERSION_4 = (1 << 0);
    const IP_VERSION_6 = (1 << 1);
    const IP_VERSION_ANY = self::IP_VERSION_4 | self::IP_VERSION_6;

    /**
     * Get addresses from Cloudflare server.
     * 
     * @param integer $type
     * @return array
     */
    public function load($type = self::IP_VERSION_ANY)
    {
        $proxies = [];

        if ($type & self::IP_VERSION_4) {
            $proxies = $this->request('ips-v4');
        }

        if ($type & self::IP_VERSION_6) {
            $proxies = array_merge($proxies, $this->request('ips-v6'));
        }

        return $proxies;
    }

    /**
     * Send HTTP request to Cloudflare and 
     * receive actual list of proxy addresses.
     * 
     * @param string $uri
     * @return array
     */
    protected function request($uri)
    {
        $contents = file_get_contents('https://www.cloudflare.com/' . $uri);

        if ($contents === false) {
            throw new \ErrorException('Failed to load trust proxies from Cloudflare server.');
        }

        return array_filter(
            explode("\n", $contents)
        );
    }
}