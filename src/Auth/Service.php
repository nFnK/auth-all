<?php
/**
 * SocialConnect project
 * @author: Patsura Dmitry https://github.com/ovr <talk@dmtry.me>
 */

namespace SocialConnect\Auth;

use Exception;
use SocialConnect\Common\HttpClient;

/**
 * Class Service
 * @package SocialConnect\Auth
 */
class Service
{
    use HttpClient;

    /**
     * @var FactoryInterface
     */
    protected $factory;

    /**
     * @var array
     */
    protected $config;

    /**
     * @param array $config
     * @param null $factory
     * @internal param $storage
     */
    public function __construct(array $config, $factory = null)
    {
        $this->config = $config;
        $this->factory = is_null($factory) ? new CollectionFactory() : $factory;
    }

    /**
     * @param $name
     * @return array
     * @throws Exception
     */
    public function getProviderConfiguration($name)
    {
        if (isset($this->config['provider'][$name])) {
            return $this->config['provider'][$name];
        }

        throw new Exception('Please setup configuration for ' . ucfirst($name) . ' provider');
    }

    /**
     * Get provider class by $name
     *
     * @param $name
     * @return \SocialConnect\Provider\AbstractBaseProvider
     * @throws Exception
     */
    public function getProvider($name)
    {
        return $this->factory->factory($name, $this->getProviderConfiguration($name), $this);
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return FactoryInterface
     */
    public function getFactory()
    {
        return $this->factory;
    }
}
