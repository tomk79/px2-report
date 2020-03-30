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
				if( strpos($src, $ngword) !== false ){
					$px->error('NG Word "'.$ngword.'" was found.');
				}
			}
		}

		return true;
	}
}
