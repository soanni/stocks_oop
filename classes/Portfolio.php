<?php

class Portfolio{
    protected $_date;
    protected $_quotes = array();
    protected $_priceOnDate = 0;

    public function __construct($date){
        require_once('db_new.inc.php');
        $this->_date = $date;
        $sql = 'SELECT
                    m.accountid
                    ,m.qid
                    ,SUM(CASE
                            WHEN movetype = 1 THEN amount
                            ELSE -1 * amount
                        END) as sum_amount
                    ,SUM(CASE
                            WHEN movetype = 1 THEN amountlot
                            ELSE -1 * amountlot
                        END) as sum_amountlot
                    ,SUM(CASE
                            WHEN movetype = 1 THEN total
                            ELSE -1 * total
                        END) as sum_total
                FROM movements m
                WHERE m.movedate <= :date
                GROUP BY accountid,qid HAVING sum_amount > 0';
        try{
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':date',$date);
            $stmt->execute();
        }catch(PDOException $e){
            $error = $e->getMessage();
            $redirect = 'error.html.php';
            header("Location: $redirect");
            exit;
        }
        while($row = $stmt->fetch()){
            $this->_quotes[] = array('quote'=>new Quote($row['qid'])
            ,'sum_amount'=>$row['sum_amount']
            ,'sum_amountlot'=>$row['sum_amountlot']
            ,'sum_total'=>$row['sum_total']);
            $this->_priceOnDate += $row['sum_total'];
        }
    }

    ////////////////////////// getters
    public function getDate()
    {
        return $this->_date;
    }

    public function getQuotes()
    {
        return $this->_quotes;
    }


    public function getPriceOnDate()
    {
        return $this->_priceOnDate;
    }

    //////////////////////////

    public function printPortfolio(){
        if(!empty($this->_quotes)){
            echo '<div>
                    <table>
                    <tr>
                        <th>Quote</th>
                        <th>SECID</th>
                        <th>Amount</th>
                        <th>Amount lots</th>
                        <th>Total</th>
                    </tr>';
            foreach($this->_quotes as $item){
                $qname = $item['quote']->getQuoteName();
                $secid = $item['quote']->getAcronym();
                $amount = $item['sum_amount'];
                $amountlot = $item['sum_amountlot'];
                $total = $item['sum_total'];

                echo "<tr>
                        <td>$qname</td>
                        <td>$secid</td>
                        <td>$amount</td>
                        <td>$amountlot</td>
                        <td>$total</td>
                        </tr>";
            }
            echo '</table></div>';
        }
    }
}