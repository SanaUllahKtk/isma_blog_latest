<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Divider extends Component
{
    public $text;
    public $type;
    public $class;
    public $heading;
    public function __construct($text, $type = 'primary', $class = '', $heading = true)
    {
        $this->text = $text;
        $this->type = $type;
        $this->class = $class;
        $this->heading = $heading;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.divider');
    }
}
