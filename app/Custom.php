<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Custom extends Model
{
    /**
     * @param string $season
     * @param int $limit
     * @return array
     */
    public static function get_schedule_season($season = '2018 - 2019', $limit = 500)
    {
//        $schedule = DB::table('group_events AS a')
//
//            ->select(DB::raw(
//                "a.id,
//                from_unixtime(a.event_date,'%M %D %Y @ %h:%i %p' ) as event_date,
//                b.full_name as home_name,
//                a.event_opponent_name,
//                c.start_year,
//                a.group_result,
//                a.opponent_result
//                "
//            ))
//            ->join('groups AS b','a.group_id','=','b.group_page_id')
//            ->join('seasons AS c','a.season_id_home','=','c.season_id')
//            ->whereRaw('(a.opponent_result AND a.group_result) is null')
//            ->where('c.start_year','=',$season)
//            ->where('a.event_date','<=','UNIX_TIMESTAMP()')
//            ->orderBy('a.event_date','DESC')
//            ->take(20)
//            ->get();

        $schedule = DB::select("
        SELECT
        a.id,
               from_unixtime(a.event_date,'%M %D %Y @ %h:%i %p') as event_date,
               b.full_name as home_name,
               a.event_opponent_name,
               c.start_year,
               a.group_result,
               a.opponent_result
        FROM mygspn_live.group_events a
          INNER JOIN groups b on b.group_page_id = a.group_id 
          INNER JOIN seasons c on c.season_id = a.season_id_home
        WHERE (a.group_result AND a.opponent_result) is null
          AND c.start_year= :schedule
          AND a.event_date <= UNIX_TIMESTAMP()  
        ORDER by a.event_date DESC
        LIMIT :limit 
        ", ['schedule' => $season, 'limit' => $limit]
        );

        return $schedule;
    }
}
