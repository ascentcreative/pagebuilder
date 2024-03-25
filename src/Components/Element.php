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

    public $inner_style;

    public $element;

    public $mode;


    // public $name;
  
  //  public $wrapper;
  //  public $class;



    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($path, $unid=null, $value=null, $mode='edit')
    {

       $this->mode = $mode;
       
    //    $this->type = $type;
        $this->path = $path;
        $this->unid = $unid;
        if(is_null($unid) || $unid == '') {
            $this->unid = uniqid();
        }
        
        
        $this->value = $value;


        $styles = collect($value->s ?? []);
        // dd($styles);   

        if(isset($styles['background_image'])) {
            // dd($styles);
            // $img = \AscentCreative\CMS\Models\File::find($styles['background_image']);
            $styles['background_image'] = "url('/image/max/" . $styles['background_image']->hashed_filename . "');";
            // "url('/storage/" . $img->filepath . "')";
        }

        // dump($styles);

        // $this->style = $styles->transform(function($item, $key) {
        //     if(trim($item) != '') {
        //         return str_replace("_", '-', $key) . ': ' . $item;
        //     }
        // })->join('; ');


        // $innerstyles = collect($value->i ?? []);
      
        // $this->inner_style = $innerstyles->transform(function($item, $key) {
        //     if(trim($item) != '') {
        //         return str_replace("_", '-', $key) . ': ' . $item;
        //     }
        // })->join('; ');

        // dump($this->styles);

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

        // populate any required view data from the Descriptor
        $descriptor = resolveElementDescriptor($this->value->t);

        $data = [];
        if($descriptor) {
            $data = $descriptor::getViewData($this->value, $this->mode);
        }

        // Allows for block blades to be in either the main project or loaded from the cms package
        // return view('pagebuilder::components.element.edit'); //, ['element'=>$this]); 
        // dump($this->value);
        foreach(pagebuilderBladePaths($this->value->t, $this->mode) as $path) {
            if(view()->exists($path)) {
                return view($path, $data);
            }
        }

    }
}
