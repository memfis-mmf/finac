<table cellpadding="6">
  <tr>
    <th valign="top" align="left">Account Code</th>
    <th valign="top" align="left">Account Name</th>
    <th valign="top" align="center">Beginning Balance</th>
    <th valign="top" align="center">Debit</th>
    <th valign="top" align="center">Credit</th>
    <th valign="top" align="center">Ending Balance</th>
  </tr>
  @for ($i = 0; $i < count($data); $i++)
    @for ($j=0; $j < count($data[$i]); $j++)
      @php
        $x = $data[$i][$j];
      @endphp
      <tr>
        <td valign="top">{{ $x->code }}</td>
        <td valign="top">{{ $x->name }}</td>
        <td valign="top" align="center">{{$x->LastBalance}}</td>
        <td valign="top" align="center">{{$x->Debit}}</td>
        <td valign="top" align="center">{{$x->Credit}}</td>
        <td valign="top" align="center">{{$x->EndingBalance}}</td>
      </tr>
    @endfor
  @endfor
</table>
