<?php

namespace App;

class ImageModel extends DBModel {

    public function getImages() {
        $images_data = [];

        $query = "SELECT * FROM image";

        if (!empty($images = $this->getDbResult($query))) {
            foreach ($images as $image) {
                if ($image['image'] == '') {
                    $image['image'] = 'noimage.jpg';
                }
                $images_data[] = [
                    'image_id' => $image['image_id'],
                    'name' => $image['name'],
                    'image' => '/img/' . $image['image'],
                ];
            }
        }

        return $images_data;
    }

    public function getImage($image_id) {
        $query = "SELECT * FROM image WHERE image_id = '" . (int)$image_id . "'";

        return $this->getDbRow($query);
    }
}