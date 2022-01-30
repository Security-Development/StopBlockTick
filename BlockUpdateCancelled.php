<?php
/**
 * @name BlockUpdateCancelled
 * @author Neo-Developer
 * @main Neo\BlockUpdateCancelled
 * @version 0.1.0
 * @api 4.0.6
 */

 namespace Neo;

use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use function yaml_parse_file;
use function yaml_emit_file;

class BlockUpdateCancelled extends PluginBase {

    private const ID = [
        #blockID
        60
    ];

    public function onEnable() : void {
        $path = Server::getInstance()->getDataPath().'pocketmine.yml';
        $data = yaml_parse_file($path);

        foreach(self::ID as $id) {
            if( isset($data['chunk-ticking']['disable-block-ticking'][$id]) )
                return;

            $data['chunk-ticking']['disable-block-ticking'][] = $id;
        }


        yaml_emit_file($path, $data);

        #메모리 해제
        unset($data);

        $data = explode("\n", file_get_contents($path));
        $str = "";
        
        foreach($data as $key => $text) {
            if( !($text === '---' || $text === '...') ) {
                $str .= str_replace('~', '',$data[$key])."\n";
                continue;
            }
        }

        file_put_contents($path, $str);


    }

}
