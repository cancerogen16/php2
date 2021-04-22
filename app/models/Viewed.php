<?php

namespace app\models;

use app\core\Model;

class Viewed extends Model
{
    public function getViewed($user_id = 0)
    {
        $sql = "SELECT * FROM viewed WHERE user_id = '" . (int)$user_id . "'";

        return $this->db->all($sql);
    }

    /**
     * @param int $user_id
     * @param string $url
     * @return mixed
     */
    public function getViews($user_id = 0, $url = '')
    {
        $sql = "SELECT * FROM viewed WHERE user_id = '" . (int)$user_id . "' AND url = '" . $url . "'";

        return $this->db->one($sql);
    }

    /**
     * @param int $user_id
     * @param string $url
     * @return int количество просмотров данной страницы данным пользователем
     */
    public function addView($user_id = 0, $url = '') {
        $views = (int)$this->getViews($user_id, $url)['views'];

        if ($views == 0) {
            $sql = "INSERT INTO viewed (user_id, url, views) VALUES (:user_id, :url, :views)";

            $views++;

            $this->db->query($sql, [
                'user_id' => $user_id,
                'url' => $url,
                'views' => $views,
            ]);
        } else {
            $sql = "UPDATE viewed SET views = views + 1 WHERE user_id = '" . (int)$user_id . "' AND url = '" . $url . "'";

            $this->db->query($sql);

            $views++;
        }

        return $views;
    }
}