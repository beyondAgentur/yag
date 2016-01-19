<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2011 Michael Knoll <mimi@kaktusteam.de>
*           Daniel Lienert <typo3@lienert.cc>
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
 * Repository for Tx_Yag_Domain_Model_Album
 *
 * @package Domain
 * @subpackage Repository
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @author Daniel Lienert <typo3@lienert.cc>
 */
class Tx_Yag_Domain_Repository_AlbumRepository extends Tx_Yag_Domain_Repository_AbstractRepository
{
    /**
     * Adds a new album to repository
     *
     * @param Tx_Yag_Domain_Model_Album $album
     */
    public function add($album)
    {
        if (!$album->getSorting()) {
            $sorting = 0;

            if ($album->getGallery()->getAlbums()->count() > 0) {
                $sorting = $album->getGallery()->getAlbums()->current()->getSorting();
            }

            $album->setSorting($sorting + 1);
        }
        parent::add($album);
    }


    /**
     * This method keeps translated items in sync when properties of the original items (sorting / delete)
     * was changed in the gallery module.
     */
    public function syncTranslatedAlbums()
    {
        $this->persistenceManager->persistAll();

        $this->createQuery()->statement(
            'UPDATE tx_yag_domain_model_album translatedAlbum
			INNER JOIN tx_yag_domain_model_album parentAlbum ON translatedAlbum.l18n_parent = parentAlbum.uid
			SET translatedAlbum.sorting = parentAlbum.sorting, translatedAlbum.deleted = parentAlbum.deleted
			WHERE translatedAlbum.l18n_parent != 0
			AND (translatedAlbum.sorting != parentAlbum.sorting OR translatedAlbum.deleted != parentAlbum.deleted);
		')->execute();
    }


    /**
     * This is a patch for TYPO3 6.2 - can be removed for
     * TYPO3 7.0 - see parents class method
     *
     * @param int $identifier
     * @param bool $ignoreEnableFields
     * @return Tx_Yag_Domain_Model_Album
     */
    public function findByUid($identifier, $ignoreEnableFields = false)
    {
        if (Tx_PtExtbase_Div::isMinTypo3Version(7)) {
            return parent::findByUid($identifier);
        }

        if ($this->session->hasIdentifier($identifier, $this->objectType)) {
            $object = $this->session->getObjectByIdentifier($identifier, $this->objectType);
        } else {
            $query = $this->createQuery();
            $query->getQuerySettings()->setRespectStoragePage(false);
            $query->getQuerySettings()->setRespectSysLanguage(false);
            $query->getQuerySettings()->setIgnoreEnableFields($ignoreEnableFields);

            $object = $query->matching($query->equals('uid', $identifier))->execute()->getFirst();
        }

        return $object;
    }
}
