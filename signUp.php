<?php
require_once 'config.php';
$config = $server_config['db'];

if($_POST){
	//echo '使用了<font color="red">post</font>方式傳遞資料,<br />「<font color="red">網址列</font>」上不會顯示傳遞的資料訊息<br /><br />';
	//if(!empty($_POST['error_type'])){echo '種類:'.$_POST['error_type'].'<br />';}else{echo 'none<br />';}
	//if(!empty($_POST['error_num'])){echo '編號:'.$_POST['error_num'].'<br />';}else{echo 'none<br />';}

	//echo '<p style="color:red">送出的資料將會是以「陣列」方式儲存在 $_POST 變數當中，<br />因此可使用 var_dump($_POST) 或 print_r($_POST) 涵數查詢內容如下:</p>';
	//echo '<p>';
	//print_r($_POST);
	//echo $_POST;
	//echo '</p>';
	if(!empty($_POST['error_type']) && !empty($_POST['error_num']))
	{
		//$Type = "M"; //設定Type
		//echo '種類是'.$_POST['error_type'];
		$Type = $_POST['error_type'];
		//$Num = "5911";//設定Num
		//echo '編號是'.$_POST['error_num'];
		$Num = $_POST['error_num'];
		//echo '轉型號的編號'.$Num;
		//$Msg = "aaaalkhlkjlkaa";//設定Msg

		//echo  "start<BR>";
		//產生一個PDO（PHP Data Object）物件
		$pdo = new PDO(
    	'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'],
    	$config['username'],
    	$config['password']
    );
		//echo "new a object of PDO<BR>";



		$pdo->beginTransaction();//開始提交任務 關閉自動提交
		//產生一個自動帶入的物件
		$sth = $pdo->prepare('SELECT * FROM DemoDB WHERE Type = :Type AND Num = :Num');
		//echo "pdo prepare OK<BR>";
		$sth->bindParam(':Type', $Type,PDO::PARAM_STR);
		$sth->bindParam(':Num', $Num,PDO::PARAM_STR);
		//echo "pdo bindParam OK<BR>";
		$sth->execute();//執行

		if ($sth->errorCode()) {
 			//echo $sth->errorInfo() . "<BR>";
		}
		//echo "pdo excute OK<BR>";

		$pdo->commit();//提交
		//echo "pdo commit OK<BR>";

		$datas = $sth->fetch(PDO::FETCH_ASSOC);
		if ($datas) {
 			echo "isUsed<BR>";
 			echo $datas[Msg];
 			//print_r($datas[Msg]);
 			//$pdo->beginTransaction();
 			//$sth = $pdo->prepare();
		}else {
			echo "NotUsed<BR>";
/*			$pdo->beginTransaction();//開始提交任務 關閉自動提交
			//產生一個自動帶入的物件
			$sth = $pdo->prepare('INSERT INTO DemoDB (Type, Num, Msg) VALUES (:Type, :Num, :Msg)');
			echo "pdo prepare OK<BR>";
			$sth->bindParam(':Type',$Type,PDO::PARAM_STR);//設定:Type為$Type並指定是str形式
			$sth->bindParam(':Num', $Num,PDO::PARAM_STR);//設定:Num為$Num並指定是str形式
			$sth->bindParam(':Msg', $Msg,PDO::PARAM_STR);
			echo "pdo bindParam OK<BR>";
			$sth->execute();//執行
			if ($sth->errorCode()) {
 				echo $sth->errorInfo() . "1234<BR>";
			}
			echo "pdo excute OK<BR>";

			$pdo->commit();//提交
			echo "pdo commit OK<BR>";*/
		}
	}
}
?>
