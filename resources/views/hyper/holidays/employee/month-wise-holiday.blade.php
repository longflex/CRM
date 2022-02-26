@forelse($holidays as $index => $holiday)
<tr> <td align="center">{{ $index+1 }}</td> <td>{{ $holiday->date->format("d-m-Y") }}</td> <td>{{ ucwords($holiday->occassion) }}</td> </tr>
@empty
    <tr> <td align="center" colspan="3">No Holiday found for this month. </td> </tr>

@endforelse