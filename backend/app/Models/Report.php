<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Report extends Model
{
    public function generateReport($userdept, $selection){
        return DB::select("
            SELECT tickets.t_id, c_code, tickets.t_title, tickets.t_description, CONCAT(users.u_fname, ' ', users.u_lname) AS 'created_by', departments.d_code, tickets.created_at, tickets.t_resolveddate, tickets.t_closeddate, 
            (SELECT CONCAT(users.u_fname, ' ', users.u_lname) FROM users WHERE users.id = tickets.t_resolvedby) AS 'resolver',
            CASE
                WHEN tickets.t_status = 1 THEN 'New'
                WHEN tickets.t_status = 2 THEN 'Viewed'
                WHEN tickets.t_status = 3 THEN 'Assigned'
                WHEN tickets.t_status = 4 THEN 'Acknowledged'
                WHEN tickets.t_status = 5 THEN 'Resolved'
                WHEN tickets.t_status = 6 THEN 'Closed-Resolved'
                WHEN tickets.t_status = 7 THEN 'Cancelled'
            END AS 'status',
            CONCAT(
                TIMESTAMPDIFF(DAY, tickets.t_acknowledgeddate, tickets.t_resolveddate), ' days ',
                MOD(TIMESTAMPDIFF(HOUR, tickets.t_acknowledgeddate, tickets.t_resolveddate), 24), ' hrs ',
                MOD(TIMESTAMPDIFF(MINUTE, tickets.t_acknowledgeddate, tickets.t_resolveddate), 60), ' mins ',
                MOD(TIMESTAMPDIFF(SECOND, tickets.t_acknowledgeddate, tickets.t_resolveddate), 60), ' sec '
            ) AS 'tat_ack_res',
            CONCAT(
                TIMESTAMPDIFF(DAY, tickets.t_resolveddate, tickets.t_closeddate), ' days ',
                MOD(TIMESTAMPDIFF(HOUR, tickets.t_resolveddate, tickets.t_closeddate), 24), ' hrs ',
                MOD(TIMESTAMPDIFF(MINUTE, tickets.t_resolveddate, tickets.t_closeddate), 60), ' mins ',
                MOD(TIMESTAMPDIFF(SECOND, tickets.t_resolveddate, tickets.t_closeddate), 60), ' sec '
            ) AS 'tat_res_clo'
            FROM tickets
            LEFT JOIN users ON tickets.t_createdby = users.id
            RIGHT JOIN categories on tickets.t_category = categories.c_id
            RIGHT JOIN departments on users.u_department = departments.d_id
            WHERE tickets.t_todepartment = :userdept
            AND tickets.created_at BETWEEN :datefrom AND :dateto
            ORDER BY tickets.t_id DESC
        ", [
            'userdept' => $userdept,
            'datefrom' => $selection['datefrom'],
            'dateto' => $selection['dateto']
        ]);
    }
}
