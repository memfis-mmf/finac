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

<table width="100%" cellpadding="8">
  <tr style="background:#5f6b5e; color:white;font-weight: bold;font-size:16px">
    <td width="25%">Account Code</td>
    <td width="55%">Account Name</td>
    <td width="10%" align="right">Accumulated</td>
    <td width="10%" align="right">Period</td>
  </tr>
  @for ($a=0; $a < count($data['pendapatan']); $a++) @php
    $x=$data['pendapatan'][$a]; @endphp 
    <tr style="font-weight: bold; border-bottom:1px solid black; font-size:16px">
      <td width="25%">{{$x->name}}</td>
      <td width="55%"></td>
      <td width="10%" align="right">
        {{$x->CurrentBalance}}
      </td>
      <td width="10%" align="right">
        {{$x->EndingBalance}}
      </td>
    </tr>
    @for ($b=0; $b < count($x->child); $b++)
      @php
        $y = $x->child[$b];
      @endphp
      <tr>
        <td width="25%">{{$x->code}}</td>
        <td width="55%">{{$y->name}}</td>
        <td width="10%" align="right">
          {{$y->CurrentBalance}}
        </td>
        <td width="10%" align="right">
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
      <td width="25%">
          Total Revenue
      </td>
      <td width="55%"></td>
      <td width="10%" align="right">
        {{$pendapatan_accumulated}}
      </td>
      <td width="10%" align="right">
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
      <td width="25%">{{$x->name}}</td>
      <td width="55%"></td>
      <td width="10%" align="right">
        {{$x->CurrentBalance}}</td>
      <td width="10%" align="right">
        {{$x->EndingBalance}}
      </td>
    </tr>
    @for ($b=0; $b < count($x->child); $b++)
      @php
      $y = $x->child[$b];
      @endphp
      <tr>
      <td width="25%">{{$x->code}}</td>
        <td width="55%">{{$y->name}}</td>
        <td width="10%" align="right">
          {{$y->CurrentBalance}}
        </td>
        <td width="10%" align="right">
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
      <td width="25%">
          Total Expense
      </td>
      <td width="55%"></td>
      <td width="10%" align="right">
          {{$biaya_accumulated}}</td>
      <td width="10%" align="right">
          {{$biaya_period}}</td>
  </tr>
</table>