<div class="row">
    <table class="table-sm table-striped table-bordered table-hover table-responsive">
        <thead>
            <tr class="bg-primary">
                <th class="small text-center"><small class="small">TICKET #</small></th>
                <th class="small text-center"><small class="small">CATEGORY</small></th>
                <th class="small text-center"><small class="small">TITLE</small></th>
                <th class="small text-center"><small class="small">DESCRIPTION</small></th>
                <th class="small text-center"><small class="small">CREATED BY</small></th>
                <th class="small text-center"><small class="small">DEPARTMENT</small></th>
                <th class="small text-center"><small class="small">DATE CREATED</small></th>
                <th class="small text-center"><small class="small">DATE RESOLVED</small></th>
                <th class="small text-center"><small class="small">DATE CLOSED</small></th>
                <th class="small text-center"><small class="small">RESOLVER</small></th>
                <th class="small text-center"><small class="small">STATUS</small></th>
                {{-- <th class="small text-center"><small class="small">TAT (ACK-RES)</small></th>
                <th class="small text-center"><small class="small">TAT (RES-CLO)</small></th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
            <tr>
                <td class="small text-center"><small class="small">{{$report->t_id}}</small></td>
                <td class="small text-center"><small class="small">{{$report->c_code}}</small></td>
                <td class="small text-center"><small class="small">{{$report->t_title}}</small></td>
                <td class="small text-center"><small class="small">{{ Str::limit($report->t_description, 27, $end='...') }}</small></td>
                <td class="small text-center"><small class="small">{{$report->created_by}}</small></td>
                <td class="small text-center"><small class="small">{{$report->d_code}}</small></td>
                <td class="small text-center"><small class="small">{{$report->created_at}}</small></td>
                <td class="small text-center"><small class="small">{{$report->t_resolveddate}}</small></td>
                <td class="small text-center"><small class="small">{{$report->t_closeddate}}</small></td>
                <td class="small text-center"><small class="small">{{$report->resolver}}</small></td>
                <td class="small text-center"><small class="small">{{$report->status}}</small></td>
                {{-- <td class="small text-center"><small class="small">{{$report->tat_ack_res}}</small></td>
                <td class="small text-center"><small class="small">{{$report->tat_res_clo}}</small></td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
</div>