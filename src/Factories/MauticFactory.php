<?php namespace Princealikhan\Mautic\Factories;

use Mautic\Auth\ApiAuth;

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

        return array_only($config, ['version','baseUrl', 'clientKey', 'clientSecret','callback']);
    }

    /**
     * Get the Mautic client.
     *
     * @param array $auth
     *
     * @return \Mautic\MauticApi
     */
    protected function getClient(array $setting)
    {
        session_name("mauticOAuth");
        session_start();

        // Initiate the auth object
        $auth = ApiAuth::initiate($setting);

        // Initiate process for obtaining an access token; this will redirect the user to the authorize endpoint and/or set the tokens when the user is redirected back after granting authorization

        if ($auth->validateAccessToken()) {
            if ($auth->accessTokenUpdated()) {
                $accessTokenData = $auth->getAccessTokenData();
                dd($accessTokenData);
                //store access token data however you want
            }
        }

    }
}
