<?php

/**
 * JPGraph v4.1.0-beta.01
 */

namespace Amenadiel\JpGraph\Util;

use function define;
use function defined;
use function dirname;
use function file_exists;
use function function_exists;
use function imagetypes;
use const IMG_GIF;
use const IMG_JPG;
use const IMG_PNG;
use const IMG_WBMP;
use const PHP_VERSION;
use function preg_match;
use function sprintf;
use function version_compare;

require_once __DIR__ . '/Configs.php';
/**
 * @class Helper
 * // Misc Helper functions
 */
class Helper
{
    private static $__jpg_err_locale = DEFAULT_ERR_LOCALE;
    private static $initialized      = false;
    /**
     * Keeps a reference of the library related
     * constants to verify their existance.
     *
     * @var array
     */
    private static $Configs = [];

    /**
     * Declares handlers and last minute constants.
     */
    public static function bootstrapLibrary()
    {
        // we don't need to initialize again, of course
        if (self::$initialized) {
            return;
        }
        //Configs::setGeneralConfigs();
        //Configs::verifyFontConfigs();
        //Configs::verifyCacheSettings();
        //Configs::verifyTTFSettings();
        //Configs::verifyMBTTFSettings();
        //Configs::verifyFormatSettings();
        $locale_messages_file = sprintf('%s/lang/%s.inc.php', dirname(__DIR__), self::$__jpg_err_locale);

        // If the chosen locale doesn't exist try english
        if (!file_exists($locale_messages_file)) {
            self::$__jpg_err_locale = 'en';
        }
        // Make sure PHP version is high enough
        if (version_compare(PHP_VERSION, Configs::getConfig('MIN_PHPVERSION')) < 0) {
            JpGraphError::RaiseL(13, PHP_VERSION, Configs::getConfig('MIN_PHPVERSION'));
            die;
        }

        // Make GD sanity check
        if (!function_exists('imagetypes') || !function_exists('imagecreatefromstring')) {
            JpGraphError::RaiseL(25001);
            //("This PHP installation is not configured with the GD library. Please recompile PHP with GD support to run JpGraph. (Neither function imagetypes() nor imagecreatefromstring() does exist)");
        }

        // Check if there were any warnings, perhaps some wrong includes by the user. In this
        // case we raise it immediately since otherwise the image will not show and makes
        // debugging difficult. This is controlled by the user setting CATCH_PHPERRMSG
        if (isset($GLOBALS['php_errormsg']) && Configs::getConfig('CATCH_PHPERRMSG') && !preg_match('/|Deprecated|/i', $GLOBALS['php_errormsg'])) {
            JpGraphError::RaiseL(25004, $GLOBALS['php_errormsg']);
        }

        defined('HALT_ON_ERRORS') || define('HALT_ON_ERRORS', true);
        self::$initialized = true;
        if (Configs::getConfig('INSTALL_PHP_ERR_HANDLER')) {
            JpGraphError::registerHandler();
        }
        // Registers image exception handler
        JpGraphException::registerHandler();

        if (!Configs::getConfig('USE_IMAGE_ERROR_HANDLER')) {
            JpGraphError::SetImageFlag(false);
        }

        return self::$initialized;
    }

    /**
     * Sets the error locale.
     *
     * @param <type> $aLoc A location
     */
    public static function SetErrLocale($aLoc)
    {
        self::$__jpg_err_locale = $aLoc;
    }

    /**
     * Gets the error locale.
     *
     * @return <type> The error locale
     */
    public static function getErrLocale()
    {
        return self::$__jpg_err_locale;
    }

    // Utility function to generate an image name based on the filename we
    // are running from and assuming we use auto detection of graphic format
    // (top level), i.e it is safe to call this function
    // from a script that uses JpGraph
    public static function GenImgName()
    {
        // Determine what format we should use when we save the images
        $supported = imagetypes();
        if ($supported & IMG_PNG) {
            $img_format = 'png';
        } elseif ($supported & IMG_GIF) {
            $img_format = 'gif';
        } elseif ($supported & IMG_JPG) {
            $img_format = 'jpeg';
        } elseif ($supported & IMG_WBMP) {
            $img_format = 'wbmp';
        } elseif ($supported & IMG_XPM) {
            $img_format = 'xpm';
        }

        if (!isset($_SERVER['PHP_SELF'])) {
            Amenadiel\JpGraph\Util\JpGraphError::RaiseL(25005);
            //(" Can't access PHP_SELF, PHP global variable. You can't run PHP from command line if you want to use the 'auto' naming of cache or image files.");
        }
        $fname = basename($_SERVER['PHP_SELF']);
        if (!empty($_SERVER['QUERY_STRING'])) {
            $q = @$_SERVER['QUERY_STRING'];
            $fname .= '_' . preg_replace('/\\W/', '_', $q) . '.' . $img_format;
        } else {
            $fname = substr($fname, 0, strlen($fname) - 4) . '.' . $img_format;
        }

        return $fname;
    }

    // Useful mathematical function
    public static function sign($a)
    {
        return $a >= 0 ? 1 : -1;
    }
}
