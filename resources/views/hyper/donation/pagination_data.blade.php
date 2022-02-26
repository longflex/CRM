@foreach($donations as $donation)
<tr>
    <td><input type='checkbox' id="{{$donation->donated_by}}" name='sms' value="{{$donation->donated_by}}"></td>
    <td>{{$donation->id}}</td>
    <!-- <td>{{ $donation->receipt_number }}</td> -->
    <td>{{ $donation->name }}</td>
    <!-- <td>{{ $donation->created_name }}</td> -->
    <td>{{ $donation->donation_type }}</td>
    <td>{{ $donation->purpose??'N.A.' }}</td>
    <td>{{ $donation->amount }}</td>
    <!-- <td>{{ $donation->payment_mode=='OTHER'?$donation->payment_method:$donation->payment_mode }}</td> -->
    <td>{{ $donation->payment_type }}</td>
    <td>@php 
    if($donation->payment_status) {
        echo '<span class="badge badge-success">Paid</span>';
    }else{
        echo '<span class="badge badge-warning">Not Paid</span>';
    }
    @endphp
    <td>{{ $donation->location }}</td>
    <!-- <td>{{ ($donation->donation_date != NULL || $donation->donation_date != "") ? date('d-M-Y', strtotime($donation->donation_date)) : 'Not available' }}</td> -->
    <td>
        @php
        $button1='';
        $button2='';
        $button3='<a href="'.route('Crm::donation_edit', ['id' => $donation->id]).'" title="Edit Donation" class=""><i
                class="uil-edit font-20"></i></a>';
        $button4='<a href="javascript:void(0);" onclick="destroy('.$donation->id.')" title="Delete Donation" class=""><i
                class="uil-trash-alt font-20"></i></a>';
        if($donation->payment_type=='recurring'){
        $button1='<a href="'.route('Crm::payment_detail', ['id' => $donation->id]).'" title="View payment details"
            class=""><i class="uil-receipt-alt font-20"></i></a>';
        }else{
        $button2='<a href="'. route('Crm::donation_details', ['id' => $donation->id]) .'" title="Print"><i
                class="uil-print font-20"></i></a>';
        }
        echo $button1.$button2.$button3.$button4;
        @endphp

    </td>
</tr>
@endforeach
<tr>
    <td colspan="3" align="center">
        {!! $donations->links() !!}
    </td>
</tr>