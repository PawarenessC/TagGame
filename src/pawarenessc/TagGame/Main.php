<?php



namespace pawarenessc\TagGame;



use pocketmine\event\Listener;

use pocketmine\plugin\PluginBase;



use pocketmine\item\Item;

use pocketmine\tile\Tile;

use pocketmine\tile\Chest as TileChest;

use pocketmine\tile\Sign;



use pocketmine\event\player\PlayerDeathEvent;

use pocketmine\event\player\PlayerKickEvent;

use pocketmine\event\entity\EntityArmorChangeEvent;

use pocketmine\event\entity\EntityDamageByEntityEvent;

use pocketmine\event\entity\EntityDamageEvent;

use pocketmine\event\player\PlayerPreLoginEvent;

use pocketmine\event\player\PlayerJoinEvent;

use pocketmine\event\player\PlayerQuitEvent;

use pocketmine\event\player\PlayerMoveEvent;

use pocketmine\event\player\PlayerInteractEvent;

use pocketmine\event\block\BlockBreakEvent;

use pocketmine\event\block\BlockPlaceEvent;



use pocketmine\Player;

use pocketmine\Server;

use pocketmine\scheduler\TaskScheduler;



use pocketmine\utils\textFormat;

use pocketmine\utils\Config;



use pocketmine\entity\Entity;

use pocketmine\entity\Effect;

use pocketmine\entity\EffectInstance;



use pocketmine\command\Command;

use pocketmine\command\CommandSender;



use pocketmine\level\Level;

use pocketmine\level\Position;

use pocketmine\level\particle\FloatingTextParticle;



use pocketmine\block\Block;

use pocketmine\math\Vector3;



use pocketmine\network\protocol\AddEntityPacket;

use pocketmine\network\mcpe\protocol\TransferPacket;

use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\ModalFormRequestPacket;
use pocketmine\network\mcpe\protocol\ModalFormResponsePacket;



class Main extends pluginBase implements Listener{









public function onEnable() {

 $this->getLogger()->info("=========================");
 $this->getLogger()->info("TagGameを読み込みました");
 $this->getLogger()->info("二次配布は絶対にやめてください");
 $this->getLogger()->info("v4");
 $this->getLogger()->info("=========================");
 $this->getServer()->loadLevel("seiyo");

 $this->getServer()->loadLevel("super");

 $this->getServer()->loadLevel("tousou");

 $this->system = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");

 $this->getServer()->getPluginManager()->registerEvents($this, $this);

 $this->totalminutes = 540;

 $this->minute = 540;

 $this->redm = false;

 $this->emem = false;

 $this->pacm = false;

 $this->win = 0;

 $this->w = 0;

 $this->t = 0;

 $this->h = 0;

 $this->game = false;

 $this->namm = false;
 
$this->cogame = false;

//$this->bigmap = false 

 $this->em1 = false;

 $this->em2 = false;

 $this->tag = 1;

 $this->Server = $this->getServer();
 
 $this->guest = true;

 $this->ServerClass = new \ReflectionClass(get_class($this->Server));

 $this->l = "未発表";

 $this->kk = new Config($this->getDataFolder() ."player.yml", Config::YAML);

 $this->nige = new Config($this->getDataFolder() ."nige.yml", Config::YAML);
 
 $this->hunter = new Config($this->getDataFolder() . "hunter.yml", Config::YAML);
 
 $this->runner = new Config($this->getDataFolder() . "runner.yml", Config::YAML);
 
 $this->jaller = new Config($this->getDataFolder() . "jailer.yml", Config::YAML);

 $this->msg = new Config($this->getDataFolder()."Message.yml", Config::YAML,  

			[ 

			

			"INFO1" => "§bバスの下に隠れる行為はBAN対象です", 

 

			"INFO2" => "§b自首boxにイモる行為はBAN対象です", 



			"JISHUMSG" => "§b自首ができるようになったよ！", 



			"INFO4" => "§bはい、スマイル～はこのサーバの挨拶だね！/smiでできるよ～！", 

			

			"INFO5" => "自首ボックスは各ワールド共通でファミマにあります", 

			]); 
 
 $this->config = new Config($this->getDataFolder()."Setup.yml", Config::YAML, 



			[



			"説明" => "prizeでは1秒ごとに増える単価,HBでは復活と途中参加できるブロックID,JBでは自首できるブロックID,KBでは観戦できるブロックIDを書いてください。",



			"prize" => "5",



			"HB" => 247,



			"JB" => 121,

			

			"KB" => 19,
			
			
			"guest" => true,


			]);


}





public function onQuit(PlayerQuitEvent $event){

 $h = $this->h;

 $t = $this->t;

 $p = $event->getPlayer();

 $name = $p->getName();
 
$this->hunter->remove($name, "", true);
$this->hunter->save();

$this->runner->remove($name, "", true);
$this->runner->save();

if($this->runner->exists($name)) {
   $this->t = $t - 1;
  
  }elseif($this->hunter->exists($name)) {

   $this->h = $h - 1;
  }

 }



public function JoinStuff(PlayerKickEvent $event){

 if($event->getReason() !== "disconnectionScreen.serverFull") return true;

 switch ($event->getPlayer()->getName()) {

  case "XxawarenessxX":

  case "PawarenessC":

  case "jggj2" :

  case "taisa0410" :

  case "XtenoriX" :

  case "amahiro2" :

  case "sioonkid" :

  case "waxGamer0417" :

  case "kuririn042219" :

  case "ribnli" :

   $event->setCancelled(true);

 return true;

 }

}



 public function onTouch(PlayerInteractEvent $event){

	$p = $event->getPlayer();

	$n = $p->getName();

	$ar = $p->getInventory();

	$b = $event->getBlock()->getId();

	$H = $this->h;

    $T = $this->t;

	$x = mt_rand(76, 82);

	$z = mt_rand(71, 170);

	$c = $event->getBlock();

	$xr = $c->getX();

	$yr = $c->getY();

	$zr = $c->getZ();
	
	$hb = $this->config->get("HB");
	
	$jb = $this->config->get("JB");
	
	$kb = $this->config->get("KB");

    $ap = $p->getArmorInventory()->getHelmet();

    $apid = $ap->getId();

	$block = Block::get(0,0);

	$rs = new Vector3($xr, $yr, $zr);

	$game = Server::getInstance()->getLevelByName("tousou");

    $seiyo = Server::getInstance()->getLevelByName("seiyo");

    $super = Server::getInstance()->getLevelByName("super");

    $post = new Position(127, 53, 129, $seiyo);

    $pou = new Position(131, 40, 130, $super);

	$vector = new Vector3($x, 4, $z);

	$pos = new Position(292, 54, 308, $game);

    $win = $this->win;

    $ww = $this->w;

    if($b == 121){

        if($event->getBlock()->getID() == 121){

				if ($this->runner->exists($n)) {
            if($this->minute > 0){

                if($this->minute < 330){

                    $this->t = $this->t - 1;
                    $p->sendMessage("§l[§aS§eY§6S§bT§cE§4M§f]§r§b自首をして".$win."円獲得！");

                    $this->getServer()->broadcastMessage("§l[§aS§eY§6S§bT§cE§4M§f]§r§b".$n."が自首を行い、§c{$win}§bスマ獲得した！！残り{$this->t}人");

                    //$this->getServer()->getPluginManager()->getPlugin("$")->addmoney($n, $win);

                    $this->system->addMoney($n, $win);

                    $this->runner->remove($n, "", true);
					$this->runner->save();
                    $p->setGamemode(3);

                    if($this->w == 1){

                        $p->teleport($pos);

                    }elseif($this->w == 2){

                        $p->teleport($post);

                    }elseif($this->w == 3){

                        $p->teleport(new Position(131, 40, 130, $super));

                    }

                }

            }

        }

    }    

    }elseif($b == $kb){

        if($this->game == true){

            if($this->w == 1){

                $p->teleport($pos);

            }elseif($this->w == 2){

                $p->teleport($post);

            }elseif($this->w == 3){

                $p->teleport($pou);

            }

            $p->sendMessage("観戦場所へ移動中...");

            $p->setGamemode(3);

        }else{

            $p->sendMessage("§cプレイヤーはテレポートすることはできません");

        }

    }elseif($b == 152){

        if($this->redm == true){
			$name = $p->getName();
            if($this->runner->exists($name)) {

                /*現在$apidの部分が$event->getBlock()->getID()になっていたこの処理はかぶっているヘルメット

                がid298だったらにするから$apid(ヘルメットid)で比較する*/

                //$this->getServer()->getPluginManager()->getPlugin("円")->addmoney($n, 250);

                $this->system->addMoney($n, 250);

                $p->sendMessage("§l[§aS§eY§6S§bT§cE§4M§f]§r§bミッションクリア！250円を獲得！！");

                if($this->w == 1){

                    $game->setBlock($rs, $block);

                }elseif($this->w == 2){

                    $seiyo->setBlock($rs, $block);

                }elseif($this->w == 3){

                    $super->setBlock($rs, $block);

                }

                $this->getServer()->broadcastMessage("§l[§aS§eY§6S§bT§cE§4M§f]§r§d".$n."がレッドストーンブロックミッションをクリアした");

            }

        }

    }elseif($b == 133){

        if($this->emem == true){
				$name = $p->getName();
            if($this->runner->exists($name)) {

                if($this->emeset == $rs){

                    $p->sendMessage("§e本物だ！750FP!");

                    $this->getServer()->broadcastMessage("§l[§aS§eY§6S§bT§cE§4M§f]§r§d".$n."がエメラルドミッションをクリア！");

                    //$this->getServer()->getPluginManager()->getPlugin("円")->addmoney($n, 750);

                    $this->system->addMoney($n, 750);

                    if($this->w == 1){

                        $game->setBlock($rs, $block);

                    }elseif($this->w == 2){

                        $seiyo->setBlock($rs, $block);

                    }elseif($this->w == 3){

                        $super->setBlock($rs, $block);

                    }

                }else{

                    $p->sendMessage("§aF§bA§cK§dE");

                }

            }

        }

    }elseif($b == $hb){

        if($this->minute > 50){

            if($this->minute < 420){
				$name = $p->getName();

                if(!$this->runner->exists($name)) {

                    $p->sendMessage("§l[§aS§eY§6S§bT§cE§4M§f]§r§eアスレチッククリア！復活しました！");

                    $this->getServer()->broadcastMessage("§l[§aS§eY§6S§bT§cE§4M§f]§r§d".$n."が復活したよ〜");

                    if($H < 6){

                    if($H >= $T / 3){

                    $hunter = 'runner';

                    $this->team($p, $hunter);

                    }elseif($H < $T){

                    $hunter = 'hunter';

                    $this->team($p, $hunter);

                    }elseif($H === $T){

                    $hunter = 'runner';

                    $this->team($p, $hunter);}

		}else{

                     $armor = $p->getArmorInventory();

                     $mus = Item::get(298,0,1);

                     $armor->setHelmet($mus);

                    $this->t = $T + 1;

                    $p->setNameTag("");

                    $p->sendMessage("[TAG]You are §bPlayer");

                    $p->removeAllEffects();

                    return true;

            }

                    if($ww == 1){

                        $xt = mt_rand(77, 82);

                        $zt = mt_rand(71, 170);

                        $posn = new Position(264, 4, 264, $game);

                        $p->teleport($posn);

                    }elseif($ww == 2){

                        $xts = mt_rand(69, 185);

                        $zts = mt_rand(69, 71);

                        $poss = new Position($xts, 4, $zts, $seiyo);

                        $p->teleport($poss);

                    }elseif($ww == 3){

                        $p->teleport(new Position(83, 4, 82, $super));

                    }

                }else{

                    $p->sendMessage("§l[§aS§eY§6S§bT§cE§4M§f]§r§e途中参加しました！");

                    $this->getServer()->broadcastMessage("§l[§aS§eY§6S§bT§cE§4M§f]§r§d".$n."が途中参加したよ〜");

                    $team = 'runner';

                    $this->team($p, $team);

                }

                if($ww == 1){

                    $xt = mt_rand(77, 82);

                    $zt = mt_rand(71, 170);

                    $posn = new Position(264, 4, 264, $game);

                    $p->teleport($posn);

                }elseif($ww == 2){

                    $xts = mt_rand(69, 185);

                    $zts = mt_rand(69, 71);

                    $poss = new Position($xts, 4, $zts, $seiyo);

                    $p->teleport($poss);

                }elseif($ww == 3){

                    $p->teleport(new Position(83, 4, 82, $super));

                }

            }

        }

    }

}

                /*言いたいことは分かるよ...今はゆるして(´･ω･｀)

                }elseif($b == 41){

                 if($this->bigmap == true){

                $this->system->addMoney($n, 500);

                $p->sendMessage("§l[§aS§eY§6S§bT§cE§4M§f]§rミッションクリア！1000FPを獲得！！");

                if($this->w == 1){

                    $game->setBlock($rs, $block);

                }elseif($this->w == 2){

                    $seiyo->setBlock($rs, $block);

                }elseif($this->w == 3){

                    $super->setBlock($rs, $block);

                }elseif($this->w == 4){

                    $koukou->setBlock($rs, $block);

                }

                $this->getServer()->broadcastMessage("§l[§aS§eY§6S§bT§cE§4M§f]§r§d".$n."の活躍によりマップが拡大した！逃走者はがんばってくれ！");

            }

        }*/



public function EntityDamageEvent(EntityDamageEvent $event){

 if($event instanceof EntityDamageByEntityEvent){

  $entity = $event->getEntity();

  $player = $event->getDamager();

  $t = 410;

  $m = $this->minute;

   if($entity instanceof Player && $player instanceof Player){

    $ena = $entity->getName();
    
    $epna = $player->getName();

    $player->sendMessage("§a".$ena."");

     if($this->pacm == true){

      if ($this->hunter->exists($pna) && $this->runner->exists($ena)) {

       $entity->sendMessage("§l§d[PAC-MANmission]§r§bPAC-MANmissionで逃走者にやられました");

       $this->getServer()->broadcastMessage("[PAC-MANmission]§aハンターの§b".$ena."§aがミッションで捕まりました");

       $this->h = $this->h - 1;
       
       $this->hunter->remove($name, "", true);
	   $this->hunter->save();

       if($this->w == 1){

           $entity->teleport(new Vector3(305, 4, 331));

          }elseif($this->w == 2){

           $entity->teleport(new Vector3(178, 5, 212));

          }elseif($this->w == 3){

           $entity->teleport(new Vector3(213, 5,130));

        /*}elseif($this->w == 4){

           $entity->teleport(new Vector3(111, 4, 111));

          }*/

          }

      }

     }else{
$pname = $player->getName();
$ename = $entity->getName();
     if($this->game == true){

      if($this->hunter->exists($pname)) {

          if($this->runner->exists($ename)) {

        if($m > 0){

         if($m < 420){

	  $pn = $player->getName();

	  $en = $entity->getName();

	  $player->sendMessage("§l[§aS§eY§6S§bT§cE§4M§f]§r§b確保報酬として500円を手に入れた！");

	  //$this->getServer()->getPluginManager()->getPlugin("円")->addmoney($pn, 50);

	  $this->system->addMoney($pn, 500);

	  $entity->sendMessage("§l[§aS§eY§6S§bT§cE§4M§f]§r§c".$pn."§bに確保された...");

	  $entity->sendMessage("§l[§aS§eY§6S§bT§cE§4M§f]§r§bアスレチックをクリアして復活しよう。");

	  $entity->addTitle("§c捕まりました...", "", 20, 20, 20);

	  $this->getServer()->broadcastMessage("§l[§aS§eY§6S§bT§cE§4M§f]§r§a".$en."が確保された...");

	  $this->getServer()->broadcastMessage("§l[§aS§eY§6S§bT§cE§4M§f]§r§cハンター→".$pn."");

          $this->kk->set($pn,$this->kk->get($pn) + 1);

          $this->kk->save();
          
          $this->runner->remove($en, "", true);
		  $this->runner->save();

           if($this->w == 1){

            $entity->teleport(new Vector3(305, 4, 331));

           }elseif($this->w == 2){

            $entity->teleport(new Vector3(178, 5, 212));

           }elseif($this->w == 3){

           $entity->teleport(new Vector3(213, 5, 130));

        /*}elseif($this->w == 4){

           $entity->teleport(new Vector3(810, 19, 19));

        }*/

        }


         $this->t = $this->t - 1;

         }

       }

      }

     }

    }

   }

  }

 }


}
public function onJoin(PlayerJoinEvent $event){

 $player = $event->getPlayer();

 $player->setGamemode(0);

 $name = $player->getName();
 

 $event->getPlayer()->setAllowMovementCheats(true);

   if(!$this->kk->exists($name)){

    $this->kk->set($name, "0");

    $this->kk->save();

    }

     if(!$this->nige->exists($name)){

      $this->nige->set($name, "0");

      $this->nige->save();

    }
			

		}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) :bool{

 switch ($command->getName()){
  case "tagui";
 if ($sender->isOp()) {
$this->startMenu($sender);
}else{
$sender->sendMessage("§4権限がありません");
}
return true;

  break;

  

  case "ts";
  if($this->guest == true){
  $this->startMenu2($sender);
  }else{
  $sender->sendMessage("§4設定により参加できません");
  }
return true;


  case "smi";

  $name = $sender->getName();

  $this->getServer()->broadcastMessage("<☆".$name."☆>§bはい、スマイル～");
       return true;
}
}

 public function scheduler(){

  $this->minute--;

  $t = $this->t;

  $h = $this->h;

  $tm = $this->totalminutes;

  $min = $this->minute;

  $total = 420;

  $eme = mt_rand(1, 10);

  $x = mt_rand(177, 182);

  $z = mt_rand(71, 170);

  $xt = mt_rand(77, 82);

  $zt = mt_rand(71, 170);

  $ms = mt_rand(1, 5);

  $main = Server::getInstance()->getLevelByName("world");

  $game = Server::getInstance()->getLevelByName("tousou");

  $seiyo = Server::getInstance()->getLevelByName("seiyo");

  $super = Server::getInstance()->getLevelByName("super");

//$koukou = Server::getInstance()->getLevelByName("school");

  $w = mt_rand(1, 3);
  
  $rand = mt_rand(1,5);

  $ww = $this->w;

  $xs = mt_rand(96, 186);

  $zs = mt_rand(184, 186);

  $xts = mt_rand(69, 185);

  $zts = mt_rand(69, 71);
  
  $prize = $this->config->get("prize");

  $ms2 = mt_rand(1, 3);

  $pou = new Position(174, 4, 149, $super);

  $poss = new Position($xs, 4, $zs, $seiyo);

  $posts = new Position($xts, 4, $zts, $seiyo);

  $pos = new Position(323, 4, 270, $game);

  $post = new Position(246, 4, 347, $game);

  $players = Server::getInstance()->getOnlinePlayers();

  $win = $this->win;
  
$init = $min;

$minutes = floor(($init / 60) % 60);

$seconds = $init % 60;





if($this->game === false){
 if($min >= $total){
foreach ($players as $player){
   $this->getServer()->broadcastPopup("".$min - $total."秒後に開始 今回のワールドは§d".$this->l."\n                §l§a逃走者 §f".$t." §cvs §bハンター §f".$h."\n\n");
}
 }

  
   }

 if($min <= 420){

  if($min >= 0){

  $this->win = $win + $prize;

  $rc = mt_rand(1, 9);
  
  $level = $this->getServer()->getDefaultLevel();

   $signpos = new Vector3(257, 4, 255, $level);

   $sign = $main->getTile($signpos);

    if($sign instanceof Sign){

     $sign->setText("§aRUNNER§e{$t}§fvs§bHUNTER§d{$h}", "§6MapName§f:§a{$this->l}", "残り§b{$min}§e秒", "§{$rc}SMILEServer");

     $sign->saveNBT();

    }
switch($this->tag){

  case 1:

   $this->getServer()->broadcastPopup("TAG GAME§r:::::§c{$minutes}:{$seconds}seconds left§a:::::§d".$win."§bSMILE§r\n     §l§aRUNNER ".$t." §cvs §bHUNTER ".$h."\n\n\n");

   $this->tag = 2;

 break;

 case 2:

   $this->getServer()->broadcastPopup("§cT§zAG GAME§r::::§a:§c{$minutes}:{$seconds}seconds left:§a::::§d".$win."§bSMILE§r\n     §l§aRUNNER ".$t." §cvs §bHUNTER ".$h."\n\n\n");

  $this->tag = 3;

break;

 case 3:

   $this->getServer()->broadcastPopup("§cT§6A§zG GAME§r:::§a::§c{$minutes}:{$seconds}seconds left::§a:::§d".$win."§bSMILE§r\n     §l§aRUNNER ".$t." §cvs §bHUNTER ".$h."\n\n\n");

  $this->tag = 4;

break;

 case 4:

   $this->getServer()->broadcastPopup("§cT§6A§eG §zGAME§r::§a:::§c{$minutes}:{$seconds}seconds left:::§a::§d".$win."§bSMILE§r\n     §l§aRUNNER ".$t." §cvs §bHUNTER ".$h."\n\n\n");
  $this->tag = 5;

break;

 case 5:

   $this->getServer()->broadcastPopup("§cT§6A§eG §aG§zAME§r:§a::::§c{$minutes}:{$seconds}seconds left::::§a:§d".$win."§bSMILE§r\n     §l§aRUNNER ".$t." §cvs §bHUNTER ".$h."\n\n\n");

  $this->tag = 6;

break;

 case 6:

   $this->getServer()->broadcastPopup("§cT§6A§eG §aG§1A§zME§r§a:::::§c{$minutes}:{$seconds}seconds left:::::§a§d".$win."§bSMILE§r\n     §l§aRUNNER ".$t." §cvs §bHUNTER ".$h."\n\n\n");

  $this->tag = 7;

break;

 case 7:

   $this->getServer()->broadcastPopup("§cT§6A§eG §aG§1A§bM§zE§r§2:::::§c{$minutes}:{$seconds}seconds left§b:::::§d".$win."§bSMILE§r\n     §l§aRUNNER ".$t." §cvs §bHUNTER ".$h."\n\n\n");

  $this->tag = 8;

break;

 case 8:

   $this->getServer()->broadcastPopup("§cT§6A§eG §aG§1A§bM§5E§d:::::§c{$minutes}:{$seconds}seconds left§c:::::§d".$win."§bSMILE§r\n     §l§aRUNNER ".$t." §cvs §bHUNTER ".$h."\n\n\n");

  $this->tag = 1;

   }

 foreach ($players as $p){

  if($t == 0){

   $name = $p->getName();

   $this->minute = -1;

   $p->addTitle("§cGAMEOVER", "", 20, 20, 20);

   $p->sendMessage("§l[§aS§eY§6S§bT§cE§4M§f]§r§b逃走者がいなくなったのでゲームが終了したよ！");

   $p->sendMessage("§l[§aS§eY§6S§bT§cE§4M§f]§r§bハンターは§a{$win}§b円獲得！");

     $this->endGame();

    
    if ($this->hunter->exists($name)) {

     //$this->getServer()->getPluginManager()->getPlugin("円")->addmoney($n, 250);

     $n = $p->getName();

     $this->system->addMoney($n, $win);
   }

  }

 }

}
}

switch($min){

 case 470:

  $this->w = $w;

  $this->getServer()->broadcastMessage("§l[§aS§eY§6S§bT§cE§4M§f]§b今回のワールドはなんと...");
  break;

 case 465:

  if($ww == 1){

   $this->getServer()->loadLevel("tousou");

   $this->l = "あわふわ";

   $this->getServer()->broadcastMessage("今回のワールドは §aあわふわ！");

  }elseif($ww == 2){

   $this->getServer()->loadLevel("seiyo");

   $this->l = "西洋";

   $this->getServer()->broadcastMessage("今回のワールドは §b西洋！");

  }elseif($ww == 3){

   $this->getServer()->loadLevel("super");

   $this->l = "イオン";

   $this->getServer()->broadcastMessage("今回のワールドは §eイオン！");

  /*}elseif($ww == 4){

   $this->getServer()->loadLevel("seiyo");

   $this->l = "キリン高校";*/

}


 break;
 
 case 460:
 if($ww == 1){

  $this->getServer()->broadcastMessage("[§bスマイル§f]§aあわふわ§は開発者のPawarenessCのサーバーだったあわふわ逃走中のワールドだよ！シンプルな街で最後まで逃げ切ろう！");

  }elseif($ww == 2){

  $this->getServer()->broadcastMessage("[§bスマイル§f]§c西洋§eは西洋の街並みが広がるワールド！素晴らしい街並みのワールドで逃げ切ろう！");

  }elseif($ww == 3){

  $this->getServer()->broadcastMessage("[§bスマイル§f]§dイオン§eは入り組んだ施設が逃げやすくなったり逃げにくくなってしまう...逃走者はそれに対応して逃げ切ろう！");
}
break;
 
 case 420:

  $this->getServer()->broadcastMessage("§l[§aS§eY§6S§bT§cE§4M§f]§r§bゲームが開始された！鬼はダイヤ装備をしてるよ");

  $this->getServer()->broadcastMessage("§l[§aS§eY§6S§bT§cE§4M§f]§r§bハンターは10秒間動けません！");

  $this->game = true;

   foreach ($players as $player){

    $name = $player->getName();

    $player->setNameTag("");

    if($ww == 1){

     if($this->runner->exists($name)) {

      $player->teleport($post);

     }

     if ($this->hunter->exists($name)) {

      $player->teleport($pos);

      $player->setImmobile(true);

     }

   }elseif($ww == 2){

     if ($this->runner->exists($name)) {

      $player->teleport($poss);

     }

     if ($this->hunter->exists($name)) {

      $player->teleport($posts);

      $player->setImmobile(true);

     }

   }elseif($ww == 3){

     if ($this->runner->exists($name)) {

      $player->teleport(new Position(83, 4, 82, $super));

     }

     if ($this->hunter->exists($name)) {

      $player->teleport(new Position(174, 4, 149, $super));

      $player->setImmobile(true);

     }

 /*}elseif($ww == 4){

     if($id == 298){

      $player->teleport(new Position(11, 4, 514, $koukou));

     }

     if($id == 310){

      $player->teleport(new Position(19, 19, 810, $koukou));*/

   }

}

 break;

 case 419:
 
  $this->game = true;
 break;

 case 410:
  foreach ($players as $player){

    $name = $player->getName();

    if($this->hunter->exists($name)) {

      $player->setImmobile(false);

    }

  }

  $this->getServer()->broadcastMessage("§l[§aS§eY§6S§bT§cE§4M§f]§r§bハンターが動けるようになりました");
 break;

 case 380:
  $msg = $this->msg->get("INFO1"); 
  $this->getServer()->broadcastMessage("[INFO]{$msg}");
  break;

 case 350:
  $msg = $this->msg->get("INFO2"); 
  $this->getServer()->broadcastMessage("[INFO]{$msg}");
  break;

 case 330:
  $msg = $this->msg->get("JISHUMSG");
  $this->getServer()->broadcastMessage("§l[§aS§eY§6S§bT§cE§4M§f]{$msg}");
  break;

 case 290:
  $msg = $this->msg->get("INFO4");
  $this->getServer()->broadcastMessage("[INFO]{$msg}");
  break;

 case 260:
  $msg = $this->msg->get("INFO5");
  $this->getServer()->broadcastMessage("[INFO]{$msg}");
  break;

 case 250:
  if($ms == 1){

   foreach($players as $p){

   $p->addTitle("§c~ミッション発令~", "", 20, 20, 20);}

   $this->getServer()->broadcastMessage("§a=====§bミッション発生§a=====");

   $this->getServer()->broadcastMessage("§c・レッドストーンブロックを探せ！");

   $this->getServer()->broadcastMessage("§d説明:§eワールドの中にレッドストーンブロックを設置した。");

   $this->getServer()->broadcastMessage("§e逃走者はハンターに見つからないようにタッチしろ！");

   $this->getServer()->broadcastMessage("§eブロックをタッチした人先着1名に250FPをプレゼント。");

   $reds = Block::get(152,0);

   if($ww == 1){

    $redsv = new Vector3($x,4, $z);

    $game->setBlock($redsv, $reds);

   }elseif($ww == 2){

    $seiyo->setBlock($poss, $reds);

   }elseif($ww == 3){

    $super->setBlock($pou, $reds);

 /* }elseif($ww == 3){

    $koukou->setBlock($pou, $reds);*/

   }

   $this->getServer()->broadcastMessage("§a===================");

   $this->redm = true;

  }

  if($ms == 2){

   foreach($players as $p){

   $p->addTitle("§c~ミッション発令~", "", 20, 20, 20);}

   $this->getServer()->broadcastMessage("§a=====§bミッション発生§a=====");

   $this->getServer()->broadcastMessage("§c・本物はどれ、、、？");

   $this->getServer()->broadcastMessage("§d説明:§eワールドの中にエメラルドブロックが複数ある。");

   $this->getServer()->broadcastMessage("§e逃走者はハンターに見つからないように本物を見つけろ！");

   $this->getServer()->broadcastMessage("§e本物を見つけた人先着1名に750FPをプレゼント。");

   $this->getServer()->broadcastMessage("§a===================");

   $this->emem = true;

   if($ww == 1){

   switch($eme){

    case 1:

     $this->emeset = new Vector3(323, 4, 314);

     break;

    case 2:

     $this->emeset = new Vector3(302, 2, 384);

     break;

    case 3:

     $this->emeset = new Vector3(323, 1, 339);

     break;

    case 4:

     $this->emeset = new Vector3(306, 4, 273);

     break;

    case 5:

     $this->emeset = new Vector3(288, 10, 303);

     break;

    case 6:

     $this->emeset = new Vector3(329, 4, 346);

     break;

    case 7:

     $this->emeset = new Vector3(274, 12, 343);

     break;

    case 8:

        $this->emeset = new Vector3(254, 11, 323);

        break;

    case 9:

        $this->emeset = new Vector3(288, 10, 272);

        break;

    case 10:

        $this->emeset = new Vector3(283, 10, 298);

        break;

    }

   }elseif($ww == 2){

   switch($eme){

    case 1:

        $this->emeset = new Vector3(73, 5, 158);

        break;

    case 2:

        $this->emeset = new Vector3(90, 5, 88);

        break;

    case 3:

        $this->emeset = new Vector3(111, 8, 180);

        break;

    case 4:

        $this->emeset = new Vector3(134, 6, 81);

        break;

    case 5:

        $this->emeset = new Vector3(116, 4, 107);

        break;

    case 6:

        $this->emeset = new Vector3(99, 5, 161);

        break;

    case 7:

        $this->emeset = new Vector3(137, 4, 147);

        break;

    case 8:

        $this->emeset = new Vector3(159, 4, 95);

        break;

    case 9:

        $this->emeset = new Vector3(127, 20, 127);

        break;

    case 10:

        $this->emeset = new Vector3(180, 4, 139);

        break;

    }

    }elseif($ww == 3){

   switch($eme){

    case 1:

        $this->emeset = new Vector3(126, 28, 85);

        break;

    case 2:

        $this->emeset = new Vector3(142, 12, 104);

        break;

    case 3:

        $this->emeset = new Vector3(144, 12, 104);

        break;

    case 4:

        $this->emeset = new Vector3(175, 11, 19);

        break;

    case 5:

        $this->emeset = new Vector3(150, 12, 118);

        break;

    case 6:

        $this->emeset = new Vector3(119, 11, 94);

        break;

    case 7:

        $this->emeset = new Vector3(133, 25, 85);

        break;

    case 8:

        $this->emeset = new Vector3(170, 10, 171);

        break;

    case 9:

        $this->emeset = new Vector3(150, 8, 175);

        break;

    case 10:

        $this->emeset = new Vector3(173, 4, 143);

        break;

   }    

  /*}elseif($ww == 4){

   switch($eme){

    case 1:

        $this->emeset = new Vector3(126, 28, 85);

        break;

    case 2:

        $this->emeset = new Vector3(142, 12, 104);

        break;

    case 3:

        $this->emeset = new Vector3(144, 12, 104);

        break;

    case 4:

        $this->emeset = new Vector3(175, 11, 19);

        break;

    case 5:

        $this->emeset = new Vector3(150, 12, 118);

        break;

    case 6:

        $this->emeset = new Vector3(119, 11, 94);

        break;

    case 7:

        $this->emeset = new Vector3(133, 25, 85);

        break;

    case 8:

        $this->emeset = new Vector3(170, 10, 171);

        break;

    case 9:

        $this->emeset = new Vector3(150, 8, 175);

        break;

    case 10:

        $this->emeset = new Vector3(173, 4, 143);

        break;*/



}

}

if($ms == 3){

 $this->pacm = true;

 foreach($players as $p){

 $p->addTitle("§c~ミッション発令~", "", 20, 20, 20);}

 $this->getServer()->broadcastMessage("§a=====§bミッション発生§a=====");

  $this->getServer()->broadcastMessage("§c・PAC-MAN MISSION");

  $this->getServer()->broadcastMessage("§d説明:§e20秒間ハンターと逃走者の立場が逆になる。");

  $this->getServer()->broadcastMessage("§e逃走者はハンターを捕まえて、ハンターを減らせ！");

  $this->getServer()->broadcastMessage("§a===================");

}

 if($ms == 4){

  $this->namm = true;

  foreach($players as $p){

   $name = $p->getName();

   $p->setNameTag($name);

 $p->addTitle("§c~ミッション発令~", "", 20, 20, 20);

 $this->getServer()->broadcastMessage("§a=====§bミッション発生§a=====");

  $this->getServer()->broadcastMessage("§c・MY NAME VISIBLE");

  $this->getServer()->broadcastMessage("§d説明:§e今から30秒間全員のネームタグが見えてしまうぞ");

  $this->getServer()->broadcastMessage("§eハンターから逃げやすく、逃走者を見つけやすくなってしまった！");

  $this->getServer()->broadcastMessage("§a===================");

  }

 }

 /*if($ms == 5){

   $this->getServer()->broadcastMessage("§a=====§bミッション発生§a=====");

   $this->getServer()->broadcastMessage("§c・マップを拡大しろ！！");

   $this->getServer()->broadcastMessage("§d説明:§eワールドの中に金のブロックを設置した。");

   $this->getServer()->broadcastMessage("§e逃走者はハンターに見つからないようにタッチしろ！");

   $this->getServer()->broadcastMessage("§eブロックをタッチした人先着1名に1000FPをプレゼント。");

   $this->getServer()->broadcastMessage("§6⚠§このミッションはあわふわとキリン高校しかできないぞ！");

   $gold = Block::get(41,0);

   if($ww == 1){

    $redsv = new Vector3($x,4, $z);

    $game->setBlock($redsv, $gold);

    }elseif($ww == 4){

    $koukou->setBlock($pou, $gold);

   }

   $this->getServer()->broadcastMessage("§a===================");

   $this->bigmap = true;

  }*/

 if($ms == 5){

 $this->getServer()->broadcastMessage("§r§b今回はミッションが発令しませんでした...");

  }

  break;

 case 230:
  if($this->pacm == true){

   $this->pacm = false;

   $this->getServer()->broadcastMessage("§aミッション終了");

   $this->getServer()->broadcastMessage("§c立場が元に戻ったぞ");

 }elseif($this->namm == true){

  $this->getServer()->broadcastMessage("§aミッション終了");

  $this->getServer()->broadcastMessage("§cネームタグが消えたぞ");

  foreach($players as $p){

   $p->setNameTag("");

}

}

 break;

 case 350:

 case 300:

 case 250:

 case 200:

 case 100:

 case 50:
  $this->getServer()->broadcastMessage("§a===§c途中結果発表§a===");

  $this->getServer()->broadcastMessage("残り".$t."人。生き残っているものは以下だ");

   foreach ($players as $player){

    $name = $player->getName();

     if($this->runner->exists($name)) {

      $this->getServer()->broadcastMessage("§a=§b".$name."§a=");

     }

   }

  $this->getServer()->broadcastMessage("§a========================");
  break;

 case 150:
  if($ms2 == 1){

  $this->em1 = true;

  foreach($players as $p){

      $p->addEffect(new EffectInstance(Effect::getEffect(2), 600, 3, false));

 $p->addTitle("§c~ミッション発令~", "", 20, 20, 20);

 $this->getServer()->broadcastMessage("§a=====§bエフェクトミッション発生§a=====");

  $this->getServer()->broadcastMessage("§c・足があああ");

  $this->getServer()->broadcastMessage("§d説明:§e今から30秒の間、足が遅くなるぞ！");

  $this->getServer()->broadcastMessage("§eslowな逃走中に貴方はイライラせずに居られるか！？");

  $this->getServer()->broadcastMessage("§a===================");

   break;

  }

  }

   if($ms2 == 2){

  $this->em2 = true;

  foreach($players as $p){
	$name = $p->getName();

   if($this->runner->exists($name)) {

   $p->addEffect(new EffectInstance(Effect::getEffect(14), 200, 3, false));

  }

  $p->addTitle("§c~ミッション発令~", "", 20, 20, 20);

 $this->getServer()->broadcastMessage("§a=====§bミッション発生§a=====");

  $this->getServer()->broadcastMessage("§c・ハンターが....見えない！？");

  $this->getServer()->broadcastMessage("§d説明:§e今から10秒間、ハンターが見えなくなるぞ！");

  $this->getServer()->broadcastMessage("§e果たして目に見えないハンターから逃げ切れるか！？");

  $this->getServer()->broadcastMessage("§a===================");

  break;

  }

   }

  if($ms2 == 3){

  $this->getServer()->broadcastMessage("§b今回はミッションが発生しませんでした...");

  break;

}
 break;

 case 140:
  if($this->em2 == true){

  $this->getServer()->broadcastMessage("§aミッション終了");

  $this->getServer()->broadcastMessage("§cハンターが見えるようになったぞ");
}
  break;

 

 case 120:
  if($this->em1 == true){

  $this->getServer()->broadcastMessage("§aミッション終了");

  $this->getServer()->broadcastMessage("§c足が元に戻ったぞ");

}

  break;

 

 case 50:
  $this->getServer()->broadcastMessage("[TIPS]§a残り50秒。復活できなくなったぞ");
 break;

 case 20:
  foreach($players as $p){
  if($rand === 1){
  $this->getServer()->broadcastMessage("[TIPS]§a残り20秒！名前が見えるようになったよ！");
   $itemhel = $p->getArmorInventory()->getHelmet();
   $id = $itemhel->getId();
   if($this->runner->exists($name)) {
   $p->setNameTag($p->getName());
   }
  }else{
  $this->getServer()->broadcastMessage("[TIPS]§a残り20秒！頑張って！");
  }
  }
  break;
  
 case 3;
 foreach($players as $p){

 $p->addTitle("3", "", 20, 20, 20);}
 break;

 

 case 2;
 foreach($players as $p){

 $p->addTitle("2", "", 20, 20, 20);}
 break;

 

 case 1;
 foreach($players as $p){

 $p->addTitle("1", "", 20, 20, 20);}
 break;

 

 case 0:
  $this->getServer()->broadcastMessage("§a===§c結果発表§a===");

  $this->getServer()->broadcastMessage("[NOTICE]§r§bゲームが終了しました。生き残ったのは".$t."人。確保されなかった人たち↓");

   foreach ($players as $player){

    $player->addTitle("§6Congratulations!", "", 20, 20, 20);

    $name = $player->getName();
    
    $this->hunter->remove($name, "", true);
	$this->hunter->save();

	$this->runner->remove($name, "", true);
	$this->runner->save();

    if($this->runner->exists($name)){

      $this->getServer()->broadcastMessage("§a===§b".$name."§a===");

      $player->sendMessage("[囚人]よく逃げ切ったな。");

      $player->sendMessage("[囚人]逃げ切った報酬として".$win."円やるわ！受け取れい！");

      //$this->getServer()->getPluginManager()->getPlugin("円")->addmoney($name, $win);

      $this->system->addMoney($name, $win);

      $this->nige->set($name,$this->nige->get($name) + 1);

      $this->nige->save();
      $this->endGame();
      $this->getServer()->broadcastMessage("§a========================");

      break;

     }

   }

   $rc = mt_rand(1, 9);

   $signpos = new Vector3(-65, 21, 51);

   $sign = $main->getTile($signpos);

    if($sign instanceof Sign){

     $sign->setText("§aRUNNER§e0§fvs§bHUNTER§d0", "§6MapName§f:§a未発表", "§bゲーム終了", "§{$rc}AwFw§{$rc}Tag§{$rc}Game§{$rc}Server");

     $sign->saveNBT();

   $sign->saveNBT();
   }

 break;

}
}

 public function team($player, $team){
$name = $player->getName();
  if($team == 'runner'){

   $this->runner->set($name, "", true);
	$this->runner->save();

   $t = $this->t;

   $this->t = $t + 1;

   $player->setNameTagVisible(false);

   $player->sendMessage("[NOTICE]あなたは§b逃走者");


   $player->removeAllEffects();

  }elseif($team == 'hunter'){

   $this->hunter->set($name, "", true);
   $this->hunter->save();

   $h = $this->h;

   $this->h = $h + 1;

   $player->setNameTagVisible(false);

   $player->sendMessage("[NOTICE]あなたは§cハンター");
   $player->addEffect(new EffectInstance(Effect::getEffect(1), 114514, 1, false));

  }elseif($hunter == 'jailer'){

   $item = Item::get(302,0,1);

   $armor = $entity->getArmorInventory();

   $armor->setHelmet($item);

   $this->t = $this->t - 1;

  }elseif($hunter == 'watch'){

   $armor = $player->getArmorInventory();

   $ita = Item::get(314,0,1);

   $armor->setHelmet($ita);

  }

  return true;

 }

   public function getHunter(){

		return $this->h;

   }		

   public function getRunner(){

		return $this->t;	

	}

   public function getMap(){

		return $this->l;	

   }

   public function getRunnerName(){

		return $name;

   }

   public function getNige($name){

     if($this->nige->exists($name)){

     return $this->nige->get($name);

     }else{

         $this->nige->set($name,"0");

         $this->nige->save();

          return 0;

     }

   }

   public function getKakuho($name){

     if($this->kk->exists($name)){

     return $this->kk->get($name);

     }else{

         $this->kk->set($name,"0");

         $this->kk->save();

          return 0;

          

     }

   }
   public function endGame(){
   $this->totalminutes = 540;
   $this->minute = 540;
   $this->redm = false;
   $this->emem = false;
   $this->pacm = false;
   $this->win = 0;
   $this->w = 0;
   $this->t = 0;
   $this->h = 0;
   $this->game = false;
   $this->namm = false;
   $this->cogame = false; 
   $this->em1 = false;
   $this->em2 = false;
   $this->tag = 1;
   $this->l = "未発表";
   $scheduler = $this->getScheduler();
   $scheduler->cancelAllTasks();
   foreach(Server::getInstance()->getOnlinePlayers() as $player){
   $level = $this->getServer()->getDefaultLevel();
   $name = $player->getName();
   $player->setImmobile(false);
   $this->runner->remove($name, "", true);
	 $this->runner->save();
	  $this->hunter->remove($name, "", true);
	  $this->hunter->save();
   $player->teleport($level->getSafeSpawn());
   $player->setGamemode(0);
   $player->setNameTag($player->getDisplayName());
   $signpos = new Vector3(257, 4, 255, $level);
   $sign = $level->getTile($signpos);
    if($sign instanceof Sign){
     $sign->setText("§aRUNNER§e0§fvs§bHUNTER§d0", "§6MapName§f:§a{$this->l}", "ゲーム準備中", "§{$rc}SMILEServer");
	 $sign->saveNBT();
}

   }
  }
   
   public function startMenu($player) {
    
        $name = $player->getName();
        $buttons[] = [ 
        'text' => "§l§4逃走中を終了する", 
        'image' => [ 'type' => 'path', 'data' => "" ] 
        ]; //0
        $buttons[] = [ 
        'text' => "§l§1時間を足す§7[BETA]", 
        'image' => [ 'type' => 'path', 'data' => "" ] 
        ]; //1
        $buttons[] = [ 
        'text' => "§l§e逃走中を始める", 
        'image' => [ 'type' => 'path', 'data' => "" ] 
        ]; //2
        $buttons[] = [ 
        'text' => "§l§6プラグインを止める", 
        'image' => [ 'type' => 'path', 'data' => "" ] 
        ]; //3
        $buttons[] = [ 
        'text' => "§l§3単価を変える", 
        'image' => [ 'type' => 'path', 'data' => "" ] 
        ]; //4
        $buttons[] = [ 
        'text' => "§l§5時間を減らす§7[BETA]", 
        'image' => [ 'type' => 'path', 'data' => "" ] 
        ]; //5
        $buttons[] = [ 
        'text' => "§l§d鯖民の逃走中参加の設定", 
        'image' => [ 'type' => 'path', 'data' => "" ] 
        ]; //6
        $buttons[] = [ 
        'text' => "§cプレイヤーの状態を確認する", 
        'image' => [ 'type' => 'path', 'data' => "" ] 
        ]; //7
        $buttons[] = [ 
        'text' => "§l§bメンテ用参加退出", 
        'image' => [ 'type' => 'path', 'data' => "" ] 
        ]; //8
        $buttons[] = [ 
        'text' => "§l§f逃走中ステータスの確認§7[BETA]", 
        'image' => [ 'type' => 'path', 'data' => "" ] 
        ]; //9
        $buttons[] = [ 
        'text' => "§dDebug§7[BETA]", 
        'image' => [ 'type' => 'path', 'data' => "" ] 
        ]; //10
        $this->sendForm($player,"CONTROL TagGame","OP専用のFormです\n職権濫用はだめですよ～",$buttons,2001);
        $this->info[$name] = "form";
        }
        
   public function startMenu2($player) {
    
        $name = $player->getName();
        $buttons[] = [ 
        'text' => "§l§b逃走中に参加する", 
        'image' => [ 'type' => 'path', 'data' => "" ] 
        ]; //0
        $buttons[] = [ 
        'text' => "§l§e逃走中から抜ける", 
        'image' => [ 'type' => 'path', 'data' => "" ] 
        ]; //1
        $buttons[] = [ 
        'text' => "§l§eステータスを確認する", 
        'image' => [ 'type' => 'path', 'data' => "" ] 
        ]; //2
        $this->sendForm($player,"TagGame","§a選択してください",$buttons,1145145);
        $this->info[$name] = "form";
        }
        
        public function sendForm(Player $player, $title, $come, $buttons, $id) {
  $pk = new ModalFormRequestPacket(); 
  $pk->formId = $id;
  $this->pdata[$pk->formId] = $player;
  $data = [ 
  'type'    => 'form', 
  'title'   => $title, 
  'content' => $come, 
  'buttons' => $buttons 
  ]; 
  $pk->formData = json_encode( $data, JSON_PRETTY_PRINT | JSON_BIGINT_AS_STRING | JSON_UNESCAPED_UNICODE );
  $player->dataPacket($pk);
  $this->lastFormData[$player->getName()] = $data;
  }
  
  
  public function onPrecessing(DataPacketReceiveEvent $event){



  $player = $event->getPlayer();

  $pk = $event->getPacket();

  $name = $player->getName();

    if($pk->getName() == "ModalFormResponsePacket"){

      $data = $pk->formData;

      $result = json_decode($data);



			if($data == "null\n"){
          switch($pk->formId){

          case 2001:

          if($data == 0){//ゲームを終了する

         $buttons[] = [ 

            'text' => "はい", 

            ]; //0

            $buttons[] = [ 

            'text' => "いいえ", 

            ];

          $this->sendForm($player,"ゲームを終了する","本当に終了しますか？\n\n",$buttons,2100);
		break;
        }elseif($data == 1){//時間を足す(後で)

        $data = [
				"type" => "custom_form",
				"title" => "時間を足す",
				"content" => [
					[
						"type" => "label",
						"text" => "追加したい時間を入力してください"
					],
					[
						"type" => "input",
						"text" => "§b秒数",
						"placeholder" => "",
						"default" => ""
					]
				]
			];
			$this->createWindow($player, $data, 77817);
break;
        }elseif($data == 2){//逃走中を開始する

        $this->getScheduler()->scheduleRepeatingTask(new CallbackTask([$this, "scheduler"]), 20);
       $this->cogame = true;
       $this->getServer()->broadcastMessage("§l[§aS§eY§6S§bT§cE§4M§f]§b逃走中を開催します.../tsで参加しましょう！");


        break;

    }elseif($data == 3){//プラグイン停止のカバー
$data = [
				"type" => "custom_form",
				"title" => "現在の状況",
				"content" => [
					[
						"type" => "label",
						"text" => "hunter{$this->h}vsrunner{$this->t}"
					],
					[
						"type" => "label",
						"text" => "MapName: {$this->l}"
					],
				]
			];
			$this->createWindow($player, $data, 8167197);
        break;
        }elseif($data == 4){//単価を変える
        $tanka = $this->config->get("prize");
        $data = [
				"type" => "custom_form",
				"title" => "単価を変更する",
				"content" => [
					[
						"type" => "label",
						"text" => "1秒ごとの単価を変更してください"
					],
					[
						"type" => "input",
						"text" => "現在の設定:{$tanka}§bスマ",
						"placeholder" => "",
						"default" => ""
					]
				]
			];
			$this->createWindow($player, $data, 6381961);
        break;
        
		}elseif($data == 5){//時間を減らす

        $data = [
				"type" => "custom_form",
				"title" => "時間減らす",
				"content" => [
					[
						"type" => "label",
						"text" => "減らしたい時間を入力してください"
					],
					[
						"type" => "input",
						"text" => "§b秒数(§40未満にならないようにお願いします！§f)",
						"placeholder" => "数字のみ入力してください",
						"default" => ""
					]
				]
			];
			$this->createWindow($player, $data, 413180);
break;
		}elseif($data == 6){//参加の制限
		 if($this->guest == true){
		  $setup = "true";
		  }else{
		  $setup = "false";
		  }
		 $name = $player->getName();
         $buttons[] = [ 
        'text' => "§l§b参加可能にする", 
        'image' => [ 'type' => 'path', 'data' => "" ] 
        ]; //0
        $buttons[] = [ 
        'text' => "§l§c参加禁止にする", 
        'image' => [ 'type' => 'path', 'data' => "" ] 
        ]; //1
        $this->sendForm($player,"鯖民の逃走中参加の設定","true = 参加可能\nfalse = 参加不可能\n\n現在の設定 {$setup}",$buttons,436271);
        $this->info[$name] = "form";
break;
          }elseif($data == 7){//状態
          $data = [
				"type" => "custom_form",
				"title" => "§l状態を確認",
				"content" => [
					[
						"type" => "label",
						"text" => "§lプレイヤーの名前を記入してください。"
					],
					[
						"type" => "input",
						"text" => "§l名前",
						"placeholder" => "名前を入力してください",
						"default" => ""
					]
				]
			];
			$this->createWindow($player, $data, 456200);
		break;
		}elseif($data == 8){//メンテ用参加退出
		$name = $player->getName();
         $buttons[] = [ 
        'text' => "§l§b逃走者", 
        'image' => [ 'type' => 'path', 'data' => "" ] 
        ]; //0
        $buttons[] = [ 
        'text' => "§l§cハンター", 
        'image' => [ 'type' => 'path', 'data' => "" ] 
        ]; //1
        $buttons[] = [ 
        'text' => "キャンセル", 
        'image' => [ 'type' => 'path', 'data' => "" ] 
        ]; //2
        $this->sendForm($player,"メンテ用","メンテナンス以外に使用しないでください\n\n",$buttons,9891019);
        $this->info[$name] = "form";
		break;
		}elseif($data == 9){//他人のステータス確認
          $data = [
				"type" => "custom_form",
				"title" => "§6ステータス確認",
				"content" => [
					[
						"type" => "label",
						"text" => "§lプレイヤーの名前を記入してください。"
					],
					[
						"type" => "input",
						"text" => "§l名前",
						"placeholder" => "名前を入力してください",
						"default" => ""
					]
				]
			];
			$this->createWindow($player, $data, 7039675);
		break;
		}elseif($data == 10){//Debug
			$players = Server::getInstance()->getOnlinePlayers();
		foreach ($players as $player){
		$name = $player->getName();
		$buttons[] = [ 
        'text' => "{$name}", 
        'image' => [ 'type' => 'path', 'data' => "" ] 
        ];
        $this->sendForm($player,"メンテ用","メンテナンス以外に使用しないでください\n\n",$buttons,134567);
        }
        }
        break;
          case 2100:

        if($data == 0){//ゲーム終了 はい

       $this->endGame();
       $this->getServer()->broadcastMessage("§l[§aS§eY§6S§bT§cE§4M§f]§c権限者によって逃走中が終了しました");

      }

      break;

      

          case 77817://時間足すやつ

          $addtime = $result[1];
					if ($result[1] === "") {
						$player->sendMessage("[SYSTEM]時間が記入されていません。");
						return true;

					} else {

					$this->minute = $this->minute + $addtime;
					$player->sendMessage("逃走中の時間に".$addtime."秒追加しました");

					return true;

}
         case 8167197://デバッグ用
          $buttons[] = [ 

            'text' => "はい", 

            ]; //0

            $buttons[] = [ 

            'text' => "いいえ", 

            ];
         $this->sendForm($player,"disablePlugin","本当にプラグインを停止しますか？\n\n",$buttons,19198101);
break;
		  case 19198101:
		  
      if($data == 0){//無効化 はい
      $this->getServer()->getPluginManager()->disablePlugin($this);
      $player->sendMessage("[SYSTEM]逃走中プラグインを無効化しました、再起動又はリロードをすれば再読み込みします");
       }else{
       $this->startMenu($player);
       }
       break;



			case 1145145://プレイヤー用
			if($data == 0){//参加する
			 $H = $this->h;

    $T = $this->t;
    
    $all = $H + $T;

    $player->setNameTag("");
    
    $name = $player->getName();

     if($this->runner->exists($name)) {

      $player->sendMessage("[逃走中]§c既に参加しています");

     }elseif($this->hunter->exists($name)) {

      $player->sendMessage("[逃走中]§c既に参加しています");

     }else{
  	
  	
  	if($this->game == false){
  	 if($this->cogame == false){
  	  if($all == 0){
  	   $this->getScheduler()->scheduleRepeatingTask(new CallbackTask([$this, "scheduler"]), 20);
  	   $this->cogame = true;
       $this->getServer()->broadcastMessage("§l[§aS§eY§6S§bT§cE§4M§f]§b逃走中を開催します.../tsで参加しましょう！");
        $hunter = 'runner';
        $this->team($player, $hunter);
}
}else{
if($H < 10){

     if($H >= $T / 3){

      $hunter = 'runner';
      $this->team($player, $hunter);
      $this->getServer()->broadcastMessage("§l[§aS§eY§6S§bT§cE§4M§f]§e{$name}さんが逃走中に参加しました");
     }elseif($H < $T){

      $hunter = 'hunter';
      $this->team($player, $hunter);
      $this->getServer()->broadcastMessage("§l[§aS§eY§6S§bT§cE§4M§f]§c{$name}さんが逃走中に参加しました");
     }elseif($H === $T){

      $hunter = 'runner';
      $this->getServer()->broadcastMessage("§l[§aS§eY§6S§bT§cE§4M§f]§e{$name}さんが逃走中に参加しました");
      $this->team($player, $hunter);
			}

		}else{

 $hunter = 'runner';
 $this->team($player, $hunter);
$this->getServer()->broadcastMessage("§l[§aS§eY§6S§bT§cE§4M§f]§e{$name}さんが逃走中に参加しました");
  }

  }
  }
  }
  	if($this->game === true){

			$player->sendMessage("[逃走中]§r§b現在試合中です、途中参加するか、観戦をしてお楽しみください。");

			$player->addTitle("§cError", "試合中", 20, 20, 20);

}
break;
   }elseif($data == 1){//抜ける
 	       $name = $player->getName();
 	       $level = $this->getServer()->getDefaultLevel();
       $H = $this->h;
       $T = $this->t;
       $player->setGamemode(0);
     if($this->runner->exists($name)) {

      $player->sendMessage("[逃走中]§c逃走中を抜けました");
      $this->getServer()->broadcastMessage("[逃走中]§e{$name}さんが逃走中を抜けました");
	 $this->t = $T - 1;
	 $player->teleport($level->getSafeSpawn());
	 $this->runner->remove($name, "", true);
	 $this->runner->save();
     }elseif($this->hunter->exists($name)) {

      $player->sendMessage("[逃走中]§c逃走中を抜けました");
      $this->getServer()->broadcastMessage("[逃走中]§c{$name}さんが逃走中を抜けました");
	  $this->h = $H - 1;
	  $player->teleport($level->getSafeSpawn());
	  $this->hunter->remove($name, "", true);
	  $this->hunter->save();
     }else{
     
     $player->sendMessage("[逃走中]§c逃走中を抜けました");
     $player->teleport($level->getSafeSpawn());
     
     }
     break;
     }elseif($data == 2){
      $name = $player->getName();
      $data = [
				"type" => "custom_form",
				"title" => "§b{$name}さんのステータス",
				"content" => [
					[
						"type" => "label",
						"text" => "§b逃げ切った回数: §e{$this->getNige($name)}§b回"
					],
					[
						"type" => "label",
						"text" => "§d確保した回数: §e{$this->getKakuho($name)}§d回"
					]
				]
			];
			$this->createWindow($player, $data, 4925389);
     }
     break;
     case 6381961://単価を変更

          $tanka = $result[1];
					if ($result[1] === "") {
						$player->sendMessage("[SYSTEM]単価が記入されていません。");
						return true;

					} else {

					$this->config->set("prize", $tanka);

					$this->config->save();
					$player->sendMessage("逃走中の単価を".$tanka."に更新しました");

					break;
}
  
			case 413180:
			$cuttime = $result[1];
					if ($result[1] === "") {
						$player->sendMessage("[SYSTEM]時間が記入されていません。");
						return true;

					} else {

					$this->minute = $this->minute - $cuttime;
					$player->sendMessage("逃走中の時間から".$cuttime."秒引きました");

					break;

}
				case 436271:
				if($data == 0){
				$name = $player->getName();
         $buttons[] = [ 
        'text' => "はい", 
        'image' => [ 'type' => 'path', 'data' => "" ] 
        ]; //0
        $buttons[] = [ 
        'text' => "いいえ", 
        'image' => [ 'type' => 'path', 'data' => "" ] 
        ]; //1
        $this->sendForm($player,"鯖民の逃走中参加の設定","参加可能にしますか?",$buttons,28158);
        $this->info[$name] = "form";
        break;
        }elseif($data == 1){
		$buttons[] = [ 
        'text' => "はい", 
        'image' => [ 'type' => 'path', 'data' => "" ] 
        ]; //0
        $buttons[] = [ 
        'text' => "いいえ", 
        'image' => [ 'type' => 'path', 'data' => "" ] 
        ]; //1
        $this->sendForm($player,"鯖民の逃走中参加の設定","参加禁止にしますか?",$buttons,281581);
        $this->info[$name] = "form";
        break;
        }
        case 28158:
				if($data == 0){
				$this->guest = true;
				$player->sendMessage("[SYSTEM]参加可能にしました。");
				}else{
				$this->startMenu($player);
        }
        break;
        case 281581:
        if($data == 0){
		$this->guest = false;
		$player->sendMessage("[SYSTEM]参加可能禁止にしました。");
        }else{
        $this->startMenu($player);
        }
        break;

		case 456200://まっちのPlayerNote移植(承諾済み)
			$pplayer = $this->getServer()->getPlayer($result[1]);
					if ($result[1] === "") {
						$player->sendMessage("§l§c⚠ 記入されていません。");
						return true;
					} elseif (!isset($pplayer)) {
						$player->sendMessage("§l§c⚠ そのプレイヤーは現在このサーバー内に存在しません。");
						return true;
					} else {
						$ping = $pplayer->getPing();
						$color = ($ping < 150 ? TextFormat::GREEN : ($ping < 250 ? TextFormat::GOLD : TextFormat::RED));
						$data = [
							"type" => "custom_form",
							"title" => "§l ".$pplayer->getName()." / ＰｌａｙｅｒＮｏｔｅ",
							"content" => [
								[
									"type" => "label",
									"text" => "§l言語: {$pplayer->getLocale()}"
								],
								[
									"type" => "label",
									"text" => "§l応答速度: {$color}{$ping}ms"
								],
								[
									"type" => "label",
									"text" => "§lIPアドレス: {$pplayer->getAddress()}"
								],
								[
									"type" => "label",
									"text" => "§lホスト: ".gethostbyaddr($pplayer->getAddress())
								],
								[
									"type" => "label",
									"text" => "§lポート: {$pplayer->getPort()}"
								],
								[
									"type" => "label",
									"text" => "§lクライアントID: {$pplayer->getClientId()}"
								],
								[
									"type" => "label",
									"text" => "§lＸＵＩＤ: {$pplayer->getXuid()}"
								],
								[
									"type" => "label",
									"text" => "§lＵＵＩＤ: {$pplayer->getUniqueId()}"
								],
								[
									"type" => "label",
									"text" => "§lワールド: {$pplayer->getLevel()->getFolderName()}"
								],
								[
									"type" => "label",
									"text" => "§l座標: x:{$pplayer->getX()} y:{$pplayer->getY()} z:{$pplayer->getZ()}"
								],
								[
									"type" => "input",
									"text" => "§lＮａｍｅＴａｇ",
									"placeholder" => "",
									"default" => $pplayer->getNameTag()
								],
								[
									"type" => "input",
									"text" => "§lＤｉｓｐｌａｙＮａｍｅ",
									"placeholder" => "",
									"default" => $pplayer->getDisplayName()
								],
								[
									"type" => "step_slider",
									"text" => "§lゲームモード",
									"steps" => array("§l§aサバイバル", "§l§eクリエイティブ", "§l§cアドベンチャー", "§l§bスペクテイター"),
									"default" => $pplayer->getGamemode()
								],
								[
									"type" => "label",
									"text" => "§l体力: {$pplayer->getHealth()}"
								],
								[
									"type" => "label",
									"text" => "§l最大体力: {$pplayer->getMaxHealth()}"
								],
								[
									"type" => "label",
									"text" => "§l空腹度: {$pplayer->getFood()}"
								],
								[
									"type" => "input",
									"text" => "§l§c⚠ ここを扱わないでください。",
									"placeholder" => "{$pplayer->getName()}",
									"default" => $pplayer->getName()
								]
							]
						];
						$this->createWindow($player, $data, 571896);
					}
					
					case 9891019:
					if($data == 0){//メンテ参加(OPなのでConfigとの比較無し)
					$hunter = 'runner';
                   $this->team($player, $hunter);
                   $this->getServer()->broadcastMessage("[メンテ]§e{$name}さんが逃走中に参加しました");
                   break;
                   }elseif($data == 1){//メンテ退出(OPなのでConfigとの比較無し)
                   $hunter = 'hunter';
                   $this->team($player, $hunter);
                   $this->getServer()->broadcastMessage("[メンテ]§c{$name}さんが逃走中に参加しました");
                   break;
                   }else{
					$this->startMenu($player);
					}
					break;

					case 7039675://ステータス確認
					$pplayer = $this->getServer()->getPlayer($result[1]);
					if ($result[1] === "") {
						$player->sendMessage("§l§c⚠ 記入されていません。");
						return true;
					} else {
					$name = $pplayer->getName();
					$data = [
				"type" => "custom_form",
				"title" => "ステータス",
				"content" => [
					[
						"type" => "label",
						"text" => "§l§6{$name}§fさんのステータス"
					],
					[
						"type" => "label",
						"text" => "§b逃げ切った回数: §e{$this->getNige($name)}§b回"
					],
					[
						"type" => "label",
						"text" => "§d確保した回数: §e{$this->getKakuho($name)}§d回"
					]
				]
			];
			$this->createWindow($player, $data, 7438920);
     }
     break;
  }
 }
 }
}
	public function createWindow(Player $player, $data, int $id){
		$pk = new ModalFormRequestPacket();
		$pk->formId = $id;
		$pk->formData = json_encode($data, JSON_PRETTY_PRINT | JSON_BIGINT_AS_STRING | JSON_UNESCAPED_UNICODE);
		$player->dataPacket($pk);
	}
 }
