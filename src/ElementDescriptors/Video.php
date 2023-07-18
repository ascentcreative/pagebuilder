<?php

namespace AscentCreative\PageBuilder\ElementDescriptors;

use AscentCreative\PageBuilder\ElementDescriptors\AbstractDescriptor; 

class Video extends AbstractDescriptor { 

    public static $name = 'Video';

    public static $bladePath = 'video';

    public static $description = "Embed a video from Youtube or Vimeo";

    public static $category = "General";

}