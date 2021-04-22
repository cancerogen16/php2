<?php

namespace app\models;

use app\core\Model;

class Viewed extends Model
{
    public function getViewed($user_id = 0)
    {
        $sql = "SELECT * FROM viewed WHERE user_id = '" . (int)$user_id . "' ORDER BY id DESC";

        return $this->db->all($sql);
    }

    /**
     * @param int $user_id
     * @param string $url
     * @return mixed
     */
    public function getViewsCount($user_id = 0, $url = '')
    {
        $sql = "SELECT * FROM viewed WHERE user_id = '" . (int)$user_id . "' AND url = '" . $url . "'";

        return (int)$this->db->one($sql)['views'];
    }

    /**
     * @param int $user_id
     * @param string $url
     * @return int количество просмотров данной страницы данным пользователем
     */
    public function addView($user_id = 0, $url = '') {
        $views_count = $this->getViewsCount($user_id, $url);

        if ($views_count == 0) {
            $viewed_pages = $this->getViewed($user_id);

            $sql = "INSERT INTO viewed (user_id, url, views) VALUES (:user_id, :url, :views)";

            $views_count++;

            $this->db->query($sql, [
                'user_id' => $user_id,
                'url' => $url,
                'views' => $views_count,
            ]);
        } else {
            $sql = "UPDATE viewed SET views = views + 1 WHERE user_id = '" . (int)$user_id . "' AND url = '" . $url . "'";

            $this->db->query($sql);

            $views_count++;
        }

        return $views_count;
    }
}