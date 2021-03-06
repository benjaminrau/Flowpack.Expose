<?php
namespace Flowpack\Expose\Routing;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flowpack.Expose".       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

class ExposeRoutePartHandler extends \TYPO3\Flow\Mvc\Routing\DynamicRoutePart {

    /**
     * Checks whether the current URI section matches the configured RegEx pattern.
     *
     * @param string $requestPath value to match, the string to be checked
     * @return boolean TRUE if value could be matched successfully, otherwise FALSE.
     */
    protected function matchValue($requestPath) {
        preg_match('/(.+):(.+)/', $requestPath, $match);
        if (count($match) < 2) {
            return FALSE;
        }
        $className = str_replace('.', '\\', '\\' . $match[1] . '\\Domain\Model\\' . $match[2]);
        if (!class_exists($className)) {
            return FALSE;
        }
        $this->value = $className;
        return TRUE;
    }

    /**
     * Checks whether the route part matches the configured RegEx pattern.
     *
     * @param string $value The route part (must be a string)
     * @return boolean TRUE if value could be resolved successfully, otherwise FALSE.
     */
    protected function resolveValue($value) {
        if (!is_string($value)) {
            return FALSE;
        }

        preg_match('/(.+)\\\\Domain\\\\Model\\\\(.+)/', ltrim($value, '\\'), $match);
        $this->value = str_replace('\\', '.', $match[1] . ':' . $match[2]);
        return TRUE;
    }

}