<?php

namespace Directoryxx\Finac\Model;


use Directoryxx\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;
use Directoryxx\Finac\Model\TrxJournalA;
use Directoryxx\Finac\Model\TypeJurnal;
use App\Models\GoodsReceived as GRN;
use App\Models\Currency;

class TrxJournal extends MemfisModel
{
    protected $table = "trxjournals";

    protected $fillable = [
		'approve',
		'id_BS',
		'transaction_number',
		'transaction_date',
		'value',
		'coac',
		'coad',
		'description',
    ];

}
