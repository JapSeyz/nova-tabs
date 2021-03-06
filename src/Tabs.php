<?php
namespace Eminiarts\Tabs;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Contracts\ListableField;

class Tabs extends Field implements ListableField
{
    /**
     * @var string
     */
    public $activeTab = '';

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'tabs';

    /**
     * @var mixed
     */
    public $showOnCreation = false;

    /**
     * @var mixed
     */
    public $showOnDetail = true;

    /**
     * @var mixed
     */
    public $showOnIndex = false;

    /**
     * @var mixed
     */
    public $showOnUpdate = false;

    /**
     * @var array
     */
    public $tabs = [];

    /**
     * @param  $name
     * @return mixed
     */
    public function activeTab($name)
    {
        $this->activeTab = $name;

        return $this;
    }

    /**
     * @param  $name
     * @param  $field
     * @param  $relationType
     * @return mixed
     */
    public function addTab($name, $field, $relationType = '')
    {
        $this->tabs[] = [
            'name'           => $name,
            'field'          => $field,
            'targetRelation' => $field->attribute,
        ];

        return $this;
    }

    /**
     * @return mixed
     */
    public function availableFields()
    {
        return collect($this->tabs)->map(function ($item, $key) {
            $item['field']->hideFromDetail();

            return $item['field'];
        });
    }

    /**
     * @param $value
     */
    public function defaultSearch()
    {
        return $this->withMeta(['extraAttributes' => [
            'defaultSearch' => true],
        ]);
    }

    /**
     * Get additional meta information to merge with the field payload.
     *
     * @return array
     */
    public function meta()
    {
        return array_merge([
            'activeTab' => $this->activeTab,
            'tabs'      => $this->tabs,
            'listable'  => true,
        ], $this->meta);
    }
}
