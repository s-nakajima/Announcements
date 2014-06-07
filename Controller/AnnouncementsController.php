<?php
/**
 * Announcements Controller
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */
App::uses('AnnouncementsAppController','Announcements.Controller');

class AnnouncementsController extends AnnouncementsAppController {

/**
 * Model name
 *
 * @var array
 */
	public $uses = array(
		'Announcements.Announcement',
		'Announcements.AnnouncementBlock',
		'Announcements.AnnouncementDatum',
		'Announcements.AnnouncementsFrame', //frames
		'Announcements.AnnouncementBlocksView',
	);

/**
 * 使用するコンポーネント
 *
 * @var array
 */
	public $components = array(
		'Security'
	);

	//セッティングモード
	private $_isSetting = false;

	//非同期通信判定
	private $_isAjax = false;

	//model格納
	public $AnnouncementDatum = null;
	public $Frame = null;
	public $Block = null;
	public $Announcement = null;

	//値
	public $langId = 2; //基本言語 日本語 あとで見直し。
	public $lang = 'ja';
	public $langList = array();

// 仕込み
	public function beforeFilter() {
		//親処理
		parent::beforeFilter();
		//modelのセット
		$this->AnnouncementDatum = Classregistry::init("Announcements.AnnouncementDatum");

		//設定値の格納
		$this->_isSetting = Configure::read('Pages.isSetting');
		$this->Frame = Classregistry::init("Announcements.AnnouncementFrame");
		//デェフォルト値
		$this->set('blockId', 0);
		//編集権源のチェックと設定値の格納
		$this->_checkEditer();
		//公開権限のチェックと設定値の格納
		$this->_checkAdmin();
		//著者かどうかの確認と設定値の格納
		$this->_checkAuthor();
		//Ajax判定と設定値の格納
		$this->_checkAjax();
		//言語設定
		$this->_setLang();
	}


/**
 * Index
 */
	public function index($frameId = 0) {
		//レイアウトきりかえ
		$this->_setLayout();

		$blockId = $this->Frame->getBlockId($frameId);
		$this->set('Data' , array());


		//ブロックが設定されておらず、セッティングモードでもない
		if(! $blockId && ! $this->_isSetting
			|| ( ! $frameId) || ! is_numeric($frameId) //frameIDがないもしくは数字じゃない場合
		) {
			return $this->render('notice');
		}

		//ブロックIDが設定されておらず、セッティングモードの場合、editを表示する
		if(! $blockId && $this->_isSetting){
			return $this->edit($frameId , 0);
		}

		//blockから情報を取得 $LangId
		$data = $this->AnnouncementDatum->getData($blockId , $this->langId , $this->_isSetting);
		//データが存在しない場合
		if(! $data){
			//空を返す
			return $this->render('notice');
		}
		//編集権源がある場合
		if($this->_checkEditer()){
			//最新情報（フォーム表示用）
			$draftData = $this->AnnouncementDatum->getData($blockId , $this->langId);
			$this->set('draftItem' , $draftData);
		}
		$this->set('item' , $data);
		$this->set('frameId' , $frameId);
		$this->set('blockId', $blockId);
		return $this->render();
	}


/**
 * お知らせの保存処理実行
 *
 * @param int $frameId
 * @param int $blockId
 * @return CakeResponse
 */
	public function post($frameId=0 , $blockId = 0)
	{
		//TODO:非同期通信以外でaccessされた場合、画面遷移させる。
		//MEMO:残念ながらputは用意できない。リクエストとして新規作成がないため。
		$this->layout = false;
		$this->set('frameId' , $frameId);
		$this->set('blockId' , $blockId);
		// urlデコード後に保存
		// javascriptでurlencodeしているため、使用する関数は rawurlencode関数
		// javascript側は encodeURIComponent()で暗号化している
		// 公開実行の場合、AnnouncementDatum.idが欲しい。
		// 言語情報もpostされてほしい langいる！
		//
		//DBヘ保存
		return $this->render();
	}

	//お知らせの新規作成 (ブロックの作成も含む）
	public function put($frameId){
		//成功した場合、結果をreturnする
		//json
		//blockIdを必ず返す必要がある。
		//contentはurlエンコードを行う
		//
	}

	//お知らせの削除
	//ブロックごと削除 block
	//記事だけ削除    data 物理削除
	//
	public function delete($type , $blockId, $dataId){

	}
	//get
	//記事情報を返す json
	public function get($type , $flameId=0 , $blockId=0, $dataId=0){

	}



/**
 * ブロック設定
 *
 * @param int $frameId フレームのID
 * @return void
 */
	public function block_setting($frameId = 0) {
		//レイアウトきりかえ
		$this->_setLayout();
		$this->set('frameId' , $frameId);
	}

	//フォームの取得
	public function get_edit_form($frameId = 0 , $blockId = 0) {
		$this->layout = false;
		$this->set('frameId' , $frameId);
	}

	//編集権源のチェック
	private  function _checkEditer() {

		$this->set('isEdit', true);
		return true;
	}

	//公開する権限があるかどうかのチェック
	private function _checkAdmin(){
		$this->set('isAdmin', true);
	}

	//書いた人本人かどうかのチェック
	private function _checkAuthor(){
		$this->set('isAuthor', true);
	}

	//ajax通信だった場合、layoutをoffにする
	private function _setLayout() {
		if($this->_isAjax){
			$this->layout = false;
		}
	}

	//非同期通信ではなく直接表示された場合の処理
	private function _checkAccess(){
		if(! $this->_isAjax){
			//frameIdからページを判定 urlを取得し、リダイレクトする。
			//javascriptが読み込まれてないことによる動作不良を防ぐため。
		}
	}

	//ajaxの判定と設定値の格納
	private function _checkAjax(){
		if($this->request->is('ajax')){
			$this->_isAjax = true;
		}
	}

	//言語list
	private function _setLang(){
		//本来はDBより取得
		$this->langList = array(
			1=>'en',
			2=>'ja'
		);
		$this->lang = 'ja';
		$this->langId = 2;
		$this->set('langId' , $this->langId);
	}


}

/*
 * frame_idから表示されるべき情報を取得する。
 * frame_idから、blockを新規作成する
 * frame_idから、内容の変更を取得する。
 * ブロックの削除についての考慮 6/16以降でOK
 *
 * エラーだった場合のjsonのフォーマットを考える
 */