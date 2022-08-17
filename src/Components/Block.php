<?php

namespace AscentCreative\PageBuilder\Components;

use Illuminate\View\Component;

class Block extends Component
{

   
  //  public $label;
  //  public $type;
    public $fieldname;
    public $idx;
    public $value;
    public $defaults;

    public $name;
  
  //  public $wrapper;
  //  public $class;



    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($fieldname, $row, $container, $idx, $value=null, $defaults=[])
    {
       
    //    $this->type = $type;
        $this->fieldname = $fieldname;
        $this->row = $row;
        $this->container = $container;
        $this->idx = $idx;
        $this->value = $value;

        $this->name = $fieldname . '[rows][' . $row . '][containers][' . $container .'][blocks][' . $idx . ']';

        $this->defaults = $defaults;
    
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        // Allows for block blades to be in either the main project or loaded from the cms package
        return view('pagebuilder::components.block'); 
    }
}
