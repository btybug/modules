<?php
namespace Sahakavatar\Modules\Plugins\Gears;
/**
 * Created by PhpStorm.
 * User: Edo
 * Date: 8/8/2016
 * Time: 9:11 PM
 */
class Autoload
{
// this function will coled only install time
    public function up($consig){
        BBRegisterAdminPages("Modules", 'Frontend Gears index', '/admin/modules/back-gears/layouts', 'defoult_empty_pages');

    }
    // this function will coled only unistall time
    public function down($consig){
    }
}