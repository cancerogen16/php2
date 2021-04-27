<?php

namespace app\models;

use app\core\Model;

class Viewed extends Model
{
    /**
     * @param int $user_id
     * @return array
     * @throws \Exception
     */
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
     * @param string $title
     * @return int количество просмотров данной страницы данным пользователем
     * @throws \Exception
     */
    public function addView($user_id = 0, $url = '', $title = '')
    {
        $views_count = $this->getViewsCount($user_id, $url);

        if ($views_count == 0) {
            $viewed_pages = $this->getViewed($user_id);

            if (count($viewed_pages) >= 5) {
                $this->deleteViewed($viewed_pages);
            }

            $views_count++;

            $sql = "INSERT INTO viewed SET user_id = '" . (int)$user_id . "', url = '" . $this->db->escape($url) . "', title = '" . $this->db->escape($title) . "', views = '" . (int)$views_count . "'";

            $this->db->query($sql);
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