<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //  BALE code generator
        DB::unprepared("DROP TRIGGER IF EXISTS before_bale_insert_generate_code");
        DB::unprepared("
            CREATE TRIGGER before_bale_insert_generate_code
            BEFORE INSERT ON bales
            FOR EACH ROW
            BEGIN
                DECLARE next_id INT;
                SELECT IFNULL(MAX(id), 0) + 1 INTO next_id FROM bales;
                SET NEW.bale_number = CONCAT('BALE-', LPAD(next_id, 3, '0'));
            END
        ");

        // ITEM code generator
        DB::unprepared("DROP TRIGGER IF EXISTS before_item_insert_generate_code");
        DB::unprepared("
            CREATE TRIGGER before_item_insert_generate_code
            BEFORE INSERT ON items
            FOR EACH ROW
            BEGIN
                DECLARE cat_prefix VARCHAR(10);
                DECLARE next_num INT;
                
                -- get the 3-letter prefix from the category name
                SELECT UPPER(LEFT(name, 3)) INTO cat_prefix 
                FROM categories 
                WHERE id = NEW.category_id;
                
                SELECT COALESCE(MAX(CAST(SUBSTRING_INDEX(item_code, '-', -1) AS UNSIGNED)), 0) + 1 
                INTO next_num 
                FROM items 
                WHERE category_id = NEW.category_id;
                
                SET NEW.item_code = CONCAT(cat_prefix, '-', LPAD(next_num, 3, '0'));
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS before_bale_insert_generate_code");
        DB::unprepared("DROP TRIGGER IF EXISTS before_item_insert_generate_code");
    }
};