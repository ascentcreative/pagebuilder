<?php
namespace AscentCreative\PageBuilder;

use AscentCreative\Forms\Contracts\FormComponent;
use AscentCreative\Forms\FormObjectBase;
use AscentCreative\Forms\Traits\CanBeValidated;
use AscentCreative\Forms\Traits\CanHaveValue;


class PageBuilder extends FormObjectBase implements FormComponent {

    use CanBeValidated, CanHaveValue;

    public $component = 'pagebuilder';

    public function __construct($name) {
        $this->name = $name;
    }
    

}