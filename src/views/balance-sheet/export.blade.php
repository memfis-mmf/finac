<table>

  <tr>

    <td>
      <h3>
        Date Period
        {{date('d/m/y', strtotime($beginDate))}} -
        {{date('d/m/y', strtotime($endingDate))}}
      </h3>
    </td>

  </tr>

</table>

<table cellpadding="8">
  <tr style="background:#5f6b5e; color:white;font-weight: bold;">
      <td >Account Code</td>
      <td align="center">Account Name</td>
      <td align="center">Total Balance</td>
  </tr>
  {{-- spasi --}}
  <tr>
      <td colspan="3"></td>
  </tr>
  <tr>
      <td colspan="3"></td>
  </tr>
  {{-- Activa --}}
  <tr style="color:blue;font-weight: bold;">
      <td colspan="3"><h3>ACTIVA</h3></td>
  </tr>
  @for ($index_activa=0; $index_activa < count($data['activa']); $index_activa++)
    @php
      $arr = $data['activa'][$index_activa];
    @endphp
    <tr style="font-weight: bold; border-bottom:1px solid black">
        <td colspan="3"><h3>{{$arr->name}}</h3></td>
    </tr>
    @for ($index_child=0; $index_child < count($arr->child); $index_child++)
      @php
        $arr2 = $arr->child[$index_child];
      @endphp
      <tr>
        <td >{{$arr2->code}}</td>
        <td >{{$arr2->name}}</td>
        <td align="center">{{$arr2->CurrentBalance}}</td>
      </tr>
    @endfor
    <tr style="background:#cfcfcf;font-weight: bold;">
      <td ><h5>Total {{$arr->name}}</h5></td>
      <td align="center"></td>
      <td align="center">{{$arr->total}}</td>
    </tr>
  @endfor
  {{-- spasi --}}
  <tr>
      <td colspan="3"></td>
  </tr>
  <tr>
      <td colspan="3"></td>
  </tr>
  {{-- total Activa --}}
  <tr style="background:#add8f7;font-weight: bold;">
      <td ><h5>Total Assets</h5></td>
      <td align="center"></td>
      <td align="center">{{$totalActiva}}</td>
  </tr>

  {{-- spasi --}}
  <tr>
      <td colspan="3"></td>
  </tr>
  <tr>
      <td colspan="3"></td>
  </tr>

  {{-- Pasiva --}}
  <tr style="color:blue;font-weight: bold;">
      <td colspan="3"><h3>PASIVA &amp; EQUITY</h3></td>
  </tr>
  @for ($index_activa=0; $index_activa < count($data['pasiva']); $index_activa++)
    @php
      $arr = $data['pasiva'][$index_activa];
    @endphp
    <tr style="font-weight: bold; border-bottom:1px solid black">
        <td colspan="3"><h3>{{$arr->name}}</h3></td>
    </tr>
    @for ($index_child=0; $index_child < count($arr->child); $index_child++)
      @php
        $arr2 = $arr->child[$index_child];
      @endphp
      <tr>
        <td >{{$arr2->code}}</td>
        <td >{{$arr2->name}}</td>
        <td align="center">{{$arr2->CurrentBalance}}</td>
      </tr>
    @endfor
    <tr style="background:#cfcfcf;font-weight: bold;">
      <td ><h5>Total {{$arr->name}}</h5></td>
      <td align="center"></td>
      <td align="center">{{$arr->total}}</td>
    </tr>
  @endfor
  {{-- spasi --}}
  <tr>
      <td colspan="3"></td>
  </tr>
  <tr>
      <td colspan="3"></td>
  </tr>
  {{-- total Activa --}}
  <tr style="background:#add8f7;font-weight: bold;">
      <td ><h5>Total Liabilitie &amp; Equities</h5></td>
      <td align="center"></td>
      <td align="center">{{$totalPasiva}}</td>
  </tr>
</table>