<?php

namespace AscentCreative\PageBuilder\Components;

use Illuminate\View\Component;

class PageBuilder extends Component
{

   
    public $label;
    public $name;
    public $value;
  
    public $previewable;

    public $wrapper;
    public $class;

    public $model;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label=null, $name, $value, $previewable = true,
                        $wrapper='none', $class='',     
                        $model = null   
                    )
    {
       
        $this->label = $label;
        $this->name = $name;

    
        if(is_string($value)) {
            $this->value = json_decode($value); //, true);
        } else {
            // this feels like such a fudge but works... 
            // used on validation fail when the incoming data is a pure array. 
            // encode / decode makes it match the expected object style.
            // works for now, but feels uncontrolled....
            $this->value = json_decode(json_encode($value));
        }
        
        $this->previewable = $previewable;

        $this->wrapper = $wrapper;
        $this->class = $class;

        try {
            if (!is_string($model)) {
                $this->model = get_class($model);
            } else {
                $this->model = $model;
            }
        } catch (Exception $e) {
            $this->model = null;
        }
       


    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('pagebuilder::pagebuilder');
    }


}
