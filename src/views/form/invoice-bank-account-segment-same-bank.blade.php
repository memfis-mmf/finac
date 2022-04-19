<table width="100%" cellpadding="4" style="padding-top:10px">
    <tr>
        <td valign="top" width="18%">Bank Name</td>
        <td valign="top" width="1%">:</td>
        <td valign="top" width="31%">
            {{$bank1->bank->name}}
        </td>
        {{-- bank 2 --}}
        <td valign="top" width="18%">Bank Name</td>
        <td valign="top" width="1%">:</td>
        <td valign="top" width="31%">
            {{@$bank3->bank->name}}
        </td>
    </tr>
    <tr>
        <td valign="top" width="18%">Bank Acc Name</td>
        <td valign="top" width="1%">:</td>
        <td valign="top" width="31%">{{$bank1->name}}</td>
        {{-- bank 2 --}}
        <td valign="top" width="18%">Bank Acc Name</td>
        <td valign="top" width="1%">:</td>
        <td valign="top" width="31%">{{@$bank3->name}}</td>
    </tr>
    <tr>
        <td valign="top" width="18%">Bank Acc <b>{{ strtoupper($bank1->currency->code) }}</b> No.</td>
        <td valign="top" width="1%">:</td>
        <td valign="top" width="31%">{{$bank1->number}}</td>
        {{-- bank 2 --}}
        <td valign="top" width="18%">Bank Acc <b>{{ strtoupper(@$bank3->currency->code) }}</b> No.</td>
        <td valign="top" width="1%">:</td>
        <td valign="top" width="31%">{{@$bank3->number}}</td>
    </tr>
    <tr>
        @if ($bank1->currency->code != 'idr')
          <td valign="top" width="18%">Swift Code</td>
          <td valign="top" width="1%">:</td>
          <td valign="top" width="31%">{{$bank1->swift_code}}</td>
        @else
          <td valign="top" width="18%"></td>
          <td valign="top" width="1%"></td>
          <td valign="top" width="31%"></td>
        @endif
        {{-- bank 2 --}}
        @if (@$bank3->currency->code != 'idr')
          <td valign="top" width="18%">Swift Code</td>
          <td valign="top" width="1%">:</td>
          <td valign="top" width="31%">{{@$bank3->swift_code}}</td>
        @else
          <td valign="top" width="18%"></td>
          <td valign="top" width="1%"></td>
          <td valign="top" width="31%"></td>
        @endif
    </tr>
</table>
<table width="100%" cellpadding="4" style="padding-top:10px" style="margin-top:-5px">
    <tr>
        <td valign="top" width="18%">Bank Acc <b>{{ strtoupper(@$bank2->currency->code) }}</b> No.</td>
        <td valign="top" width="1%">:</td>
        <td valign="top" width="">{{@$bank2->number}}</td>
    </tr>
    @if (@$bank2->currency->code != 'idr')
      <tr>
          <td valign="top" width="18%">Swift Code</td>
          <td valign="top" width="1%">:</td>
          <td valign="top" width="">{{@$bank2->swift_code}}</td>
      </tr>
    @endif

    <tr>
        <td colspan="3" align="center"><i>PAYMENT SHOULD BE RECEIVED IN FULL AMOUNT</i></td>
    </tr>
</table>
