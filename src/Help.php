<?php

namespace Comodolab\Nova\Fields\Help;

use Laravel\Nova\Fields\Field;

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
        'sideLabel' => false,
        'icon'      => 'help'
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

    private function loadDefaultIcons(): self
    {
        $this->svgIcons = require(dirname(__DIR__) . '/icons.php');

        return $this;
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

    public function type(string $type): self
    {
        return $this->withMeta(compact('type'));
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

    public function withSideLabel(): self
    {
        return $this->withMeta(['sideLabel' => true]);
    }

    public function displayAsHtml(): self
    {
        return $this->withMeta(['asHtml' => true]);
    }

    public function icon(string $icon): self
    {
        if ($svg = array_get($this->svgIcons, $icon)) {
            $icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">' . $svg . '</svg>';
        }

        return $this->withMeta(compact('icon'));
    }

    public function withoutIcon(): self
    {
        return $this->withMeta(['icon' => null]);
    }

    public function showFullWidthOnDetail(): self
    {
        $this->showOnDetail = true;

        return $this
            ->withMeta(['fullWidthOnDetail' => true]);
    }

    public function alsoOnIndex(): self
    {
        $this->showOnIndex = true;

        return $this;
    }
}
