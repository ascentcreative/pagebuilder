<?php

namespace AscentCreative\PageBuilder\ElementDescriptors;

use AscentCreative\PageBuilder\ElementDescriptors\AbstractDescriptor; 

class ThirdPartyCode extends AbstractDescriptor { 

    public static $name = 'Third Party Code';

    public static $bladePath = 'third-party-code';

    public static $description = "Code from a third-party site - often used for embedded content";

    public static $category = "General";

}