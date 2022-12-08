<?php
    $filepath = realpath(dirname(__FILE__));
    include_once($filepath.'/../lib/database.php');
    include_once($filepath.'/../helpers/format.php');
?>
<?php
class chart
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function statistical_revenue($option = 'day')
    {
        $query = match($option) {
            'day' => "SELECT CONCAT(date_order, '-', month_order, '-', year_order) as date,  sum(quantity*price) as revenue FROM `tbl_order` GROUP BY date_order, month_order, year_order ORDER BY date asc",
            'month' => "SELECT CONCAT(month_order, '-', year_order) as date,  sum(quantity*price) as revenue FROM `tbl_order` GROUP BY month_order, year_order ORDER BY date asc",
            'year' => "SELECT CONCAT(year_order) as date,  sum(quantity*price) as revenue FROM `tbl_order` GROUP BY year_order ORDER BY date asc",
            default => "SELECT CONCAT(date_order, '-', month_order, '-', year_order) as date,  sum(quantity*price) as revenue FROM `tbl_order` GROUP BY date_order, month_order, year_order ORDER BY date asc"
        };

        $result = $this->db->select($query);

        return $result;
    }

    public function statistical_revenue_by_date($dateFrom, $dateTo)
    {
        $addSql = " 1 = 1 ";
        if ($dateFrom) {
            $addSql = " CONCAT(year_order, '-', month_order, '-', date_order) >= '$dateFrom' ";
        }

        if ($dateTo) {
            if ($dateFrom) {
                $addSql .= " AND ";
            }
            $addSql .= " CONCAT(year_order, '-', month_order, '-', date_order) <= '$dateTo'";
        }

        $query = "SELECT CONCAT(date_order, '-', month_order, '-', year_order) as date,  sum(quantity*price) as revenue FROM `tbl_order` GROUP BY date_order, month_order, year_order HAVING  $addSql ORDER BY date asc";

        $result = $this->db->select($query);

        return $result ?: [];
    }

    public function statistical_order_cutomer($month) {
        $query = "SELECT tbl_customer.name, count(tbl_order.id) as 'count', CONCAT(year_order, '-', month_order) as 'month' from tbl_order INNER JOIN tbl_customer ON tbl_customer.id = tbl_order.customer_id GROUP BY tbl_order.customer_id, month_order, year_order HAVING month = '$month' ORDER BY count desc LIMIT 10" ;

        $result = $this->db->select($query);

        return $result ?: [];
    }

    public function statistical_order_product($option) {
        $query = "SELECT tbl_order.productId, tbl_product.productName , count(id) as count from tbl_order INNER JOIN tbl_product on tbl_order.productId = tbl_product.productId GROUP BY tbl_order.productId " ;

        $query .= match($option) {
            'day' => ", date_order, month_order, year_order",
            'month' => ", month_order, year_order",
            'year' => ", year_order",
            default => ''
        };

        $query .= " ORDER BY count  DESC";

        $result = $this->db->select($query);

        return $result ?: [];
    }

    private function formatDate(&$date) {
        // foreach ($dateArr as &$value) {
        //     $string = (string) $value;
        //     if ($string[0] == '0') {
        //         $value = substr($string, 1);
        //         continue;
        //     }

        //     $value = $string;
        // }
        // $date = implode('-', $dateArr);
    }
}
?>