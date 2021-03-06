<?php
/**
 * test
 */

class mainTest extends PHPUnit_Framework_TestCase{
	private $fs;

	public function setup(){
		mb_internal_encoding('UTF-8');
		$this->fs = new tomk79\filesystem();
	}


	/**
	 * 普通に実行してみるテスト
	 */
	public function testStandard(){
		$output = $this->passthru( [
			'php',
			__DIR__.'/testdata/src_px2/.px_execute.php' ,
			'/' ,
		] );
		// var_dump($output);
		$this->assertTrue( $this->common_error( $output ) );

		// パブリッシュ
		$output = $this->passthru( [
			'php', __DIR__.'/testdata/src_px2/.px_execute.php', '/?PX=publish.run'
		] );
		// var_dump($output);
		$this->assertTrue( $this->common_error( $output ) );
		clearstatcache();

		// alert_log.csv を確認する
		$path_csv = __DIR__.'/testdata/src_px2/px-files/_sys/ram/publish/alert_log.csv';
		$this->assertTrue( is_file(__DIR__.'/testdata/src_px2/px-files/_sys/ram/publish/alert_log.csv') );
		$fs = new \tomk79\filesystem();
		$csv = $fs->read_csv($path_csv);
		// var_dump($csv);
		$this->assertTrue( is_array($csv) );
		$this->assertEquals( count($csv), 10 );
		$this->assertEquals( $csv[1][1], '/index.html' );
		$this->assertEquals( $csv[1][2], 'NG Word "nogood" was found.' );
		$this->assertEquals( $csv[2][1], '/index.html' );
		$this->assertEquals( $csv[2][2], 'NG Word "nogood" was found. (hinted by "NoGood")' );
		$this->assertEquals( $csv[4][1], '/common/scripts/contents.js' );
		$this->assertEquals( $csv[4][2], 'NG Word "func" was found.' );

		// 後始末
		$output = $this->passthru( [
			'php', __DIR__.'/testdata/src_px2/.px_execute.php', '/?PX=clearcache'
		] );

		clearstatcache();
		$this->assertTrue( $this->common_error( $output ) );
		$this->assertTrue( !is_dir( __DIR__.'/testdata/src_px2/caches/p/' ) );

	}





	/**
	 * PHPがエラー吐いてないか確認しておく。
	 */
	private function common_error( $output ){
		if( preg_match('/'.preg_quote('Fatal', '/').'/si', $output) ){ return false; }
		if( preg_match('/'.preg_quote('Warning', '/').'/si', $output) ){ return false; }
		if( preg_match('/'.preg_quote('Notice', '/').'/si', $output) ){ return false; }
		return true;
	}


	/**
	 * コマンドを実行し、標準出力値を返す
	 * @param array $ary_command コマンドのパラメータを要素として持つ配列
	 * @return string コマンドの標準出力値
	 */
	private function passthru( $ary_command ){
		$cmd = array();
		foreach( $ary_command as $row ){
			$param = '"'.addslashes($row).'"';
			array_push( $cmd, $param );
		}
		$cmd = implode( ' ', $cmd );
		ob_start();
		passthru( $cmd );
		$bin = ob_get_clean();
		return $bin;
	}

}
