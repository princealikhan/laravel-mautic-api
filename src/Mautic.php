<?php namespace Princealikhan\Mautic;

use Princealikhan\Mautic\Factories\MauticFactory;
use GrahamCampbell\Manager\AbstractManager;
use Illuminate\Contracts\Config\Repository;
use Mautic\Auth\OAuthClient;
use Princealikhan\Mautic\Models\MauticConsumer;

class Mautic extends AbstractManager
{

    /**
     * The factory instance.
     *
     * @var \Mautic\Factory
     */
    protected $factory;

    /**
     * Create a new Mautic manager instance.
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
     * @return \Mautic\MauticFactory
     */
    public function getFactory()
    {
        return $this->factory;  
    }

    /**
     * @param null $method
     * @param null $endpoints
     * @param null $body
     * @return mixed
     */
    public function request($method=null, $endpoints=null, $body=null)
    {

        $consumer = MauticConsumer::whereNotNull('id')
            ->orderBy('created_at', 'desc')
            ->first();

        $expirationStatus = $this->factory->checkExpirationTime($consumer->expires);

        if($expirationStatus==true){
            $newToken   =  $this->factory->refreshToken($consumer->refresh_token);
            return $this->factory->callMautic($method,$endpoints,$body,$newToken->access_token);
        } else{
            return $this->factory->callMautic($method,$endpoints,$body,$consumer->access_token);
        }
    }

}
