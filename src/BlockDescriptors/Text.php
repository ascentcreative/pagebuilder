<?php

namespace AscentCreative\PageBuilder\BlockDescriptors;

use AscentCreative\PageBuilder\BlockDescriptors\AbstractDescriptor; 

class Text extends AbstractDescriptor { 

    public static $name = 'Text';

    public static $bladePath = 'text';

    public static $description = "A rich-text block. Forms the main content of the page";

    public static $category = "General";

    public static $defaults = [
    
    ];


    // public function extractText(array $block) {

    //     return strip_tags_leaving_spaces($block['content']);

    // }

}