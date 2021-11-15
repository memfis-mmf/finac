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
    @php
      $font_weight = (strtolower($data_row->description) == 'header')? 'font-weight:bold;': '';
    @endphp
    <tr>
      <td valign="top" style="{{ $font_weight }}">{{ $data_row->code }}</td>
      <td valign="top" style="{{ $font_weight }}">{{ $data_row->name }}</td>
      <td valign="top" style="{{ $font_weight }}" align="right">{{$data_row->LastBalance}}</td>
      <td valign="top" style="{{ $font_weight }}" align="right">{{$data_row->Debit}}</td>
      <td valign="top" style="{{ $font_weight }}" align="right">-{{$data_row->Credit}}</td>
      <td valign="top" style="{{ $font_weight }} {{($data_row->period_balance < 0)? 'background:#ff9b9b;': '' }}"  align="right">{{$data_row->period_balance}}</td>
      <td valign="top" style="{{ $font_weight }}" align="right">{{$data_row->EndingBalance}}</td>
    </tr> 
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
