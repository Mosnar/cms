<?php
/**
 * @link      https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license   https://craftcms.com/license
 */

namespace craft\models;

use Craft;
use craft\base\Field;
use craft\base\FieldInterface;
use craft\base\Model;

/**
 * FieldLayout model class.
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since  3.0
 */
class FieldLayout extends Model
{
    // Properties
    // =========================================================================

    /**
     * @var integer ID
     */
    public $id;

    /**
     * @var string Type
     */
    public $type;


    /**
     * @var
     */
    private $_tabs;

    /**
     * @var
     */
    private $_fields;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'number', 'integerOnly' => true],
        ];
    }

    /**
     * Returns the layout’s tabs.
     *
     * @return FieldLayoutTab[] The layout’s tabs.
     */
    public function getTabs()
    {
        if ($this->_tabs !== null) {
            return $this->_tabs;
        }

        if (!$this->id) {
            return [];
        }

        return $this->_tabs = Craft::$app->getFields()->getLayoutTabsById($this->id);
    }

    /**
     * Returns the layout’s fields.
     *
     * @return FieldInterface[] The layout’s fields.
     */
    public function getFields()
    {
        if ($this->_fields !== null) {
            return $this->_fields;
        }

        if (!$this->id) {
            return [];
        }

        return $this->_fields = Craft::$app->getFields()->getFieldsByLayoutId($this->id);
    }

    /**
     * Returns the layout’s fields’ IDs.
     *
     * @return array The layout’s fields’ IDs.
     */
    public function getFieldIds()
    {
        $ids = [];

        foreach ($this->getFields() as $field) {
            /** @var Field $field */
            $ids[] = $field->id;
        }

        return $ids;
    }

    /**
     * Sets the layout’s tabs.
     *
     * @param array|FieldLayoutTab[] $tabs An array of the layout’s tabs, which can either be FieldLayoutTab
     *                                     objects or arrays defining the tab’s attributes.
     *
     * @return void
     */
    public function setTabs($tabs)
    {
        $this->_tabs = [];

        foreach ($tabs as $tab) {
            if (is_array($tab)) {
                $tab = new FieldLayoutTab($tab);
            }

            $tab->setLayout($this);
            $this->_tabs[] = $tab;
        }
    }

    /**
     * Sets the layout']”s fields.
     *
     * @param FieldInterface[] $fields         An array of the layout’s fields, which can either be
     *                                         FieldLayoutFieldModel objects or arrays defining the tab’s
     *                                         attributes.
     *
     * @return void
     */
    public function setFields($fields)
    {
        $this->_fields = $fields;
    }
}