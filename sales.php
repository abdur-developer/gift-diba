<?php
	include 'includes/session.php';

	if(isset($_GET['pay'])){
		
		$payid = $_GET['pay'];
		$name = $_SESSION['name'];
		$number = $_SESSION['number'];
		$dl_type = $_SESSION['type']; // delivery type
		$payment = $_SESSION['payment']; //payment type

		unset($_SESSION['name']);
		unset($_SESSION['number']);
		unset($_SESSION['type']);
		unset($_SESSION['payment']);
		
		$date = date('Y-m-d');

		$conn = $pdo->open();

		try{
			
			$stmt = $conn->prepare("INSERT INTO sales (user_id, name, number, payment_type, delivery_type, pay_id, sales_date) VALUES (:user_id, :name, :number, :payment_type, :delivery_type, :pay_id, :sales_date)");
			$stmt->execute(['user_id'=>$user['id'],'name'=>$name, 'number'=>$number, 'payment_type'=>$payment, 'delivery_type'=>$dl_type, 'pay_id'=>$payid, 'sales_date'=>$date]);
			$salesid = $conn->lastInsertId();
			
			try{
				$stmt = $conn->prepare("SELECT * FROM cart LEFT JOIN products ON products.id=cart.product_id WHERE user_id=:user_id");
				$stmt->execute(['user_id'=>$user['id']]);

				foreach($stmt as $row){
					$stmt = $conn->prepare("INSERT INTO details (sales_id, product_id, quantity) VALUES (:sales_id, :product_id, :quantity)");
					$stmt->execute(['sales_id'=>$salesid, 'product_id'=>$row['product_id'], 'quantity'=>$row['quantity']]);
				}

				$stmt = $conn->prepare("DELETE FROM cart WHERE user_id=:user_id");
				$stmt->execute(['user_id'=>$user['id']]);

				$_SESSION['success'] = 'Transaction successful. Thank you.';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}

		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	
	header('location: profile.php');
	
?>