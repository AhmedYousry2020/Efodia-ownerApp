<?php
  class Dates {
    
    public function getNow(){
      return date("Y-m-d H:i");
    }

    public function getNowPlusDays($days){
      return date("Y-m-d H:i", strtotime('+'. $days .' days'));
    }

    public function getPrevFromNow($month){
      return date('Y:m:d H:i', strtotime('-'. $month .' month'));
    }

    public function getPrevFromDate($month, $date){
      return date('Y-m-d', strtotime('-'. $month .' month',strtotime($date)));
    }
    

    public function getNextFromNow($month){
      return date('Y:m:d H:i', strtotime('+'. $month .' month'));
    }


    public function getNextFromDate($month, $date){
      return date('Y-m-d', strtotime('+'. $month .' month',strtotime($date)));
    }

  }
  
?>