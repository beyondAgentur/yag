<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <typo3@lienert.cc>, Michael Knoll <mimi@kaktsuteam.de>
*  All rights reserved
*
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
 * Class provides viewHelper to iterate through the custom meta data
 * 
 * @author Daniel Lienert <typo3@lienert.cc>
 * @package ViewHelpers
 */
class Tx_Yag_ViewHelpers_EachCustomMetaDataViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper
{
    /**
     * Initialize arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerTagAttribute('showEmptyFields', 'boolean', 'Show configured data fields that are not filled', false);
    }


    /**
     * @var Tx_Yag_Domain_Configuration_Item_CustomMetaConfigCollection
     */
    protected $definedCustomMetaDataConfigCollection;



    public function initialize()
    {
        parent::initialize();

        $this->definedCustomMetaDataConfigCollection = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance()->buildCustomMetaDataConfiguration();
    }


    /**
     * @param Tx_Yag_Domain_Model_Item $item
     * @return string
     */
    public function render(Tx_Yag_Domain_Model_Item $item)
    {
        $customMetaDataArray = $item->getItemMeta()->getCustomMetaDataArray();

        $content = '';

        if ((is_array($customMetaDataArray) && count($customMetaDataArray)) || $this->arguments['showEmptyFields']) {
            foreach ($this->definedCustomMetaDataConfigCollection as $customMetaDataKey => $customMetaDataConfig) {
                $customMetaData['config'] = $customMetaDataConfig;
                if (array_key_exists($customMetaDataKey, $customMetaDataArray)) {
                    $customMetaData['data'] = $customMetaDataArray[$customMetaDataKey];
                }

                $this->templateVariableContainer->add('customMetaData', $customMetaData);

                $content .= $this->renderChildren();

                $this->templateVariableContainer->remove('customMetaData');
            }
        }


        return $content;
    }
}
