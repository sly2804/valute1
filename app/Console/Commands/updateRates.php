<?php
/**
 * Created by PhpStorm.
 * User: sly28
 * Date: 25.11.2020
 * Time: 23:00
 */

namespace App\Console\Commands;


use App\Http\Controllers\valuteController;
use Illuminate\Console\Command;


/**
 * Class deletePostsCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class updateRates extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "update_rates";
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Update rates for all currencies";
    
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $update = new valuteController();
        if ($update->updateLogic() === 1) {
            $this->info("Rates updated!");
        } else {
            $this->error("Error! Rates not update");
        }
    }
}