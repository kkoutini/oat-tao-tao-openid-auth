<?php
/**
 * Created by PhpStorm.
 * User: khaled
 * Date: 10/18/15
 * Time: 4:12 PM
 */


namespace oat\taoOpenIDAuth\model;
use common_user_User;
use core_kernel_classes_Resource;
use core_kernel_classes_Property;
use common_Logger;
class ComplexUser extends common_user_User {
    /** @var  array of configuration */
    protected $configuration;
    /**
     * @var array
     */
    protected $userRawParameters;
    /**
     * @var array
     */
    protected $userExtraParameters = array();
    /**
     * @var string
     */
    protected $identifier;
    /** @var  array $roles */
    protected $roles;
    /**
     * Array that contains the language code as a single string
     *
     * @var array
     */
    protected $languageUi = array(DEFAULT_LANG);
    /**
     * Array that contains the language code as a single string
     *
     * @var array
     */
    protected $languageDefLg = array(DEFAULT_LANG);
    /**
     * The mapping of custom parameter from ldap to TAO property
     *
     * @var array
     */
    protected $mapping;
    public function __construct(array $mapping = null){
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
     * Sets the language URI
     *
     * @param string $languageDefLgUri
     */
    public function setLanguageDefLg($languageDefLgUri)
    {
        $this->languageDefLg = array((string)$languageDefLgUri);
        return $this;
    }
    /**
     * Returns the language code
     *
     * @return array
     */
    public function getLanguageDefLg()
    {
        return $this->languageDefLg;
    }
    /**
     * @param $property string
     * @param $value string
     */
    public function setUserParameter($property, $value){
        $this->userRawParameters[$property] = $value;
    }
    public function getUserParameter($property) {
        if (isset ($this->userRawParameters[$property] ) )
            return $this->userRawParameters[$property];
        return null;
    }
    /**
     * @param array $params
     * @return AuthKeyValueUser
     */
    public function setUserRawParameters(array $params)
    {
        $this->setRoles(array('http://www.tao.lu/Ontologies/TAO.rdf#DeliveryRole'));
        // initialize parameter that should be set
        isset($params['preferredlanguage']) ? $this->setLanguageUi($params['preferredlanguage']) : DEFAULT_LANG;
        isset($params['preferredlanguage']) ? $this->setLanguageDefLg($params['preferredlanguage']) : DEFAULT_LANG;
        isset($params['mail']) ? $this->setUserParameter(PROPERTY_USER_MAIL, $params['mail']) : '';
        isset($params['displayname']) ? $this->setUserParameter(PROPERTY_USER_LASTNAME, $params['displayname']) : $this->setUserParameter(PROPERTY_USER_LASTNAME, $params['cn']) ;
        $mapping = $this->getMapping();
        foreach($params as $key => $value) {
            if(! in_array($key, array('preferredlanguage','mail', 'displayname'))) {
                if(array_key_exists($key, $mapping)){
                    $this->setUserParameter($mapping[$key], $value);
                }
            }
        }
        return $this;
    }
    /**
     * @return array
     */
    public function getUserRawParameters()
    {
        return $this->userRawParameters;
    }
    /**
     * @param mixed $language
     */
    public function setLanguageUi($languageUri)
    {
        $this->languageUi = array((string)$languageUri);
        return $this;
    }
    /**
     * @return array
     */
    public function getLanguageUi()
    {
        return $this->languageUi;
    }
    /**
     * @return string
     */
    public function getIdentifier(){
        return $this->identifier;
    }
    /**
     * @param $identifier
     * @return $this
     */
    public function setIdentifier($identifier){
        $this->identifier = $identifier;
        return $this;
    }
    /**
     * @param $property string
     * @return array|null
     */
    public function getPropertyValues($property)
    {
        $returnValue = null;
        switch ($property) {
            case PROPERTY_USER_DEFLG :
                $returnValue = $this->getLanguageDefLg();
                break;
            case PROPERTY_USER_UILG :
                $returnValue = $this->getLanguageUi();
                break;
            case PROPERTY_USER_ROLES :
                $returnValue = $this->getRoles();
                break;
            default:
                $returnValue = array($this->getUserParameter($property));
        }
        return $returnValue;
    }
    /**
     * Function that will refresh the parameters.
     */
    public function refresh() {
    }
    /**
     * @return array
     */
    public function getRoles() {
        return $this->roles;
    }
    /**
     * @param array $roles
     * @return $this
     */
    public function setRoles(array $roles ) {
        $this->roles = $roles;
        return $this;
    }
}