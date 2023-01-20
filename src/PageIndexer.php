<?php
namespace AscentCreative\PageBuilder;

use Illuminate\Database\Eloquent\Model;

/**
 * Extracts the text content from a pagebuilder field
 *  - for use with ascentcreative/sitesearch
 */
class PageIndexer {

    /**
     * @param mixed $input - the structured data from the content field
     * 
     * @return : String - the extracted text
     */
    public static function extract(Model $model, $field) : String {

        $input = $model->$field;

        if(!is_array($input)) {
            $input = json_decode($input, true);
        }

        $out = [];
        if(is_array($input)) {
            // process each block - the BlockDescriptor will know which fields are text.
            foreach($input['rows'] as $row) {
                foreach($row['containers'] as $container) {
                    foreach($container['blocks'] as $block) {
                      
                        $descriptor = resolveBlockDescriptor($block['template']);

                        if($descriptor) {
                            $instance = new $descriptor();
                            $out[] = $instance->extractText($model, $block);
                        }
                    

                    }
                }
            }
        }

        // dd();
        return join(' ', $out);

    }

}