<?php

namespace AscentCreative\PageBuilder\ElementDescriptors;

use AscentCreative\PageBuilder\ElementDescriptors\AbstractDescriptor; 

class AudioPlayer extends AbstractDescriptor { 

    public static $name = 'Audio Player';

    public static $bladePath = 'audioplayer';

    public static $description = "Upload an audio file for users to stream";

    public static $category = "General";

}