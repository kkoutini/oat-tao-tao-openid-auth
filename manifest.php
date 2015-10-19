<?php
/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Copyright (c) 2014 (original work) Open Assessment Technologies SA;
 *
 *
 */

return array(
    'name' => 'taoOpenIDAuth',
	'label' => 'extension-tao-openid-auth',
	'description' => 'extension that allows login using OpenID accounts',
    'license' => 'GPL-2.0',
    'version' => '1.0.1',
	'author' => 'Sayeg',
	'requires' => array(
	   'tao' => '>=2.7.0',
	   'taoItems' => '>=2.6',
       'taoTests' => '*',
        'taoQtiTest' => '*'
    ),
	// for compatibility
	'dependencies' => array('tao', 'taoItems'),
	'managementRole' => 'http://www.tao.lu/Ontologies/generis.rdf#taoOpenIDAuthManager',
    'acl' => array(
        array('grant', 'http://www.tao.lu/Ontologies/generis.rdf#AnonymousRole', array('ext'=>'taoOpenIDAuth', 'mod' => 'OpenIDLogin')),

    ),
    'install' => array(
        'php' => array(
            dirname(__FILE__).'/scripts/install/setDataAccess.php',
        )
    ),
    'uninstall' => array(
        'php' => array(
            dirname(__FILE__).'/scripts/uninstall/unsetDataAccess.php',
        )
    ),
    'update' => 'oat\\taoOpenIDAuth\\scripts\\update\\Updater',
    'autoload' => array (
        'psr-4' => array(
            'oat\\taoOpenIDAuth\\' => dirname(__FILE__).DIRECTORY_SEPARATOR
        )
    ),
    'routes' => array(
        '/taoOpenIDAuth' => 'oat\\taoOpenIDAuth\\controller'
    ),
	'constants' => array(
	    # views directory
	    "DIR_VIEWS" => dirname(__FILE__).DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR,

		#BASE URL (usually the domain root)
		'BASE_URL' => ROOT_URL.'taoOpenIDAuth/',

        #BASE WWW the web resources path
        'BASE_WWW' => ROOT_URL.'taoOpenIDAuth/views/'
	),
    'extra' => array(
        'structures' => dirname(__FILE__).DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR.'structures.xml',
    )
);
