<?php

namespace Foo\ContentManagement\OptionsProvider;

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
 * TODO: (SK) what are "Option Providers" in general?
 * 		 (MN) An OptionsProvider is used for FormElements like Select and such to provide Options :)
 *   		  This on uses an RegEx from the Annotation to match Constants in the same class.
 *      	  Example:
 *        		    TYPO3\Party\Domain\Model\ElectronicAddress:
 *                		Properties:
 *                  		type:
 *                    			Widget: TYPO3.Form:SingleSelectDropdown
 *                       		OptionsProvider: 
 *                         			Name: ConstOptionsProvider
 *                            		RegEx: TYPE_.+
 *
 * OptionsProvider for constants
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @author Marc Neuhaus <marc@mneuhaus.com>
 */
class ConstOptionsProvider extends \Foo\ContentManagement\Core\OptionsProvider\AbstractOptionsProvider {

	public function getOptions(){
		$reflection = new \ReflectionClass($this->annotations->getClass());
		$constants = $reflection->getConstants();
		$regex = $this->annotations->getOptionsProvider()->regex;
		foreach ($constants as $key => $value) {
			if(!preg_match("/".$regex."/", $key))
				unset($constants[$key]);
		}
		return $constants;
	}
}

?>