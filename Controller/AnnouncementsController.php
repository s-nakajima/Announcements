<?php
/**
 * Announcements Controller
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 *
 * type :
 *  Draft : 下書き
 *  PublishRequest : 公開申請
 *  Publish : 公開
 *
 * API:
 *  get : 取得
 *  put : 新規作成
 *  post :修正
 *  delete : 削除
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
		'Security',
		'RequestHandler'
	);

	//セッティングモード
	private $_isSetting = false;

	//非同期通信判定
	private $_isAjax = false;
	//編集権源あり
	private $_isEditer = false;

	//model格納
	public $AnnouncementDatum = null;
	public $Frame = null;
	public $Block = null;
	public $Announcement = null;

	//値
	public $langId = 2; //基本言語 日本語 あとで見直し。
	public $lang = 'ja';
	public $langList = array();
	public $_roomId = 0;
	private $_userId = 0;


	// 仕込み
	public function beforeFilter() {
		//親処理
		parent::beforeFilter();
		//modelのセット
		$this->AnnouncementDatum = Classregistry::init("Announcements.AnnouncementDatum");
		//設定値の格納
		$this->_isSetting = Configure::read('Pages.isSetting');
		$this->Frame = Classregistry::init("Announcements.AnnouncementFrame");
		//blockId初期値設定 view用
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
		//ルームIDの設定
		$this->_setRoomtId();
		//ユーザIDの設定
		$this->_setUserId();

		//json
		//

	}


/**
 * Index
 */
	public function index($frameId = 0) {
		//レイアウトきりかえ
		$this->_setLayout();
		$this->set('item' , array());
		//blockIdの取得
		$blockId = $this->Frame->getBlockId($frameId);

		 //編集権限が無い人 (ログイン中も含む 公開情報しかみえない）
		if(! $this->_isEditer ){
			//blockから情報を取得 $LangId
			return $this->_index_no_login($frameId);
		}

		//ログインしている場合
		//編集権源があるひと
		//ブロックが設定されておらず、セッティングモードでもない
		if(! $blockId && ! $this->_isSetting) {
			//return $this->render('notice');
		}

		//blockから情報を取得 $LangId
		$data = $this->AnnouncementDatum->getPublishData($blockId , $this->langId);


		//編集権源がある場合
		$this->set('draftItem' , array());
		//最新情報（フォーム表示用）
		$draftData = $this->AnnouncementDatum->getData($blockId , $this->langId , $this->_isSetting);
		$this->set('draftItem' , $draftData);
		//echo '<pre>'; var_dump( $draftData); echo '</pre>';
		//echo '<pre>'; var_dump( $data); echo '</pre>';
		//出力情報セット
		$this->set('item' , $data);
		$this->set('frameId' , $frameId);
		$this->set('blockId', $blockId);
		//出力
		return $this->render();
	}

	//未ログイン中の人用
	private function _index_no_login($frameId){
		$blockId = $this->Frame->getBlockId($frameId);
		$this->set('Data' , array());
		//blockから情報を取得 $LangId
		$data = $this->AnnouncementDatum->getPublishData($blockId , $this->langId);
		$this->set('item' , $data);
		$this->set('frameId' , $frameId);
		$this->set('blockId', $blockId);
		return $this->render("index_not_login");
	}

/**
 * お知らせの保存処理実行
 *
 * @param int $frameId
 * @param int $blockId
 * @return CakeResponse
 */
	public function post($frameId=0 , $blockId=0 , $dataId=0)
	{
		$this->_setLayout();

		$rtn = $this->AnnouncementDatum->saveData(
			$this->data ,
			$this->_userId,
			$this->_roomId,
			$this->_isAjax
		);

	   if($rtn) {
		   $result = array(
				'status'=>'OK',
				'message'=>__('保存しました'),
				'data'=>$rtn
		   );
		   $this->viewClass = 'Json';
		   $this->set(compact('result'));
		   $this->set('_serialize', 'result');
		   return $this->render();
	   }

		$result = array(
			'status'=>'NG',
			'message'=>__('保存に失敗しました')
		);
		$this->viewClass = 'Json';
		$this->set(compact('result'));
		$this->set('_serialize', 'result');
		return $this->render();

	}

	//お知らせの新規作成 (ブロックの作成も含む）
	public function put($type , $frameId=0 ,$blockId=0 , $dataId=0){
		//成功した場合、結果をreturnする
		//json
		//blockIdを必ず返す必要がある。
		//contentはurlエンコードを行う
	}

	//お知らせの削除
	//ブロックごと削除 block
	//記事だけ削除    data 物理削除
	//
	public function delete($type , $frameId=0 , $blockId=0, $dataId=0){

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
		$this->layout = false;
		//パート名 あとでDBから取得する。
		$part = array(
			1=>array("id"=>1 , "name"=>'ルーム管理者'),
			2=>array("id"=>2 ,"name"=>'編集長'),
			3=>array("id"=>3 ,"name"=>'編集者'),
			4=>array("id"=>4 ,"name"=>'一般')
		);

		$this->set('partList' , $part);
		$this->set('partListSelect');
		$this->set('frameId' , $frameId);


	}

	//フォームの取得
	public function get_edit_form($frameId = 0 , $blockId = 0) {
		$this->layout = false;
		$this->set('frameId' , $frameId);
	}

	//編集権源のチェック
	private  function _checkEditer() {
		$this->_isEditer = true;
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
   //roomIdの設定
	private function _setRoomtId(){
		//pageから取得するべき情報
		$this->_roomId = 1;
	}
	//userIdの設定
	private function _setUserId(){
		$this->_userId = 1;
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