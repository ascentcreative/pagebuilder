<?php

namespace AscentCreative\PageBuilder\Components;

use Illuminate\View\Component;

class Block extends Component
{

   
  //  public $label;
  //  public $type;
    public $fieldname;
    public $unid;
    public $value;
    public $defaults;

    public $name;

    public $template;
  
  //  public $wrapper;
  //  public $class;



    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($fieldname, $unid=null, $template=null, $value=null, $defaults=[])
    {
       
    //    $this->type = $type;
        $this->fieldname = $fieldname;

        if(is_null($unid) || $unid == '') {
            $unid = uniqid();
        }

        $this->unid = $unid;

        $this->value = $value;

        // 
        if(is_null($template)) {
            $this->template = $value->template ?? 'empty';
        } else {
            // dd($template);
            $this->template = $template;
        }

        $this->name = $fieldname . '[blocks][' . $unid . ']';

        // var_dump($this->template);

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
