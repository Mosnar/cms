<?php
/**
 * @link      https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license   https://craftcms.com/license
 */

namespace craft\records;

use craft\db\ActiveRecord;
use yii\db\ActiveQueryInterface;

/**
 * Class CategoryGroup_SiteSettings record.
 *
 * @property int           $id                       ID
 * @property int           $groupId                  Group ID
 * @property int           $siteId                   Site ID
 * @property bool          $hasUrls                  Has URLs
 * @property string        $uriFormat                URI format
 * @property string        $template                 Template
 * @property CategoryGroup $group                    Group
 * @property Site          $site                     Site
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since  3.0
 */
class CategoryGroup_SiteSettings extends ActiveRecord
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     *
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%categorygroups_sites}}';
    }

    /**
     * Returns the associated category group.
     *
     * @return ActiveQueryInterface The relational query object.
     */
    public function getGroup(): ActiveQueryInterface
    {
        return $this->hasOne(CategoryGroup::class, ['id' => 'groupId']);
    }

    /**
     * Returns the associated site.
     *
     * @return ActiveQueryInterface The relational query object.
     */
    public function getSite(): ActiveQueryInterface
    {
        return $this->hasOne(Site::class, ['id' => 'siteId']);
    }
}
