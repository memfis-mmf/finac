<?php

namespace Directoryxx\Finac\Model;

use Directoryxx\Finac\Model\MemfisModel;
use DB;

class QueryFunction extends MemfisModel
{
	static public function run()
	{

		try {
			QueryFunction::getCoaHeader();
			QueryFunction::startDate();
			QueryFunction::endDate();
			QueryFunction::neraca();
			QueryFunction::mJournal();

			return 'query success';
		} catch (\Exception $e) {
			return $e;
		}
	}

	static public function getCoaHeader()
	{
		$query = "
		DROP FUNCTION IF EXISTS GetCoaHeader;

		DELIMITER $$

		CREATE
			FUNCTION `GetCoaHeader`(AccountCode varchar(255))
		    RETURNS varchar(255) CHARSET utf8mb4
		        DETERMINISTIC

		BEGIN
			DECLARE Result varchar(255);
			SET Result = AccountCode;
		WHILE ((RIGHT(Result,1)='0') OR (RIGHT(Result,1)='.')) DO
			SET Result = SUBSTRING(Result,1,LENGTH(Result)-1);
		END WHILE;

		RETURN Result;
		END $$
		DELIMITER ;
		";

		$result = DB::connection()->getpdo()->exec($query);

		return $result;
	}

	static public function startDate()
	{
		$query = "
			DROP FUNCTION IF EXISTS StartDate;

			CREATE
				FUNCTION StartDate()
					RETURNS date
					NO SQL
					DETERMINISTIC
			return @StartDate;
		";

		$result = DB::connection()->getpdo()->exec($query);

		return $result;
	}

	static public function endDate($value='')
	{
		$query = "
			DROP FUNCTION IF EXISTS EndDate;

			CREATE
				FUNCTION `EndDate`()
					RETURNS date
					NO SQL
					DETERMINISTIC
			return @EndDate;
		";

		$result = DB::connection()->getpdo()->exec($query);

		return $result;
	}

	static public function neraca()
	{
		$query = "
			DROP VIEW IF EXISTS neraca;

			CREATE
				ALGORITHM=UNDEFINED
				VIEW `neraca` AS

			select `d`.`account_code` AS `AccountCode`,
			(
			case when (cast(`h`.`transaction_date` as date) < `StartDate`())
			then
			(
			case when ((`a`.`Type` = 'activa') or (`a`.`Type` = 'biaya'))
			then
			(`d`.`debit` - `d`.`credit`)
			else
			(`d`.`credit` - `d`.`debit`)
			end
			)
			else
			0
			end
			) AS `LastBalance`,
			(
			case when
			(cast(`h`.`transaction_date` as date) between `StartDate`() and `EndDate`())
			then
			(
			case when
			((`a`.`Type` = 'activa') or (`a`.`Type` = 'biaya'))
			then
			(`d`.`debit` - `d`.`credit`)
			else
			(`d`.`credit` - `d`.`debit`)
			end
			)
			else
			0
			end
			) AS `CurrentBalance`,
			(
			case when
			(cast(`h`.`transaction_date` as date) <= `EndDate`())
			then
			(
			case when ((`a`.`Type` = 'activa') or (`a`.`Type` = 'biaya'))
			then
			(`d`.`debit` - `d`.`credit`)
			else
			(`d`.`credit` - `d`.`debit`)
			end
			)
			else
			0
			end
			) AS `EndingBalance`
			from
			((`trxjournals` `h`
			left join `trxjournala` `d`
			on((`h`.`voucher_no` = `d`.`voucher_no`)))
			left join `m_journal` `a`
			on((`d`.`account_code` = `a`.`code`)))
			where
			((`h`.`approve` = 1)
			and
			(`d`.`account_code` not in ('31131001','31131002')))
			union all
			select
			'31131001' AS `account_code`,
			(
			case when
			((cast(`h`.`transaction_date` as date) < `StartDate`()) and (year(`h`.`transaction_date`) = year(`StartDate`())))
			then
			(`d`.`credit` - `d`.`debit`)
			else
			0
			end
			) AS `LastBalance`,
			(
			case when
			((cast(`h`.`transaction_date` as date) between `StartDate`() and `EndDate`()) and (year(`h`.`transaction_date`) = year(`StartDate`())))
			then
			(`d`.`credit` - `d`.`debit`)
			else
			0
			end
			) AS `CurrentBalance`,
			(
			case when
			((cast(`h`.`transaction_date` as date) <= `EndDate`()) and (year(`h`.`transaction_date`) = year(`StartDate`())))
			then
			(`d`.`credit` - `d`.`debit`)
			else
			0
			end
			) AS `EndingBalance`
			from
			((`trxjournals` `h`
			left join `trxjournala` `d`
			on((`h`.`voucher_no` = `d`.`voucher_no`)))
			left join `m_journal` `a`
			on((`d`.`account_code` = `a`.`code`)))
			where
			((`h`.`approve` = 1) and ((`d`.`account_code` in ('31131001','31131002')) or (`a`.`Type` = 'pendapatan') or (`a`.`Type` = 'biaya')))
			union all
			select
			'31131002' AS `account_code`,
			(
			case when
			((cast(`h`.`transaction_date` as date) < `StartDate`()) and (year(`h`.`transaction_date`) < year(`StartDate`())))
			then
			(`d`.`credit` - `d`.`debit`)
			else
			0
			end
			) AS `LastBalance`,
			(
			case when
			((cast(`h`.`transaction_date` as date) between `StartDate`() and `EndDate`()) and (year(`h`.`transaction_date`) < year(`StartDate`())))
			then
			(`d`.`credit` - `d`.`debit`)
			else
			0
			end
			) AS `CurrentBalance`,
			(
			case when
			((cast(`h`.`transaction_date` as date) <= `EndDate`()) and (year(`h`.`transaction_date`) < year(`StartDate`())))
			then
			(`d`.`credit` - `d`.`debit`)
			else
			0
			end
			) AS `EndingBalance`
			from
			((`trxjournals` `h`
			left join `trxjournala` `d`
			on((`h`.`voucher_no` = `d`.`voucher_no`)))
			left join `m_journal` `a`
			on((`d`.`account_code` = `a`.`code`)))
			where ((`h`.`approve` = 1) and ((`d`.`account_code` in ('31131001','31131002')) or (`a`.`Type` = 'pendapatan') or (`a`.`Type` = 'biaya')));
		";

		$result = DB::connection()->getpdo()->exec($query);

		return $result;
	}

	static public function mJournal()
	{
		$query = "
			DROP VIEW IF EXISTS m_journal;

			CREATE
			    ALGORITHM = UNDEFINED
			VIEW `m_journal` AS
			    SELECT
			        `coas`.`id` AS `id`,
			        `coas`.`code` AS `code`,
			        `coas`.`name` AS `name`,
			        `types`.`code` AS `Type`,
			        `coas`.`description` AS `description`,
			        (CASE
			            WHEN (`coas`.`description` = 'Header') THEN GETCOAHEADER(`coas`.`code`)
			            ELSE `coas`.`code`
			        END) AS `COA`
			    FROM
			        (`coas`
			        LEFT JOIN `types` ON ((`coas`.`type_id` = `types`.`id`)));
		";

		$result = DB::connection()->getpdo()->exec($query);

		return $result;
	}
}
