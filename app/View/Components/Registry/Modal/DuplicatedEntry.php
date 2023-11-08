<?php

namespace App\View\Components\Registry\Modal;

use Illuminate\View\Component;

class DuplicatedEntry extends Component
{
    public $duplicates_found;

    public $identifier;

    public $save;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($entries, $identifier, bool $save = false)
    {
        $this->duplicates_found = $entries;
        $this->identifier = $identifier;

        $this->save = $save;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.registry.modal.duplicated-entry');
    }
}
