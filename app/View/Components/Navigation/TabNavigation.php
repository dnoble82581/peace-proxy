<?php

namespace App\View\Components\Navigation;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TabNavigation extends Component
{
    /**
     * List of tabs with their labels and keys.
     * Each tab should have a `key`, `label`, and optional `content`.
     */
    public array $tabs;

    /**
     * Default active tab key.
     */
    public ?string $defaultTab;

    /**
     * Custom CSS class for the tab container.
     */
    public ?string $containerClass;

    /**
     * Custom CSS class for the header.
     */
    public ?string $headerClass;

    /**
     * Custom CSS class for the dropdown.
     */
    public ?string $dropdownClass;

    /**
     * Custom CSS class for the panel container.
     */
    public ?string $panelContainerClass;

    /**
     * Create a new component instance.
     */
    public function __construct(
        array $tabs,
        ?string $defaultTab = null,
        ?string $containerClass = null,
        ?string $headerClass = null,
        ?string $dropdownClass = null,
        ?string $panelContainerClass = null
    ) {
        $this->tabs = $tabs;
        $this->defaultTab = $defaultTab;
        $this->containerClass = $containerClass;
        $this->headerClass = $headerClass;
        $this->dropdownClass = $dropdownClass;
        $this->panelContainerClass = $panelContainerClass;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.navigation.tab-navigation');
    }
}
