<?php 
	$dbconn = mysqli_connect("localhost","root","");

	//creating database
	$dbcreate = "CREATE DATABASE IF NOT EXISTS burmics";
	$dbcreate_rtn = mysqli_query($dbconn, $dbcreate);


	//selecting database
	mysqli_select_db($dbconn, 'burmics');

	//creating tables

	//wallet table
	$wallet_tb = "CREATE TABLE IF NOT EXISTS wallet
	(
		wallet_id CHAR(8) NOT NULL PRIMARY KEY,
		amount INT(7) NOT NULL DEFAULT 0
	)";
	$wallet_tb_rtn = mysqli_query($dbconn, $wallet_tb);

	//package table
	$package_tb = "CREATE TABLE IF NOT EXISTS package
	(
		package_id CHAR(8) NOT NULL PRIMARY KEY,
		package_name VARCHAR(20),
		duration_day INT(2) NOT NULL,
		price INT(7) NOT NULL
	)";
	$package_tb_rtn = mysqli_query($dbconn, $package_tb);

	//payment method table
	$payMethod_tb = "CREATE TABLE IF NOT EXISTS payment_method(
		pm_id CHAR(4) NOT NULL PRIMARY KEY,
		payment_method VARCHAR(20) NOT NULL,
		acc_number VARCHAR(30) NOT NULL,
		holder_name VARCHAR(50) NOT NULL
	)";
	$pmethod_tb_rtn = mysqli_query($dbconn, $payMethod_tb);

	$er_tb = "CREATE TABLE IF NOT EXISTS exchange_rate(
		er_type CHAR(4) NOT NULL PRIMARY KEY,
		rate_per_coin INT(6)
	)";
	$er_tb_rtn = mysqli_query($dbconn, $er_tb); //creating exchange rate Table

	//staff table
	$staff_tb = "CREATE TABLE IF NOT EXISTS staff
	(
		staff_id CHAR(8) NOT NULL PRIMARY KEY,
		full_name VARCHAR(50) NOT NULL,
		email VARCHAR(50) NOT NULL,
		password VARCHAR(32),
		phone_no VARCHAR(13),
		nrc VARCHAR(20),
		address TEXT,
		join_date DATE
	)";
	$staff_tb_rtn = mysqli_query($dbconn, $staff_tb);

	//user table
	$user_tb = "CREATE TABLE IF NOT EXISTS user
	(
		user_id CHAR(8) NOT NULL PRIMARY KEY,
		username VARCHAR(30) NOT NULL,
		user_icon VARCHAR(30) DEFAULT 'defIcon.png',
		email VARCHAR(50) NOT NULL,
		password VARCHAR(32),
		age VARCHAR(10),
		acc_type VARCHAR(8),
		create_date DATE,
		wallet_id CHAR(8),
		status VARCHAR(7) DEFAULT 'free',
		FOREIGN KEY(wallet_id) REFERENCES wallet(wallet_id)
	)";
	$user_tb_rtn = mysqli_query($dbconn, $user_tb);

	//creator table
	$creator_tb = "CREATE TABLE IF NOT EXISTS creator
	(
		creator_id CHAR(8) NOT NULL PRIMARY KEY,
		user_id CHAR(8),
		phone_no VARCHAR(13),
		FOREIGN KEY(user_id) REFERENCES user(user_id)
	)";
	$creator_tb_rtn = mysqli_query($dbconn, $creator_tb);


	//series table
	$series_tb = "CREATE TABLE IF NOT EXISTS series
	(
		series_id CHAR(8) NOT NULL PRIMARY KEY,
		creator_id CHAR(8),
		series_name VARCHAR(50) NOT NULL,
		author VARCHAR(50) NOT NULL,
		artist VARCHAR(100) NOT NULL,
		genre_1 VARCHAR(13) NOT NULL,
		genre_2 VARCHAR(13),
		genre_3 VARCHAR(13),
		description TEXT,
		cover_img VARCHAR(20),
		age_restrict VARCHAR(8),
		create_date DATE,
		last_update DATETIME,
		FOREIGN KEY (creator_id) REFERENCES creator(creator_id)
	)";
	$series_tb_rtn = mysqli_query($dbconn, $series_tb);


	//chapter table
	$chapter_tb = "CREATE TABLE IF NOT EXISTS chapter
	(
		chap_id CHAR(8) NOT NULL PRIMARY KEY,
		series_id CHAR(8),
		chap_no VARCHAR(11) NOT NULL,
		chap_name VARCHAR(50),
		images TEXT,
		note TEXT,
		upload_date DATETIME,
		status VARCHAR(10),
		FOREIGN KEY (series_id) REFERENCES series(series_id)
	)";
	$chapter_tb_rtn = mysqli_query($dbconn, $chapter_tb);

	$chap_view = "CREATE TABLE IF NOT EXISTS ch_view_count
	(
		vc_id CHAR(8) NOT NULL PRIMARY KEY,
		chap_id CHAR(8),
		views INT(8) DEFAULT 0,
		last_update DATETIME,
		FOREIGN KEY(chap_id) REFERENCES chapter(chap_id)
	)";
	$ch_view_rtn = mysqli_query($dbconn, $chap_view);

	//series rating table
	$rating_tb = "CREATE TABLE IF NOT EXISTS series_rating
	(
		rate_id CHAR(8) NOT NULL PRIMARY KEY,
		user_id CHAR(8),
		series_id CHAR(8),
		rating INT(1),
		feedback TEXT,
		FOREIGN KEY(user_id) REFERENCES user(user_id),
		FOREIGN KEY(series_id) REFERENCES series(series_id)
	)";
	$rating_tb_rtn = mysqli_query($dbconn, $rating_tb);
	
	$rate_tb = "CREATE TABLE IF NOT EXISTS rating(
		rating_id CHAR(8) NOT NULL PRIMARY KEY,
		user_id CHAR(8),
		rating INT(1),
		review TEXT,
		FOREIGN KEY(user_id) REFERENCES user(user_id))";
	$rtb_rtn = mysqli_query($dbconn,$rate_tb);

	// library table
	$library_tb = "CREATE TABLE IF NOT EXISTS library
	(
		lib_id CHAR(8) NOT NULL PRIMARY KEY,
		user_id CHAR(8),
		series_names TEXT,
		FOREIGN KEY (user_id) REFERENCES user(user_id)
	)";
	$library_tb_rtn = mysqli_query($dbconn, $library_tb);


	//chap_read_track table
	$crt_tb = "CREATE TABLE IF NOT EXISTS chap_read_track
	(
		crt_id CHAR(8) NOT NULL PRIMARY KEY,
		user_id CHAR(8),
		chap_id CHAR(8),
		read_date DATETIME,
		FOREIGN KEY(user_id) REFERENCES user(user_id),
		FOREIGN KEY(chap_id) REFERENCES chapter(chap_id)
	)";
	$crt_tb_rtn = mysqli_query($dbconn, $crt_tb);


	//locked_chap table
	$lc_tb = "CREATE TABLE IF NOT EXISTS locked_chapter
	(
		lock_id CHAR(8) NOT NULL PRIMARY KEY,
		chap_id CHAR(8),
		price INT(3) NOT NULL,
		upload_date DATE,
		expire_date DATE,
		FOREIGN KEY(chap_id) REFERENCES chapter(chap_id)
	)";
	$lc_tb_rtn = mysqli_query($dbconn, $lc_tb);


	//early access purchase table
	$ea_tb = "CREATE TABLE IF NOT EXISTS ea_purchase_rec
	(
		eap_id CHAR(8) NOT NULL PRIMARY KEY,
		user_id CHAR(8),
		lock_id CHAR(8),
		purc_date DATETIME,
		FOREIGN KEY(user_id) REFERENCES user(user_id),
		FOREIGN KEY(lock_id) REFERENCES locked_chapter(lock_id)
	)";
	$ea_tb_rtn = mysqli_query($dbconn, $ea_tb);


	//package purchase table
	$pp_tb = "CREATE TABLE IF NOT EXISTS package_purchase_rec
	(
		ppr_id CHAR(8) NOT NULL PRIMARY KEY,
		user_id CHAR(8),
		package_id CHAR(8),
		purchase_date DATETIME NOT NULL,
		expire_date DATETIME NOT NULL,
		FOREIGN KEY(user_id) REFERENCES user(user_id),
		FOREIGN KEY(package_id) REFERENCES package(package_id)
	)";
	$pp_tb_rtn = mysqli_query($dbconn, $pp_tb);


	//donation table
	$donate_tb = "CREATE TABLE IF NOT EXISTS donation
	(
		donation_id CHAR(8) NOT NULL PRIMARY KEY,
		user_id CHAR(8),
		amount INT(7),
		donate_date DATE,
		FOREIGN KEY(user_id) REFERENCES user(user_id)
	)";
	$donate_tb_rtn = mysqli_query($dbconn, $donate_tb);


	//coin_purchase_rec table
	$cp_tb = "CREATE TABLE IF NOT EXISTS coin_purchase_rec
	(
		cpr_id CHAR(10) NOT NULL PRIMARY KEY,
		user_id CHAR(8),
		coin_amount INT(7) NOT NULL,
		amount INT(8) NOT NULL,
		cp_date DATETIME,
		confirm_date DATETIME,
		staff_id CHAR(8),
		pm_id CHAR(4),
		payment_ss VARCHAR(30),
		status VARCHAR(12),
		FOREIGN KEY(user_id) REFERENCES user(user_id),
		FOREIGN KEY(staff_id) REFERENCES staff(staff_id),
		FOREIGN KEY(pm_id) REFERENCES payment_method(pm_id)
	)";
	$cp_tb_rtn = mysqli_query($dbconn, $cp_tb);


	//withdrawal_rec
	$withdraw_tb = "CREATE TABLE IF NOT EXISTS coin_withdraw_rec
	(
		w_id CHAR(8) NOT NULL PRIMARY KEY,
		creator_id CHAR(8),
		coin_amount INT(6),
		amount INT(8),
		pm_id CHAR(4),
		acc_holder VARCHAR(50),
		acc_number VARCHAR(30),
		w_date DATETIME,
		confirm_date DATETIME,
		staff_id CHAR(8),
		status VARCHAR(12),
		FOREIGN KEY(creator_id) REFERENCES creator(creator_id),
		FOREIGN KEY(staff_id) REFERENCES staff(staff_id),
		FOREIGN KEY(pm_id) REFERENCES payment_method(pm_id)
	)";
	$withdraw_tb_rtn = mysqli_query($dbconn, $withdraw_tb);


 ?>