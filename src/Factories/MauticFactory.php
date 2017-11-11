<?php namespace Princealikhan\Mautic\Factories;

<<<<<<< HEAD
use Mautic\Auth\OAuthClient;
=======
use Mautic\Auth\ApiAuth;
use Mautic\Auth\OAuthClient;
use Princealikhan\Mautic\Models\MauticConsumer;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

>>>>>>> origin/master

class MauticFactory
{

    /**
<<<<<<< HEAD
     * Make a new Mautic client.
     *
     * @param array $config
     * @return \Mautic\Mautic
     */
    public function make(array $config)
    {
        $config = $this->getConfig($config);

=======
     * Make a new Mautic url.
     *
     * @param string $endpoints
     * @return url
     */
    protected function getMauticUrl($endpoints=null)
    {
        if(!empty($endpoints))
            return config('mautic.connections.main.baseUrl').'/'.$endpoints;
        else
            return config('mautic.connections.main.baseUrl').'/';

    }

    /**
     * Check AccessToken Expiration Time
     * @param $expireTimestamp
     * @return bool
     */
    public function checkExpirationTime($expireTimestamp)
    {
        $now = time();
        if($now > $expireTimestamp)
            return true;
        else
            return false;

    }
    /**
     * Make a new Mautic client.
     *
     * @param array $config
     * @return \Mautic\Config
     */
    public function make(array $config)
    {

        $config = $this->getConfig($config);
>>>>>>> origin/master
        return $this->getClient($config);
    }

    /**
     * Get the configuration data.
     *
<<<<<<< HEAD
     * @param string[] $config
=======
     * @param array $config
>>>>>>> origin/master
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

<<<<<<< HEAD
        return array_only($config, ['client_id', 'client_secret', 'access_token']);
=======
        return array_only($config, ['version','baseUrl', 'clientKey', 'clientSecret','callback']);
>>>>>>> origin/master
    }

    /**
     * Get the Mautic client.
     *
<<<<<<< HEAD
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
=======
     * @param array $setting
     *
     * @return \Mautic\MauticConsumer
     */
    protected function getClient(array $setting)
    {
        session_name("mauticOAuth");
        session_start();

        // Initiate the auth object
        $auth = ApiAuth::initiate($setting);
        // Initiate process for obtaining an access token; this will redirect the user to the authorize endpoint and/or set the tokens when the user is redirected back after granting authorization

        if ($auth->validateAccessToken())
        {
            if ($auth->accessTokenUpdated()) {
                $accessTokenData = $auth->getAccessTokenData();
                return  MauticConsumer::create($accessTokenData);
            }
        }

    }


    /**
     * Call Mautic Api
     *
     * @throws \ClientException
     *
     * @param $method
     * @param $endpoints
     * @param $body
     * @param $token
     *
     * @return mixed
     */
    public function callMautic($method, $endpoints, $body, $token)
    {

        $mauticURL = $this->getMauticUrl('api/'.$endpoints);

        $params = array();
        if(!empty($body)){
            $params = array();
            foreach ($body as $key => $item){
                $params['form_params'][$key] = $item;
            }
        }

        $headers = array('headers' => ['Authorization' => 'Bearer '. $token]);
        $client = new Client($headers);
        try {

            $response = $client->request($method,$mauticURL,$params);
            $responseBodyAsString = $response->getBody();

            return json_decode($responseBodyAsString,true);
        }
        catch (ClientException $e) {
             $exceptionResponse = $e->getResponse();
             return $statusCode = $exceptionResponse->getStatusCode();
        }
    }


    /**
     * Generate new token once old one expire
     * and store in consumer table.
     *
     * @throws \ClientException
     *
     * @param $refreshToken
     *
     * @return MauticConsumer
     */
    public function refreshToken($refreshToken)
    {
        $mauticURL = $this->getMauticUrl('oauth/v2/token');
        $config = config('mautic.connections.main');

        $client = new Client();

        try {
            $response = $client->request('POST',$mauticURL,array(
                'form_params' => [
                    'client_id'     => $config['clientKey'],
                    'client_secret' => $config['clientSecret'],
                    'redirect_uri'  => $config['callback'],
                    'refresh_token' => $refreshToken,
                    'grant_type'    => 'refresh_token'
                ]));
            $responseBodyAsString = $response->getBody();
            $responseBodyAsString = json_decode($responseBodyAsString,true);

            return MauticConsumer::create([
                'access_token'  => $responseBodyAsString['access_token'],
                'expires'       => time() + $responseBodyAsString['expires_in'],
                'token_type'    => $responseBodyAsString['token_type'],
                'refresh_token' => $responseBodyAsString['refresh_token']
            ]);
        }
        catch (ClientException $e) {
           return $exceptionResponse = $e->getResponse();
        }
>>>>>>> origin/master
    }
}
