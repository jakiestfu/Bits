<?PHP

class Tiny {
    public static $set = 'H8CVcxRvNAnWy3uTkPKei1MljB2J0oDpQEd6msqzY5FGtUhw47fraZbLIgOXS9';

    public static function toTiny($id){
        $set = self::$set;

        $HexN="";
        $id = floor(abs(intval($id))) * 1000 ;
        $radix = strlen($set);
        while (true) {
            $R=$id%$radix;
            $HexN = $set{$R}.$HexN;
            $id=($id-$R)/$radix;
            if ($id==0) break;
        }
        return $HexN;
    }

    public static function generate_set(){
        $arr = array();
        for ($i = 65; $i <= 122; $i++)
        {
            if ($i < 91 || $i > 96) $arr[] = chr($i);
        }
        $arr = array_merge($arr, range(0, 9));
        shuffle($arr);
        return join('', $arr);
    }
	 
}