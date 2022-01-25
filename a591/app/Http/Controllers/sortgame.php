<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GameMaster;
use App\Models\GameSpec;

use DB;



class sortgame extends Controller
{
	public function __construct()
	{
		$this->code_masterList = [
			'vs20olympgate',
			'vs243lionsgold',
			'vs20fruitsw',
			'vswaysrhino',
			'vs20starlight',
			'vs20santawonder',
			'vs243caishien',
			'vs88hockattack',
			'vswayslions',
			'vs10bxmasbnza',
			'vs20sbxmas',
			'vs4096bufking',
			'vs7pigs',
			'vs243lions',
			'vs10firestrike',
			'vs20bonzgold',
			'vs20bermuda',
			'vs25btygold',
			'vs25scarabqueen',
			'vswaysbufking',
			'vs10bookfallen',
			'vs5joker',
			'vs1dragon8',
			'vs1tigers',
			'vs12bbb',
			'vs20candvil',
			'vswaysdogs',
			'vs20tweethouse',
			'vs20goldfever',
			'vs20doghouse',
			'vs243fortune',
			'vs20vegasmagic',
			'vs20pbonanza',
			'vs10fruity2',
			'vs20fparty2',
			'vs20eightdragons',
			'vs20fruitparty',
			'vswayschilheat',
			'vswayshammthor',
			'vs7776aztec',
			'vs25mmouse',
			'vs25kingdoms',
			'vs10floatdrg',
			'vs20terrorv',
			'vs9piggybank',
			'vs20xmascarol',
			'vs10nudgeit',
			'vs9madmonkey',
			'vs20rhino',
			'vs10cowgold',
			'vs243mwarrior',
			'vs1024lionsd',
			'vs40wildwest',
			'vs25mustang',
			'cs5triple8gold',
			'vs20trsbox',
			'vs5aztecgems',
			'vs20magicpot',
			'vs10bbbonanza',
			'vswaysmadame',
			'vs1600drago',
			'vs576treasures',
			'vs20emptybank',
			'vs243chargebull',
			'vs25journey',
			'vs20midas',
			'vswaysbankbonz',
			'vs10amm',
			'vs20phoenixf',
			'vswayslight',
			'cs5moneyroll',
			'vs25peking',
			'vs25wolfgold',
			'vswayssamurai',
			'vs40pirate',
			'vs5ultra',
			'vs10bblpop',
			'vswayswest',
			'vs20rhinoluxe',
			'vswaysyumyum',
			'vs243crystalcave',
			'vs75empress',
			'vs1money',
			'vs5hotburn',
			'vs25goldpig',
			'vs40bigjuan',
			'vswaysaztecking',
			'vs10egyptcls',
			'vs20chickdrop',
			'vs25pandatemple',
			'vs25gldox',
			'vs25pandagold',
			'vswayswerewolf',
			'vs1fortunetree',
			'vs25aztecking',
			'vs5super7',
			'vs243dancingpar',
			'vs25rio',
			'vs432congocash',
			'vs7monkeys',
			'vs7fire88',
			'vs75bronco',
			'vs25hotfiesta',
			'cs3w',
			'vs25dwarves_new',
			'vs1024temuj',
			'vswayshive',
			'vs25chilli',
			'vs243fortseren',
			'vs20cm',
			'vs25wildspells',
			'vs576hokkwolf',
			'vs10goldfish',
			'vs18mashang',
			'vs5spjoker',
			'vs15fairytale',
			'vs20kraken',
			'vs20leprexmas',
			'vs25dragonkingdom',
			'vs20chicken',
			'cs3irishcharms',
			'vs20daydead',
			'vs50kingkong',
			'vs20egypttrs',
			'vs10starpirate',
			'vs20bl',
			'vs9aztecgemsdx',
			'vs50juicyfr',
			'vs1ball',
			'vs5trdragons',
			'vs25goldrush',
			'vs25newyear',
			'vs15diamond',
			'vs25queenofgold',
			'vs25davinci',
			'vs20santa',
			'vs10bookoftut',
			'vs25safari',
			'vs10wildtut',
			'vs25asgard',
			'vs7776secrets',
			'vs50aladdin',
			'vs10returndead',
			'vs25tigerwar',
			'vs20hercpeg',
			'vs20honey',
			'vs10threestar',
			'vs40frrainbow',
			'vs13ladyofmoon',
			'vs40pirgold',
			'vs25pyramid',
			'vs10luckcharm',
			'vs40streetracer',
			'vs25sea',
			'vs117649starz',
			'vs10vampwolf',
			'vs40spartaking',
			'vs25samurai',
			'vs50pixie',
			'vs4096mystery',
			'vs10egypt',
			'vs3train',
			'vs20wildboost',
			'vs1fufufu',
			'vs20eking',
			'vs8magicjourn',
			'vs9chen',
			'vs25bkofkngdm',
			'vs20godiva',
			'vs1masterjoker',
			'vs25walker',
			'vs20ekingrr',
			'vs20leprechaun',
			'vs40madwheel',
			'vs1024butterfly',
			'vs1024dtiger',
			'vs10mayangods',
			'vs40voodoo',
			'vs50chinesecharms',
			'vs25champ',
			'vs10eyestorm',
			'vs25vegas',
			'vs20wildpix',
			'vs9hotroll',
			'vs20hburnhs',
			'vs5ultrab',
			'vs50amt',
			'vs25pantherqueen',
			'vs5drhs',
			'vs4096jurassic',
			'vs20gorilla',
			'vs25jokerking',
			'vs10madame',
			'vs40beowulf',
			'vs5drmystery',
			'vs25dwarves',
			'vs25gladiator',
			'vs1024atlantis',
			'vs5trjokers',
			'vs20aladdinsorc',
			'vs13g',
			'vs20rome',
			'vs20egypt',
			'vs50hercules',
			'vs50safariking',
		];
		$this->strList = 'FIELD(code_master, ';
		foreach ($this->code_masterList as $value) {
			// $this->strList .= "$value,";
			$this->strList .= "'$value',";
		}
		$this->strList = substr($this->strList, 0, -1);
		$this->strList .= ')';
		// echo $this->strList;
	}

	public function sortgame()
	{

		$masterList = [
			'vs7pigs',
			'vs243lionsgold',
		];
		// $phone = User::find(1)->phone;
		// $id = GameMaster::where('id', 1197)->get();
		// $id = GameMaster::find(1197);
		// $id = GameMaster::where('id', 1197)->first()->find("id");
		// $id = GameMaster::where('id', 1197)->limit(1)->with('GameSpec')->get();	//計算關聯數量
		// $id = GameMaster::where('id', 1197)->with('GameSpec')->with('GameCategory')->get()->toArray();	//關聯
		// $id = GameMaster::where('id', 1197)->with('GameSpec')->get()->toArray();	//關聯
		// $id = GameMaster::where('id', '1197')->get();	//關聯
		// $id = GameMaster::find(1197);	//關聯
		// $id = GameSpec::whereIn('code_master', $this->code_masterList)->orderByRaw('code_master', $this->strList)->with('GameMaster')->get()->pluck('id_GameMaster')->toArray();	//關聯
		// $id = GameSpec::whereIn('code_master', $this->code_masterList)->with('GameMaster')->orderByRaw(GameSpec::raw("FIELD('code_master', $this->strList)"))->get()->pluck('id_GameMaster')->toArray();	//關聯
		$id = GameSpec::whereIn('code_master', $this->code_masterList)
		->with('GameMaster')
		->orderByRaw($this->strList)
		// ->get()
		->pluck('code_master', 'id_GameMaster')

		// $id = GameSpec::where('id', 1197)
		// ->toSql();
		->toArray();

		// $id = $id[0]->find("code_master");	//關聯


		
		// $gs = GameSpec::whereIn('code_master', $masterList)->with('GameMaster')->get();	//關聯
		// foreach ($gs as $key => $value) {
		// 	$id[] = $value->id_GameMaster;
		// }
		// $collection = collect(['Desk', 'Sofa', 'Chair']);
		// $id = $id[0]->intersect(['id', 'name', 'seq']);
		// $id->aaa = '123';
		// dd($intersect);
		// print_r($id);
		// echo $id . PHP_EOL;
		// echo $id->name . PHP_EOL;
		// echo $id->updated_by . PHP_EOL;
		// exit;

		dd($id);


		echo '輸入：';
		$fgets = fgets(STDIN);
		if ($fgets == 1) {
			$users = DB::table('GameSpec')->whereIn('code_master', $this->code_masterList)
				->join('GameMaster', 'GameSpec.id_GameMaster', '=', 'GameMaster.id')
				->pluck('id_GameMaster');
			print_r(($users));
		} else {
			foreach ($this->code_masterList as $code_master) {
				$GameMaster = DB::table('GameSpec')->where('code_master', $code_master)
					->join('GameMaster', 'GameSpec.id_GameMaster', '=', 'GameMaster.id')
					->pluck('id');
				// print_r(($users));
				// $GameSpec = DB::table('GameSpec')->where('code_master', $code_master)->pluck('id_GameMaster');
				// $GameMaster = DB::table('GameMaster')->where('id', $GameSpec[0])->pluck('id');
				$idList['OK'][] = $GameMaster[0];
				if (count($GameMaster) != 1) {
					foreach ($GameMaster as $key => $value) {
						$idList['NO'][] = $value;
					}
				}
			}
			print_r($idList);
			exit;

			$str = "UPDATE GameMaster SET seq = CASE id ";
			$str2 = "";
			foreach ($idList['OK'] as $key => $value) {
				$key2 = $key + 1;
				$str .= "WHEN $value THEN '$key2' ";
				$str2 .= "$value,";
			}
			$str2 = substr($str2, 0, -1);
			$str .= "END WHERE id IN ($str2);";
			// $idList['NO'][] = 'idList';
			print_r($str);
		}
	}
}
