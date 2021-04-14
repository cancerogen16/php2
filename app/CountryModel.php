<?php

namespace App;

class CountryModel extends DBModel {

    public function getData() {
        $countries_data = [];

        $query = "SELECT * FROM country";

        if (!empty($countries = $this->getDbResult($query))) {
            foreach ($countries as $country) {
                $countries_data[] = [
                    'country_id' => $country['country_id'],
                    'name' => $country['name'],
                    'region' => $country['region'],
                    'population' => $country['population'],
                    'capital' => $country['capital'],
                    'language' => $country['language'],
                ];
            }
        }

        return $countries_data;
    }
}