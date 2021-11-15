<table>
  <tr>
    <th valign="top" align="left">
      <b>Account Code</b>
    </th>
    <th valign="top" align="left">
      <b>Account Name</b>
    </th>
    <th valign="top" align="center">
      <b>Beginning Balance</b>
    </th>
    <th valign="top" align="center">
      <b>Debit</b>
    </th>
    <th valign="top" align="center">
      <b>Credit</b>
    </th>
    <th valign="top" align="center">
      <b>Period Balance</b>
    </th>
    <th valign="top" align="center">
      <b>Ending Balance</b>
    </th>
  </tr>
  @foreach ($data as $data_row)
    @foreach ($data_row as $row)
      @php
        $font_weight = (strtolower($row->description) == 'header')? 'font-weight:bold;': '';
      @endphp
      <tr>
        <td valign="top" style="{{ $font_weight }}">{{ $row->code }}</td>
        <td valign="top" style="{{ $font_weight }}">{{ $row->name }}</td>
        <td valign="top" style="{{ $font_weight }}" align="right">{{$row->LastBalance}}</td>
        <td valign="top" style="{{ $font_weight }}" align="right">{{$row->Debit}}</td>
        <td valign="top" style="{{ $font_weight }}" align="right">-{{$row->Credit}}</td>
        <td valign="top" style="{{ $font_weight }} {{($row->period_balance < 0)? 'background:#ff9b9b;': '' }}"  align="right">{{$row->period_balance}}</td>
        <td valign="top" style="{{ $font_weight }}" align="right">{{$row->EndingBalance}}</td>
      </tr> 
    @endforeach
  @endforeach
  <tr>
    <td valign="top" colspan="2">Total</td>
    <td valign="top" align="right">{{ $total_beginning }}</td>
    <td valign="top" align="right">{{ $total_debit }}</td>
    <td valign="top" align="right">-{{ $total_credit }}</td>
    <td valign="top" align="right">{{ $total_period }}</td>
    <td valign="top" align="right">{{ $total_ending }}</td>
  </tr>
</table>
