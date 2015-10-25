<?php
/**
 * Created by PhpStorm.
 * User: khaled
 * Date: 10/19/15
 * Time: 11:04 AM
 */

namespace oat\taoOpenIDAuth\model;

class OpenIDUser extends \common_user_User
{

    private $userResource;

    private $cache;

    public function __construct(\core_kernel_classes_Resource $user)
    {
        $this->userResource = $user;
        // load datalanguage to prevent cycle later on
        $this->getPropertyValues(PROPERTY_USER_DEFLG);
    }

    public function getIdentifier()
    {
        return $this->userResource->getUri();
    }

    // private $cache = array();
    private function getUserResource()
    {
        return new \core_kernel_classes_Resource($this->getIdentifier());
    }

    public function getPropertyValues($property)
    {
        //PROPERTY_USER_ROLES
        if (! isset($this->cache[$property])) {
            $this->cache[$property] = $this->getUncached($property);
        }
        return $this->cache[$property];

    }

    private function getUncached($property)
    {
        $value = array();
        switch ($property) {
            case PROPERTY_USER_DEFLG:
            case PROPERTY_USER_UILG:
                $resource = $this->getUserResource()->getOnePropertyValue(new \core_kernel_classes_Property($property));
                if (!is_null($resource)) {
                    if ($resource instanceof \core_kernel_classes_Resource) {
                        return array($resource->getUniquePropertyValue(new \core_kernel_classes_Property(RDF_VALUE)));
                    } else {
                        common_Logger::w('Language '.$resource.' is not a resource');
                        return array(DEFAULT_LANG);
                    }
                } else {
                    return array(DEFAULT_LANG);
                }
                break;
            case PROPERTY_USER_ROLES:
                return array("http://www.tao.lu/Ontologies/TAOItem.rdf#TestAuthor","http://www.tao.lu/Ontologies/TAOItem.rdf#ItemAuthor");
            case "http://www.tao.lu/Ontologies/TAO.rdf#FirstTimeInTao":


                return array("http://www.tao.lu/Ontologies/generis.rdf#False");
            case "http://www.tao.lu/Ontologies/TAO.rdf#LastExtensionUsed":
                return array("tao/Main/index?structure=items&ext=taoItems");

            default:
                return $this->getUserResource()->getPropertyValues(new \core_kernel_classes_Property($property));
        }
    }

    public function refresh() {
        $this->cache = array(
            PROPERTY_USER_DEFLG => $this->getUncached(PROPERTY_USER_DEFLG)
        );
        return true;
    }

}