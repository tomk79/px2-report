<?php
namespace tomk79\pickles2\px2report;

/**
 * px2-report
 */
class found{

	/**
	 * NGワードが含まれていたら、報告する
	 * @param object $px Picklesオブジェクト
	 * @param object $json プラグイン設定
	 */
	public static function ngwords( $px, $json ){

		foreach( $px->bowl()->get_keys() as $key ){
			$src = $px->bowl()->get( $key );

			foreach($json as $ngword){
				$pattern = '/('.preg_quote($ngword, '/').')/i'; // case insensitive
				if( preg_match($pattern, $src, $matched) ){
					$ngword_hit = $matched[0];
					$msg = '';
					if( $ngword !== $ngword_hit ){
						$msg = 'NG Word "'.$matched[0].'" was found. (hinted by "'.$ngword.'")';
					}else{
						$msg = 'NG Word "'.$ngword.'" was found.';
					}
					$px->error( $msg );
				}
			}
		}

		return true;
	}
}
