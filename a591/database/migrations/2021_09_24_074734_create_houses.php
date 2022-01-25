<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHouses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->bigIncrements('id');	//遞增的 ID（主鍵），使用相當於「UNSIGNED BIG INTEGER」的型態。
            $table->text('post_id')->nullable();			// 物件代號
            $table->text('title');				// 標題
            $table->float('price', 12, 1);				// 租金
            $table->text('community');			// 地點
            $table->text('photo_list');			// 圖片,陣列
            $table->text('rent_tag')->nullable();			// 特色標籤,陣列
            $table->text('role_name')->nullable();			// 出租人身分
            $table->text('contact')->nullable();			// 出租人名稱
            $table->text('area')->nullable();				// 坪數
            $table->text('floor_str')->nullable();			// 樓層
            $table->text('kind_name')->nullable();			// 類型
            $table->text('room_str')->nullable();			// 格局
            $table->text('refresh_time')->nullable();		// 更新時間
            $table->text('location')->nullable();			// 位置
            $table->text('section_name')->nullable();		// 所在區域
            $table->text('street_name')->nullable();		// 所在路段
            $table->text('desc')->nullable();				// 附近地標
            $table->text('distance')->nullable();			// 附近地標距離
            $table->text('yesterday_hit')->nullable();		// 昨日瀏覽人數
            $table->timestamps(); //加入 created_at 和 updated_at 欄位。
			$table->softDeletes();	//加入 deleted_at 欄位於軟刪除使用。
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('houses');
    }
}
