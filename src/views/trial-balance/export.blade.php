<table cellpadding="6">
  <tr>
    <th valign="top" align="left">Account Code</th>
    <th valign="top" align="left">Account Name</th>
    <th valign="top" align="center">Beginning Balance</th>
    <th valign="top" align="center">Period Balance</th>
    {{-- <th valign="top" align="center">Debit</th>
    <th valign="top" align="center">Credit</th> --}}
    <th valign="top" align="center">Ending Balance</th>
  </tr>
  @foreach ($data as $data_row)
    @php
      $substract = 2;
      $loop = strlen($data_row->COA) - $substract;
      if ($loop == 6) {
        $loop -= 1;
      }

      $space = '';
      for ($i=0; $i < $loop; $i++) { 
        $space .= '. ';
      }
    @endphp
    <tr>
      <td valign="top">{!! $space.$data_row->code !!}</td>
      <td valign="top">{{ $data_row->name }}</td>
      <td valign="top" align="center">{{$data_row->LastBalance}}</td>
      <td valign="top" align="center" {{ ($data_row->period_balance < 0)? "style=background:#ff9b9b;": '' }}>{{$data_row->period_balance}}</td>
      {{-- <td valign="top" align="center">{{$data_row->Debit}}</td>
      <td valign="top" align="center">{{$data_row->Credit}}</td> --}}
      <td valign="top" align="center">{{$data_row->EndingBalance}}</td>
    </tr> 
  @endforeach
</table>
