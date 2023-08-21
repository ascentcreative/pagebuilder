<?php

use MatthiasMullie\Minify;

use Illuminate\Support\Facades\Storage;

function getPageCSSFile($content, $model) {

    if(is_string($content)) {
        $data = json_decode($content);
    } else {
        $data = $content;
    }

    // dd($data);

    // check if we need to re-create the CSS (based on file date and model->updated_at)
    $path = '/storage/stackeditor/' . $data->unid . '.css';
    $fullpath = $_SERVER['DOCUMENT_ROOT'] . $path;
    $regen = env('STACKEDITOR_FORCECSSREGEN') ?? false;
    if (!file_exists($fullpath)) {
        $regen = true;
    } else {

        if ($model->updated_at->timestamp > filemtime($_SERVER['DOCUMENT_ROOT'] . '/storage/stackeditor/' . $data->unid . '.css')) {
            $regen = true;
        }
    }

    if ($regen) {
        // write to a file
        // normal autoVersion / Minify will kick in on the producced file.
        Storage::disk('public')->put('stackeditor/' . $data->unid . '.css', renderStackCSS($content));      
    }

    return $path;
    
}

function renderPageCSS($content) {

    $out = '';
 
    if(is_string($content)) {
        $data = json_decode($content);
    } else {
        $data = $content;
    }

    foreach($content as $unid=>$element) {
        $out .= renderElementCSS($unid, $element);
    }
    return $out;

    // dd($data);

}

function renderElementCSS($unid, $element) {

    $out = view('pagebuilder::css', ['id'=>'elm-' . $unid, 'element'=>$element])->render();

    if(isset($element->e)) {
        foreach($element->e as $unid=>$element) {
            $out .= renderElementCSS($unid, $element);
        }
    }
    return $out;

}

function resolveElementDescriptor($type) {

    if($type=='empty')
        return null;

    $map = collect(discoverElementDescriptors())->mapWithKeys(function($item, $key) {
        $ref = new ReflectionClass($item);
        return [$item::getBladePath() => $item];
    })->toArray();

    if(isset($map[$type])) {
        return ($map[$type]);
    } else {
        return null;
    }

}


function oldRenderPageCSS($content) {

    $out = '';
    // foreach row:

    if(is_string($content)) {
        $data = json_decode($content);
    } else {
        $data = $content;
    }

    $rows = $data->rows;
    
    if(isset($rows)) {
        foreach($rows as $row) {
            // output the row's own CSS
            $out .= view('pagebuilder::css.row', ['id'=>'row-' . $row->unid, 'data'=>$row])->render();

            // for each block in the row:
            if(isset($row->containers)) {
                foreach($row->containers as $container) {
                    // output the container's CSS
                    $out .= view('pagebuilder::css.container', ['id'=>'container-' . $container->unid, 'data'=>$container])->render();

                    if(isset($container->blocks)) {

                        foreach($container->blocks as $block) {
                            // output the block's CSS
                            $out .= view('pagebuilder::css', ['id'=>'block-' . $block->unid, 'data'=>$block])->render();

                        }

                    }

                }
            }

        }
    }

    return $out;

}



function pagebuilderBladePaths($template, $action) {

    $paths = config('pagebuilder.blade_paths');

    $out = collect($paths)->transform(function($item) use ($template, $action) {

        return $item . '.' . $template . '.' . $action;

    })->toArray();

    $out[] = 'pagebuilder::null';

    return $out;

}




/**
 * @param mixed $model - a model for use in the isApplicable($model) function of the block descriptor classes
 * 
 * @return array - an associative arrary of block info (keyed by categories)
 */
function discoverElements($model=null) : array {

    // first get the array of keys from the StackEditor config:
    $aryElements = collect(config('pagebuilder.categories'))->mapWithKeys(function($item, $key) {
        return [$item => []];
    })->toArray();
    
    foreach(discoverElementDescriptors($model) as $class) {

        $ref = new  ReflectionClass($class);
        
        // add the necessary data to the array - if:

        // - Not explicitly disabled:
       
        if($class::isApplicable($model)) {
            // add the details to the relevent category in the array
            $aryElements[$class::getCategory()][] = [
                        'name'=>$class::getName(),
                        'description'=>$class::getDescription(),
                        'bladePath'=>$class::getBladePath(),
                ];


        }
    
    }

    // array_filter to only return the categories which have blocks
    return array_filter($aryElements);

}


function discoverElementDescriptors($model = null) : array {

    $types = [];

    // start discovering the classes:
    $paths = config('pagebuilder.discovery_paths');

    $disabled = config('pagebuilder.disabled_types');
    // dump($paths);

    foreach($paths as $path) {
        // if the folder exists, find all the classes there and instantiate (or maybe we're calling static functions... not sure yet)
        $files = glob($path.'/*.php');

        foreach ($files as $file) {

            $class = getClassFullNameFromFile($file);

            $ref = new ReflectionClass($class);

            if(!in_array($class, $disabled)) {
                // - Not an abstract class
                if (!$ref->isAbstract()) {
                    // - Implements the correct interface (could be by extending the AbstractDescriptor class)
                    if($ref->implementsInterface(\AscentCreative\PageBuilder\Contracts\ElementDescriptor::class)) {
                        // - is deemed applicable (perhaps to the supplied model, but there may be wider, global conditions coded in too)
                        $types[] = $class;
                    }
                }
            }

        }

    }

     return $types;

}


function resolveBlockDescriptor($type) {

    if($type=='empty')
        return null;

    $map = collect(discoverBlockDescriptors())->mapWithKeys(function($item, $key) {
        $ref = new ReflectionClass($item);
        return [$item::getBladePath() => $item];
    })->toArray();

    return ($map[$type]);

}
