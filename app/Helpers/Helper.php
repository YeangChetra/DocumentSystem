<?php
use Carbon\Carbon;
class Helper 
{
    public static function getTimesStatus($release_date, $CommentDate = '')
    {
        // dd($release_date, $CommentDate);

        $current_date = date('Y-m-d H:i:s');
        if(!$CommentDate){$CommentDate = $current_date;};

        $result = '';
        // $date1 = strtotime('2023-01-17 14:00:00');
        $date1 = strtotime($release_date);
        $date2 = strtotime($CommentDate);
        $diff = $date2 - $date1;

        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24)/ (30*60*60*24));
        $week = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24) / 7);
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        $hours = floor(($diff - ($years * 365*60*60*24) - ($months*30*60*60*24) - $days*60*60*24) / (60*60));
        $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24  - $hours*60*60)/ 60);
        $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));
        
        if($years != 0){
            $result = $years." years";
        }elseif($months != 0){
            $result = $months." months";
        }elseif($week != 0){
            $result = $week." weeks";
        }elseif($days != 0){
            $result = $days." days";
        }elseif($hours != 0){
            $result = $hours." hours";
        }elseif($minutes != 0){
            $result = $minutes." mins";
        }else{
            $result = $seconds." secounds";
        }
        return $result;
    }
}
?>