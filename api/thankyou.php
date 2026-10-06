<?php

include("config.php");





<div class="container-fluid">
	<div class="row">
		<div class="col-sm-6">



			<?php
			include("Instamojo/Instamojo.php");



			$api = new Instamojo\Instamojo("6eadb9f056aa4b2fb83217c1e50cb06f", "587e0ea84f93ed9ddc08395b542a333b", 'https://www.instamojo.com/api/1.1/');
			$payid = $_GET['payment_request_id'];


			try {
				$response = $api->paymentRequestStatus($payid);
				echo "<h4>Payment Id :-   " . $response['payments'][0]['payment_id'] . "</h4>";
				//print_r($response);
				?>
				<h2>Payments details :- </h2>
				<table border="1" class="table table-striped">
					<!--
		<tr>
		<th>You Choose is :-</th>
		<td><?php echo $purpose=$response['purpose'];?></td>
		</tr>-->
					<tr>
						<th>Payment Id :- </th>
						<td>
							<?php echo $pid = $response['payments'][0]['payment_id']; ?>
						</td>
					</tr>
					<tr>
						<th>Payee Name</th>
						<td>
							<?php echo $name = $response['payments'][0]['buyer_name']; ?>
						</td>
					</tr>
					<tr>
						<th>Payee Email</th>
						<td>
							<?php echo $email = $response['payments'][0]['buyer_email']; ?>
						</td>
					</tr>
					<tr>
						<th>Payee phone Number</th>
						<td>
							<?php echo $phone = $response['payments'][0]['buyer_phone']; ?>
						</td>
					</tr>
					<tr>
						<th>Payee status</th>
						<td>
							<?php echo $status = $response['payments'][0]['status'] ?>
						</td>
					</tr>
					<tr>
						<th>Payee amount</th>
						<td>
							<?php echo $amount = $response['payments'][0]['amount'] ?>
						</td>
					</tr>
					<?php
					date_default_timezone_set('Asia/Kolkata');


					$pay_date = date("Y-m-d h:i:sa");


					$stmt = mysqli_prepare($conn, "INSERT INTO spay (p_id, amount, payment_status, pay_date, phone, email, name, purpose) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
					mysqli_stmt_bind_param($stmt, "ssssssss", $pid, $amount, $status, $pay_date, $phone, $email, $name, $purpose);
					$run = mysqli_stmt_execute($stmt);
					if ($run>0) {
						echo "<div class='alert alert-success'>Payment Successfully Credit.</div>";
					} else {
						echo "<div class='alert alert-danger'>Payment Failure! Please try again.</div>";
					}

					?>
				</table>
				<?php
			} catch (Exception $e) {
				print('Error: ' . $e->getMessage());
			}


			?>

		</div><!-- column 1 closed -->
		<div class="col-sm-6 mt-3">
			
			<button data-bs-toggle="collapse" class="btn btn-success mt-3" data-bs-target="#demo_print">Print Preview</button>
		
			<div id="demo_print" class="collapse mt-3">
				<?php
				$stmt5 = mysqli_prepare($conn, "SELECT * FROM tc_register WHERE spoc_email=?");
				mysqli_stmt_bind_param($stmt5, "s", $email);
				mysqli_stmt_execute($stmt5);
				$query5 = mysqli_stmt_get_result($stmt5);
				$row1 = mysqli_fetch_array($query5);

				?>
				<table border="1" class="table table-striped">
					<tr>
						<th>First Name</th>
						<td>
							<?php echo $row1['spoc_name']; ?>
						</td>
					</tr>

					<tr>
						<th>Email</th>
						<td>
							<?php echo $row1['spoc_email']; ?>
						</td>
					</tr>
					<tr>
						<th>Phone Number</th>
						<td>
							<?php echo $row1['spoc_phone']; ?>
						</td>
					</tr>

					<tr>
						<th>Amount</th>
						<td>
							<?php echo $row1['amount']; ?>
						</td>
					</tr>
					<tr>
						<th>Payment Id</th>
						<td>
							<?php echo $row1['p_id']; ?>
						</td>
					</tr>
					<tr>
						<th>Payment Status</th>
						<td>
							<?php echo $row1['payment_status']; ?>
						</td>
					</tr>
					<tr>
						<th>Registeration Date</th>
						<td>
							<?php echo $row1['reg_date']; ?>
						</td>
					</tr>
					<tr>
						<th>Payment Date</th>
						<td>
							<?php echo $row1['pay_date']; ?>
						</td>
					</tr>
					<tr>
						<td colspan="2"><input type="button" value="Print Record" class="btn btn-success"
								onclick="window.print();" name=""></td>

					</tr>
				</table>

			</div>



		</div><!-- column 2 closed -->

	</div>

</div>
