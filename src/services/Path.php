<?php
/**
 * @link      https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license   https://craftcms.com/license
 */

namespace craft\services;

use Craft;
use craft\helpers\App;
use craft\helpers\FileHelper;
use yii\base\Component;
use yii\base\Exception;

/**
 * The Path service provides APIs for getting server paths that are used by Craft.
 *
 * An instance of the Path service is globally accessible in Craft via [[Application::path `Craft::$app->getPath()`]].
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since  3.0
 */
class Path extends Component
{
    // Properties
    // =========================================================================

    /**
     * @var
     */
    private $_appPath;

    /**
     * @var
     */
    private $_configPath;

    /**
     * @var
     */
    private $_pluginsPath;

    /**
     * @var
     */
    private $_storagePath;

    /**
     * @var
     */
    private $_siteTranslationsPath;

    /**
     * @var
     */
    private $_vendorPath;

    // Public Methods
    // =========================================================================

    /**
     * Returns the path to the craft/app/ folder.
     *
     * @return string The path to the craft/app/ folder.
     * @throws Exception if Craft was installed via Composer
     */
    public function getAppPath()
    {
        if (isset($this->_appPath)) {
            return $this->_appPath;
        }

        // "craft/app" is only a thing for manual installs
        if (App::isComposerInstall()) {
            throw new Exception('There is no "app" folder when Craft is installed via Composer.');
        }

        $basePath = Craft::$app->getBasePath();
        $this->_appPath = dirname(dirname(dirname($basePath)));

        return $this->_appPath;
    }

    /**
     * Retursn the path to the craft/config/ folder.
     *
     * @return string The path to the craft/config/ folder.
     */
    public function getConfigPath()
    {
        if (!isset($this->_configPath)) {
            $this->_configPath = FileHelper::normalizePath(Craft::getAlias('@config'));
        }

        return $this->_configPath;
    }

    /**
     * Returns the path to the craft/plugins/ folder.
     *
     * @return string The path to the craft/plugins/ folder.
     */
    public function getPluginsPath()
    {
        if (!isset($this->_pluginsPath)) {
            $this->_pluginsPath = FileHelper::normalizePath(Craft::getAlias('@plugins'));
        }

        return $this->_pluginsPath;
    }

    /**
     * Returns the path to the craft/storage/ folder.
     *
     * @return string The path to the craft/storage/ folder.
     */
    public function getStoragePath()
    {
        if (!isset($this->_storagePath)) {
            $this->_storagePath = FileHelper::normalizePath(Craft::getAlias('@storage'));
        }

        return $this->_storagePath;
    }

    /**
     * Returns the path to the craft/storage/rebrand/ folder.
     *
     * @return string
     */
    public function getRebrandPath()
    {
        $path = $this->getStoragePath().DIRECTORY_SEPARATOR.'rebrand';
        FileHelper::createDirectory($path);

        return $path;
    }

    /**
     * Returns the path to the craft/app/vendor/ folder.
     *
     * @return string The path to the craft/app/vendor/ folder.
     */
    public function getVendorPath()
    {
        if (!isset($this->_vendorPath)) {
            $this->_vendorPath = FileHelper::normalizePath(Craft::getAlias('@vendor'));
        }

        return $this->_vendorPath;
    }

    /**
     * Returns the path to the craft/storage/runtime/ folder.
     *
     * @return string The path to the craft/storage/runtime/ folder.
     */
    public function getRuntimePath()
    {
        $path = $this->getStoragePath().DIRECTORY_SEPARATOR.'runtime';
        FileHelper::createDirectory($path);

        // Add a .gitignore file in there if there isn't one
        $gitignorePath = $path.DIRECTORY_SEPARATOR.'.gitignore';
        if (!is_file($gitignorePath)) {
            FileHelper::writeToFile($gitignorePath, "*\n!.gitignore\n");
        }

        return $path;
    }

    /**
     * Returns the path to the craft/storage/backups/ folder.
     *
     * @return string The path to the craft/storage/backups/ folder.
     */
    public function getDbBackupPath()
    {
        $path = $this->getStoragePath().DIRECTORY_SEPARATOR.'backups';
        FileHelper::createDirectory($path);

        return $path;
    }

    /**
     * Returns the path to the craft/storage/runtime/temp/ folder.
     *
     * @return string The path to the craft/storage/runtime/temp/ folder.
     */
    public function getTempPath()
    {
        $path = $this->getRuntimePath().DIRECTORY_SEPARATOR.'temp';
        FileHelper::createDirectory($path);

        return $path;
    }

    /**
     * Returns the path to the craft/storage/runtime/temp/uploads/ folder.
     *
     * @return string The path to the craft/storage/runtime/temp/uploads/ folder.
     */
    public function getTempUploadsPath()
    {
        $path = $this->getTempPath().DIRECTORY_SEPARATOR.'uploads';
        FileHelper::createDirectory($path);

        return $path;
    }

    /**
     * Returns the path to the craft/storage/runtime/assets/ folder.
     *
     * @return string The path to the craft/storage/runtime/assets/ folder.
     */
    public function getAssetsPath()
    {
        $path = $this->getRuntimePath().DIRECTORY_SEPARATOR.'assets';
        FileHelper::createDirectory($path);

        return $path;
    }

    /**
     * Returns the path to the craft/storage/runtime/assets/cache/ folder.
     *
     * @return string The path to the craft/storage/runtime/assets/cache/ folder.
     */
    public function getAssetsCachePath()
    {
        $path = $this->getAssetsPath().DIRECTORY_SEPARATOR.'cache';
        FileHelper::createDirectory($path);

        return $path;
    }

    /**
     * Returns the path to the craft/storage/runtime/assets/tempuploads/ folder.
     *
     * @return string The path to the craft/storage/runtime/assets/tempuploads/ folder.
     */
    public function getAssetsTempVolumePath()
    {
        $path = $this->getAssetsPath().DIRECTORY_SEPARATOR.'tempuploads';
        FileHelper::createDirectory($path);

        return $path;
    }

    /**
     * Returns the path to the craft/storage/runtime/assets/sources/ folder.
     *
     * @return string The path to the craft/storage/runtime/assets/sources/ folder.
     */
    public function getAssetsImageSourcePath()
    {
        $path = $this->getAssetsCachePath().DIRECTORY_SEPARATOR.'sources';
        FileHelper::createDirectory($path);

        return $path;
    }

    /**
     * Returns the path to the craft/storage/runtime/assets/cache/resized/ folder.
     *
     * @return string The path to the craft/storage/runtime/assets/cache/resized/ folder.
     */
    public function getResizedAssetsPath()
    {
        $path = $this->getAssetsCachePath().DIRECTORY_SEPARATOR.'resized';
        FileHelper::createDirectory($path);

        return $path;
    }

    /**
     * Returns the path to the craft/storage/runtime/assets/icons/ folder.
     *
     * @return string The path to the craft/storage/runtime/assets/icons/ folder.
     */
    public function getAssetsIconsPath()
    {
        $path = $this->getAssetsCachePath().DIRECTORY_SEPARATOR.'icons';
        FileHelper::createDirectory($path);

        return $path;
    }

    /**
     * Returns the path to the craft/storage/runtime/pluginicons/ folder.
     *
     * @return string The path to the craft/storage/runtime/pluginicons/ folder.
     */
    public function getPluginIconsPath()
    {
        $path = $this->getRuntimePath().DIRECTORY_SEPARATOR.'pluginicons';
        FileHelper::createDirectory($path);

        return $path;
    }

    /**
     * Returns the path to the craft/storage/logs/ folder.
     *
     * @return string The path to the craft/storage/logs/ folder.
     */
    public function getLogPath()
    {
        $path = $this->getStoragePath().DIRECTORY_SEPARATOR.'logs';
        FileHelper::createDirectory($path);

        return $path;
    }

    /**
     * Returns the path to the craft/app/resources/ folder.
     *
     * @return string The path to the craft/app/resources/ folder.
     */
    public function getResourcesPath()
    {
        return Craft::$app->getBasePath().DIRECTORY_SEPARATOR.'resources';
    }

    /**
     * Returns the path to the craft/app/translations/ folder.
     *
     * @return string The path to the craft/app/translations/ folder.
     */
    public function getCpTranslationsPath()
    {
        return Craft::$app->getBasePath().DIRECTORY_SEPARATOR.'translations';
    }

    /**
     * Returns the path to the craft/translations/ folder.
     *
     * @return string The path to the craft/translations/ folder.
     */
    public function getSiteTranslationsPath()
    {
        if (!isset($this->_siteTranslationsPath)) {
            $this->_siteTranslationsPath = Craft::getAlias('@translations');
        }

        return $this->_siteTranslationsPath;
    }

    /**
     * Returns the path to the craft/app/templates/ folder.
     *
     * @return string The path to the craft/app/templates/ folder.
     */
    public function getCpTemplatesPath()
    {
        return Craft::$app->getBasePath().DIRECTORY_SEPARATOR.'templates';
    }

    /**
     * Returns the path to the craft/templates/ folder.
     *
     * @return string The path to the craft/templates/ folder.
     */
    public function getSiteTemplatesPath()
    {
        return FileHelper::normalizePath(Craft::getAlias('@templates'));
    }

    /**
     * Returns the path to the craft/storage/runtime/compiled_templates/ folder.
     *
     * @return string The path to the craft/storage/runtime/compiled_templates/ folder.
     */
    public function getCompiledTemplatesPath()
    {
        $path = $this->getRuntimePath().DIRECTORY_SEPARATOR.'compiled_templates';
        FileHelper::createDirectory($path);

        return $path;
    }

    /**
     * Returns the path to the craft/storage/runtime/sessions/ folder.
     *
     * @return string The path to the craft/storage/runtime/sessions/ folder.
     */
    public function getSessionPath()
    {
        $path = $this->getRuntimePath().DIRECTORY_SEPARATOR.'sessions';
        FileHelper::createDirectory($path);

        return $path;
    }

    /**
     * Returns the path to the file cache folder.
     *
     * This will be located at craft/storage/runtime/cache/ by default, but that can be overridden with the 'cachePath'
     * config setting in craft/config/filecache.php.
     *
     * @return string The path to the file cache folder.
     */
    public function getCachePath()
    {
        $path = Craft::$app->getConfig()->get('cachePath', Config::CATEGORY_FILECACHE);
        $path = FileHelper::normalizePath(Craft::getAlias($path));

        if (!$path) {
            $path = $this->getRuntimePath().DIRECTORY_SEPARATOR.'cache';
        }

        FileHelper::createDirectory($path);

        return $path;
    }

    /**
     * Returns the path to craft/config/license.key.
     *
     * @return string The path to craft/config/license.key.
     */
    public function getLicenseKeyPath()
    {
        return $this->getConfigPath().DIRECTORY_SEPARATOR.'license.key';
    }
}