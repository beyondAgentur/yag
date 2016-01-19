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

namespace DL\Yag\Domain\Configuration\Theme;

use DL\Yag\Domain\Configuration\ConfigurationBuilder;

/**
 * Factory for theme configuration
 *
 * @package Domain
 * @subpackage Configuration\Theme

 * @author Daniel Lienert <typo3@lienert.cc>
 */
class ThemeConfigurationFactory
{
    /**
     * @static
     * @param ConfigurationBuilder $configurationBuilder
     * @param null $themeSettings array
     * @param null $themeName string
     * @return ThemeConfiguration
     */
    public static function getInstance(ConfigurationBuilder $configurationBuilder, $themeSettings = null, $themeName = null)
    {
        if (!$themeSettings) {
            $themeSettings = $configurationBuilder->getSettingsForConfigObject('theme');
            $themeName = $configurationBuilder->getTheme();
        }

        return new ThemeConfiguration($configurationBuilder, $themeSettings, $themeName);
    }
}
