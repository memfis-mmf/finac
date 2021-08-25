<table>
  <tr>
    <td>Account Code</td>
    <td>:</td>
    <td>{{ $account_code }}</td>
  </tr>
  <tr>
    <td>Account Name</td>
    <td>:</td>
    <td>{{ $account_name }}</td>
  </tr>
  <tr>
    <td>Currency</td>
    <td>:</td>
    <td>{{ $currency }}</td>
  </tr>
</table>
<table>
  <tr>
    <td width="" align="left" valign="top"><b>Date</b></td>
    <td width="" align="center" valign="top"><b>Description</b></td>
    <td width="" align="center" valign="top"><b>Reference</b></td>
    <td width="" align="center" valign="top"><b>Transaction No</b></td>
    <td width="" align="right" valign="top"><b>Debit</b></td>
    <td width="" align="right" valign="top"><b>Credit</b></td>
    <td width="" align="right" valign="top"><b>Balance</b></td>
  </tr>
</table>
<table>
  @foreach ($data as $data_row)
  <tr>
    <td>{{ $data_row->date }}</td>
    <td>{{ $data_row->description }}</td>
    <td>{{ $data_row->ref }}</td>
    <td>{{ $data_row->number }}</td>
    <td>{{ $data_row->debit }}</td>
    <td>{{ $data_row->credit }}</td>
    <td>{{ $data_row->balance }}</td>
  </tr>
  @endforeach
</table>