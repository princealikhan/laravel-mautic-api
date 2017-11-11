<?php namespace Princealikhan\Mautic\Factories;

use Mautic\Auth\OAuthClient;

class MauticFactory
{

    /**
     * Make a new Mautic client.
     *
     * @param array $config
     * @return \Mautic\Mautic
     */
    public function make(array $config)
    {
        $config = $this->getConfig($config);

        return $this->getClient($config);
    }

    /**
     * Get the configuration data.
     *
     * @param string[] $config
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    protected function getConfig(array $config)
    {
        $keys = ['clientKey', 'clientSecret'];

        foreach ($keys as $key) {
            if (!array_key_exists($key, $config)) {
                throw new \InvalidArgumentException('The Mautic client requires configuration.');
            }
        }

        return array_only($config, ['client_id', 'client_secret', 'access_token']);
    }

    /**
     * Get the Mautic client.
     *
     * @param array $auth
     *
     * @return \Mautic\MauticApi
     */
    protected function getClient(array $auth)
    {
        return new OAuthClient(
            $auth['public_key'],
            $auth['secret_key'],
            $auth['access_token']
        );
    }
}
