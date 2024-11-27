<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Debug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $amount = $this->generate(33000);
        return 0;
        $data = [];
        for ($i=2000;$i<=5000;$i++){
            if($i%100 != 0) continue;
            $amount = $this->generate($i);
            $data[] = $amount;
        }
        usort($data, function($a, $b) {
            return $a['1'] <=> $b['1'];
        });

        dd($data);

        return 0;
    }

    public function generate($amount)
    {
        $baseAmount = $amount;
        //$amount = 3000;
        $totalAmount = $amount;

        $percents = [
            //[0.09,0.07],
            [0.15,0.09],
            [0.19,0.12],
            //[0.30,0.22],
            //[0.32,0.28],
        ];
        foreach ($percents as $key => $percent) {
            $this->getAmount($amount,$percent[0],$percent[1],$key + 1,$totalAmount);
        }
        $this->info("总投入金额：".$totalAmount);
        $this->info("股价总计下跌：".((0.15 + 0.1) * 100)."%");


        $this->info("这个时候股价开始反弹：假设25%");
        $endAmount = round($amount * 0.25 + $amount,2);
        $this->info("反弹后金额来到：".$endAmount);
        $billAmount = round($endAmount - $totalAmount,2);
        $this->info("卖出后盈利：".$billAmount);
        $this->info("盈利比：".round($billAmount/$totalAmount * 100,2).'%');
        return [$baseAmount,$totalAmount - $billAmount];

    }

    public function getAmount(&$currentAmount,$start,$end,$key,&$totalAmount)
    {
        $this->info("当前持仓金额({$key}):".$currentAmount);
        $this->info("当下跌百分比".$start * 100 ."%");

        $diffAmount = $totalAmount * $start;
        $this->info("当前亏损金额:".$diffAmount);
        $currentAmount -= $diffAmount;
        $nextAmount = $this->amount($totalAmount,$currentAmount,1-$end);
        $currentAmount += $nextAmount;
        $totalAmount += $nextAmount;
        $this->info("再投入({$key}):".$nextAmount);
        $this->info("当前亏损百分比:".$end * 100 ."%");
        $this->info("当前持仓({$key}):".$currentAmount."/".$totalAmount);

        $this->info("");
    }
    public function amount($totalAmount,$currentAmount,$percents)
    {
        $addAmount = 0;
        for ($i = 0;$i<1000000;$i++) {
            $addAmount += 1;
            $totalAmount ++;
            if((($currentAmount + $addAmount)/$totalAmount) > $percents){
                break;
            }
        }
        return $addAmount;

    }
}
