<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2013 Daniel Lienert <typo3@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Reports\Status;

/**
 * Class implements a status report checking filesystem for required directories and settings
 *
 * @author Michael Knoll
 * @package Report
 */
class Tx_Yag_Report_Filesystem implements \TYPO3\CMS\Reports\StatusProviderInterface
{
    protected $reports = array();

    /**
     * Returns status of filesystem
     *
     * @return    array    An array of \TYPO3\CMS\Reports\Status objects
     */
    public function getStatus()
    {
        $this->reports = array();
        $this->checkOrigsDirectory();
        $this->checkYagTmpDirectory();

        return $this->reports;
    }


    /**
     * Checks whether yag origs directory exists and is writable
     *
     * @return void
     */
    protected function checkOrigsDirectory()
    {
        $extConfSettings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['yag']);
        if (array_key_exists('origFilesRoot', $extConfSettings)) {
            $this->reports[] = GeneralUtility::makeInstance('TYPO3\\CMS\\Reports\\Status',
                'Filesystem',
                'Original files root is set',
                'Setting for original files root is available.',
                Status::OK
            );
            if (is_dir(PATH_site . '/' . $extConfSettings['origFilesRoot'])) {
                $this->reports[] = GeneralUtility::makeInstance('TYPO3\\CMS\\Reports\\Status',
                    'Filesystem',
                    'Original files root exists',
                    'Directory for original files (' . $extConfSettings['origFilesRoot'] . ') exists.',
                    Status::OK
                );
                if (is_writable(PATH_site . '/' . $extConfSettings['origFilesRoot'])) {
                    $this->reports[] = GeneralUtility::makeInstance('TYPO3\\CMS\\Reports\\Status',
                        'Filesystem',
                        'Original files root directory is writable',
                        'Directory for original files (' . $extConfSettings['origFilesRoot'] . ') is writable.',
                        Status::OK
                    );
                } else {
                    $this->reports[] = GeneralUtility::makeInstance('TYPO3\\CMS\\Reports\\Status',
                        'Filesystem',
                        'Original files root directory (' . $extConfSettings['origFilesRoot'] . ') is not writable',
                        'The directory to store original images is not writable!',
                        Status::ERROR
                    );
                }
            } else {
                $this->reports[] = GeneralUtility::makeInstance('TYPO3\\CMS\\Reports\\Status',
                    'Filesystem',
                    'Original files root',
                    'The directory to store original images (' . $extConfSettings['origFilesRoot'] . ') does not exist!',
                    Status::ERROR
                );
            }
        } else {
            $this->reports[] = GeneralUtility::makeInstance('TYPO3\\CMS\\Reports\\Status',
                'Filesystem',
                'Original files root',
                'The directory to store original images has not been set in Extension Manager!',
                Status::ERROR
            );
        }
    }


    /**
     * Checks whether YAG temp directory exists and is writable
     * @return void
     */
    protected function checkYagTmpDirectory()
    {
        $extConfSettings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['yag']);
        if (array_key_exists('hashFilesystemRoot', $extConfSettings)) {
            $this->reports[] = GeneralUtility::makeInstance('TYPO3\\CMS\\Reports\\Status',
                'Filesystem',
                'Hash filesystem root',
                'Setting for hash filesystem root is available.',
                Status::OK
            );
            if (is_dir(PATH_site . '/' . $extConfSettings['hashFilesystemRoot'])) {
                $this->reports[] = GeneralUtility::makeInstance('TYPO3\\CMS\\Reports\\Status',
                    'Filesystem',
                    'Hash filesystem root directory exists',
                    'Directory for hash filesystem root (' . $extConfSettings['hashFilesystemRoot'] . ') exists.',
                    Status::OK
                );
                if (is_writable(PATH_site . '/' . $extConfSettings['hashFilesystemRoot'])) {
                    $this->reports[] = GeneralUtility::makeInstance('TYPO3\\CMS\\Reports\\Status',
                        'Filesystem',
                        'Hash filesystem root is writable',
                        'Directory for hash filesystem root (' . $extConfSettings['hashFilesystemRoot'] . ') is writable.',
                        Status::OK
                    );
                } else {
                    $this->reports[] = GeneralUtility::makeInstance('TYPO3\\CMS\\Reports\\Status',
                        'Filesystem',
                        'Hash filesystem root is not writable',
                        'The directory for hash filesystem root (' . $extConfSettings['hashFilesystemRoot'] . ') is not writable!',
                        Status::ERROR
                    );
                }
            } else {
                $this->reports[] = GeneralUtility::makeInstance('TYPO3\\CMS\\Reports\\Status',
                    'Filesystem',
                    'Hash filesystem root does not exist',
                    'The directory for hash filesystem root (' . $extConfSettings['hashFilesystemRoot'] . ') does not exist!',
                    Status::ERROR
                );
            }
        } else {
            $this->reports[] = GeneralUtility::makeInstance('TYPO3\\CMS\\Reports\\Status',
                'Filesystem',
                'Hash filesystem root is not set',
                'The directory for hash filesystem root has not been set in Extension Manager!',
                Status::ERROR
            );
        }
    }
}
