<?php
if (!is_null($form) and isset($form->widget)) {
    echo BBRenderWidget($form->widget, $data);
} else {
    $widget = \Sahakavatar\Cms\Models\Widgets::where('default', 1)->where('main_type', 'fields')->first();
    $main = null;
    if ($widget) {
        $variations = $widget->variations();
        foreach ($variations as $variation) {
            if ($variation->default) {
                $main = $variation->id;
            }
        }
    }
    echo BBRenderWidget($main, $data);
}
?>