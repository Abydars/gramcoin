<?php

namespace App\Console\Commands;

use App\UserWallet;
use Illuminate\Console\Command;

class SynchronizeWalletBalance extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'wallet:sync';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Synchronize wallets from Block Trail';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$cmd = $this;
		UserWallet::all()->each( function ( UserWallet $wallet ) use ( &$cmd ) {
			$wallet->getBalance();
			$wallet->user->btc_balance = $wallet->balance;
			$wallet->user->save();

			$cmd->line( 'ID: ' . $wallet->user->id . ', Balance: ' . $wallet->user->btc_balance );
		} );
	}
}
