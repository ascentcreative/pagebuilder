<?php

namespace AscentCreative\PageBuilder\BlockDescriptors;

use AscentCreative\PageBuilder\BlockDescriptors\AbstractDescriptor; 

class Card extends AbstractDescriptor { 

    public static $name = 'Card';

    public static $bladePath = 'card';

    public static $description = "A 'card' with image, title, text and action'";

    public static $category = "General";

    public static $defaults = [
    
    ];

}