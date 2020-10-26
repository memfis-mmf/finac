<table class="table table-hover table-striped table-bordered">
  <thead>
    <tr>
      <th>Journal Transaction Date</th>
      <th>Journal Number</th>
      <th>Journal Amount</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($journal as $journal_row)
      <tr>
        <td>{{ $journal_row->transaction_date }}</td>
        <td>{{ $journal_row->voucher_no }}</td>
        <td>{{ $journal_row->currency->symbol.' '.number_format($journal_row->total_transaction, '0', ',', '.') }}</td>
      </tr>
    @endforeach
  </tbody>
</table>