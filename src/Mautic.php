<?php namespace Princealikhan\Mautic;

use Princealikhan\Mautic\Factories\MauticFactory;
use GrahamCampbell\Manager\AbstractManager;
use Illuminate\Contracts\Config\Repository;
use Mautic\Auth\ApiAuth;
use Mautic\Auth\OAuthClient;



class Mautic extends AbstractManager
{

    /**
     * The factory instance.
     *
     * @var \Vinkla\Vimeo\Factories\VimeoFactory
     */
    protected $factory;

    /**
     * Create a new Vimeo manager instance.
     *
     * @param $config
     * @param $factory
     *
     * @return void
     */
    public function __construct(Repository $config, MauticFactory $factory)
    {
        parent::__construct($config);

        $this->factory = $factory;
    }

    /**
     * Create the connection instance.
     *
     * @param array $config
     *
     * @return mixed
     */
    protected function createConnection(array $config)
    {
        return $this->factory->make($config);
    }

    /**
     * Get the configuration name.
     *
     * @return string
     */
    protected function getConfigName()
    {
        return 'mautic';
    }

    /**
     * Get the factory instance.
     *
     * @return \Vinkla\Vimeo\Factories\VimeoFactory
     */
    public function getFactory()
    {
        return $this->factory;  
    }

    public function test()
    {
        session_name("oauthtester");
        session_start();
        $callback= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $settings = array(
            'base_url'      => env('MAUTIC_BASE_URL','http://mautic.dev'),
            'clientKey'    => env('MAUTIC_PUBLIC_KEY','5onittxoj30gwco0csc4g4sk4okckwgsg448wkcw0okoscgkwo'),
            'clientSecret'    => env('MAUTIC_SECRET_KEY','zq1a54bmcis4ggkkkgwswcs4kk8k4ko0cs8sgkgkok4wg8cwo'),
            'callback'      => env('MAUTIC_CALLBACK',$callback),

            'version'          => 'OAuth1a', // Version of the OAuth can be OAuth2 or OAuth1a. OAuth2 is the default value.

        );


        // If you already have the access token, et al, pass them in as well to prevent the need for reauthorization
//        $settings['accessToken']        = $accessToken;
//        $settings['accessTokenSecret']  = $accessTokenSecret; //for OAuth1.0a
//        $settings['accessTokenExpires'] = $accessTokenExpires; //UNIX timestamp
//        $settings['refreshToken']       = $refreshToken;


        // Initiate the auth object
        $auth = \Mautic\Auth\ApiAuth::initiate($settings);

        return $auth->validateAccessToken();
//        $initAuth = new ApiAuth();
//        $auth = $initAuth->newAuth($settings);


        try {
            if ($auth->validateAccessToken()) {

                // Obtain the access token returned; call accessTokenUpdated() to catch if the token was updated via a
                // refresh token

                // $accessTokenData will have the following keys:
                // For OAuth1.0a: access_token, access_token_secret, expires
                // For OAuth2: access_token, expires, token_type, refresh_token

                if ($auth->accessTokenUpdated()) {
                    return $accessTokenData = $auth->getAccessTokenData();

                    //store access token data however you want
                }
            }
        } catch (Exception $e) {
            // Do Error handling
            return $e;
        }

    }
//	public function test(){
//        $settings = array(
//            'baseUrl'          => 'http://mautic.dev',       // Base URL of the Mautic instance
//            'version'          => 'OAuth', // Version of the OAuth can be OAuth2 or OAuth1a. OAuth2 is the default value.
//            'clientKey'        => '5onittxoj30gwco0csc4g4sk4okckwgsg448wkcw0okoscgkwo',       // Client/Consumer key from Mautic
//            'clientSecret'     => 'zq1a54bmcis4ggkkkgwswcs4kk8k4ko0cs8sgkgkok4wg8cwo',       // Client/Consumer secret key from Mautic
//            'callback'         => 'http://mautic.dev/callback'        // Redirect URI/Callback URI for this script
//        );
//
//
//        $auth =   \Mautic\Auth\ApiAuth::initiate(array('OAuth'));
//
//        $auth->newAuth($settings);
//        try {
//            if ($auth->validateAccessToken()) {
//
//                // Obtain the access token returned; call accessTokenUpdated() to catch if the token was updated via a
//                // refresh token
//
//                // $accessTokenData will have the following keys:
//                // For OAuth1.0a: access_token, access_token_secret, expires
//                // For OAuth2: access_token, expires, token_type, refresh_token
//
//                if ($auth->accessTokenUpdated()) {
//                    $accessTokenData = $auth->getAccessTokenData();
//
//                    //store access token data however you want
//                }
//            }
//        } catch (Exception $e) {
//            echo 'saldfjksld';
//
//            // Do Error handling
//        }
//        dd($auth);
//		return array('test' => 'asdf');;
//	}
}



