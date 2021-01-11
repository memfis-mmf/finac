<table cellpadding="6">
  <tr>
    <th valign="top" align="left">Account Code</th>
    <th valign="top" align="left">Account Name</th>
    <th valign="top" align="center">Beginning Balance</th>
    <th valign="top" align="center">Ending Balance</th>
    @for ($i = 0; $i < 6; $i++)
      <th valign="top" align="center">Debit</th>
      <th valign="top" align="center">Credit</th>
    @endfor
  </tr>
</table>
<table>
  @foreach ($data as $data_row)
    @php
      $substract = 2;
      $loop = strlen($data_row->COA) - $substract;
      if ($loop == 6) {
        $loop -= 1;
      }
    @endphp
    <tr>
      <td valign="top">{{ $data_row->code }}</td>
      <td valign="top">{{ $data_row->name }}</td>
      <td valign="top" align="center">{{$data_row->LastBalance}}</td>
      <td valign="top" align="center">{{$data_row->EndingBalance}}</td>
      @for ($i = 0; $i < $loop; $i++)
        <td valign="top" align="center"></td>
        <td valign="top" align="center"></td>
      @endfor
      <td valign="top" align="center">{{$data_row->Debit}}</td>
      <td valign="top" align="center">{{$data_row->Credit}}</td>
    </tr> 
  @endforeach
</table>
