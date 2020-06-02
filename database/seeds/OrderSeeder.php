<?php

use Flynsarmy\CsvSeeder\CsvSeeder;
use Illuminate\Support\Facades\Auth;

class OrderSeeder extends CsvSeeder
{
	public function __construct()
	{
		$this->table = 'orders';
		$this->csv_delimiter = ',';
		$this->filename = base_path().'/database/seeds/csvs/orders.csv';
		// Uncomment to import orders from MiGabinete
		// $this->offset_rows = 1;
		// $this->mapping = [
	  //   0 => 'id',
	  //   1 => 'shopping_bag_id',
	  //   2 => 'user_id',
		// 	3 => 'clinic_id',
		// 	4 => 'product_provider_id',
		// 	5 => 'profile_id',
		// 	6 => 'details',
		// 	7 => 'orderable_id',
		// 	8 => 'orderable_type',
		// 	10 => 'quantity',
		// 	12 => 'created_at',
		// 	13 => 'updated_at'
		// ];
	}
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
		// Recommended when importing larger CSVs
		// DB::disableQueryLog();

		// Uncomment the below to wipe the table clean before populating
		DB::table($this->table)->truncate();

		parent::run();

		// Uncomment to import orders from MiGabinete
		// Auth::loginUsingId(1);
		// $orders = App\Order::get();

		// foreach ($orders as $order) {
		// 	$order->user_id = 1;
		// 	$order->orderable_type = 'App\Product';
		// 	switch ($order->orderable_id) {
		// 		case 1:
		// 			if ($order->product_provider_id === 2) $order->product_provider_id = 21;
		// 			break;
		// 		case 2:
		// 			if ($order->product_provider_id === 1) $order->product_provider_id = 2;
		// 			else $order->product_provider_id = 22;
		// 			break;
		// 		case 3:
		// 			if ($order->product_provider_id === 1) $order->product_provider_id = 3;
		// 			else $order->product_provider_id = 23;
		// 			break;
		// 		case 4:
		// 			if ($order->product_provider_id === 1) $order->product_provider_id = 4;
		// 			else $order->product_provider_id = 24;
		// 			break;
		// 		case 5:
		// 			$order->orderable_id = 7;
		// 			$order->product_provider_id = 25;
		// 			break;
		// 		case 6:
		// 			$order->orderable_id = 8;
		// 			$order->product_provider_id = 26;
		// 			break;
		// 		case 7:
		// 			$order->orderable_id = 9;
		// 			$order->product_provider_id = 27;
		// 			break;
		// 		case 8:
		// 			$order->orderable_id = 10;
		// 			if ($order->product_provider_id === 1) $order->product_provider_id = 28;
		// 			else $order->product_provider_id = 45;
		// 			break;
		// 		case 9:
		// 			$order->orderable_id = 11;
		// 			$order->product_provider_id = 29;
		// 			break;
		// 		case 10:
		// 			$order->orderable_id = 12;
		// 			$order->product_provider_id = 30;
		// 			break;
		// 		case 11:
		// 			$order->orderable_id = 13;
		// 			$order->product_provider_id = 31;
		// 			break;
		// 		case 12:
		// 			$order->orderable_id = 14;
		// 			$order->product_provider_id = 32;
		// 			break;
		// 		case 13:
		// 			$order->orderable_id = 16;
		// 			if ($order->product_provider_id === 1) $order->product_provider_id = 34;
		// 			else $order->product_provider_id = 35;
		// 			break;
		// 		case 14:
		// 			$order->orderable_id = 17;
		// 			if ($order->product_provider_id === 1) $order->product_provider_id = 36;
		// 			else $order->product_provider_id = 37;
		// 			break;
		// 		case 15:
		// 			$order->product_provider_id = 33;
		// 			break;
		// 		case 17:
		// 			$order->orderable_id = 23;
		// 			$order->product_provider_id = 44;
		// 			break;
		// 		case 18:
		// 			$order->orderable_id = 19;
		// 			$order->product_provider_id = 40;
		// 			break;
		// 		case 19:
		// 			$order->orderable_id = 20;
		// 			$order->product_provider_id = 41;
		// 			break;
		// 		case 20:
		// 			$order->orderable_id = 24;
		// 			$order->product_provider_id = 47;
		// 			break;
		// 		case 21:
		// 			$order->orderable_id = 21;
		// 			$order->product_provider_id = 42;
		// 			break;
		// 		case 22:
		// 			$order->orderable_id = 22;
		// 			$order->product_provider_id = 43;
		// 			break;
		// 		case 23:
		// 			$order->orderable_id = 25;
		// 			$order->product_provider_id = 48;
		// 			break;
		// 	}
		// 	$order->save();
		// }

	}
}
