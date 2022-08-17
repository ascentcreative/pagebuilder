<?php

namespace AscentCreative\PageBuilder\Components;

use Illuminate\View\Component;

class Row extends Component
{

   
  //  public $label;
  //  public $type;
    public $fieldname;
    public $rowidx;
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
    public function __construct($fieldname, $rowidx, $value=null, $defaults=[])
    {
       
    //    $this->type = $type;
        $this->fieldname = $fieldname;
        $this->rowidx = $rowidx;
        $this->value = $value;

        $this->name = $fieldname . '[rows][' . $rowidx . ']';

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
        return view('pagebuilder::components.row'); 
    }
}
