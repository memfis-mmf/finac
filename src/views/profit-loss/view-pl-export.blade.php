<table>
  <tr>
    <td>
      <h3>
        Date Period {{ date('d/m/y', strtotime($beginDate)) }} -
        {{ date('d/m/y', strtotime($endingDate)) }}
      </h3>
    </td>
  </tr>
</table>

<table cellpadding="8">
  <tr style="background:#5f6b5e; color:white;font-weight: bold;font-size:16px">
    <td>Account Code</td>
    <td>Account Name</td>
    <td align="right">Accumulated</td>
    <td align="right">Period</td>
  </tr>
  @for ($a=0; $a < count($data['pendapatan']); $a++) @php
    $x=$data['pendapatan'][$a]; @endphp 
    <tr style="font-weight: bold; border-bottom:1px solid black; font-size:16px">
      <td>{{$x->name}}</td>
      <td></td>
      <td align="right">
        {{$x->CurrentBalance}}
      </td>
      <td align="right">
        {{$x->EndingBalance}}
      </td>
    </tr>
    @for ($b=0; $b < count($x->child); $b++)
      @php
        $y = $x->child[$b];
      @endphp
      <tr>
        <td>{{$x->code}}</td>
        <td>{{$y->name}}</td>
        <td align="right">
          {{$y->CurrentBalance}}
        </td>
        <td align="right">
          {{$y->EndingBalance}}
        </td>
      </tr>
    @endfor
  @endfor

  <tr>
    <td colspan="4"></td>
  </tr>
  <tr>
    <td colspan="4"></td>
  </tr>

  <tr style="background:#add8f7;font-weight: bold;font-size:16px">
      <td>
          Total Revenue
      </td>
      <td></td>
      <td align="right">
        {{$pendapatan_accumulated}}
      </td>
      <td align="right">
        {{$pendapatan_period}}
      </td>
  </tr>

  <tr>
      <td colspan="4"></td>
  </tr>
  <tr>
      <td colspan="4"></td>
  </tr>

  {{-- Biaya --}}
  @for ($a=0; $a < count($data['biaya']); $a++) 
    @php
      $x=$data['biaya'][$a]; 
    @endphp 
    <tr style="font-weight: bold; border-bottom:1px solid black; font-size:16px">
      <td>{{$x->name}}</td>
      <td></td>
      <td align="right">
        {{$x->CurrentBalance}}</td>
      <td align="right">
        {{$x->EndingBalance}}
      </td>
    </tr>
    @for ($b=0; $b < count($x->child); $b++)
      @php
      $y = $x->child[$b];
      @endphp
      <tr>
      <td>{{$x->code}}</td>
        <td>{{$y->name}}</td>
        <td align="right">
          {{$y->CurrentBalance}}
        </td>
        <td align="right">
          {{$y->EndingBalance}}
        </td>
      </tr>
    @endfor
  @endfor
  <tr>
      <td colspan="4"></td>
  </tr>
  <tr>
      <td colspan="4"></td>
  </tr>
  <tr
      style="background:#add8f7;font-weight: bold; font-size:16px">
      <td>
          Total Expense
      </td>
      <td></td>
      <td align="right">
          {{$biaya_accumulated}}</td>
      <td align="right">
          {{$biaya_period}}</td>
  </tr>
</table>