<?php

namespace Foo\ContentManagement\ViewHelpers\Query;

/*                                                                        *
 * This script belongs to the FLOW3 framework.                            *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use Doctrine\ORM\Mapping as ORM;
use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * @version $Id: ForViewHelper.php 3346 2009-10-22 17:26:10Z k-fish $
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @api
 * @FLOW3\Scope("prototype")
 */
class SearchViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper {
	/**
	 * @var \Foo\ContentManagement\Core\ConfigurationManager
	 * @FLOW3\Inject
	 */
	protected $configurationManager;
	
	/**
	 * @var \Foo\ContentManagement\Core\Helper
	 * @author Marc Neuhaus <apocalip@gmail.com>
	 * @FLOW3\Inject
	 */
	protected $helper;
	
	/**
	 *
	 * @param mixed $objects
	 * @param string $as
	 * @param string $searchAs
	 * @return string Rendered string
	 * @author Marc Neuhaus <apocalip@gmail.com>
	 * @api
	 */
	public function render($objects = null, $as = "matchingObjects", $searchAs = "search") {
		$this->objects = $objects;
		$this->query = $objects->getQuery();
		
		$this->request = $this->controllerContext->getRequest();
		
		$search = $this->handleSearch();
		
		$this->templateVariableContainer->add($searchAs, $search);
		$this->templateVariableContainer->add($as, $this->query->execute());
		$content = $this->renderChildren();
		$this->templateVariableContainer->remove($searchAs);
		$this->templateVariableContainer->remove($as);
		
		return $content;
	}
	
	public function handleSearch(){
		if( $this->request->hasArgument("search") ) {
			$search = $this->request->getArgument("search");
			$configuration = $this->configurationManager->getClassConfiguration($this->query->getType());
			$searchProviderClass = strval(current($configuration["searchProvider"]));
			$searchProvider = new $searchProviderClass();
			$this->query = $searchProvider->search($search, $this->query);
			return $search;
		}else{
			return "";
		}
	}
}

?>