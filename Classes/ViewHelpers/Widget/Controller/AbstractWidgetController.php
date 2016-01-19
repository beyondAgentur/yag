<?php
/***************************************************************
* Copyright notice
*
*   2010 Daniel Lienert <typo3@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
* All rights reserved
*
*
* This script is part of the TYPO3 project. The TYPO3 project is
* free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* The GNU General Public License can be found at
* http://www.gnu.org/copyleft/gpl.html.
*
* This script is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
* 
* @package ViewHelpers
* @subpackage Widget\Controller
* @author Daniel Lienert <typo3@lienert.cc>
*/

class Tx_Yag_ViewHelpers_Widget_Controller_AbstractWidgetController extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetController
{
    /**
     * Holds an instance of gallery context
     *
     * @var Tx_Yag_Domain_Context_YagContext
     */
    protected $yagContext;


    /**
     * @var Tx_Yag_Domain_Configuration_ConfigurationBuilder
     */
    protected $configurationBuilder;


    /**
     * @return void
     */
    public function initializeAction()
    {
        $this->yagContext = Tx_Yag_Domain_Context_YagContextFactory::getInstance();
        $this->configurationBuilder = $this->yagContext->getConfigurationBuilder();
    }
}
