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
      // $substract = 2;
      // $loop = strlen($data_row->COA) - $substract;
      // if ($loop == 6) {
      //   $loop -= 1;
      // }

      // $space = '';
      // for ($i=0; $i < $loop; $i++) { 
      //   $space .= '. ';
      // }

      $font_weight = (strtolower($data_row->description) == 'header')? 'font-weight:bold;': '';
    @endphp
    <tr>
      <td valign="top" style="{{ $font_weight }}">{{ $data_row->code }}</td>
      <td valign="top" style="{{ $font_weight }}">{{ $data_row->name }}</td>
      <td valign="top" style="{{ $font_weight }}" align="center">{{$data_row->LastBalance}}</td>
      <td valign="top" style="{{ $font_weight }}" align="center">{{$data_row->Debit}}</td>
      <td valign="top" style="{{ $font_weight }}" align="center">-{{$data_row->Credit}}</td>
      <td valign="top" style="{{ $font_weight }} {{($data_row->period_balance < 0)? 'background:#ff9b9b;': '' }}"  align="center">{{$data_row->period_balance}}</td>
      <td valign="top" style="{{ $font_weight }}" align="center">{{$data_row->EndingBalance}}</td>
    </tr> 
  @endforeach
</table>
