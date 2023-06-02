<?php

namespace AscentCreative\PageBuilder\Components;

use Illuminate\View\Component;

class Section extends Component
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
        $this->unid = $unid;
        if(is_null($unid) || $unid == '') {
            $this->unid = uniqid();
        }
        
        // var_dump($this->rowidx);
        
        if(is_null($value)) {
            $value = [];
            // ['containers'=>
            //     [
            //         [
            //             'blocks' => [
            //                 ['template'=>'text']
            //             ]
            //         ]
            //     ]
            // ];

            $value = json_decode(json_encode($value));
        }
        
        
        $this->value = $value;


        $this->name = $fieldname . '[' . $this->unid . ']';

        $this->defaults = $defaults;

        view()->share('pb_row_unid', $this->unid);
    
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        // Allows for block blades to be in either the main project or loaded from the cms package
        return view('pagebuilder::components.section'); 
    }
}
