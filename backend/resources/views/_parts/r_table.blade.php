<div class="row">
    <table class="table-sm table-stripped table-bordered table-hover table-responsive">
        <thead>
            <th>TICKET #</th>
            <th>CATEGORY</th>
            <th>TITLE</th>
            <th>DESCRIPTION</th>
            <th>CREATED BY</th>
            <th>DEPARTMENT</th>
            <th>DATE CREATED</th>
            <th>DATE RESOLVED</th>
            <th>DATE CLOSED</th>
            <th>RESOLVER</th>
            <th>STATUS</th>
            <th>TAT (ACK-RES)</th>
            <th>TAT (RES-CLO)</th>
        </thead>
        <tbody>
            @foreach($reports as $report)
            <tr>
                <td class="small">{{$report->t_id}}</td>
                <td class="small">{{$report->c_code}}</td>
                <td class="small">{{$report->t_title}}</td>
                <td class="small">{{$report->t_description}}</td>
                <td class="small">{{$report->created_by}}</td>
                <td class="small">{{$report->d_code}}</td>
                <td class="small">{{$report->created_at}}</td>
                <td class="small">{{$report->t_resolveddate}}</td>
                <td class="small">{{$report->t_closeddate}}</td>
                <td class="small">{{$report->resolver}}</td>
                <td class="small">{{$report->status}}</td>
                <td class="small">{{$report->tat_ack_res}}</td>
                <td class="small">{{$report->tat_res_clo}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>