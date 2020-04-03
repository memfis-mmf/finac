@foreach ($data as $items)
  <table>
      <tr>
          <td> Account Code</td>
          <td>:</td>
          <td> {{$items[0]->AccountCode}} - <span> {{$items[0]->Name}}</span> </td>
      </tr>
      <tr>
          <td>Period </td>
          <td>:</td>
          <td>{{$beginDate.' - '.$endingDate}}</td>
      </tr>
  </table><br>
    
  <table class="table table-striped table-bordered table-hover">
      <thead>
          <tr>
              <th>Date</th>
              <th>Transaction No.</th>
              <th>Ref. No.</th>
              <th>Description</th>
              <th>Debit</th>
              <th>Credit</th>
              <th>Ending Balance</th>
          </tr>
      </thead>
      <tbody>
          @foreach ($items as $item)
              <tr>
                  <td>{{$item->TransactionDate}}</td>
                  <td>{{$item->VoucherNo}}</td>
                  <td>-</td>
                  <td>{{$item->Description}}</td>
                  <td>Rp {{number_format($item->Debit, 0, 0, '.')}}</td>
                  <td>Rp {{number_format($item->Credit, 0, 0, '.')}}</td>
                  <td>Rp {{number_format($item->SaldoAwal, 0, 0, '.')}}</td>
              </tr>
          @endforeach
      </tbody>
  </table>

@endforeach