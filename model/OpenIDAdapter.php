<?php
/**
 * Created by PhpStorm.
 * User: khaled
 * Date: 10/18/15
 * Time: 4:14 PM
 */


namespace oat\taoOpenIDAuth\model;
use core_kernel_users_Service;
use core_kernel_users_InvalidLoginException;
use oat\taoOpenIDAuth\model\User;
use oat\oatbox\user\auth\LoginAdapter;
use common_persistence_Manager;
/**
 * Adapter to authenticate users stored in the Ldap implementation
 *
 * @author Christophe Massin <christope@taotesting.com>
 *
 */
class OpenIDAdapter implements LoginAdapter
{
    /** @var  $username string */
    private $username;
    /** @var  $password string */
    private $password;
    /** @var $configuration array $configuration  */
    protected $configuration;
    /** @var $mapping array $mapping  */
    protected $mapping;

    public function setOptions(array $options)
    {

    }
    /**
     * Create an adapter from the configuration
     *
     * @param array $configuration
     * @return oat\taoOpenIDAuth\model\OpenIDAdapter
     */
    public static function createFromConfig(array $configuration) {
        return new self($configuration);
    }
    /**
     * @param array $configuration
     */
    public function __construct(array $configuration) {
        $this->configuration = $configuration;
        $this->adapter->setOptions($configuration['config']);
        $this->setMapping($configuration['mapping']);
    }
    /**
     * Set the credential
     *
     * @param string $login
     * @param string $password
     */
    public function setCredentials($login, $password){
        $this->username = $login;
        $this->password = $password;
    }
    public function authenticate() {
        $adapter = null;
        $adapter->setUsername($this->getUsername());
        $adapter->setPassword($this->getPassword());
        $result = $adapter->authenticate();
        if($result->isValid()){
            $result = $adapter->getAccountObject();
            $params = get_object_vars($result);
            $user = new User($this->getMapping());
            $user->setUserRawParameters($params);
            return $user;
        } else {
            throw new core_kernel_users_InvalidLoginException();
        }
    }

    /**
     * @param array $configuration
     */
    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;
    }
    /**
     * @return array
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }
    /**
     * @param array $mapping
     */
    public function setMapping($mapping)
    {
        $this->mapping = $mapping;
    }
    /**
     * @return array
     */
    public function getMapping()
    {
        return $this->mapping;
    }
    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }
    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
}