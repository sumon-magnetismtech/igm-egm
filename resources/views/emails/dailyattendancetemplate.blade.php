@component('mail::message')
<strong>Good Morning,</strong>
<br>
Hope you are doing great.
Today's ({{now()->format('l, d-M-Y')}}) attendance as below:


<table id="mailTable" style="border-collapse: collapse; border: 1px solid #e8e8e8;">
    <thead>
    <tr>
        <th>Employee Name </th>
        <th>In Time</th>
        <th>Late</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>Employee Name </th>
        <th>In Time</th>
        <th>Late</th>
    </tr>
    </tfoot>
    <tbody>
    @forelse($dailyAttendance as $attendance)
        <tr>
            <td>{{$attendance->employee->name}}</td>
            <td>{{$attendance->in_time}}</td>
            <td style="color: #e10000">
                @if($attendance->late)
                    <strong>
                        @if($attendance->late > 60)
                            {{intdiv($attendance->late, 60).":".($attendance->late % 60)}} Min(s)
                        @else
                            {{$attendance->late}} Min(s)
                        @endif
                    </strong>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8"><h5 class="text-muted my-3"> No Data Found Based on your query. </h5> </td>
        </tr>
    @endforelse

    </tbody>
</table>

<p></p>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
