<?php

namespace AscentCreative\PageBuilder\BlockDescriptors;

use AscentCreative\PageBuilder\BlockDescriptors\AbstractDescriptor; 

class Video extends AbstractDescriptor { 

    public static $name = 'Video';

    public static $bladePath = 'video';

    public static $description = "Paste in a YouTube / Vimeo URL to embed the player in the page";

    public static $category = "General";

}