<?php namespace Princealikhan\Mautic;

use Princealikhan\Mautic\Factories\MauticFactory;
use GrahamCampbell\Manager\AbstractManager;
use Illuminate\Contracts\Config\Repository;
use Mautic\Auth\OAuthClient;

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

}



