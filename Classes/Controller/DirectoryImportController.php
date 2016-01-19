<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Michael Knoll <mimi@kaktusteam.de>, MKLV GbR
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

namespace DL\Yag\Controller;

use DL\Yag\Domain\FileSystem\Div;
use DL\Yag\Domain\Import\DirectoryImporter\ImporterBuilder;
use DL\Yag\Domain\Model\Album;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Class implements an controller for importing images from a directory
 * 
 * @package Controller
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class DirectoryImportController extends AbstractController
{
    /**
     * Shows import form for selecting directory to import images from
     *
     * @param string $directory Directory to show initially
     * @return string The HTML source for import form
     * @rbacNeedsAccess
     * @rbacObject Album
     * @rbacAction edit
     */
    public function showImportFormAction($directory='')
    {
        $albums = $this->albumRepository->findAll();
        $this->view->assign('pageId', $_GET['id']);
        $this->view->assign('albums', $albums);
        $this->view->assign('directory', $directory);
    }
    
    
    
    /**
     * Shows results for importing images from directory
     *
     * @param string $directory
     * @param Album $album
     * @param bool $crawlRecursive If set to true, subdirs will also be crawled
     * @param bool $noDuplicates If set to true, items that are already imported to album won't be imported twice
     * @return string The HTML source for import from directory action
     * @rbacNeedsAccess
     * @rbacObject Album
     * @rbacAction edit
     */
    public function importFromDirectoryAction($directory, Album $album, $crawlRecursive = false, $noDuplicates = false)
    {
        // Directory must be within fileadmin
        $directory = Div::getT3BasePath() . $directory;

        $importer = ImporterBuilder::getInstance()->getInstanceByDirectoryAndAlbum($directory, $album);
        $importer->setNoDuplicates($noDuplicates);
        $importer->setCrawlRecursive($crawlRecursive);
        $importer->runImport();

        $this->addFlashMessage( LocalizationUtility::translate('tx_yag_controller_directoryimportcontroller_importfromdirectory.importsuccessfull', $this->extensionName, array($importer->getItemsImported())),
            '',
            FlashMessage::OK);
        $this->yagContext->setAlbum($album);
        $this->forward('list', 'ItemList');
    }
}
