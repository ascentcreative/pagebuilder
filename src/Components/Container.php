<?php

namespace AscentCreative\PageBuilder\Components;

use Illuminate\View\Component;

class Container extends Component
{

   
  //  public $label;
  //  public $type;
    public $fieldname;
    public $unid;
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
    public function __construct($fieldname, $unid=null, $value=null, $defaults=[])
    {
       
    //    $this->type = $type;
        $this->fieldname = $fieldname;
        // $this->row = $row;
        $this->unid = $unid;

        if(is_null($this->unid) || $this->unid == '') {
            $this->unid = uniqid();
        }
 
        $this->value = $value;

        $this->name = $fieldname . '[containers][' . $this->unid .']';

        $this->defaults = $defaults;

        view()->share('pb_container_unid', $this->unid);
    
    }

    public function getLayout() {

        $layout = $this->value->options->container_layout ?? 'single';

        $data = config('pagebuilder.container_layouts.' . $layout);

        return $data;
    }

    public function getLayoutClass() {
        return $this->value->options->container_layout ?? 'single';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        // Allows for block blades to be in either the main project or loaded from the cms package
        return view('pagebuilder::components.container'); 
    }
}
