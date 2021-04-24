<?php

namespace app\models;

use app\core\Model;

class Viewed extends Model
{
    public function getViewed($user_id = 0)
    {
        $viewed = [];

        $sql = "SELECT * FROM viewed WHERE user_id = '" . (int)$user_id . "' ORDER BY id DESC";

        $query = $this->db->query($sql);

        if ($query->num_rows) {
            $viewed = $query->rows;
        }

        return $viewed;
    }

    /**
     * @param int $user_id
     * @param string $url
     * @return int
     * @throws \Exception
     */
    public function getViewsCount($user_id = 0, $url = '')
    {
        $viewsCount = 0;

        $sql = "SELECT * FROM viewed WHERE user_id = '" . (int)$user_id . "' AND url = '" . $url . "'";

        $query = $this->db->query($sql);

        if ($query->num_rows) {
            $viewsCount = $query->row['views'];
        }

        return $viewsCount;
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

            if (count($viewed_pages) >= 5) {
                $this->deleteViewed($viewed_pages);
            }

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

    public function deleteViewed($viewed_pages)
    {
        $limit = 3;

        foreach ($viewed_pages as $p => $page) {
            if ($p > $limit) {
                $sql = "DELETE FROM viewed WHERE user_id = '" . (int)$page['user_id'] . "' AND url = '" . $page['url'] . "'";

                $this->db->query($sql);
            }
        }
    }
}