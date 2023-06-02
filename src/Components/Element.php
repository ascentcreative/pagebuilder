<?php

namespace AscentCreative\PageBuilder\Components;

use Illuminate\View\Component;

class Element extends Component
{

   
  //  public $label;
    public $type;
    public $path;
    public $unid;
    public $value;
    public $defaults;

    public $style;

    public $element;


    // public $name;
  
  //  public $wrapper;
  //  public $class;



    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($path, $unid=null, $value=null)
    {

       
       
    //    $this->type = $type;
        $this->path = $path;
        $this->unid = $unid;
        if(is_null($unid) || $unid == '') {
            $this->unid = uniqid();
        }
        
        
        $this->value = $value;


        $styles = collect($value->s ?? []);
        // dump($styles);

        if(isset($styles['background_image'])) {
            $img = \AscentCreative\CMS\Models\File::find($styles['background_image']);
            $styles['background_image'] = "url('/storage/" . $img->filepath . "')";
        }

        $this->style = $styles->transform(function($item, $key) {
            return str_replace("_", '-', $key) . ': ' . $item;
        })->join('; ');


        $this->path = $path . '[' . $this->unid . ']';

        // $this->defaults = $defaults;
// 
        // view()->share('pb_row_unid', $this->unid);

        $this->element = $this;
    
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        // Allows for block blades to be in either the main project or loaded from the cms package
        // return view('pagebuilder::components.element.edit'); //, ['element'=>$this]); 

        foreach(pagebuilderBladePaths($this->value->t, 'edit') as $path) {
            if(view()->exists($path)) {
                return view($path);
            }
        }

    }
}
