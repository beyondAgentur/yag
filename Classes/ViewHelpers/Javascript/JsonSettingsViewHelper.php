<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2012 Daniel Lienert <typo3@lienert.cc>
*            
*           
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * This ViewHelper returns settings as JSON array
 *
 * @author Daniel Lienert <typo3@lienert.cc>
 * @package ViewHelpers
 * @subpackage Javascript
 * 
 */
class Tx_Yag_ViewHelpers_Javascript_JsonSettingsViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * @param string $tsPath
     * @param array $settings
     * @param boolean $onlyKeyValuePairs Only return the kex value pairs without the brackets
     * @return string
     */
    public function render($tsPath = '', $settings = null, $onlyKeyValuePairs = false)
    {
        $jsonCompliantSettings = array();

        if ($tsPath !== '') {
            $jsonCompliantSettings = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance()->getJSCompliantSettings($tsPath);
        } elseif ($settings !== null) {
            $jsonCompliantSettings = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance()->convertToJSCompliantSettings($settings);
        }

        $jsonSettings = json_encode($jsonCompliantSettings);

        if ($onlyKeyValuePairs) {
            $jsonSettings = substr($jsonSettings, 1, -1);
        }

        return $jsonSettings;
    }
}
