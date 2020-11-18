<?php

namespace Comodolab\Nova\Fields\Help;

use Exception;
use Illuminate\Support\Arr;
use Laravel\Nova\Fields\Field;

/**
 * Class Help
 * @package Comodolab\Nova\Fields\Help
 * @property string $name
 */
class Help extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'help';

    /**
     * The meta data for the element.
     *
     * @var array
     */
    public $meta = [
        'sideLabel'   => false,
        'icon'        => 'help',
        'collapsible' => false,
    ];

    /**
     * By default hide on index.
     *
     * @var bool
     */
    public $showOnIndex = false;

    /**
     * Default icons in svg format.
     *
     * @var array
     */
    protected $svgIcons = [];

    /**
     * The text alignment for the field's text in tables.
     *
     * @var string
     */
    public $textAlign = 'center';

    /**
     * @var string
     */
    public $type;

    /**
     * The built-in help types and their corresponding CSS classes.
     *
     * @var array
     */
    public $types = [
        'success' => 'bg-success-light text-success-dark',
        'info' => 'bg-info-light text-info-dark',
        'danger' => 'bg-danger-light text-danger-dark',
        'warning' => 'bg-warning-light text-warning-dark',
    ];

    /**
     * Help constructor.
     *
     * @param string $name
     * @param string|callable|null $message
     */
    public function __construct(string $name = '', $message = null)
    {
        parent::__construct($name, null, null);

        if ($message) {
            $this->message($message);
        }

        $this->loadDefaultIcons()->icon('help');
    }

    /**
     * Load default icons.
     *
     * @return $this
     */
    private function loadDefaultIcons(): self
    {
        $this->svgIcons = require(dirname(__DIR__) . '/icons.php');

        return $this;
    }

    /**
     * Add badge types and their corresponding CSS classes to the built-in ones.
     *
     * @param  array  $types
     * @return $this
     */
    public function addTypes(array $types)
    {
        $this->types = array_merge($this->types, $types);

        return $this;
    }

    /**
     * Set the badge types and their corresponding CSS classes.
     *
     * @param  array  $types
     * @return $this
     */
    public function types(array $types)
    {
        $this->types = $types;

        return $this;
    }

    /**
     * @param string $title
     * @param string|callable|null $message
     *
     * @return self
     */
    public static function success(string $title = '', $message = null): self
    {
        return static::make($title, $message)
            ->type('success')
            ->icon('success');
    }

    /**
     * @param string $title
     * @param string|callable|null $message
     *
     * @return self
     */
    public static function info(string $title = '', $message = null): self
    {
        return static::make($title, $message)
            ->type('info')
            ->icon('info');
    }

    /**
     * @param string $title
     * @param string|callable|null $message
     *
     * @return self
     */
    public static function warning(string $title = '', $message = null): self
    {
        return static::make($title, $message)
            ->type('warning')
            ->icon('warning');
    }

    /**
     * @param string $title
     * @param string|callable|null $message
     *
     * @return self
     */
    public static function danger(string $title = '', $message = null): self
    {
        return static::make($title, $message)
            ->type('danger')
            ->icon('danger');
    }

    /**
     * @param string $title
     * @param string|callable|null $message
     *
     * @return self
     */
    public static function header(string $title = '', $message = null)
    {
        return static::make($title, $message)
            ->type('header')
            ->showFullWidthOnDetail()
            ->withoutIcon();
    }

    /**
     * Set type.
     *
     * @param  string $type
     * @return $this
     */
    public function type(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param string|callable $message
     * @return Help
     */
    public function message($message): self
    {
        if (!is_string($message) && is_callable($message)) {
            $message = (string)$message();
        }

        return $this->withMeta(compact('message'));
    }

    /**
     * With side label.
     *
     * @return $this
     */
    public function withSideLabel(): self
    {
        return $this->withMeta(['sideLabel' => true]);
    }

    /**
     * Display as HTML.
     *
     * @return $this
     */
    public function displayAsHtml(): self
    {
        return $this->withMeta(['asHtml' => true]);
    }

    /**
     * Set icon.
     *
     * @param  string $icon
     * @return $this
     */
    public function icon(string $icon): self
    {
        if ($svg = Arr::get($this->svgIcons, $icon)) {
            $icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">' . $svg . '</svg>';
        }

        return $this->withMeta(compact('icon'));
    }

    /**
     * Disable icon.
     *
     * @return $this
     */
    public function withoutIcon(): self
    {
        return $this->withMeta(['icon' => null]);
    }

    /**
     * Show full width on detail.
     *
     * @return $this
     */
    public function showFullWidthOnDetail(): self
    {
        $this->showOnDetail = true;

        return $this
            ->withMeta(['fullWidthOnDetail' => true]);
    }

    /**
     * Allows to make a field collapsible.
     *
     * @return $this
     */
    public function collapsible(): self
    {
        return $this->withMeta(['collapsible' => true]);
    }

    /**
     * Display on index.
     *
     * @return $this
     */
    public function alsoOnIndex(): self
    {
        $this->showOnIndex = true;

        return $this;
    }

    /**
     * Prepare the element for JSON serialization.
     *
     * @return array
     * @throws Exception
     */
    public function jsonSerialize()
    {
        $this->validateCollapsible();

        return array_merge(parent::jsonSerialize(), [
            'type' => $this->type,
            'typeClasses' => $this->types,
        ]);
    }

    /**
     * Validate that the right conditions are applied
     * to make the field collapsible.
     *
     * @throws Exception
     */
    private function validateCollapsible(): void
    {
        if (!Arr::get($this->meta, 'collapsible')){
           return;
        }

        if (Arr::get($this->meta, 'sideLabel')){
            throw new Exception('Help fields cannot be both collapsible and have a side label!');
        }

        if (!$this->name || !Arr::get($this->meta, 'message')){
            throw new Exception('Collapsible help fields must define both a title and a message!');
        }
    }
}
