<?php

if (! function_exists('getSiteType')) {
    function getSiteType() {
        return [
            0 => (object) [
                "id" => 0,
                "name" => "Wordpress",
                "version" => "2.0.1",
                "language" => "PHP"
            ],
            1 => (object) [
                "id" => 1,
                "name" => "Wekan",
                "version" => "XXX",
                "language" => "Python"
            ],
            2 => (object) [
                "id" => 2,
                "name" => "Blogango",
                "version" => "XXX",
                "language" => "Python"
            ],
        ];
    }
}
